@extends('layouts.app')

@section('content')
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Manajemen Pengguna</h2>
    <p class="text-sm text-gray-500">Kelola data admin, guru, orang tua, dan siswa.</p>
  </div>
@if (session('success'))
  <div class="mb-6 rounded-lg bg-emerald-100 border border-emerald-300 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2 shadow">
    <svg class="w-5 h-5 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
  </div>

@endif

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    @php
      $cardStyles = 'bg-white border-l-4 rounded-xl px-4 py-3 shadow hover:scale-[1.01] transition';
    @endphp

    <div class="{{ $cardStyles }} border-blue-500">
      <p class="text-xs text-gray-500">Total Pengguna</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $users->total() }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-gray-500">
      <p class="text-xs text-gray-500">Admin</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['admin'] ?? 0 }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-emerald-500">
      <p class="text-xs text-gray-500">Guru</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['guru'] ?? 0 }}</h3>
    </div>
    <div class="{{ $cardStyles }} border-indigo-500">
      <p class="text-xs text-gray-500">Siswa</p>
      <h3 class="text-xl font-bold text-gray-800">{{ $counts['siswa'] ?? 0 }}</h3>
    </div>
  </div>

  <!-- Filter -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
    <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Cari nama pengguna..."
             class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-500" />

      <select name="role" class="rounded-lg px-3 py-2 text-sm border border-gray-300">
        <option value="">Semua Role</option>
        <option value="1" {{ request('role') == 1 ? 'selected' : '' }}>Admin</option>
        <option value="2" {{ request('role') == 2 ? 'selected' : '' }}>Guru</option>
        <option value="3" {{ request('role') == 3 ? 'selected' : '' }}>Orang Tua</option>
        <option value="4" {{ request('role') == 4 ? 'selected' : '' }}>Siswa</option>
      </select>

      <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        Filter
      </button>
    </form>

    <a href="{{ route('core.users.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
      + Tambah Pengguna
    </a>
  </div>

  <!-- Table -->
  <div class="bg-white shadow rounded-xl overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left border-collapse">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs border-b">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">Nama</th>
          <th class="px-6 py-3">Email</th>
          <th class="px-6 py-3">No. HP</th>
          <th class="px-6 py-3">Role</th>
          <th class="px-6 py-3">Sidik Jari Ibu Jari</th>
          <th class="px-6 py-3">Sidik Jari Telunjuk</th>
          <th class="px-6 py-3">Sidik Jari Tengah</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($users as $index => $user)
          <tr class="hover:bg-blue-50 transition">
            <td class="px-6 py-3">{{ $users->firstItem() + $index }}</td>
            <td class="px-6 py-3 font-medium text-gray-900">{{ $user->name }}</td>
            <td class="px-6 py-3 text-gray-700">{{ $user->email }}</td>
            <td class="px-6 py-3 text-gray-700">
              {{ $user->phone_number ?? '-' }}  
            </td>   
            <td class="px-6 py-3 text-gray-700">
              @php $roles = [1 => 'Admin', 2 => 'Guru', 3 => 'Orang Tua', 4 => 'Siswa']; @endphp
              {{ $roles[$user->role_id] ?? '-' }}
            </td>
            <td class="px-6 py-3 text-gray-700">
              @if ($user->fingerprint == null)
                <span class="text-red-500">Tidak Tersedia</span>
              @else
                <span class="text-green-500">Tersedia</span>
              @endif            
            </td>
            <td class="px-6 py-3 text-gray-700">
              @if ($user->fingerprint2 == null)
                <span class="text-red-500">Tidak Tersedia</span>
              @else
                <span class="text-green-500">Tersedia</span>
              @endif            
            </td>
            <td class="px-6 py-3 text-gray-700">
              @if ($user->fingerprint3 == null)
                <span class="text-red-500">Tidak Tersedia</span>
              @else
                <span class="text-green-500">Tersedia</span>
              @endif            
            </td>
            <td class="px-6 py-3 text-gray-700">
              @if ($user->is_active)
                <span class="text-green-500">Aktif</span>
              @else
                <span class="text-red-500">Tidak Aktif</span>
              @endif
            </td>
            <td class="px-6 py-3 text-center whitespace-nowrap space-x-2">
              <!-- <a href="{{ route('core.fingerprint.create', $user->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
                Tambah Sidik Jari
              </a> -->
              @if ($user->is_active)
                <form action="{{ route('core.users.deactivate', $user->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menonaktifkan pengguna ini?')">
                      @csrf
                  <button type="submit"
                          class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                    Non Aktifkan
                  </button>
                </form>
              @else
                <form action="{{ route('core.users.activate', $user->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin mengaktifkan pengguna ini?')">
                      @csrf 
                      <button type="submit"
                          class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded hover:bg-green-200">
                    Aktifkan
                    </button>
                </form>
              @endif
                <a href="{{ route('core.users.show', $user->id) }}"
                     class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                    Lihat
                </a>
              <a href="{{ route('core.users.edit', $user->id) }}"
                 class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                Edit
              </a>
              <form action="{{ route('core.users.destroy', $user->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded hover:bg-red-200">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Data pengguna tidak ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination + Counter -->
  <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-600">
    <p>
      Menampilkan {{ $users->firstItem() }} – {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
    </p>
    <div>
      {{ $users->appends(request()->query())->onEachSide(1)->links() }}
    </div>
  </div>
@endsection
