<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Donor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between">
    <h1 class="text-red-600 font-bold">🩸 DonorHub</h1>

    <a href="{{ route('user.home') }}" class="text-gray-600 hover:text-red-500">
        ← Kembali
    </a>
</nav>

<div class="max-w-2xl mx-auto p-6">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-xl font-bold mb-4">Profil Donor</h2>

        @if(!$donor)
            <p class="text-gray-500 mb-4">
                Kamu belum mengisi profil donor.
            </p>

            <a href="{{ route('donor.profile') }}?edit=true"
               class="bg-red-600 text-white px-4 py-2 rounded">
                Isi Profil
            </a>
        @else

            <div class="space-y-3 text-sm">

                <div><strong>Nama:</strong> {{ auth()->user()->name }}</div>

                <div>
                    <strong>Golongan Darah:</strong>
                    {{ $donor->bloodType->type }}{{ $donor->bloodType->rhesus }}
                </div>

                <div><strong>No HP:</strong> {{ $donor->phone }}</div>

                <div>
                    <strong>Terakhir Donor:</strong>
                    {{ $donor->last_donation_date ?? '-' }}
                </div>

                <div>
                    <strong>Alamat:</strong>
                    {{ $donor->location->address ?? '-' }}
                </div>

                <div>
                    <strong>Status:</strong>
                    <span class="text-green-600 font-semibold">
                        {{ $donor->is_available ? 'Siap Donor' : 'Tidak Aktif' }}
                    </span>
                </div>

            </div>

            <div class="mt-6">
                <a href="{{ route('donor.profile') }}?edit=true"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    Edit Profil
                </a>
            </div>

        @endif

    </div>

</div>

</body>
</html>