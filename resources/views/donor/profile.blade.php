@extends('layouts.app', ['title' => 'Profil Donor - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Profil Donor</h1>
        <p class="mt-2 text-slate-500">Lengkapi data Anda agar sistem matching dapat bekerja lebih akurat.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <form method="POST" action="{{ route('donor.profile.update') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Golongan Darah</label>
                <select name="blood_type_id" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <option value="">-- Pilih Golongan Darah --</option>
                    @foreach($bloodTypes as $bloodType)
                        <option value="{{ $bloodType->id }}"
                            @selected(old('blood_type_id', $donor->blood_type_id ?? null) == $bloodType->id)>
                            {{ $bloodType->type }}{{ $bloodType->rhesus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $donor->phone ?? '') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                           placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Donor Terakhir</label>
                    <input type="date" name="last_donation_date"
                           value="{{ old('last_donation_date', isset($donor->last_donation_date) ? \Illuminate\Support\Carbon::parse($donor->last_donation_date)->format('Y-m-d') : '') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                          placeholder="Masukkan alamat lengkap">{{ old('address', $donor->location->address ?? '') }}</textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $donor->location->latitude ?? '') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                           placeholder="-2.345678">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $donor->location->longitude ?? '') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                           placeholder="99.123456">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Ketersediaan</label>
                <select name="is_available" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <option value="1" @selected(old('is_available', $donor->is_available ?? 0) == 1)>Tersedia</option>
                    <option value="0" @selected(old('is_available', $donor->is_available ?? 0) == 0)>Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                Simpan Profil Donor
            </button>
        </form>
    </div>
@endsection