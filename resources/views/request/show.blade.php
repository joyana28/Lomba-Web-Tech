@extends('layouts.app')

@section('title', 'Detail Request Donor - DonorHub')

@section('content')
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Detail Request #{{ $donorRequest->id }}</h1>
            <p class="text-slate-600">Pantau kandidat donor hasil smart matching dan status request yang sedang berjalan.</p>
        </div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('matching.run', $donorRequest) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Jalankan Ulang Matching
            </a>
        @endif
    </div>

    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Golongan Dibutuhkan</p>
            <p class="mt-2 text-3xl font-bold">{{ $donorRequest->bloodType->type }}{{ $donorRequest->bloodType->rhesus }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Jumlah Kantong</p>
            <p class="mt-2 text-3xl font-bold">{{ $donorRequest->quantity }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Donor Eligible</p>
            <p class="mt-2 text-3xl font-bold">{{ $eligibleCount }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Notifikasi Disiapkan</p>
            <p class="mt-2 text-3xl font-bold">{{ $notificationCount }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Request</h2>

            <dl class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Lokasi</dt>
                    <dd class="font-medium">{{ $donorRequest->location->address ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Koordinat</dt>
                    <dd class="font-medium">{{ $donorRequest->location->latitude }}, {{ $donorRequest->location->longitude }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Urgensi</dt>
                    <dd class="font-medium uppercase">{{ $donorRequest->urgency }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Deadline</dt>
                    <dd class="font-medium">{{ $donorRequest->deadline?->format('d M Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Status</dt>
                    <dd class="font-medium capitalize">{{ str_replace('_', ' ', $donorRequest->status) }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Dibuat oleh</dt>
                    <dd class="font-medium">{{ $donorRequest->admin->name ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-fit">
            <h2 class="text-lg font-semibold mb-4">Interpretasi hasil</h2>
            <ul class="space-y-3 text-sm text-slate-600 list-disc list-inside">
                <li>Skor lebih tinggi berarti donor lebih diprioritaskan.</li>
                <li>Status <span class="font-semibold">Eligible</span> berarti donor tersedia dan tidak sedang cooldown.</li>
                <li>Jarak dihitung dengan rumus Haversine dari koordinat donor ke lokasi request.</li>
            </ul>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Hasil Smart Matching</h2>
            <span class="text-sm text-slate-500">{{ $donorRequest->matchingResults->count() }} kandidat kompatibel</span>
        </div>

        @if($donorRequest->matchingResults->isEmpty())
            <div class="px-6 py-10 text-slate-500">Belum ada donor yang cocok untuk request ini.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left px-5 py-3">Donor</th>
                            <th class="text-left px-5 py-3">Golongan</th>
                            <th class="text-left px-5 py-3">Jarak</th>
                            <th class="text-left px-5 py-3">Skor</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-left px-5 py-3">Kontak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donorRequest->matchingResults as $result)
                            <tr class="border-t border-slate-100">
                                <td class="px-5 py-3">
                                    <div class="font-semibold">{{ $result->donor->user->name ?? 'Donor' }}</div>
                                    <div class="text-xs text-slate-500">{{ $result->donor->location->address ?? 'Alamat donor belum diisi' }}</div>
                                </td>
                                <td class="px-5 py-3">{{ $result->donor->bloodType->type }}{{ $result->donor->bloodType->rhesus }}</td>
                                <td class="px-5 py-3">{{ $result->distance_km !== null ? number_format($result->distance_km, 2) . ' km' : '-' }}</td>
                                <td class="px-5 py-3 font-semibold">{{ number_format($result->priority_score, 0) }}</td>
                                <td class="px-5 py-3">
                                    @if($result->is_eligible)
                                        <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">Eligible</span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-medium">Tidak eligible</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">{{ $result->donor->phone ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection