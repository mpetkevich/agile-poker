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

        $vote = Vote::where(['room_id' => $roomID, 'user_id' => $userId])->first();

        $response = [];
        if ($vote) {
            $response['vote'] = $vote->vote;
            $response['room'] = Vote::where(['room_id' => $roomID])->with('user')->get();
        }
        if (User::isAdmin()) {
            //  $response['room'] = Vote::where(['room_id'=> $roomID])->with('user')->get();
            $response['admin'] = true;
        }

        $response['roomName'] = Room::find($roomID)->name;

        return response()->json($response);
    }

    public function clearVotesDataPost($roomID)
    {

        if (User::isAdmin()) {
            Vote::where(['room_id' => $roomID])->delete();
        }

        return $this->voteDataGet($roomID);
    }

    public function voteDataPost(Request $request ,$roomID)
    {

        $validatedData = $request->validate([
            'vote' => 'required|numeric|max:10',
        ]);

        $userId = Auth::id();

        $vote = Vote::where(['room_id' => $roomID, 'user_id' => $userId])->first();
        if (!$vote) {
            $newVote = new Vote();
            $newVote->user_id =  $userId;
            $newVote->room_id = $roomID;
            $newVote->vote = $request->vote;
            $newVote->save();
        }

        return $this->voteDataGet($roomID);
    }


}
