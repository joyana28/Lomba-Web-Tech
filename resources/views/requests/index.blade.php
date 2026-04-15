@extends('layouts.app', ['title' => 'Request Donor - DonorHub'])

@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Request Donor</h1>
            <p class="mt-2 text-slate-500">Semua user login dapat membuat request donor darah dan memantau prosesnya.</p>
        </div>

        <a href="{{ route('requests.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition shadow-sm">
            + Buat Request
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('requests.index') }}" class="flex flex-col md:flex-row gap-4 md:items-end">
            <div class="w-full md:w-64">
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Filter Status</label>
                <select name="status" id="status" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="open" {{ ($status ?? 'all') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ ($status ?? 'all') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Terapkan
                </button>

                <a href="{{ route('requests.index') }}" class="px-5 py-3 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($requests->isEmpty())
            <div class="p-12 text-center text-slate-500">
                <p class="text-lg font-semibold mb-2">Belum ada request donor</p>
                <p class="text-sm">Data request akan muncul di halaman ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-3 text-left">ID</th>
                            <th class="px-5 py-3 text-left">Dibuat Oleh</th>
                            <th class="px-5 py-3 text-left">Golongan</th>
                            <th class="px-5 py-3 text-left">Lokasi</th>
                            <th class="px-5 py-3 text-left">Urgensi</th>
                            <th class="px-5 py-3 text-left">Deadline</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Kandidat</th>
                            <th class="px-5 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-5 py-3 font-semibold">#{{ $request->id }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $request->user->name ?? '-' }}</td>
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
                                <td class="px-5 py-3 font-semibold text-blue-600">{{ $request->matching_results_count ?? 0 }}</td>
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

            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection