<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Donor - DonorHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-red-600">🩸 DonorHub</h1>

    <div class="flex items-center gap-4">
        <a href="{{ route('user.home') }}" class="text-gray-600 hover:text-red-500 font-medium">
            Home
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="p-6 max-w-7xl mx-auto">

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Request Donor</h1>
            <p class="text-gray-500">Buat dan pantau kebutuhan donor darah secara real-time.</p>
        </div>

        <a href="{{ route('requests.create') }}"
           class="px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition shadow">
            + Buat Request
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        @if($requests->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <p class="text-lg mb-2">Belum ada request donor</p>
                <p class="text-sm mb-4">Mulai dengan membuat permintaan donor pertama.</p>

                <a href="{{ route('requests.create') }}"
                   class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Buat Request
                </a>
            </div>
        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-3 text-left">ID</th>
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
                            <tr class="border-t hover:bg-gray-50 transition">

                                <td class="px-5 py-3 font-semibold text-gray-800">
                                    #{{ $request->id }}
                                </td>

                                <td class="px-5 py-3">
                                    {{ $request->bloodType->type ?? '-' }}{{ $request->bloodType->rhesus ?? '' }}
                                </td>

                                <td class="px-5 py-3 text-gray-600">
                                    {{ $request->location->address ?? '-' }}
                                </td>

                                <td class="px-5 py-3">
                                    <span class="text-xs px-3 py-1 rounded-full font-medium
                                        @if($request->urgency === 'high') bg-red-100 text-red-600
                                        @elseif($request->urgency === 'medium') bg-yellow-100 text-yellow-600
                                        @else bg-green-100 text-green-600
                                        @endif">
                                        {{ strtoupper($request->urgency) }}
                                    </span>
                                </td>

                                <td class="px-5 py-3 text-gray-600">
                                    {{ $request->deadline?->format('d M Y H:i') ?? '-' }}
                                </td>

                                <td class="px-5 py-3 capitalize">
                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                                        {{ str_replace('_', ' ', $request->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-3 font-semibold text-blue-600">
                                    {{ $request->matching_results_count ?? 0 }}
                                </td>

                                <td class="px-5 py-3">
                                    <a href="{{ route('requests.show', $request->id) }}"
                                       class="text-red-600 hover:underline font-semibold">
                                        Detail →
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t bg-gray-50">
                {{ $requests->links() }}
            </div>

        @endif

    </div>

</div>

</body>
</html>