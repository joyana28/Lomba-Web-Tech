@extends('layouts.app')

@section('title', 'Buat Request Donor - DonorHub')

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h1 class="text-3xl font-bold mb-2">Buat Request Donor</h1>
            <p class="text-slate-600 mb-6">Isi kebutuhan donor sesuai kondisi lapangan. Setelah disimpan, sistem akan langsung menjalankan smart matching.</p>

            <form action="{{ route('requests.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-2">Golongan darah yang dibutuhkan</label>
                        <select name="blood_type_id" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500">
                            <option value="">Pilih golongan darah</option>
                            @foreach($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}" @selected(old('blood_type_id') == $bloodType->id)>
                                    {{ $bloodType->type }}{{ $bloodType->rhesus }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Jumlah kantong</label>
                        <input type="number" name="quantity" min="1" max="20" value="{{ old('quantity', 1) }}" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-2">Tingkat urgensi</label>
                        <select name="urgency" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500">
                            <option value="medium" @selected(old('urgency') === 'medium')>Medium</option>
                            <option value="high" @selected(old('urgency') === 'high')>High</option>
                            <option value="low" @selected(old('urgency') === 'low')>Low</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Deadline</label>
                        <input type="datetime-local" name="deadline" value="{{ old('deadline') }}" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Alamat lokasi kebutuhan donor</label>
                    <textarea name="address" rows="3" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" placeholder="Contoh: RSUD Porsea, Toba">{{ old('address') }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-2">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" placeholder="Contoh: 2.6666">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" placeholder="Contoh: 99.0666">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                        Simpan & Jalankan Matching
                    </button>
                    <a href="{{ route('requests.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-fit">
            <h2 class="text-lg font-semibold mb-4">Logika matching</h2>
            <ul class="space-y-3 text-sm text-slate-600 list-disc list-inside">
                <li>Prioritas tertinggi diberikan pada donor dengan golongan darah dan rhesus paling sesuai.</li>
                <li>Donor yang sedang cooldown atau menonaktifkan ketersediaan tidak akan diprioritaskan.</li>
                <li>Jarak donor ke lokasi request ikut menaikkan skor prioritas.</li>
                <li>Setelah request dibuat, sistem otomatis menyimpan kandidat dan menyiapkan notifikasi.</li>
            </ul>
        </div>
    </div>
@endsection