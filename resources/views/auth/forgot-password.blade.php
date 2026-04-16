<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - DonorHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md">

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

        <div class="text-center mb-6">
            <div class="text-3xl text-red-600 font-extrabold">DonorHub</div>
            <p class="text-slate-500 text-sm mt-1">Reset Password</p>
        </div>

        <h2 class="text-xl font-bold text-slate-800 text-center mb-4">
            Lupa Password?
        </h2>

        <p class="text-sm text-slate-500 text-center mb-6">
            Masukkan email kamu, kami akan mengirimkan link untuk reset password.
        </p>

        @if(session('status'))
            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-slate-600">Email</label>
                <input type="email" name="email"
                       class="w-full mt-1 border border-slate-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="Masukkan email kamu"
                       required>
            </div>

            <button type="submit"
                class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition shadow">
                Kirim Link Reset
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-red-500">
                ← Kembali ke Login
            </a>
        </div>

    </div>

</div>

</body>
</html>