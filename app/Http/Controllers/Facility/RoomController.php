<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\School;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('school')->paginate(10);
        return view('admin.masters.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $schools = School::all();
        return view('admin.masters.rooms.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
        ]);

        Room::create($request->only('name', 'school_id'));

        return redirect()->route('facility.rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $schools = School::all();
        return view('admin.masters.rooms.edit', compact('room', 'schools'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
        ]);

        $room->update($request->only('name', 'school_id'));

        return redirect()->route('facility.rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('facility.rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
