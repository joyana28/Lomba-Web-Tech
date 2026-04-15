@extends('layouts.app', ['title' => 'Riwayat Donasi - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Riwayat Donasi</h1>
        <p class="mt-2 text-slate-500">Lihat catatan donasi darah yang pernah Anda lakukan.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($histories->count() === 0)
            <div class="p-10 text-center">
                <div class="text-5xl mb-4">📜</div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada riwayat donasi</h3>
                <p class="text-sm text-slate-500 max-w-md mx-auto">
                    Riwayat akan muncul setelah admin mengonfirmasi bahwa donor berhasil dilakukan.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-3 text-left">ID</th>
                            <th class="px-5 py-3 text-left">Request</th>
                            <th class="px-5 py-3 text-left">Tanggal Donor</th>
                            <th class="px-5 py-3 text-left">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-5 py-3 font-semibold">#{{ $history->id }}</td>
                                <td class="px-5 py-3">#{{ $history->donor_request_id ?? '-' }}</td>
                                <td class="px-5 py-3 text-slate-600">
                                    @if(!empty($history->donated_at))
                                        {{ \Illuminate\Support\Carbon::parse($history->donated_at)->format('d M Y H:i') }}
                                    @elseif(!empty($history->created_at))
                                        {{ $history->created_at->format('d M Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-slate-700">
                                    {{ $history->notes ?? 'Donasi berhasil tercatat.' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
@endsection