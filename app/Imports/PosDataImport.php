<?php

namespace App\Imports;

use App\PosData;
use App\PosDataDate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PosDataImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new PosData([
            'invoice'        => $row['orderid'],
            'date'          => $row['orderdate'],
            'barcode'       => $row['productid'],
            'product_name'  => $row['productname'],
            'sales'         => $row['sales'],
            'qty'           => $row['quantity'],
        ]);
    }
}
