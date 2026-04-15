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

        $availableDonors = Donor::query()
            ->where('is_available', 1)
            ->count();

        $unavailableDonors = Donor::query()
            ->where('is_available', 0)
            ->count();

        $activeRequests = DonorRequest::query()
            ->where('status', 'open')
            ->count();

        $closedRequests = DonorRequest::query()
            ->where('status', 'closed')
            ->count();

        $totalNotifications = Notification::count();

        $latestRequests = DonorRequest::query()
            ->with(['bloodType', 'location', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalDonors',
            'availableDonors',
            'unavailableDonors',
            'activeRequests',
            'closedRequests',
            'totalNotifications',
            'latestRequests'
        ));
    }
}