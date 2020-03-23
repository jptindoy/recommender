<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function users(){
        return $this->hasMany(\App\User::class);
    }

    public function moduleRights(){
        return $this->hasMany(\App\ModuleRight::class);
    }

    public function hasAccess($role, $module){        
        foreach ($this->moduleRights as $right) {
            if($right->hasAccess([$role], $module)){
                return true;   
            }            
        }
        return false;
    }
}
