@extends('layouts.app', ['title' => 'Detail Kebutuhan Donor - DonorHub'])

@section('content')
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Detail Kebutuhan Donor</h1>
            <p class="mt-2 text-slate-500">
                Request ini dibuat oleh {{ $donorRequest->user->name ?? 'Admin' }}.
            </p>
        </div>

        @if(auth()->user()->role === 'admin')
            @if($donorRequest->status !== 'closed')
                <form method="POST" action="{{ route('requests.close', $donorRequest->id) }}">
                    @csrf
                    <button type="submit" class="px-5 py-3 rounded-xl bg-slate-900 text-white font-semibold hover:bg-black transition">
                        Tandai Selesai
                    </button>
                </form>
            @else
                <div class="px-4 py-2 rounded-xl bg-green-100 text-green-700 font-semibold">
                    Request Sudah Selesai
                </div>
            @endif
        @endif
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-5 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Golongan Darah</p>
            <h3 class="mt-2 text-2xl font-bold text-red-600">
                {{ $donorRequest->bloodType->type ?? '-' }}{{ $donorRequest->bloodType->rhesus ?? '' }}
            </h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Jumlah Dibutuhkan</p>
            <h3 class="mt-2 text-2xl font-bold text-slate-800">{{ $donorRequest->quantity }} Kantong</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Kandidat Eligible</p>
            <h3 class="mt-2 text-2xl font-bold text-blue-600">{{ $eligibleCount }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Notifikasi</p>
            <h3 class="mt-2 text-2xl font-bold text-purple-600">{{ $notificationCount }}</h3>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <p class="text-sm text-slate-500">Donor Terkonfirmasi</p>
            <h3 class="mt-2 text-2xl font-bold text-green-600">{{ $confirmedCount }}</h3>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-3">Informasi Kebutuhan Donor</h3>

            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-slate-500">Dibuat Oleh</div>
                    <div class="font-semibold mt-1">{{ $donorRequest->user->name ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-slate-500">Status</div>
                    <div class="font-semibold mt-1">{{ strtoupper($donorRequest->status) }}</div>
                </div>

                <div>
                    <div class="text-slate-500">Urgensi</div>
                    <div class="font-semibold mt-1">{{ strtoupper($donorRequest->urgency) }}</div>
                </div>

                <div>
                    <div class="text-slate-500">Deadline</div>
                    <div class="font-semibold mt-1">{{ $donorRequest->deadline?->format('d M Y H:i') ?? '-' }}</div>
                </div>

                <div class="md:col-span-2">
                    <div class="text-slate-500">Alamat</div>
                    <div class="font-semibold mt-1">{{ $donorRequest->location->address ?? '-' }}</div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role !== 'admin')
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                @if($donorRequest->status !== 'closed')
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Tawarkan Donor</h3>
                    <p class="text-sm text-slate-500 mb-4">
                        Jika Anda siap menjadi donor untuk kebutuhan ini, klik tombol di bawah.
                    </p>

                    <form method="POST" action="{{ route('donor.respond', $donorRequest->id) }}">
                        @csrf
                        <button type="submit" class="w-full px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                            Saya Siap Donor
                        </button>
                    </form>
                @else
                    <h3 class="text-lg font-bold text-yellow-700 mb-2">Request Ditutup</h3>
                    <p class="text-sm text-yellow-700">Kebutuhan donor ini sudah selesai dan tidak bisa direspons lagi.</p>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Hasil Smart Matching</h3>
            <p class="text-sm text-slate-500 mt-1">Diurutkan berdasarkan eligibility, skor prioritas, dan jarak.</p>
        </div>

        @if($donorRequest->matchingResults->isEmpty())
            <div class="p-10 text-center text-slate-500">
                Belum ada hasil matching untuk request ini.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-3 text-left">Donor</th>
                            <th class="px-5 py-3 text-left">Golongan</th>
                            <th class="px-5 py-3 text-left">Jarak</th>
                            <th class="px-5 py-3 text-left">Skor</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Cooldown</th>
                            <th class="px-5 py-3 text-left">Catatan</th>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-5 py-3 text-left">Aksi Admin</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($donorRequest->matchingResults as $result)
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-5 py-3">
                                    <div class="font-semibold">{{ $result->donor->user->name ?? 'Donor' }}</div>
                                    <div class="text-xs text-slate-500">{{ $result->donor->user->email ?? '-' }}</div>
                                </td>

                                <td class="px-5 py-3">
                                    {{ $result->donor->bloodType->type ?? '-' }}{{ $result->donor->bloodType->rhesus ?? '' }}
                                </td>

                                <td class="px-5 py-3 text-slate-600">
                                    {{ number_format($result->distance_km ?? 0, 2) }} km
                                </td>

                                <td class="px-5 py-3 font-semibold text-purple-600">
                                    {{ $result->priority_score ?? 0 }}
                                </td>

                                <td class="px-5 py-3">
                                    @if($result->is_eligible)
                                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700 font-medium">
                                            Eligible
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 font-medium">
                                            Tidak Eligible
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-3 text-slate-600">
                                    @if($result->donor && $result->donor->cooldown && $result->donor->cooldown->cooldown_until)
                                        {{ \Carbon\Carbon::parse($result->donor->cooldown->cooldown_until)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-5 py-3 text-slate-600">
                                    {{ $result->notes ?? '-' }}
                                </td>

                                @if(auth()->user()->role === 'admin')
                                    <td class="px-5 py-3">
                                        @if($donorRequest->status === 'closed')
                                            <span class="text-xs text-slate-400">Request closed</span>
                                        @elseif(\Illuminate\Support\Str::contains((string) $result->notes, 'DONASI_BERHASIL:'))
                                            <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                                Sudah Dikonfirmasi
                                            </span>
                                        @elseif($result->is_eligible && \Illuminate\Support\Str::contains((string) $result->notes, 'RESPON_DONOR:'))
                                            <form method="POST" action="{{ route('requests.results.confirm', [$donorRequest->id, $result->id]) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 rounded-xl bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                                                    Tandai Berhasil
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">Menunggu respon donor</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection