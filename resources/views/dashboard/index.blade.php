<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DonorHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-red-600">🩸 DonorHub Dashboard</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </nav>

    <div class="p-6 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-semibold mb-6">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h2>

        <div class="grid md:grid-cols-4 gap-4 mb-8">

            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500 text-sm">Total Donor</p>
                <h3 class="text-2xl font-bold text-red-500">{{ $totalDonors ?? 0 }}</h3>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500 text-sm">Donor Tersedia</p>
                <h3 class="text-2xl font-bold text-green-500">{{ $eligibleDonors ?? 0 }}</h3>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500 text-sm">Request Aktif</p>
                <h3 class="text-2xl font-bold text-yellow-500">{{ $activeRequests ?? 0 }}</h3>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500 text-sm">Notifikasi</p>
                <h3 class="text-2xl font-bold text-blue-500">{{ $sentNotifications ?? 0 }}</h3>
            </div>

        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Permintaan Donor Terbaru</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Golongan Darah</th>
                            <th class="p-3">Lokasi</th>
                            <th class="p-3">Urgensi</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestRequests as $request)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3">
                                    {{ $request->bloodType->type ?? '-' }}{{ $request->bloodType->rhesus ?? '' }}
                                </td>
                                <td class="p-3">
                                    {{ $request->location->address ?? '-' }}
                                </td>
                                <td class="p-3 capitalize">
                                    {{ $request->urgency ?? '-' }}
                                </td>
                                <td class="p-3 capitalize">
                                    <span class="px-2 py-1 rounded text-xs 
                                        @if($request->status === 'open') bg-green-100 text-green-700 
                                        @elseif($request->status === 'in_progress') bg-yellow-100 text-yellow-700 
                                        @else bg-gray-100 text-gray-700 
                                        @endif">
                                        {{ $request->status ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('requests.show', $request->id) }}"
                                       class="text-blue-500 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Belum ada permintaan donor
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>