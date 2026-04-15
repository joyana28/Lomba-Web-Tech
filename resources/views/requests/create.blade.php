<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Request Donor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-red-600 text-lg">🩸 DonorHub</h1>

    <a href="{{ route('requests.index') }}" class="text-gray-600 hover:text-red-500">
        ← Kembali
    </a>
</nav>

<div class="max-w-2xl mx-auto p-6">

    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">Buat Request Donor</h2>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('requests.store') }}" class="space-y-5">
            @csrf

            <!-- BLOOD TYPE -->
            <div>
                <label class="font-medium text-gray-700">Golongan Darah</label>
                <p class="text-sm text-gray-500">Pilih jenis golongan darah yang dibutuhkan.</p>
                <select name="blood_type_id" class="w-full border p-2 rounded mt-1">
                    @foreach($bloodTypes as $blood)
                        <option value="{{ $blood->id }}">
                            {{ $blood->type }}{{ $blood->rhesus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- QUANTITY -->
            <div>
                <label class="font-medium text-gray-700">Jumlah Kantong Darah</label>
                <p class="text-sm text-gray-500">Masukkan jumlah kantong darah yang dibutuhkan (1–20).</p>
                <input type="number" name="quantity" value="{{ old('quantity') }}"
                       class="w-full border p-2 rounded mt-1" min="1" max="20">
            </div>

            <!-- URGENCY -->
            <div>
                <label class="font-medium text-gray-700">Tingkat Urgensi</label>
                <p class="text-sm text-gray-500">Tentukan tingkat kebutuhan donor.</p>
                <select name="urgency" class="w-full border p-2 rounded mt-1">
                    <option value="low">Rendah</option>
                    <option value="medium">Sedang</option>
                    <option value="high">Tinggi</option>
                </select>
            </div>

            <!-- DEADLINE -->
            <div>
                <label class="font-medium text-gray-700">Batas Waktu</label>
                <p class="text-sm text-gray-500">Tentukan batas waktu kebutuhan donor.</p>
                <input type="datetime-local" name="deadline" value="{{ old('deadline') }}"
                       class="w-full border p-2 rounded mt-1">
            </div>

            <!-- ADDRESS -->
            <div>
                <label class="font-medium text-gray-700">Alamat Lokasi</label>
                <p class="text-sm text-gray-500">Masukkan lokasi lengkap tempat donor dibutuhkan.</p>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full border p-2 rounded mt-1">
            </div>

            <!-- LATITUDE -->
            <div>
                <label class="font-medium text-gray-700">Latitude</label>
                <p class="text-sm text-gray-500">Koordinat lokasi (contoh: 2.33).</p>
                <input type="number" step="any" name="latitude" value="{{ old('latitude') }}"
                       class="w-full border p-2 rounded mt-1">
            </div>

            <!-- LONGITUDE -->
            <div>
                <label class="font-medium text-gray-700">Longitude</label>
                <p class="text-sm text-gray-500">Koordinat lokasi (contoh: 99.12).</p>
                <input type="number" step="any" name="longitude" value="{{ old('longitude') }}"
                       class="w-full border p-2 rounded mt-1">
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                Simpan Request Donor
            </button>

        </form>

    </div>

</div>

</body>
</html>