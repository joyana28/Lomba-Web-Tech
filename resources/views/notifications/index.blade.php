@extends('layouts.app', ['title' => 'Notifikasi - DonorHub'])

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Notifikasi</h1>
        <p class="mt-2 text-slate-500">Lihat pemberitahuan terbaru terkait donor darah.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($notifications->isEmpty())
            <div class="p-10 text-center text-slate-500">
                Belum ada notifikasi.
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($notifications as $notification)
                    <div class="p-5 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="mb-2">
                                @if($notification->status === 'read')
                                    <span class="px-3 py-1 rounded-full text-xs bg-slate-100 text-slate-600 font-medium">
                                        SUDAH DIBACA
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 font-medium">
                                        BARU
                                    </span>
                                @endif
                            </div>

                            <p class="font-medium text-slate-800">{{ $notification->message ?? 'Ada notifikasi baru untuk Anda.' }}</p>
                            <p class="mt-2 text-sm text-slate-500">{{ $notification->created_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>

                        @if($notification->status !== 'read')
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                                    Tandai Dibaca
                                </button>
                            </form>
                        @else
                            <div class="text-sm font-medium text-green-600">Sudah dibaca</div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection