<?php

namespace App\Policies;

use App\ModuleRight;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ModulePolicy
{
    use HandlesAuthorization;

    /** 
     * Determine whether the user can view any modules.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user, $module)
    {   
        $modules = ModuleRight::where('role_id', '=', $user->role_id)->get();

        foreach($modules as $val){
            if($val->module->module == $module){
                return $val->view;
            }
        }
        
        // return $user->role_id == 1;
    }

    /**
     * Determine whether the user can view the module.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function view(User $user, $module)
    {
        
        // if($user->role_id == 1){
        //     if($module->module == 'Profile Management'){
        //         return true;
        //     }
        // }
    }

    /**
     * Determine whether the user can create modules.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $module)
    {
        $modules = ModuleRight::where('role_id', '=', $user->role_id)->get();

        foreach($modules as $val){
            if($val->module->module == $module){
                return $val->create;
            }
        }
        
        // return true;
        
    }

    /**
     * Determine whether the user can update the module.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function update(User $user, $module)
    {
        $modules = ModuleRight::where('role_id', '=', $user->role_id)->get();

        foreach($modules as $val){
            if($val->module->module == $module){
                return $val->update;
            }
        }
    }

    /**
     * Determine whether the user can delete the module.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function delete(User $user, $module)
    {
        $modules = ModuleRight::where('role_id', '=', $user->role_id)->get();

        foreach($modules as $val){
            if($val->module->module == $module){
               return $val->delete;
            }
        }
    }

    /**
     * Determine whether the user can restore the module.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function restore(User $user, ModuleRight $module)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the module.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function forceDelete(User $user, ModuleRight $module)
    {
        //
    }
}
