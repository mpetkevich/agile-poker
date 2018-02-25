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
        return view('rooms.rooms')->with('rooms', Room::all());
    }

    /**
     * Show the application dashboard.
     *
     * @param $roomID
     * @return \Illuminate\Http\Response
     */
    public function vote($roomID)
    {
        return view('rooms.vote')->with('roomID', $roomID);
    }

    public function voteDataGet($roomID)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        $vote = Vote::where(['room_id'=> $roomID, 'user_id'=>$userId])->first();

        $response = [];
        if($vote){
            $response['vote'] = $vote->vote;
        }
        if($userRole == User::ROLE_ADMIN){
            $response['room'] = Vote::where(['room_id'=> $roomID])->with('user')->get();
        }

        return 'aaa';//response()->json($response);
    }

    public function voteDataPost(Request $request)
    {

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
//
//        return response()->json([
//            'name' => 'Abigail',
//            'state' => 'CA'
//        ]);
    }


}
