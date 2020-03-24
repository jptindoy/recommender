<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PosData;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getSalesPerMonth() {

        $salesThisYear = array();
        $salesLastYear = array();
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $year = date('Y');
        foreach($months as $month) {
            $sumThisYear = PosData::whereMonth('file_date',$month)
                        ->whereYear('file_date',$year)
                        ->sum(DB::raw('replace(total, ",", "")'));
            $salesThisYear[] = number_format($sumThisYear, 2, '.', '');

            $sumLastYear = PosData::whereMonth('file_date',$month)
                        ->whereYear('file_date',$year-1)
                        ->sum(DB::raw('replace(total, ",", "")'));
            $salesLastYear[] = number_format($sumLastYear, 2, '.', '');
        }

        return json_encode([
            "labels" => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            "datasets" => [
                    ([
                        "label" => 'This Year',
                        "backgroundColor"=> '#007bff',
                        "pointBackgroundColor"=> '#007bff',
                        "borderWidth"=> 1,
                        "pointBorderColor"=> '#249EBF',
                        "data"=> $salesThisYear,
                    ]),
                    ([
                        "label" => 'Last Year',
                        "backgroundColor"=> '#ced4da',
                        "pointBackgroundColor"=> '#ced4da',
                        "borderWidth"=> 1,
                        "pointBorderColor"=> '#249EBF',
                        "data"=> $salesThisYear,
                    ])

                ]            
        ]);
    }

    public function getTopSales() {

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', time() - 60 * 60 * 24);        
        
        $topSales = PosData::whereDate('file_date', '2020-03-22')
                        ->orderBy(DB::raw('CAST(sales AS SIGNED)'),'desc')
                        ->paginate(10);

        return json_encode($topSales);
    }

    public function getTotalSales() {
        
        $year = date('Y');
        $thisMonth = date('m');
        $lastMonth = date('m', strtotime("previous month"));

        $total = PosData::whereYear('file_date', $year)->sum(DB::raw('replace(total, ",", "")'));

        $totalThisMonth = PosData::whereMonth('file_date', $thisMonth )->sum(DB::raw('replace(total, ",", "")'));
        $totalLastMonth = PosData::whereMonth('file_date', $lastMonth )->sum(DB::raw('replace(total, ",", "")'));

        $percentage = 0;
        $percentage = (($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100;



        return json_encode([
            'data' => number_format($total, 2,),
            'percentage' => number_format($percentage, 2,),
        ]);

        // return $percentage;

    }

   
}
