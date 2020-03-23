<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleRight extends Model
{
    
    public function module(){
        return $this->belongsTo(\App\Module::class);
    }

    public function role(){
        return $this->belongsTo(\App\Role::class);
    }

    public function users(){
        return $this->belongsToMany(\App\User::class , 'role_id');
    }
    
    public function hasAccess(array $roles, $module){           
        foreach($roles as $role){
            if($this->hasPermission($module)){
                return true;
            }
        }

        return false;
    }

    protected function hasPermission($module){
        $module_name = $this->module->module;
        return $module_name == $module;        
    }
    
}
