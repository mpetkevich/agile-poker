<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
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
    public function vote($roomID)
    {
        return view('rooms.vote')->with('roomID', $roomID);
    }

    public function voteDataGet($roomID)
    {
        $userId = Auth::id();

        $vote = Vote::where(['room_id' => $roomID, 'user_id' => $userId])->first();

        $response = [];
        if ($vote) {
            $response['vote'] = $vote->vote;
            $response['room'] = Vote::where(['room_id' => $roomID])->with('user')->get();
        }

        $room = Room::find($roomID);
        if (User::isAdmin() || $room->user == Auth::user()) {
            //  $response['room'] = Vote::where(['room_id'=> $roomID])->with('user')->get();
            $response['admin'] = true;
        }

        $response['roomName'] = Room::find($roomID)->name;

        return response()->json($response);
    }

    public function clearVotesDataPost($roomID)
    {
        $room = Room::find($roomID);
        if (User::isAdmin() || $room->user == Auth::user()) {
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
            $newVote->vote = $validatedData['vote'];
            $newVote->save();
        }

        return $this->voteDataGet($roomID);
    }



}
