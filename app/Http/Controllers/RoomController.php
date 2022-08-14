<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name');
        $room_all = Room::select('id', 'name' )->get(); 
        if($name){
            $rooms = Room::where('name','like','%'.$name.'%')
            ->with('users')
            ->paginate(5);
        }else{ 
            $rooms = Room::with('users')
            ->paginate(5);  
        } 
        return view('admin.room.list', [
            'rooms' => $rooms,  
            'name' => $name,
            'room_all' => $room_all,
        ]);
    }
    public function changeStatus(Request $request)
    { 
        $rooms = Room::find($request->id); 
        $rooms->status = $request->status; 
        $rooms->save(); 
        return response()->json(['success'=>'Status change successfully.']); 
    } 
    public function delete(Room $room) {
        if($room->delete()) {
            return redirect()->back();
        }
    }
    public function create()
    { 
        $room_all = Room::select('id', 'name' )->get(); 
        return view('admin.room.create', [
            'room_all' => $room_all
        ]);
    }
    public function store(RoomRequest $request)
    {  
        $room = new Room(); 
        $room->fill($request->all());  
        $room->save();
        return redirect()->route('rooms.list'); 
    }

    public function edit(Room $room)
    {
        // $room->birthday = date('Y-m-d', strtotime($room->birthday));
        $room_all = Room::select('id', 'name' )->get();
        return view('admin.room.create', [
            'room' => $room,
            'room_all' => $room_all,
        ]);
    }  
    public function update(RoomRequest $request, Room $Room) { 
        $Room->fill($request->except('->id')); 
        $Room->save();
        return redirect()->route('rooms.list');
    }
}
