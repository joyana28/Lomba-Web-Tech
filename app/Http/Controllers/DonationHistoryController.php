<?php

namespace App\Http\Controllers;

use App\Models\DonationHistory;
use App\Models\Donor;
use Illuminate\Support\Facades\Auth;

class DonationHistoryController extends Controller
{
    public function index()
    {
        $donor = Donor::query()
            ->where('user_id', Auth::id())
            ->first();

        if (!$donor) {
            $histories = DonationHistory::query()
                ->whereRaw('1 = 0')
                ->paginate(10);

            return view('history.index', compact('histories'));
        }

        $histories = DonationHistory::query()
            ->where('donor_id', $donor->id)
            ->latest('id')
            ->paginate(10);

        return view('history.index', compact('histories'));
    }
}