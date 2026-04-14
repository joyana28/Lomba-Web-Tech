<?php

namespace App\Http\Controllers;

use App\Models\DonorRequest;
use App\Services\MatchingService;
use Illuminate\Support\Facades\Auth;

class MatchingController extends Controller
{
    public function match(DonorRequest $request, MatchingService $matchingService)
    {
        abort_unless(Auth::user()?->role === 'admin', 403, 'Hanya admin yang dapat menjalankan matching donor.');

        $results = $matchingService->run($request);

        return redirect()
            ->route('requests.show', $request)
            ->with('success', 'Matching donor berhasil dijalankan ulang. ' . $results->count() . ' kandidat diproses.');
    }
}