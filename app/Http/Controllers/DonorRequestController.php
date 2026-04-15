<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use App\Models\DonorRequest;
use App\Models\Location;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorRequestController extends Controller
{
    public function index()
    {
        $requests = DonorRequest::query()
            ->with(['bloodType', 'location', 'user'])
            ->withCount('matchingResults')
            ->latest()
            ->paginate(10);

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        $bloodTypes = BloodType::orderBy('type')->orderBy('rhesus')->get();

        return view('requests.create', compact('bloodTypes'));
    }

    public function store(Request $request, MatchingService $matchingService)
    {
        $validated = $request->validate([
            'blood_type_id' => ['required', 'exists:blood_types,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'urgency' => ['required', 'in:low,medium,high'],
            'deadline' => ['required', 'date', 'after:now'],
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
            ->with('success', 'Request berhasil dibuat. ' . $results->count() . ' kandidat ditemukan.');
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

        return view('requests.show', [
            'donorRequest' => $request,
            'eligibleCount' => $eligibleCount,
            'notificationCount' => $notificationCount,
        ]);
    }
}