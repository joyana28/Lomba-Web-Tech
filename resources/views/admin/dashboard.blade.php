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

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Request Terbaru</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar kebutuhan donor terbaru yang masuk ke sistem.</p>
            </div>

            <a href="{{ route('requests.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                + Buat Request
            </a>
        </div>

        @if($latestRequests->isEmpty())
            <div class="p-10 text-center text-slate-500">
                Belum ada data request.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-3 text-left">ID</th>
                            <th class="px-5 py-3 text-left">Golongan</th>
                            <th class="px-5 py-3 text-left">Lokasi</th>
                            <th class="px-5 py-3 text-left">Urgensi</th>
                            <th class="px-5 py-3 text-left">Deadline</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestRequests as $request)
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-5 py-3 font-semibold">#{{ $request->id }}</td>
                                <td class="px-5 py-3">{{ $request->bloodType->type ?? '-' }}{{ $request->bloodType->rhesus ?? '' }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $request->location->address ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs px-3 py-1 rounded-full font-medium
                                        @if($request->urgency === 'high') bg-red-100 text-red-600
                                        @elseif($request->urgency === 'medium') bg-yellow-100 text-yellow-700
                                        @else bg-green-100 text-green-700
                                        @endif">
                                        {{ strtoupper($request->urgency) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $request->deadline?->format('d M Y H:i') ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs px-3 py-1 rounded-full {{ $request->status === 'closed' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ strtoupper(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('requests.show', $request->id) }}" class="text-red-600 font-semibold hover:underline">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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