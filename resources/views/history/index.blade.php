@extends('layouts.app', ['title' => 'Riwayat Donasi - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Riwayat Donasi</h1>
        <p class="mt-2 text-slate-500">Lihat catatan donasi yang telah berhasil dikonfirmasi oleh admin.</p>
    </div>

    @if($histories->count() === 0)
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📜</div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada riwayat donasi</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto">
                Riwayat akan muncul setelah Anda menawarkan donor, lalu admin mengonfirmasi bahwa donasi berhasil dilakukan.
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($histories as $history)
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                                ✅
                            </div>

                            <div>
                                <div class="text-sm text-slate-500">Request #{{ $history->donor_request_id ?? '-' }}</div>
                                <h3 class="text-lg font-bold text-slate-900 mt-1">
                                    Donasi Berhasil Dikonfirmasi
                                </h3>
                                <p class="text-sm text-slate-500 mt-2">
                                    @if(!empty($history->donated_at))
                                        {{ \Illuminate\Support\Carbon::parse($history->donated_at)->format('d M Y H:i') }}
                                    @elseif(!empty($history->created_at))
                                        {{ $history->created_at->format('d M Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-sm text-slate-600 md:text-right">
                            {{ $history->notes ?? 'Donasi berhasil tercatat.' }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="pt-2">
                {{ $histories->links() }}
            </div>
        </div>
    @endif
@endsection