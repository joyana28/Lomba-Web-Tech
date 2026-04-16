@extends('layouts.app', ['title' => 'Home Donor - DonorHub'])

@section('content')
    @php
        $myDonor = \App\Models\Donor::query()
            ->with('cooldown')
            ->where('user_id', auth()->id())
            ->first();

        $openRequestsCount = \App\Models\DonorRequest::query()
            ->where('status', 'open')
            ->count();

        $unreadNotificationsCount = \App\Models\Notification::query()
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'read')
            ->count();

        $donationCount = 0;
        if ($myDonor) {
            $donationCount = \App\Models\DonationHistory::query()
                ->where('donor_id', $myDonor->id)
                ->count();
        }

        $availabilityLabel = 'Belum Lengkap';
        $availabilityColor = 'text-slate-600 bg-slate-100';

        if ($myDonor) {
            if ((int) $myDonor->is_available === 1) {
                $availabilityLabel = 'Tersedia Donor';
                $availabilityColor = 'text-green-700 bg-green-100';
            } else {
                $availabilityLabel = 'Tidak Tersedia';
                $availabilityColor = 'text-yellow-700 bg-yellow-100';
            }
        }
    @endphp

    <div class="grid xl:grid-cols-3 gap-6 mb-8">
        <div class="xl:col-span-2 rounded-[2rem] bg-gradient-to-r from-red-600 to-rose-500 text-white p-8 shadow-xl shadow-red-200">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 text-sm font-semibold mb-5">
                🩸 Portal Pendonor Sukarela
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                Selamat datang, {{ auth()->user()->name }} 👋
            </h1>

            <p class="mt-4 text-red-50 max-w-2xl leading-relaxed">
                Lengkapi profil donor Anda, pantau kebutuhan donor yang aktif, terima notifikasi, lalu tawarkan kesiapan donor saat dibutuhkan.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('donor.profile') }}"
                   class="px-5 py-3 rounded-2xl bg-white text-red-600 font-bold hover:bg-red-50 transition">
                    Lengkapi Profil
                </a>

                <a href="{{ route('requests.index') }}"
                   class="px-5 py-3 rounded-2xl border border-white/30 text-white font-bold hover:bg-white/10 transition">
                    Lihat Kebutuhan Donor
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
            <div class="text-sm text-slate-500 mb-2">Status Donor</div>
            <div class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $availabilityColor }}">
                {{ $availabilityLabel }}
            </div>

            @if($myDonor && $myDonor->cooldown && $myDonor->cooldown->cooldown_until && \Carbon\Carbon::parse($myDonor->cooldown->cooldown_until)->isFuture())
                <div class="mt-5 rounded-2xl bg-yellow-50 border border-yellow-200 p-4">
                    <div class="font-semibold text-yellow-700">Masa Cooldown Aktif</div>
                    <div class="text-sm text-yellow-700 mt-1">
                        Sampai {{ \Carbon\Carbon::parse($myDonor->cooldown->cooldown_until)->format('d M Y') }}
                    </div>
                </div>
            @else
                <div class="mt-5 rounded-2xl bg-green-50 border border-green-200 p-4">
                    <div class="font-semibold text-green-700">Siap Diproses Sistem</div>
                    <div class="text-sm text-green-700 mt-1">
                        Akun donor Anda siap menerima ajakan donor jika status tersedia aktif.
                    </div>
                </div>
            @endif

            <div class="mt-5 text-sm text-slate-500">
                Pastikan data golongan darah, lokasi, dan status ketersediaan selalu diperbarui.
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-4">🩸</div>
            <div class="text-sm text-slate-500">Kebutuhan Aktif</div>
            <div class="mt-2 text-3xl font-extrabold text-red-600">{{ $openRequestsCount }}</div>
            <p class="text-sm text-slate-500 mt-2">Kebutuhan donor yang masih terbuka saat ini.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-4">🔔</div>
            <div class="text-sm text-slate-500">Notifikasi Baru</div>
            <div class="mt-2 text-3xl font-extrabold text-blue-600">{{ $unreadNotificationsCount }}</div>
            <p class="text-sm text-slate-500 mt-2">Pemberitahuan yang belum Anda baca.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-4">📜</div>
            <div class="text-sm text-slate-500">Riwayat Donasi</div>
            <div class="mt-2 text-3xl font-extrabold text-green-600">{{ $donationCount }}</div>
            <p class="text-sm text-slate-500 mt-2">Jumlah donasi yang telah dikonfirmasi admin.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="text-3xl mb-4">👤</div>
            <div class="text-sm text-slate-500">Profil Donor</div>
            <div class="mt-2 text-xl font-bold text-slate-800">
                {{ $myDonor ? 'Lengkap' : 'Belum Lengkap' }}
            </div>
            <p class="text-sm text-slate-500 mt-2">Lengkapi profil agar sistem matching lebih akurat.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <a href="{{ route('requests.index') }}"
           class="group bg-white rounded-[2rem] border border-slate-200 shadow-sm p-7 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500">Aksi Utama</div>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2 group-hover:text-red-600 transition">
                        Lihat Kebutuhan Donor
                    </h3>
                    <p class="mt-3 text-slate-500 leading-relaxed">
                        Buka daftar kebutuhan donor yang aktif, cek detailnya, lalu tawarkan kesiapan donor jika Anda memenuhi syarat.
                    </p>
                </div>
                <div class="text-4xl">🧭</div>
            </div>
        </a>

        <a href="{{ route('notifications.index') }}"
           class="group bg-white rounded-[2rem] border border-slate-200 shadow-sm p-7 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500">Pusat Informasi</div>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2 group-hover:text-red-600 transition">
                        Buka Notifikasi
                    </h3>
                    <p class="mt-3 text-slate-500 leading-relaxed">
                        Cek notifikasi donor terbaru, pembaruan status donor, dan konfirmasi dari admin.
                    </p>
                </div>
                <div class="text-4xl">🔔</div>
            </div>
        </a>
    </div>
@endsection