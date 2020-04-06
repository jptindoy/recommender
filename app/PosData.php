<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosData extends Model
{
    protected $fillable = [
        'invoice', 'date', 'barcode', 'product_name', 'sales', 'qty',
    ];
}
