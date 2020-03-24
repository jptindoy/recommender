<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
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

    public function accountant() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            return view('accountant');
        }
    }

    public function merchandizer() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id)) {
            return view('merchant');
        }
    }

    public function profile() {
        if (Gate::check('canAccessPage', [Auth::user()->role_id, 'Profile Management'])) {
            
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Profile Management']);
            return view('pages.profile');
        }else{
            return "it look's like you don't have access to this page!";
        }
        
    }

    public function users() {
        if (Gate::check('canAccessPage', [Auth::user()->role_id, 'User Management'])) {            
            $this->authorize('viewAny', [\App\ModuleRight::class, 'User Management']);
            return view('pages.users');
        }else{
            return "it look's like you don't have access to this page!";
        }
        
    }

    public function importData() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id)) {
            return view('pages.import-data');
        }
    }

    public function documentation() {
        return view('welcome');
    }
}