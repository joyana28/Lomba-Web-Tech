<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonorHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-white min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="flex justify-between items-center px-8 py-4 bg-white shadow">
        <h1 class="text-2xl font-bold text-red-600">🩸 DonorHub</h1>

        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-4 py-2 border border-red-500 text-red-500 rounded hover:bg-red-500 hover:text-white transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                Register
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="flex flex-col items-center justify-center text-center flex-1 px-6">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Sistem Donor Darah Cerdas
        </h2>

        <p class="text-lg text-gray-600 max-w-xl mb-6">
            Menghubungkan pendonor dan pasien secara cepat, tepat, dan efisien dengan teknologi matching berbasis lokasi dan prioritas.
        </p>

        <div class="space-x-4">
            <a href="{{ route('register') }}" class="px-6 py-3 bg-red-500 text-white rounded-lg text-lg hover:bg-red-600 transition">
                Mulai Donor Sekarang
            </a>

            <a href="{{ route('login') }}" class="px-6 py-3 border border-gray-400 rounded-lg text-lg hover:bg-gray-100 transition">
                Sudah Punya Akun?
            </a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-12 bg-white">
        <div class="max-w-5xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-8">Fitur Unggulan</h3>

            <div class="grid md:grid-cols-3 gap-6 px-6">
                
                <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="font-semibold text-red-500 mb-2">🧠 Smart Matching</h4>
                    <p class="text-gray-600 text-sm">
                        Sistem otomatis mencocokkan donor berdasarkan golongan darah, lokasi, dan prioritas.
                    </p>
                </div>

                <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="font-semibold text-red-500 mb-2">📍 Lokasi Terdekat</h4>
                    <p class="text-gray-600 text-sm">
                        Menemukan donor terdekat untuk mempercepat proses penyelamatan.
                    </p>
                </div>

                <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="font-semibold text-red-500 mb-2">🔔 Notifikasi Real-time</h4>
                    <p class="text-gray-600 text-sm">
                        Update permintaan donor langsung ke pengguna secara cepat.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center py-4 text-gray-500 text-sm">
        © {{ date('Y') }} DonorHub - TechSprint Innovation Cup 🚀
    </footer>

</body>
</html>