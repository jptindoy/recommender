<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosData extends Model
{
    protected $fillable = [
        'barcode', 'name', 'sales', 'unit', 'total', 'file_date',
    ];
}
