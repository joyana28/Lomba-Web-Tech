<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Request Donor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-red-600">🩸 DonorHub</h1>

    <div class="flex items-center gap-4">
        <a href="{{ route('requests.index') }}" class="text-gray-600 hover:text-red-500">
            ← Kembali
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="p-6 max-w-6xl mx-auto">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- DETAIL -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-2xl font-bold mb-4">Detail Request Donor</h2>

        <div class="grid md:grid-cols-2 gap-4 text-sm">

            <div><strong>ID:</strong> #{{ $donorRequest->id }}</div>

            <div>
                <strong>Golongan Darah:</strong>
                {{ $donorRequest->bloodType->type }}{{ $donorRequest->bloodType->rhesus }}
            </div>

            <div><strong>Jumlah:</strong> {{ $donorRequest->quantity }} kantong</div>

            <div>
                <strong>Urgensi:</strong>
                <span class="px-2 py-1 rounded text-xs
                    @if($donorRequest->urgency === 'high') bg-red-100 text-red-600
                    @elseif($donorRequest->urgency === 'medium') bg-yellow-100 text-yellow-600
                    @else bg-green-100 text-green-600
                    @endif">
                    {{ strtoupper($donorRequest->urgency) }}
                </span>
            </div>

            <div>
                <strong>Deadline:</strong>
                {{ $donorRequest->deadline?->format('d M Y H:i') }}
            </div>

            <div>
                <strong>Status:</strong>
                {{ str_replace('_', ' ', $donorRequest->status) }}
            </div>

            <div class="md:col-span-2">
                <strong>Lokasi:</strong>
                {{ $donorRequest->location->address ?? '-' }}
            </div>

            <div><strong>Total Kandidat:</strong> {{ $eligibleCount }}</div>
            <div><strong>Notifikasi Akan Dikirim:</strong> {{ $notificationCount }}</div>

        </div>

        <!-- 🔥 CTA USER -->
        <div class="mt-6">

            @if(isset($alreadyDonated) && $alreadyDonated)
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    ✔ Kamu sudah mendaftar sebagai donor
                </div>
            @else
                <form method="POST" action="{{ route('donor.respond', $donorRequest->id) }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition w-full">
                        Saya Bersedia Donor ❤️
                    </button>
                </form>
            @endif

        </div>
    </div>

    <!-- MATCHING -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Kandidat Donor</h2>

        @if($donorRequest->matchingResults->isEmpty())
            <p class="text-gray-500">Belum ada kandidat donor.</p>
        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Golongan</th>
                            <th class="px-4 py-3 text-left">Jarak</th>
                            <th class="px-4 py-3 text-left">Skor</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($donorRequest->matchingResults as $result)
                            <tr class="border-t hover:bg-gray-50
                                @if($result->is_eligible) bg-green-50 @endif">

                                <td class="px-4 py-3">
                                    {{ $result->donor->user->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $result->donor->bloodType->type ?? '-' }}
                                    {{ $result->donor->bloodType->rhesus ?? '' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ number_format($result->distance_km, 2) }} km
                                </td>

                                <td class="px-4 py-3">
                                    {{ $result->priority_score }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="text-xs px-2 py-1 rounded
                                        @if($result->is_eligible) bg-green-100 text-green-600
                                        @else bg-gray-100 text-gray-600
                                        @endif">
                                        {{ $result->is_eligible ? 'Eligible' : 'Tidak' }}
                                    </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

</div>

</body>
</html>