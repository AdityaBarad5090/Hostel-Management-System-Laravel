<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Student;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $count = Student::where('room_id', $room->id)->count();
            if ($count >= $room->capacity) {
                $room->status = 'full';
            } else {
                $room->status = 'available';
            }
        }
        return view('rooms', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'capacity' => 'required|numeric|min:1',
            'fee' => 'required|numeric'
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'fee' => $request->fee,
        ]);

        return redirect()->back()->with('success', 'Room Added');
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'room_number' => 'required',
            'capacity' => 'required|numeric|min:1',
            'fee' => 'required|numeric'
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'fee' => $request->fee
        ]);

        return redirect()->back()->with('success', 'Room Updated');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $count = Student::where('room_id', $room->id)->count();

        if ($count > 0) {
            return redirect()->back()->with('error', 'Cannot delete room with students');
        }
        $room->delete();

        return redirect()->back()->with('success', 'Room Deleted');
    }
}
