<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DonorHub' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">

    @php
        $user = auth()->user();
        $isAdmin = $user && $user->role === 'admin';
        $homeRoute = $isAdmin ? route('dashboard') : route('user.home');

        $unreadNotifications = 0;
        if ($user) {
            $unreadNotifications = \App\Models\Notification::query()
                ->where('user_id', $user->id)
                ->where('status', '!=', 'read')
                ->count();
        }
    @endphp

    <div class="min-h-screen">
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-20 flex items-center justify-between">
                    <div class="flex items-center gap-8">
                        <a href="{{ $homeRoute }}" class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl shadow-sm">
                                🩸
                            </div>
                            <div>
                                <div class="text-2xl font-extrabold text-red-600 tracking-tight">DonorHub</div>
                                <div class="text-xs text-slate-500 -mt-1">
                                    {{ $isAdmin ? 'Admin Panel' : 'Donor Portal' }}
                                </div>
                            </div>
                        </a>

                        <nav class="hidden md:flex items-center gap-2">
                            @if($isAdmin)
                                <a href="{{ route('dashboard') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Dashboard
                                </a>

                                <a href="{{ route('requests.index') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('requests.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Request
                                </a>
                            @else
                                <a href="{{ route('user.home') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('user.home') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Home
                                </a>

                                <a href="{{ route('donor.profile') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('donor.profile*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Profil
                                </a>

                                <a href="{{ route('requests.index') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('requests.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Kebutuhan Donor
                                </a>

                                <a href="{{ route('history.index') }}"
                                   class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('history.*') ? 'bg-red-50 text-red-600' : 'text-slate-600 hover:bg-slate-100' }}">
                                    Riwayat
                                </a>
                            @endif
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('notifications.index') }}"
                           class="relative w-11 h-11 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 transition flex items-center justify-center text-lg">
                            🔔
                            @if($unreadNotifications > 0)
                                <span class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 rounded-full bg-red-600 text-white text-[10px] font-bold flex items-center justify-center">
                                    {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                                </span>
                            @endif
                        </a>

                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-semibold text-slate-800">{{ $user?->name }}</div>
                            <div class="text-xs text-slate-500">{{ $isAdmin ? 'Administrator' : 'Pendonor Sukarela' }}</div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition shadow-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
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
    </div>

    @stack('scripts')
</body>
</html>