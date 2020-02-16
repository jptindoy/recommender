<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class APIUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('roles', 'users.u_role', '=', 'roles.r_id')
                        ->select('users.*', 'roles.r_id', 'roles.r_category')
                        ->paginate(5);
        
        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        // return $this->$request;

        // $this->validate($request,[
        //     'u_fname' => ['required', 'string', 'max:255'],
        //     'u_lname' => ['required', 'string', 'max:255'],            
        //     'u_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'u_role' => ['required', 'string', 'max:255'],
        //     'u_password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);

        $user = $request->isMethod('PUT') ? User::findOrFail($request->input('user_id')) : New User;
        
        $user->u_id         = $request->input('user_id');
        $user->u_fname      = $request->input('u_fname');
        $user->u_lname      = $request->input('u_lname');
        $user->email        = $request->input('u_email');
        $user->u_role       = $request->input('u_role');
        $user->u_image      = 'blank-img.png';
        $user->password     = Hash::make($request->input('u_password'));
        $user->api_token    = Str::random(60);
        // $user->u_status     = 'Active';

        if($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::join('roles', 'users.u_role', '=', 'roles.r_id')
                        ->select('users.*', 'roles.r_id', 'roles.r_category')
                        ->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->delete()) {
            return new UserResource($user);
        } 
    }
}
