<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DonorHub' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    @php
        $user = auth()->user();
        $isAdmin = $user && $user->role === 'admin';
        $homeRoute = $isAdmin ? route('dashboard') : route('user.home');
    @endphp

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <a href="{{ $homeRoute }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold shadow">
                            🩸
                        </div>
                        <div>
                            <div class="font-bold text-lg text-red-600">DonorHub</div>
                            <div class="text-xs text-slate-500 -mt-1">
                                {{ $isAdmin ? 'Admin Panel' : 'Donor Portal' }}
                            </div>
                        </div>
                    </a>

                    <div class="hidden md:flex items-center gap-2">
                        @if($isAdmin)
                            <a href="{{ route('dashboard') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Dashboard
                            </a>

                            <a href="{{ route('requests.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('requests.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Request
                            </a>

                            <a href="{{ route('reports.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Laporan
                            </a>

                            <a href="{{ route('notifications.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('notifications.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Notifikasi
                            </a>
                        @else
                            <a href="{{ route('user.home') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('user.home') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Home
                            </a>

                            <a href="{{ route('donor.profile') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('donor.profile*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Profil
                            </a>

                            <a href="{{ route('requests.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('requests.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Request
                            </a>

                            <a href="{{ route('notifications.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('notifications.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Notifikasi
                            </a>

                            <a href="{{ route('history.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('history.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                Riwayat
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-semibold text-slate-700">{{ $user?->name }}</div>
                        <div class="text-xs text-slate-500">{{ $isAdmin ? 'Administrator' : 'Donor' }}</div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>