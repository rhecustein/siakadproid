@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 space-y-6">

  {{-- Header Pengumuman --}}
  <div class="bg-white p-6 shadow rounded-xl border border-gray-100">
    <div class="flex justify-between items-start mb-4">
      <div class="flex gap-3 items-center">
        <img src="{{ asset('images/user.png') }}" class="w-10 h-10 rounded-full" alt="user">
        <div>
          <p class="text-sm font-semibold text-gray-800">{{ $announcement->creator->name }}</p>
          <p class="text-xs text-gray-500">{{ $announcement->published_at?->format('d M Y, H:i') ?? '-' }}</p>
        </div>
      </div>
      @if($announcement->is_pinned)
        <span class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full">📌 Pinned</span>
      @endif
    </div>

    {{-- Judul & Isi --}}
    <div class="space-y-2">
      <h1 class="text-2xl font-bold text-gray-900">{{ $announcement->title }}</h1>
      <div class="prose max-w-none text-sm text-gray-800">{!! $announcement->content !!}</div>
    </div>

    {{-- Metadata --}}
    <div class="mt-6 flex flex-wrap gap-4 text-sm text-gray-600">
      <span class="inline-block bg-gray-100 px-3 py-1 rounded-full">#{{ $announcement->category }}</span>
      <span class="inline-block bg-gray-100 px-3 py-1 rounded-full">🎯 {{ ucfirst($announcement->target) }}</span>
      <span class="inline-block bg-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-100 text-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-700 px-3 py-1 rounded-full">
        {{ ucfirst($announcement->priority) }}
      </span>
      <span class="inline-block px-3 py-1 rounded-full {{ $announcement->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
        {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
      </span>
    </div>
  </div>

  {{-- File Lampiran --}}
  @if ($announcement->files->count())
    <div class="bg-white p-5 shadow rounded-xl border border-gray-100">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">📎 Lampiran</h3>
      <ul class="space-y-2 text-sm text-blue-600">
        @foreach($announcement->files as $file)
          <li>
            <a href="{{ Storage::disk('public')->url($file->file_path) }}" target="_blank" class="hover:underline flex items-center gap-2">
              📄 {{ $file->file_name }}
              <span class="text-xs text-gray-500">
                ({{ strtoupper($file->mime_type) }}, {{ number_format($file->file_size / 1024, 1) }} KB)
              </span>
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- 💬 Komentar --}}
  <div class="bg-white p-5 shadow rounded-xl border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">💬 Komentar</h3>

    {{-- Daftar Komentar --}}
    @forelse($announcement->comments ?? [] as $comment)
      <div class="border-t py-3 text-sm flex gap-3">
        <img src="{{ asset('images/user.png') }}" class="w-8 h-8 rounded-full" alt="user">
        <div>
          <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
          <p class="text-gray-700">{{ $comment->message }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
      </div>
    @empty
      <p class="text-gray-500 text-sm">Belum ada komentar.</p>
    @endforelse

    {{-- Form Kirim Komentar --}}
    @auth
    <form method="POST" action="{{ route('announcements.comment', $announcement->id) }}" class="mt-6 space-y-2">
      @csrf
      <textarea name="message" rows="3"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-100 text-sm"
                placeholder="Tulis komentar...">{{ old('message') }}</textarea>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
        Kirim Komentar
      </button>
    </form>
    @else
    <div class="mt-4 text-sm text-gray-500">
      <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> untuk mengirim komentar.
    </div>
    @endauth
  </div>

  {{-- Tombol Kembali --}}
  <div>
    <a href="{{ route('announcements.index') }}" class="text-blue-600 hover:underline text-sm">← Kembali ke daftar</a>
  </div>
</div>
@endsection
