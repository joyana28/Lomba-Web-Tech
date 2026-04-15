<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - DonorHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-red-600">🩸 DonorHub</h1>

        <div class="flex items-center gap-4">
            <span class="text-gray-600">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- HERO -->
    <div class="p-6 max-w-6xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold mb-2">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-gray-600 mb-6">
            Mari bantu sesama dengan menjadi donor darah. Akses fitur di bawah untuk mulai berkontribusi.
        </p>

        <!-- MENU UTAMA -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- PROFIL -->
            <a href="{{ route('donor.profile') }}" 
               class="bg-white p-6 rounded shadow hover:shadow-lg transition block">
                <h3 class="text-lg font-semibold text-red-500 mb-2">👤 Profil Saya</h3>
                <p class="text-gray-600 text-sm">
                    Kelola data diri dan informasi donor Anda.
                </p>
            </a>

            <!-- REQUEST -->
            <a href="{{ route('requests.index') }}" 
               class="bg-white p-6 rounded shadow hover:shadow-lg transition block">
                <h3 class="text-lg font-semibold text-blue-500 mb-2">🩸 Permintaan Donor</h3>
                <p class="text-gray-600 text-sm">
                    Lihat dan respon permintaan donor darah.
                </p>
            </a>

            <!-- HISTORY -->
            <a href="{{ route('history.index') }}" 
               class="bg-white p-6 rounded shadow hover:shadow-lg transition block">
                <h3 class="text-lg font-semibold text-green-500 mb-2">📜 Riwayat Donasi</h3>
                <p class="text-gray-600 text-sm">
                    Lihat riwayat donasi yang pernah Anda lakukan.
                </p>
            </a>

            <!-- NOTIF -->
            <a href="{{ route('notifications.index') }}" 
               class="bg-white p-6 rounded shadow hover:shadow-lg transition block">
                <h3 class="text-lg font-semibold text-yellow-500 mb-2">🔔 Notifikasi</h3>
                <p class="text-gray-600 text-sm">
                    Cek notifikasi terbaru terkait donor.
                </p>
            </a>

            <!-- MATCHING -->
            <a href="#" 
               class="bg-white p-6 rounded shadow hover:shadow-lg transition block">
                <h3 class="text-lg font-semibold text-purple-500 mb-2">🧠 Smart Matching</h3>
                <p class="text-gray-600 text-sm">
                    Sistem akan mencarikan donor terbaik secara otomatis.
                </p>
            </a>

        </div>

    </div>

</body>
</html>