<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonorHub - Sistem Donor Darah Cerdas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">

<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl shadow-sm">
                    🩸
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-red-600 tracking-tight">DonorHub</div>
                    <div class="text-xs text-slate-500 -mt-1">Komunitas Donor Darah Lokal</div>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition shadow-sm">
                    Register
                </a>
            </div>
        </div>
    </div>
</header>

<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-rose-50"></div>
    <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-red-100 blur-3xl opacity-60"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-rose-100 blur-3xl opacity-60"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-18">
        <div class="grid lg:grid-cols-2 gap-10 items-center">

            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tight text-slate-900">
                    Sistem Donor Darah Cerdas
                    <span class="block text-red-600 mt-2">untuk Respons yang Lebih Cepat</span>
                </h1>

                <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                    DonorHub membantu menghubungkan kebutuhan donor darah dengan calon donor yang sesuai
                    berdasarkan golongan darah, lokasi terdekat, prioritas, dan ketersediaan donor.
                </p>

                <div class="mt-8 grid grid-cols-3 gap-4 max-w-xl">
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-2xl font-extrabold text-red-600">Smart</div>
                        <div class="text-sm text-slate-500 mt-1">Matching donor otomatis</div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-2xl font-extrabold text-blue-600">Fast</div>
                        <div class="text-sm text-slate-500 mt-1">Notifikasi cepat</div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-2xl font-extrabold text-green-600">Local</div>
                        <div class="text-sm text-slate-500 mt-1">Fokus komunitas lokal</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/60 p-6">
                    <div class="space-y-4">

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="font-bold text-slate-800 mb-2">Donor Darah</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Donor darah adalah aksi sederhana yang bisa menyelamatkan nyawa. 
                                <span class="text-red-500 font-medium">Satu donor bisa membantu lebih dari satu orang.</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div class="rounded-2xl border border-red-100 bg-red-50 p-5">
                                <h3 class="font-semibold text-red-600 mb-2">🧠 Smart Matching</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Sistem membantu menemukan donor yang sesuai berdasarkan kebutuhan dan kondisi.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                                <h3 class="font-semibold text-blue-600 mb-2">📍 Lokasi Terdekat</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Mempermudah pencarian donor di sekitar lokasi agar proses lebih cepat.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-yellow-100 bg-yellow-50 p-5">
                                <h3 class="font-semibold text-yellow-600 mb-2">🔔 Notifikasi</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Memberikan informasi kepada donor secara cepat dan tepat.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-green-100 bg-green-50 p-5">
                                <h3 class="font-semibold text-green-600 mb-2">📊 Monitoring</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Memudahkan pengguna dalam melihat dan mengikuti proses donor darah.
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Alur Penggunaan DonorHub</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="rounded-3xl bg-slate-50 border border-slate-200 p-7">
                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-4">1</div>
                <h3 class="text-xl font-bold text-slate-800">Buat Request</h3>
                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                    User mengisi kebutuhan donor darah lengkap dengan golongan darah, jumlah, urgensi, dan lokasi.
                </p>
            </div>

            <div class="rounded-3xl bg-slate-50 border border-slate-200 p-7">
                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-4">2</div>
                <h3 class="text-xl font-bold text-slate-800">Sistem Matching</h3>
                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                    DonorHub menyeleksi donor potensial berdasarkan kecocokan darah, jarak, availability, dan cooldown.
                </p>
            </div>

            <div class="rounded-3xl bg-slate-50 border border-slate-200 p-7">
                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-4">3</div>
                <h3 class="text-xl font-bold text-slate-800">Pantau & Konfirmasi</h3>
                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                    Donor merespons, admin memantau progres, lalu sistem mencatat histori donor secara lebih tertib.
                </p>
            </div>
        </div>
        <div class="mt-12 text-center">
    <h3 class="text-xl font-semibold text-slate-800 mb-3">
        Siap untuk mulai membantu sesama?
    </h3>
    <p class="text-slate-500 mb-6">
        Bergabung sekarang dan jadilah bagian dari solusi dalam membantu kebutuhan donor darah.
    </p>

    <a href="{{ route('login') }}"
       class="inline-block px-8 py-3 rounded-2xl bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-lg">
        Mulai Sekarang
    </a>
</div>
    </div>
</section>

<footer class="border-t border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-slate-500">
        © 2026 DonorHub · Sistem Penghubung Donor Darah
    </div>
</footer>

</body>
</html>