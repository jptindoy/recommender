<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\Http\Resources\Module as ModuleResource;

class APIModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $modules = Module::join('roles', 'modules.m_category', '=', 'roles.r_id')
                        ->select('modules.*', 'roles.r_id', 'roles.r_category')
                        ->groupBy('modules.m_category')
                        ->paginate(5);
        
        return ModuleResource::collection($modules); 
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
        $module = $request->isMethod('PUT') ? Module::findOrFail($request->input('m_id')) : New Module;
        
        $module->m_id = $request->input('m_id');
        $module->m_category = $request->input('m_category');
        $module->m_name = $request->input('m_name');
        $module->m_view = $request->input('m_view');
        $module->m_add = $request->input('m_add');
        $module->m_edit = $request->input('m_edit');
        $module->m_delete = $request->input('m_delete');

        if($module->save()) {
            return New ModuleResource($module);
        }

        //return $request->input('m_category');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modules = Module::join('roles', 'modules.m_category', '=', 'roles.r_id')
                        ->select('modules.*', 'roles.r_id', 'roles.r_category')
                        ->where('modules.m_category', $id)
                        ->paginate(5);
        
        return new ModuleResource($modules);

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
