@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 space-y-6">

  {{-- 🔍 Horizontal Filter --}}
  <form method="GET" action="{{ route('communication.announcements.index') }}"
        class="flex flex-wrap gap-4 bg-white shadow p-4 rounded-xl items-end">
    <div>
      <label class="text-sm text-gray-600">Cari Judul</label>
      <input type="text" name="search" value="{{ request('search') }}"
             class="w-48 md:w-64 border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
      <label class="text-sm text-gray-600">Kategori</label>
      <select name="category" class="w-36 border-gray-300 rounded-md shadow-sm">
        <option value="">Semua</option>
        @foreach(['informasi', 'jadwal', 'keuangan', 'darurat', 'lainnya'] as $cat)
          <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="text-sm text-gray-600">Target</label>
      <select name="target" class="w-36 border-gray-300 rounded-md shadow-sm">
        <option value="">Semua</option>
        @foreach(['all', 'guru', 'ortu', 'siswa'] as $role)
          <option value="{{ $role }}" {{ request('target') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="text-sm text-gray-600">Prioritas</label>
      <select name="priority" class="w-36 border-gray-300 rounded-md shadow-sm">
        <option value="">Semua</option>
        @foreach(['normal', 'tinggi', 'mendesak'] as $prio)
          <option value="{{ $prio }}" {{ request('priority') === $prio ? 'selected' : '' }}>{{ ucfirst($prio) }}</option>
        @endforeach
      </select>
    </div>
    @php
      $role = Auth::user()?->role?->name;
    @endphp
    <div class="flex items-center gap-2 ml-auto">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Filter</button>
       @if ($role === 'admin')
        <a href="{{ route('communication.announcements.create') }}" class="text-sm text-blue-600 hover:underline">+ Tambah</a>
      @endif
    </div>
  </form>

  <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    {{-- Main Content --}}
    <section class="col-span-3 space-y-6">

      {{-- Info --}}
      @if ($announcements->total() > 0)
        <p class="text-sm text-gray-500">Menampilkan {{ $announcements->firstItem() }} – {{ $announcements->lastItem() }} dari {{ $announcements->total() }} pengumuman</p>
      @endif

      {{-- List --}}
      @forelse($announcements as $announcement)
        <div class="bg-white p-5 rounded-xl shadow border border-gray-100 hover:border-blue-200 transition">
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
              <img src="{{ asset('images/user.png') }}" class="w-9 h-9 rounded-full" alt="user">
              <div>
                <p class="text-sm font-semibold text-gray-800">{{ $announcement->creator->name }}</p>
                <p class="text-xs text-gray-500">{{ $announcement->published_at?->format('d M Y, H:i') ?? '-' }}</p>
              </div>
            </div>
            @if($announcement->is_pinned)
              <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">📌 Pinned</span>
            @endif
          </div>

          <div class="mt-3">
            <span class="inline-block text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
              #{{ ucfirst($announcement->category) }}
            </span>
            <h3 class="text-lg font-bold mt-1 text-gray-900">{{ $announcement->title }}</h3>
            <p class="text-sm text-gray-700 mt-1 line-clamp-3">{{ Str::limit(strip_tags($announcement->content), 180) }}</p>
          </div>

          <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
            <div class="flex gap-4 items-center">
              <span>🎯 {{ ucfirst($announcement->target) }}</span>
              <span class="px-2 py-1 text-xs rounded bg-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-100 text-{{ $announcement->priority === 'mendesak' ? 'red' : ($announcement->priority === 'tinggi' ? 'yellow' : 'gray') }}-700">
                {{ ucfirst($announcement->priority) }}
              </span>
              <span>💬 {{ $announcement->comments_count ?? 0 }} Komentar</span>
            </div>
            <a href="{{ route('communication.announcements.show', $announcement->id) }}" class="text-blue-600 font-semibold hover:underline">Lihat Detail</a>
          </div>
        </div>
      @empty
        <p class="text-gray-500 text-center">Belum ada pengumuman.</p>
      @endforelse

      {{-- Tombol Lihat Lebih Banyak --}}
      @if ($announcements->hasMorePages())
        <div class="text-center mt-6">
          <a href="{{ $announcements->nextPageUrl() }}" class="inline-block px-5 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
            Lihat Lebih Banyak
          </a>
        </div>
      @endif
    </section>

    {{-- Sidebar Pinned --}}
    <aside class="col-span-1 bg-white p-4 shadow rounded-xl h-fit">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">📌 Pinned</h3>
      @forelse($pinned as $pin)
        <div class="mb-4">
          <p class="text-sm font-bold text-gray-800">{{ $pin->title }}</p>
          <p class="text-xs text-gray-500">{{ Str::limit(strip_tags($pin->content), 50) }}</p>
          <a href="{{ route('communication.announcements.show', $pin->id) }}" class="text-xs text-blue-600 hover:underline">Lihat post</a>
        </div>
      @empty
        <p class="text-gray-500 text-sm">Tidak ada pinned.</p>
      @endforelse
    </aside>

  </div>
</div>
@endsection
