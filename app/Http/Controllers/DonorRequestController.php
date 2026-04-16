<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use App\Models\Cooldown;
use App\Models\DonationHistory;
use App\Models\DonorRequest;
use App\Models\Location;
use App\Models\MatchingResult;
use App\Models\Notification;
use App\Services\MatchingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonorRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $requestsQuery = DonorRequest::query()
            ->with(['bloodType', 'location', 'user'])
            ->withCount('matchingResults');

        if ($status !== 'all') {
            $requestsQuery->where('status', $status);
        }

        $requests = $requestsQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('requests.index', compact('requests', 'status'));
    }

    public function create()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $bloodTypes = BloodType::orderBy('type')->orderBy('rhesus')->get();

        return view('admin.requests.create', compact('bloodTypes'));
    }

    public function store(Request $request, MatchingService $matchingService)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'blood_type_id' => ['required', 'exists:blood_types,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'urgency' => ['required', 'in:low,medium,high'],
            'deadline' => ['required', 'date', function ($attribute, $value, $fail) {
                if (strtotime($value) < time()) {
                    $fail('Deadline tidak boleh di masa lalu.');
                }
            }],
            'address' => ['required', 'string', 'max:500'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $location = Location::create([
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        $donorRequest = DonorRequest::create([
            'created_by' => Auth::id(),
            'blood_type_id' => $validated['blood_type_id'],
            'location_id' => $location->id,
            'quantity' => $validated['quantity'],
            'urgency' => $validated['urgency'],
            'deadline' => $validated['deadline'],
            'status' => 'open',
        ]);

        $results = $matchingService->run($donorRequest);

        return redirect()
            ->route('requests.show', $donorRequest->id)
            ->with('success', 'Request berhasil dibuat. ' . $results->count() . ' kandidat donor ditemukan.');
    }

    public function show(DonorRequest $request)
    {
        $request->load([
            'user',
            'bloodType',
            'location',
            'matchingResults' => fn ($query) => $query
                ->orderByDesc('is_eligible')
                ->orderByDesc('priority_score')
                ->orderBy('distance_km'),
            'matchingResults.donor.user',
            'matchingResults.donor.bloodType',
            'matchingResults.donor.location',
            'matchingResults.donor.cooldown',
        ]);

        $eligibleCount = $request->matchingResults->where('is_eligible', true)->count();

        $notificationCount = $request->matchingResults
            ->where('is_eligible', true)
            ->take(max($request->quantity * 3, 5))
            ->count();

        $confirmedCount = $request->matchingResults
            ->filter(fn ($result) => Str::contains((string) $result->notes, 'DONASI_BERHASIL:'))
            ->count();

        return view('requests.show', compact(
            'request',
            'eligibleCount',
            'notificationCount',
            'confirmedCount'
        ))->with('donorRequest', $request);
    }

    public function close(DonorRequest $request)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        if ($request->status === 'closed') {
            return redirect()
                ->route('requests.show', $request->id)
                ->with('error', 'Request ini sudah ditandai selesai.');
        }

        $request->update([
            'status' => 'closed',
        ]);

        return redirect()
            ->route('requests.show', $request->id)
            ->with('success', 'Request berhasil ditandai selesai.');
    }

    public function confirmDonation(DonorRequest $request, MatchingResult $result)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        if ($result->donor_request_id !== $request->id) {
            abort(404);
        }

        if ($request->status === 'closed') {
            return back()->with('error', 'Request sudah ditutup.');
        }

        $result->loadMissing('donor.user');

        if (!$result->donor) {
            return back()->with('error', 'Donor tidak ditemukan.');
        }

        if (Str::contains((string) $result->notes, 'DONASI_BERHASIL:')) {
            return back()->with('error', 'Sudah dikonfirmasi.');
        }

        DonationHistory::updateOrCreate(
            [
                'donor_id' => $result->donor_id,
                'donor_request_id' => $request->id,
            ],
            [
                'notes' => 'Donasi berhasil untuk request #' . $request->id,
                'donated_at' => now(),
            ]
        );

        Cooldown::updateOrCreate(
            ['donor_id' => $result->donor_id],
            [
                'cooldown_until' => Carbon::now()->addDays(90),
                'reason' => 'Donor selesai untuk request #' . $request->id,
            ]
        );

        $result->donor->update([
            'is_available' => 0,
            'last_donation_date' => now()->format('Y-m-d'),
        ]);

        $result->update([
            'notes' => trim(($result->notes ? $result->notes . ' | ' : '') . 'DONASI_BERHASIL: dikonfirmasi admin'),
        ]);

        if ($result->donor->user_id) {
            Notification::create([
                'user_id' => $result->donor->user_id,
                'message' => 'Donasi Anda telah dikonfirmasi berhasil untuk request #' . $request->id,
                'status' => 'sent',
            ]);
        }

        $confirmedCount = MatchingResult::where('donor_request_id', $request->id)
            ->get()
            ->filter(fn ($item) => Str::contains((string) $item->notes, 'DONASI_BERHASIL:'))
            ->count();

        if ($confirmedCount >= $request->quantity) {
            $request->update(['status' => 'closed']);

            return redirect()
                ->route('requests.show', $request->id)
                ->with('success', 'Donor terpenuhi, request otomatis ditutup.');
        }

        return redirect()
            ->route('requests.show', $request->id)
            ->with('success', 'Donor berhasil dikonfirmasi.');
    }
}