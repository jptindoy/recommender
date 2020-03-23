<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    

    public function moduleRights(){
        return $this->hasMany(\App\ModuleRight::class);
    }
}
