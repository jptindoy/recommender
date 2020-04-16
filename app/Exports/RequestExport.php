<?php

namespace App\Exports;

use App\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestExport implements FromQuery, WithHeadings
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
        return Request::query()->select('product_name', DB::raw('COUNT(id) as id'))
                        ->groupBy('product_name')
                        ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), [$this->from, $this->to])
                        ->where('action', 'approved')
                        ->orderBy('product_name', 'asc')
                        ->limit(30);
    }

    public function headings(): array
    {
        return [
            'PRODUCT NAME',
            'TIMES OF REQUEST',
        ];
    }
}
 