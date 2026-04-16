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
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-red-400"
                                    placeholder="Buat password"
                                >
                                <button type="button"
                                    onclick="togglePassword('password', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-red-400"
                                    placeholder="Ulangi password"
                                >
                                <button type="button"
                                    onclick="togglePassword('password_confirmation', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
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

<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector("svg");

    if (input.type === "password") {
        input.type = "text";
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.944-9.543-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.27 2.944 9.543 7a9.96 9.96 0 01-4.132 5.411M15 12a3 3 0 01-4.243 2.829M9.88 9.88A3 3 0 0115 12M3 3l18 18" />
        `;
    } else {
        input.type = "password";
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
</script>

</body>
</html>