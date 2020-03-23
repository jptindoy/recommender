<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\ModuleRight;
use App\Http\Resources\Module as ModuleResource;
use App\Http\Resources\ModuleRight as ModuleRightResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
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
         
            $this->authorize('viewAny', [\App\ModuleRight::class, 'User Management']);
            $module = Module::paginate(5);

            return ModuleResource::collection($module);
      
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
        //return $request;
        $this->authorize('create', [\App\ModuleRight::class, 'User Management']);

        $module_name = $request->isMethod('PUT') ? Module::findOrFail($request->input('id')) : new Module;

        $module_name->id = $request->input('id');
        $module_name->module = $request->input('module_name');

        if($module_name->save()){
            return new ModuleResource($module_name);
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
        //
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
        $this->authorize('delete', [\App\ModuleRight::class, 'User Management']);
        $module = Module::findOrFail($id);
        $moduleRight = ModuleRight::where('module_id', '=', $id);
        $moduleRight->delete();

        if($module->delete() ) {
            return new ModuleResource($module);
        }
    }
}
