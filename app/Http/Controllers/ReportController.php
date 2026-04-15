<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorRequest;
use App\Models\Notification;

class ReportController extends Controller
{
    public function index()
    {
        $totalDonors = Donor::count();

        $availableDonors = Donor::query()
            ->where('is_available', 1)
            ->count();

        $totalRequests = DonorRequest::count();

        $activeRequests = DonorRequest::query()
            ->where('status', 'open')
            ->count();

        $completedRequests = DonorRequest::query()
            ->where('status', 'closed')
            ->count();

        $totalNotifications = Notification::count();

        $latestRequests = DonorRequest::query()
            ->with(['bloodType', 'location', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'totalDonors',
            'availableDonors',
            'totalRequests',
            'activeRequests',
            'completedRequests',
            'totalNotifications',
            'latestRequests'
        ));
    }
}