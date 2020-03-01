<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Login as LoginResource;

class LoginController extends Controller
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
    
    public function index() {

        $login = ['err' => false, 'msg' => 'Long in succesful!'];        
        return new LoginResource($login);
    }
}
