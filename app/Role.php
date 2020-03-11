<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $primaryKey = ('r_id');

    public function role(){
        return $this->belongsTo(User::class, 'r_id');
    }
}
