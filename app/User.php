<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'fname', 'lname', 'email', 'password','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(\App\Role::class);
    }

    public function moduleRights(){
        return $this->hasMany(\App\ModuleRight::class, 'role_id');
    }

    public function hasAccess($role, $module){
        
        if($this->role->hasAccess($role, $module)){
            return true;
        }
        return false;
        
        // return $module == "User Management";
    }

    public function isAdmin(){
        return $this->role_id == 1 && $this->active == true;
    }

    public function isAccountant(){
        return $this->role_id == 2 && $this->active == true;
    }

    public function isMerchant(){
        return $this->role_id == 3 && $this->active == true;
    }
}
