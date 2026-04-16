@extends('layouts.app', ['title' => 'Dashboard Admin - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Dashboard Admin</h1>
        <p class="mt-2 text-slate-500">Pantau donor, request aktif, dan kondisi sistem DonorHub secara ringkas.</p>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <p class="text-sm text-slate-500">Total Donor</p>
            <h3 class="mt-2 text-3xl font-bold text-red-600">{{ $totalDonors }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <p class="text-sm text-slate-500">Donor Tersedia</p>
            <h3 class="mt-2 text-3xl font-bold text-green-600">{{ $availableDonors }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <p class="text-sm text-slate-500">Request Aktif</p>
            <h3 class="mt-2 text-3xl font-bold text-blue-600">{{ $activeRequests }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <p class="text-sm text-slate-500">Total Notifikasi</p>
            <h3 class="mt-2 text-3xl font-bold text-purple-600">{{ $totalNotifications }}</h3>
        </div>
    </div>

    <div class="grid xl:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Status Request</h3>
            <div class="h-80">
                <canvas id="requestStatusChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Ketersediaan Donor</h3>
            <div class="h-80">
                <canvas id="donorAvailabilityChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
    new Chart(document.getElementById('requestStatusChart'), {
        type: 'bar',
        data: {
            labels: ['Open', 'Closed'],
            datasets: [{
                label: 'Jumlah Request',
                data: [{{ $activeRequests }}, {{ $closedRequests }}],
                borderWidth: 1
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('donorAvailabilityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Tersedia', 'Tidak Tersedia'],
            datasets: [{
                label: 'Donor',
                data: [{{ $availableDonors }}, {{ $unavailableDonors }}],
                borderWidth: 1
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush