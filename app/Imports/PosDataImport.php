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
        $lastItem = PosDataDate::orderBy('id', 'desc')->limit(1)->get();
        foreach($lastItem as $val){}

        return new PosData([
            'barcode'   => $row['barcode'],
            'name'      => $row['name'],
            'sales'     => $row['sales'],
            'unit'      => $row['unit'],
            'total'     => $row['total'],
            'file_date' => $val->date,
        ]);
    }
}
