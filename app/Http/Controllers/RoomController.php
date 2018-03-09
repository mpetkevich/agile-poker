<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rooms.rooms')->with('rooms', Room::all())->with('isAdmin',User::isAdmin());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newRoomGet()
    {
        if (User::isAdmin()) {
            return view('rooms.new');
        }

        return redirect()->route('rooms');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newRoomPost(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (User::isAdmin()) {
            $room = new Room();
            $room->name = $validatedData['name'];
            $room->save();
        }

        return redirect()->route('rooms');
    }


    public function deleteGet($roomID)
    {
        if (User::isAdmin()) {
            $room = Room::find($roomID);
            return view('rooms.delete')->with('room', $room);
        }

        return redirect()->route('rooms');
    }

    public function deletePost(Request $request,$roomID)
    {
        if (User::isAdmin()) {

            $room = Room::find($roomID);
            $room->delete();
        }

        return redirect()->route('rooms');
    }

}
