<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModuleRight;
use App\Http\Resources\ModuleRight as ModuleRightResource;

class ModuleRightController extends Controller
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
        //
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
        

        $module = $request->isMethod('PUT') ? ModuleRight::findOrFail($request->input('m_id')) : New ModuleRight;

        if($request->isMethod('PUT')) {
            // $this->authorize('update', [\App\ModuleRight::class, 'User Management']);

            $module->id = $request->input('m_id');
            $module->role_id = $request->input('m_category');
            $module->module_id = $request->input('m_name');
            $module->view = $request->input('m_view');
            $module->create = $request->input('m_add');
            $module->update = $request->input('m_edit');
            $module->delete = $request->input('m_delete');

            if($module->save()) {
                return New ModuleRightResource($module);
            }
        }

        $ifExist = ModuleRight::where([
                                    ['role_id', '=', $request->input('m_category')],
                                    ['module_id', '=', $request->input('m_name')],
                                    ])->get();
        
        if(count($ifExist) > 0) {
            $msg = ['err' => true, 'msg' => 'Record already exist!'];
            return New ModuleRightResource($msg);
        } else {           
            // $this->authorize('create', [\App\ModuleRight::class, 'User Management']);

            $module->id = $request->input('m_id');
            $module->role_id = $request->input('m_category');
            $module->module_id = $request->input('m_name');
            $module->view = $request->input('m_view');
            $module->create = $request->input('m_add');
            $module->update = $request->input('m_edit');
            $module->delete = $request->input('m_delete');

            if($module->save()) {
                return New ModuleRightResource($module);
            }
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
        $modules = ModuleRight::join('roles', 'module_rights.role_id', '=', 'roles.id')
                        ->join('modules', 'module_rights.module_id', '=', 'modules.id')
                        ->select('module_rights.*', 'modules.module', 'roles.role')
                        ->where('module_rights.role_id', $id)
                        ->paginate(5);
        
        return new ModuleRightResource($modules);
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
        //
    }
}
