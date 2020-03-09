<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class APIUserController extends Controller
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

        //  return $this->$request;

        // $this->validate($request,[
        //     'u_fname' => ['required', 'string', 'max:255'],
        //     'u_lname' => ['required', 'string', 'max:255'],            
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
        $user->u_status     = true;

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
    public function edit(Request $request, $id)
    {   
        //
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

            $profile->u_id = $request->id;
            $profile->u_image = $fileNametToStore;

            if($profile->save()){
                return new UserResource($profile);
            }
        }
        
    }

    public function updatePassword(Request $request)
    {
        if($request->password === $request->password_confirm){
            $password = User::findOrFail($request->id);

            $password->u_id = $request->id;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->u_status = $request->input('u_status');
        
        if($user->save()){
            return new UserResource($user);
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

        if($user->delete()) {
            return new UserResource($user);
        } 
    }

}
