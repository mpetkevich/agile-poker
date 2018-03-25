<?php

namespace App\Http\Controllers;

use App\Room;
use App\Settings;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('authAdmin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.users')->with('users', User::all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function indexPost(Request $request)
    {
        $validatedData = $request->validate([
            'user-self-register-allowed' => 'boolean',
        ]);

        if (isset($validatedData['user-self-register-allowed'])) {
            Settings::set('userSelfRegisterAllowed', $validatedData['user-self-register-allowed'] === '1');
            Settings::save();

        }

        return $this->index();


    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newUserGet()
    {

        return view('users.edit')->with('user', new User());
    }

    public function newUserPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer',
        ]);

        /** @var User $user */
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        $user->save();

        return redirect()->route('users');
    }

    public function editUserGet($id)
    {
        return view('users.edit')->with('user', User::find($id));
    }

    public function editUserPost(Request $request, $id)
    {

        return redirect()->route('users');
    }

//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function newUserPost(Request $request)
//    {
//        $validatedData = $request->validate([
//            'name' => 'required|string|max:255',
//        ]);
//
//        $room = new Room();
//        $room->name = $validatedData['name'];
//        $room->user_id = Auth::id();
//        $room->save();
//
//        return redirect()->route('rooms');
//    }
//
//    /**
//     * @param $roomID
//     * @return $this|\Illuminate\Http\RedirectResponse
//     */
//    public function deleteGet($roomID)
//    {
//        $room = Room::find($roomID);
//
//        if (User::isAdmin() || $room->user == Auth::user()) {
//            return view('rooms.delete')->with('room', $room);
//        }
//
//        return redirect()->route('rooms');
//    }
//
//    /**
//     * @param Request $request
//     * @param $roomID
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function deletePost(Request $request, $roomID)
//    {
//        $room = Room::find($roomID);
//        if (User::isAdmin() || $room->user == Auth::user()) {
//            $room->delete();
//        }
//
//        return redirect()->route('rooms');
//    }

}
