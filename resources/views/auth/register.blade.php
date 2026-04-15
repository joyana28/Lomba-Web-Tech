<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DonorHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen grid lg:grid-cols-2">
        <div class="hidden lg:flex bg-gradient-to-br from-red-600 to-rose-500 text-white p-12 flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl">
                        🩸
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">DonorHub</h1>
                        <p class="text-red-100 text-sm">Komunitas Donor Darah Lokal</p>
                    </div>
                </div>

                <div class="max-w-md">
                    <h2 class="text-4xl font-bold leading-tight mb-4">
                        Buat akun dan mulai terhubung dengan komunitas donor.
                    </h2>
                    <p class="text-red-50 text-lg leading-relaxed">
                        Daftar sekarang untuk membuat request donor, menerima notifikasi,
                        dan ikut berkontribusi dalam ekosistem donor darah yang lebih terorganisasi.
                    </p>
                </div>
            </div>

            <div class="text-sm text-red-100">
                Techsprint Innovation Cup 2026 · DonorHub Komunitas
            </div>
        </div>

        <div class="flex items-center justify-center p-6 sm:p-10">
            <div class="w-full max-w-md">
                <div class="text-center mb-8 lg:hidden">
                    <div class="text-4xl mb-3">🩸</div>
                    <h1 class="text-2xl font-bold text-red-600">DonorHub</h1>
                    <p class="text-slate-500 text-sm">Komunitas Donor Darah Lokal</p>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-slate-900">Buat Akun</h2>
                        <p class="text-slate-500 mt-2">Lengkapi data berikut untuk mendaftar ke DonorHub.</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                                placeholder="Masukkan email"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                                placeholder="Buat password"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"
                                placeholder="Ulangi password"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-red-600 text-white py-3 font-semibold hover:bg-red-700 transition"
                        >
                            Daftar
                        </button>
                    </form>

                    <div class="mt-6 text-sm text-center text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">
                            Login
                        </a>
                    </div>
                </div>

                <p class="text-center text-xs text-slate-400 mt-6">
                    DonorHub · Sistem koordinasi donor darah berbasis komunitas
                </p>
            </div>
        </div>
    </div>

</body>
</html>