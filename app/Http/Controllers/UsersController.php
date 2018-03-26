<?php

namespace App\Http\Controllers;

use App\Room;
use App\Settings;
use App\User;
use App\Vote;
use Illuminate\Http\RedirectResponse;
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
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function newUserGet()
    {

        return view('users.edit')->with('user', new User());
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
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

    /**
     * @param $id
     * @return $this
     */
    public function editUserGet($id)
    {
        return view('users.edit')->with('user', User::find($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function editUserPost(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'integer',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if ($validatedData['password']) {
                $user->password = bcrypt($validatedData['password']);
            }
            $user->role = $validatedData['role'];
            $user->save();
        }

        return redirect()->route('users');
    }

    /**
     * @param $id
     * @return $this|RedirectResponse
     */
    public function deleteGet($id)
    {
        if (User::isAdmin()) {
            return view('users.delete')->with('user', User::find($id));
        }

        return redirect()->route('users');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deletePost(Request $request, $id)
    {
        if (User::isAdmin() && Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
        }
        return redirect()->route('users');
    }

}
