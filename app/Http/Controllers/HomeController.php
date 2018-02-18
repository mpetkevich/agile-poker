<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
        return view('home');
    }

//    /**
//     * Create a new controller instance.
//     *
//     */
//
//    public function myCaptcha()
//    {
//
//        return view('myCaptcha');
//
//    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function myCaptchaPost(Request $request)
    {

        request()->validate([

            'email' => 'required|email',

            'password' => 'required',

            'captcha' => 'required|captcha'

        ],

            ['captcha.captcha' => 'Invalid captcha code.']);

        dd("You are here :) .");

    }


    /**
     * Create a new controller instance.
     *
     */

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
