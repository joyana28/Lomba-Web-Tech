@extends('layouts.app', ['title' => 'Buat Request Donor - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Buat Request Donor</h1>
        <p class="mt-2 text-slate-500">Masukkan kebutuhan donor untuk menjalankan smart matching.</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <form method="POST" action="{{ route('requests.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Golongan Darah</label>
                    <select name="blood_type_id" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">-- Pilih Golongan Darah --</option>
                        @foreach($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}" @selected(old('blood_type_id') == $bloodType->id)>
                                {{ $bloodType->type }}{{ $bloodType->rhesus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Kantong</label>
                        <input type="number" name="quantity" min="1" max="20" value="{{ old('quantity') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="Contoh: 2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Urgensi</label>
                        <select name="urgency" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                            <option value="">-- Pilih Urgensi --</option>
                            <option value="low" @selected(old('urgency') === 'low')>Low</option>
                            <option value="medium" @selected(old('urgency') === 'medium')>Medium</option>
                            <option value="high" @selected(old('urgency') === 'high')>High</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deadline</label>
                    <input type="datetime-local" name="deadline" value="{{ old('deadline') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lokasi Kebutuhan</label>
                    <textarea name="address" rows="3"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                              placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="-2.345678">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="99.123456">
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                    Simpan & Jalankan Smart Matching
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-fit">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Panduan</h3>
            <div class="space-y-4 text-sm text-slate-600">
                <div>
                    <div class="font-semibold text-slate-800 mb-1">Golongan Darah</div>
                    <p>Pilih golongan darah sesuai kebutuhan pasien.</p>
                </div>
                <div>
                    <div class="font-semibold text-slate-800 mb-1">Urgensi</div>
                    <p>Gunakan <span class="text-red-600 font-semibold">high</span> untuk kebutuhan darurat.</p>
                </div>
                <div>
                    <div class="font-semibold text-slate-800 mb-1">Koordinat Lokasi</div>
                    <p>Koordinat dipakai untuk menghitung donor terdekat.</p>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-700">
                Setelah request dibuat, sistem akan melakukan matching berdasarkan kecocokan golongan darah,
                cooldown, dan jarak lokasi donor.
            </div>
        </div>
    </div>
@endsection