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
        return view('rooms.rooms')->
        with('rooms', Room::all())->
        with('user', Auth::user());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newRoomGet()
    {
        return view('rooms.new');
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

        $room = new Room();
        $room->name = $validatedData['name'];
        $room->user_id = Auth::id();
        $room->save();

        return redirect()->route('rooms');
    }

    /**
     * @param $roomID
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function deleteGet($roomID)
    {
        $room = Room::find($roomID);

        if (User::isAdmin() || $room->user == Auth::user()) {
            return view('rooms.delete')->with('room', $room);
        }

        return redirect()->route('rooms');
    }

    /**
     * @param Request $request
     * @param $roomID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost(Request $request, $roomID)
    {
        $room = Room::find($roomID);
        if (User::isAdmin() || $room->user == Auth::user()) {
            $room->delete();
        }

        return redirect()->route('rooms');
    }

}
