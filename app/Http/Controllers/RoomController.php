<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

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
     * @param $roomID
     * @return \Illuminate\Http\Response
     */
    public function work($roomID)
    {
        return view('roomsWork')->with('roomID', $roomID);
    }


}
