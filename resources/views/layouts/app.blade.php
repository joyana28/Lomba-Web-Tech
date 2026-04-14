<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DonorHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-red-600">DonorHub</a>
                <p class="text-xs text-slate-500">Koordinasi donor darah komunitas</p>
            </div>

            @auth
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('dashboard') }}" class="hover:text-red-600">Dashboard</a>
                    <a href="{{ route('requests.index') }}" class="hover:text-red-600">Request Donor</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('requests.create') }}" class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Buat Request</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg border border-slate-300 hover:bg-slate-100">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3">
                <p class="font-semibold mb-2">Ada input yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>