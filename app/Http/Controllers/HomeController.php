<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Gate::allows('isAdmin', Auth::user()->role_id)) {
            return view('home');
        } else if(Gate::allows('isAccountant', Auth::user()->role_id)) {
            return view('accountant');
        } else if(Gate::allows('isMerchant', Auth::user()->role_id)){
            return view('merchant');
        } else {
            Auth::logout();
        }

        
    }
}
