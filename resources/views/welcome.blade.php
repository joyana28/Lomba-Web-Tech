<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonorHub - Sistem Donor Darah Cerdas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- NAVBAR -->
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

    <!-- HERO -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-rose-50"></div>
        <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-red-100 blur-3xl opacity-60"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-rose-100 blur-3xl opacity-60"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- LEFT -->
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold mb-6">
                        ⚡ Smart Matching · Notifikasi Cepat · Radius Terdekat
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tight text-slate-900">
                        Sistem Donor Darah Cerdas
                        <span class="block text-red-600 mt-2">untuk Respons yang Lebih Cepat</span>
                    </h1>

                    <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                        DonorHub membantu menghubungkan kebutuhan donor darah dengan calon donor yang sesuai
                        berdasarkan golongan darah, lokasi terdekat, prioritas, dan ketersediaan donor.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center px-7 py-4 rounded-2xl bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">
                            Mulai Sekarang
                        </a>

                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-7 py-4 rounded-2xl border border-slate-300 bg-white text-slate-800 font-bold hover:bg-slate-50 transition">
                            Sudah Punya Akun?
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-3 gap-4 max-w-xl">
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

                <!-- RIGHT -->
                <div class="relative">
                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/60 p-6">
                        <div class="space-y-4">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-bold text-slate-800">Request Donor Aktif</h3>
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">DARURAT</span>
                                </div>
                                <p class="text-sm text-slate-500">Golongan darah O+ dibutuhkan di RSUD Porsea</p>
                                <div class="mt-4 flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Deadline: Hari ini, 19:00</span>
                                    <span class="font-bold text-red-600">2 Kantong</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-2xl border border-red-100 bg-red-50 p-5">
                                    <div class="text-sm text-red-600 font-semibold">Smart Matching</div>
                                    <div class="text-3xl font-extrabold text-slate-900 mt-2">12</div>
                                    <div class="text-sm text-slate-500 mt-1">Kandidat donor ditemukan</div>
                                </div>

                                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                                    <div class="text-sm text-blue-600 font-semibold">Notifikasi</div>
                                    <div class="text-3xl font-extrabold text-slate-900 mt-2">5</div>
                                    <div class="text-sm text-slate-500 mt-1">Donor terdekat dihubungi</div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-900 text-white p-5">
                                <div class="text-sm text-slate-300 mb-3">Keunggulan Sistem</div>
                                <ul class="space-y-2 text-sm">
                                    <li>• Cek kompatibilitas golongan darah</li>
                                    <li>• Pertimbangkan radius donor terdekat</li>
                                    <li>• Cek availability dan cooldown donor</li>
                                    <li>• Pantau request dan respons secara terpusat</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block absolute -bottom-5 -left-5 bg-white rounded-2xl border border-slate-200 shadow-lg px-4 py-3">
                        <div class="text-xs text-slate-500">Status Sistem</div>
                        <div class="font-bold text-green-600 mt-1">Siap Digunakan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold mb-4">
                    Fitur Unggulan
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Dirancang untuk Respons yang Cepat dan Tepat</h2>
                <p class="mt-4 text-slate-500 max-w-2xl mx-auto">
                    DonorHub membantu proses koordinasi donor darah agar lebih efisien, terukur, dan mudah dipantau oleh komunitas.
                </p>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="text-3xl mb-4">🧠</div>
                    <h3 class="text-xl font-bold text-slate-800">Smart Matching</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        Sistem otomatis mencocokkan donor berdasarkan golongan darah, prioritas, radius, dan status donor.
                    </p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="text-3xl mb-4">📍</div>
                    <h3 class="text-xl font-bold text-slate-800">Lokasi Terdekat</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        Membantu menemukan donor terdekat agar proses respons donor darah lebih cepat.
                    </p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="text-3xl mb-4">🔔</div>
                    <h3 class="text-xl font-bold text-slate-800">Notifikasi Cepat</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        Donor terpilih akan mendapatkan pemberitahuan lebih cepat untuk meningkatkan peluang respons.
                    </p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="text-3xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-slate-800">Dashboard Terpusat</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        Pantau request, donor tersedia, status pencarian, dan progres pemenuhan donor dalam satu tempat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-flex px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm font-semibold mb-4">
                    Cara Kerja
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Alur Penggunaan DonorHub</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8">
                    <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-5">1</div>
                    <h3 class="text-xl font-bold text-slate-800">Buat Request</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        User mengisi kebutuhan donor darah lengkap dengan golongan darah, jumlah, urgensi, dan lokasi.
                    </p>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8">
                    <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-5">2</div>
                    <h3 class="text-xl font-bold text-slate-800">Sistem Matching</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        DonorHub menyeleksi donor potensial berdasarkan kecocokan darah, jarak, availability, dan cooldown.
                    </p>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8">
                    <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-lg mb-5">3</div>
                    <h3 class="text-xl font-bold text-slate-800">Pantau & Konfirmasi</h3>
                    <p class="text-slate-500 mt-3 text-sm leading-relaxed">
                        Donor merespons, admin memantau progres, lalu sistem mencatat histori donor secara lebih tertib.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-gradient-to-r from-red-600 to-rose-500 text-white p-10 md:p-14 shadow-xl shadow-red-200">
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl font-extrabold">Siap bergabung dengan DonorHub?</h2>
                    <p class="mt-4 text-red-50 max-w-2xl mx-auto">
                        Buat akun sekarang untuk mulai membuat request donor, menerima notifikasi, dan ikut menjadi bagian dari komunitas donor darah yang lebih terkoordinasi.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}"
                           class="px-7 py-4 rounded-2xl bg-white text-red-600 font-bold hover:bg-red-50 transition">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                           class="px-7 py-4 rounded-2xl border border-white/40 text-white font-bold hover:bg-white/10 transition">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-sm text-slate-500">
                © 2026 DonorHub · TechSprint Innovation Cup
            </p>
            <p class="text-sm text-slate-400">
                Sistem donor darah berbasis komunitas lokal
            </p>
        </div>
    </footer>

</body>
</html>