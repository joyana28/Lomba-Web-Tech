@extends('layouts.app', ['title' => 'Buat Request Donor'])

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900">Buat Request Donor</h1>
        <p class="text-slate-500 mt-1">Isi data kebutuhan donor darah.</p>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('requests.store') }}" class="space-y-5 bg-white p-6 rounded-2xl shadow">
        @csrf
        <div>
            <label class="block mb-2 font-semibold">Golongan Darah</label>
            <select name="blood_type_id" class="w-full border p-3 rounded-xl">
                <option value="">-- Pilih --</option>
                @foreach($bloodTypes as $blood)
                    <option value="{{ $blood->id }}">
                        {{ $blood->type }}{{ $blood->rhesus }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-2 font-semibold">Jumlah Kebutuhan</label>
            <input type="number" name="quantity" class="w-full border p-3 rounded-xl" placeholder="Contoh: 3">
        </div>
        <div>
            <label class="block mb-2 font-semibold">Tingkat Urgensi</label>
            <select name="urgency" class="w-full border p-3 rounded-xl">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div>
            <label class="block mb-2 font-semibold">Deadline</label>
            <input type="datetime-local" name="deadline" class="w-full border p-3 rounded-xl">
        </div>
        <div>
            <label class="block mb-2 font-semibold">Alamat</label>
            <textarea name="address" class="w-full border p-3 rounded-xl" rows="3"></textarea>
        </div>
        <div>
            <label class="block mb-2 font-semibold">Latitude</label>
            <input type="text" name="latitude" class="w-full border p-3 rounded-xl" placeholder="-2.123456">
        </div>
        <div>
            <label class="block mb-2 font-semibold">Longitude</label>
            <input type="text" name="longitude" class="w-full border p-3 rounded-xl" placeholder="99.123456">
        </div>

        <button class="w-full bg-red-600 text-white py-3 rounded-xl font-bold hover:bg-red-700">
            Simpan Request
        </button>
    </form>

</div>
@endsection