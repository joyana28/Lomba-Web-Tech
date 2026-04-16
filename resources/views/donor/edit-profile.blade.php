<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Donor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between">
    <h1 class="text-red-600 font-bold">🩸 DonorHub</h1>

    <a href="{{ route('donor.profile') }}" class="text-gray-600 hover:text-red-500">
        ← Kembali
    </a>
</nav>

<div class="max-w-2xl mx-auto p-6">

    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-xl font-bold mb-4">Edit Profil Donor</h2>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('donor.profile.update') }}" class="space-y-4">
            @csrf

            <div>
                <label>Golongan Darah</label>
                <select name="blood_type_id" class="w-full border p-2 rounded">
                    @foreach($bloodTypes as $blood)
                        <option value="{{ $blood->id }}"
                            {{ optional($donor)->blood_type_id == $blood->id ? 'selected' : '' }}>
                            {{ $blood->type }}{{ $blood->rhesus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>No HP</label>
                <input type="text" name="phone" value="{{ $donor->phone ?? '' }}"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Terakhir Donor</label>
                <input type="date" name="last_donation_date"
                       value="{{ $donor->last_donation_date ?? '' }}"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Alamat</label>
                <input type="text" name="address"
                       value="{{ $donor->location->address ?? '' }}"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Latitude</label>
                <input type="number" step="any" name="latitude"
                       value="{{ $donor->location->latitude ?? '' }}"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Longitude</label>
                <input type="number" step="any" name="longitude"
                       value="{{ $donor->location->longitude ?? '' }}"
                       class="w-full border p-2 rounded">
            </div>

            <button class="w-full bg-red-600 text-white py-3 rounded">
                Simpan Profil
            </button>

        </form>

    </div>

</div>

</body>
</html>