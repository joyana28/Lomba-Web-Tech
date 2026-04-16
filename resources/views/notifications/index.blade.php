@extends('layouts.app', ['title' => 'Notifikasi - DonorHub'])

@section('content')
    <div class="mb-8">
        <div class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold mb-4">
            Pusat Notifikasi
        </div>
        <h1 class="text-3xl font-bold text-slate-900">Notifikasi</h1>
        <p class="mt-2 text-slate-500">Lihat pemberitahuan terkait kebutuhan donor, respons donor, dan konfirmasi admin.</p>
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">🔔</div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada notifikasi</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto">
                Saat ada kebutuhan donor yang relevan atau admin mengonfirmasi proses donor Anda, notifikasi akan muncul di sini.
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-5 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex gap-4 flex-1">
                        <div class="w-12 h-12 rounded-2xl {{ $notification->status === 'read' ? 'bg-slate-100' : 'bg-red-100' }} flex items-center justify-center text-xl">
                            {{ $notification->status === 'read' ? '📩' : '🔔' }}
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @if($notification->status === 'read')
                                    <span class="px-3 py-1 rounded-full text-xs bg-slate-100 text-slate-600 font-semibold">
                                        SUDAH DIBACA
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 font-semibold">
                                        BARU
                                    </span>
                                @endif
                            </div>

                            <p class="font-medium text-slate-800 leading-relaxed">
                                {{ $notification->message ?? 'Ada notifikasi baru untuk Anda.' }}
                            </p>

                            <p class="mt-2 text-sm text-slate-500">
                                {{ $notification->created_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    @if($notification->status !== 'read')
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                                Tandai Dibaca
                            </button>
                        </form>
                    @else
                        <div class="text-sm font-semibold text-green-600">Sudah dibaca</div>
                    @endif
                </div>
            @endforeach

            <div class="pt-2">
                {{ $notifications->links() }}
            </div>
        </div>
    @endif
@endsection