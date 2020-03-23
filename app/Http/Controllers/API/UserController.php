<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                        ->select('users.*', 'roles.role')
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
        
        $user = $request->isMethod('PUT') ? User::findOrFail($request->input('user_id')) : New User;
        
        $user->id         = $request->input('user_id');
        $user->fname      = $request->input('u_fname');
        $user->lname      = $request->input('u_lname');
        $user->email      = $request->input('u_email');
        $user->role_id    = $request->input('u_role');
        $user->image      = 'blank-img.png';
        $user->password   = Hash::make($request->input('u_password'));
        $user->api_token  = Str::random(60);
        $user->active     = true;

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
        $user = User::join('roles', 'users.role_id', '=', 'roles.id')
                        ->select('users.*', 'roles.role')
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
        $user = User::findOrFail($id);

        $user->active = $request->input('active');
        
        if($user->save()){
            return new UserResource($user);
        }
    }

    public function updateProfile(Request $request)
    {

        if($request->hasFile('file')){
            $originalFileName = $request->file('file')->getClientOriginalName();

            $fileExt = $request->file('file')->getClientOriginalExtension();

            $fileName = $request->file($originalFileName, PATHINFO_FILENAME);

            $fileNametToStore = $fileName.'_'.time().'.'.$fileExt;
            
            $path = Storage::putFileAs('public/img/profile-img', $request->file('file'), $fileNametToStore);

            $profile = User::findOrFail($request->id);

            if($profile->image != 'blank-img.png'){
                Storage::delete('public/img/profile-img/'.$profile->image);
            }           

            $profile->id = $request->id;
            $profile->image = $fileNametToStore;

            if($profile->save()){
                return new UserResource($profile);
            }
        }
        
    }

    public function updatePassword(Request $request)
    {
        if($request->password === $request->password_confirm){
            $password = User::findOrFail($request->id);

            $password->id = $request->id;
            $password->password = Hash::make($request->password);

            if($password->save()){
                return new UserResource($password);
            }
        } else {
            return json_encode([
                'err' => true,
                'errType' => 'error',
                'msg' => 'Password didn\'t match!' 
            ]);
        }
        
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
        if($user->image!= 'blank-img.png'){
            Storage::delete('public/img/profile-img/'.$user->image);
        } 
        if($user->delete()) {
            return new UserResource($user);
        } 
    }
}
