<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonors = Donor::count();
        $eligibleDonors = Donor::where('is_available', true)->count();
        $activeRequests = DonorRequest::whereIn('status', ['open', 'in_progress'])->count();
        $sentNotifications = Notification::count();

        $latestRequests = DonorRequest::with(['bloodType', 'location', 'admin'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalDonors',
            'eligibleDonors',
            'activeRequests',
            'sentNotifications',
            'latestRequests'
        ));
    }
}