<form action="{{ $action }}" method="POST" class="space-y-4">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- User --}}
    <div>
        <label for="user_id" class="block text-sm font-semibold mb-1">Santri / Guru / Staff</label>
        <select name="user_id" id="user_id" required class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $attendance->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->role->name }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tanggal & Waktu --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="date" class="block text-sm font-semibold mb-1">Tanggal</label>
            <input type="date" name="date" id="date" class="w-full border rounded px-3 py-2"
                value="{{ old('date', $attendance->date ?? now()->toDateString()) }}" required>
        </div>
        <div>
            <label for="time" class="block text-sm font-semibold mb-1">Waktu</label>
            <input type="time" name="time" id="time" class="w-full border rounded px-3 py-2"
                value="{{ old('time', $attendance->time ?? now()->format('H:i')) }}" required>
        </div>
    </div>

    {{-- Role & Unit --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="role_type" class="block text-sm font-semibold mb-1">Role</label>
            <select name="role_type" id="role_type" class="w-full border rounded px-3 py-2" required>
                @foreach(['siswa', 'guru', 'staff'] as $role)
                    <option value="{{ $role }}" {{ old('role_type', $attendance->role_type ?? '') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="unit_id" class="block text-sm font-semibold mb-1">Unit / Kelas</label>
            <select name="unit_id" id="unit_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id', $attendance->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Status & Tipe --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="status" class="block text-sm font-semibold mb-1">Status Kehadiran</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2" required>
                @foreach(['hadir', 'izin', 'sakit', 'alfa'] as $status)
                    <option value="{{ $status }}" {{ old('status', $attendance->status ?? '') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="type" class="block text-sm font-semibold mb-1">Tipe</label>
            <select name="type" id="type" class="w-full border rounded px-3 py-2" required>
                <option value="masuk" {{ old('type', $attendance->type ?? '') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="pulang" {{ old('type', $attendance->type ?? '') == 'pulang' ? 'selected' : '' }}>Pulang</option>
            </select>
        </div>
    </div>

    {{-- Device & Location --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="device" class="block text-sm font-semibold mb-1">Perangkat</label>
            <input type="text" name="device" id="device" class="w-full border rounded px-3 py-2"
                value="{{ old('device', $attendance->device ?? '') }}">
        </div>
        <div>
            <label for="location" class="block text-sm font-semibold mb-1">Lokasi</label>
            <input type="text" name="location" id="location" class="w-full border rounded px-3 py-2"
                value="{{ old('location', $attendance->location ?? '') }}">
        </div>
    </div>

    {{-- Catatan --}}
    <div>
        <label for="notes" class="block text-sm font-semibold mb-1">Catatan</label>
        <textarea name="notes" id="notes" rows="3" class="w-full border rounded px-3 py-2">{{ old('notes', $attendance->notes ?? '') }}</textarea>
    </div>

    {{-- Checkbox Manual --}}
    <div class="flex items-center">
        <input type="checkbox" name="is_manual" id="is_manual" value="1"
            {{ old('is_manual', $attendance->is_manual ?? false) ? 'checked' : '' }}>
        <label for="is_manual" class="ml-2 text-sm">Input Manual</label>
    </div>

    {{-- Tombol Submit --}}
    <div class="pt-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
    </div>
</form>
