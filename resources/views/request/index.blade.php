@extends('layouts.app')

@section('title', 'Request Donor - DonorHub')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold">Request Donor</h1>
            <p class="text-slate-600">Kelola kebutuhan donor dan pantau kandidat yang cocok.</p>
        </div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('requests.create') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Tambah Request
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($requests->isEmpty())
            <div class="px-6 py-10 text-slate-500">Belum ada request donor yang dibuat.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left px-5 py-3">ID</th>
                            <th class="text-left px-5 py-3">Golongan Darah</th>
                            <th class="text-left px-5 py-3">Lokasi</th>
                            <th class="text-left px-5 py-3">Urgensi</th>
                            <th class="text-left px-5 py-3">Deadline</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-left px-5 py-3">Kandidat</th>
                            <th class="text-left px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr class="border-t border-slate-100">
                                <td class="px-5 py-3 font-semibold">#{{ $request->id }}</td>
                                <td class="px-5 py-3">{{ $request->bloodType->type }}{{ $request->bloodType->rhesus }}</td>
                                <td class="px-5 py-3">{{ $request->location->address ?? '-' }}</td>
                                <td class="px-5 py-3 uppercase">{{ $request->urgency }}</td>
                                <td class="px-5 py-3">{{ $request->deadline?->format('d M Y H:i') }}</td>
                                <td class="px-5 py-3 capitalize">{{ str_replace('_', ' ', $request->status) }}</td>
                                <td class="px-5 py-3">{{ $request->matching_results_count }}</td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('requests.show', $request) }}" class="text-red-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-200">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection