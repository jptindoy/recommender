<?php

namespace App\Exports;

use App\PosData;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function from(string $from)
    {
        $this->from = $from;
        
        return $this;
    }

    public function to(string $to)
    {
        $this->to = $to;
        
        return $this;
    }

    public function query()
    {
        return PosData::query()->select('product_name', DB::raw('SUM(qty) as qty'), DB::raw('SUM(sales) as sales'))
                            ->groupBy('product_name')
                            ->whereBetween('date', [$this->from, $this->to])
                            ->orderBy('product_name', 'asc');
    }

    public function headings(): array
    {
        return [
            'PRODUCT NAME',
            'TOTAL QTY',
            'TOTAL SALES',
        ];
    }
}
 