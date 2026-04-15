@extends('layouts.app', ['title' => 'Home Donor - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Selamat datang, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-2 text-slate-500">Kelola profil donor, cek request, lihat notifikasi, dan pantau riwayat donasi Anda.</p>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
        <a href="{{ route('donor.profile') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="text-3xl mb-4">👤</div>
            <h3 class="font-bold text-lg text-slate-800 group-hover:text-red-600">Profil Donor</h3>
            <p class="text-sm text-slate-500 mt-2">Lengkapi data donor agar proses matching lebih akurat.</p>
        </a>

        <a href="{{ route('requests.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="text-3xl mb-4">🩸</div>
            <h3 class="font-bold text-lg text-slate-800 group-hover:text-red-600">Request Donor</h3>
            <p class="text-sm text-slate-500 mt-2">Lihat kebutuhan donor dan kirim respons jika Anda siap membantu.</p>
        </a>

        <a href="{{ route('notifications.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="text-3xl mb-4">🔔</div>
            <h3 class="font-bold text-lg text-slate-800 group-hover:text-red-600">Notifikasi</h3>
            <p class="text-sm text-slate-500 mt-2">Pantau pemberitahuan terbaru terkait request donor.</p>
        </a>

        <a href="{{ route('history.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="text-3xl mb-4">📜</div>
            <h3 class="font-bold text-lg text-slate-800 group-hover:text-red-600">Riwayat Donasi</h3>
            <p class="text-sm text-slate-500 mt-2">Lihat histori donasi Anda secara rapi dan terpusat.</p>
        </a>
    </div>

    <div class="mt-8 bg-gradient-to-r from-red-600 to-rose-500 text-white rounded-3xl p-8 shadow-lg">
        <h2 class="text-2xl font-bold">DonorHub Komunitas</h2>
        <p class="mt-2 text-red-50 max-w-2xl">
            Platform ini membantu menghubungkan donor darah sukarela dengan kebutuhan donor secara cepat,
            terstruktur, dan mudah dipantau.
        </p>
    </div>
@endsection