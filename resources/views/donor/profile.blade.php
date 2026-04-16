@extends('layouts.app', ['title' => 'Profil Donor - DonorHub'])

@section('content')
    <div class="mb-8">
        <div class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold mb-4">
            Profil Pendonor
        </div>
        <h1 class="text-3xl font-bold text-slate-900">Lengkapi Profil Donor</h1>
        <p class="mt-2 text-slate-500 max-w-2xl">
            Data ini membantu sistem matching menilai kecocokan donor berdasarkan golongan darah, lokasi, dan status ketersediaan Anda.
        </p>
    </div>

    <div class="grid xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 md:p-8">
            <form method="POST" action="{{ route('donor.profile.update') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Golongan Darah</label>
                    <select name="blood_type_id" class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">-- Pilih Golongan Darah --</option>
                        @foreach($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}"
                                @selected(old('blood_type_id', $donor->blood_type_id ?? null) == $bloodType->id)>
                                {{ $bloodType->type }}{{ $bloodType->rhesus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $donor->phone ?? '') }}"
                               class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Donor Terakhir</label>
                        <input type="date" name="last_donation_date"
                               value="{{ old('last_donation_date', isset($donor->last_donation_date) ? \Illuminate\Support\Carbon::parse($donor->last_donation_date)->format('Y-m-d') : '') }}"
                               class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <textarea name="address" rows="4"
                              class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $donor->location->address ?? '') }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $donor->location->latitude ?? '') }}"
                               class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="-2.345678">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $donor->location->longitude ?? '') }}"
                               class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                               placeholder="99.123456">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Ketersediaan</label>
                    <select name="is_available" class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="1" @selected(old('is_available', $donor->is_available ?? 0) == 1)>Tersedia</option>
                        <option value="0" @selected(old('is_available', $donor->is_available ?? 0) == 0)>Tidak Tersedia</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full rounded-2xl bg-red-600 text-white py-3.5 font-bold hover:bg-red-700 transition shadow-sm">
                    Simpan Profil Donor
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-3">Tips Profil Donor</h3>
                <ul class="space-y-3 text-sm text-slate-500 leading-relaxed">
                    <li>• Isi golongan darah dengan benar agar hasil matching tidak salah.</li>
                    <li>• Gunakan lokasi yang akurat supaya perhitungan donor terdekat lebih relevan.</li>
                    <li>• Ubah status ketersediaan jika Anda sedang tidak siap donor.</li>
                    <li>• Tanggal donor terakhir membantu sistem membaca kesiapan donor Anda.</li>
                </ul>
            </div>

            <div class="rounded-[2rem] bg-gradient-to-br from-red-600 to-rose-500 text-white p-6 shadow-lg shadow-red-200">
                <div class="text-sm text-red-100">Peran Anda</div>
                <h3 class="text-2xl font-bold mt-2">Pendonor Sukarela</h3>
                <p class="mt-3 text-red-50 text-sm leading-relaxed">
                    Setelah profil lengkap, Anda dapat menerima ajakan donor dan menawarkan kesiapan donor melalui sistem DonorHub.
                </p>
            </div>
        </div>
    </div>
@endsection