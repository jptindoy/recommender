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
            $sumThisYear = PosData::whereMonth('date',$month)
                        ->whereYear('date',$year)
                        ->sum('sales');
            $salesThisYear[] = number_format($sumThisYear, 2, '.', '');

            $sumLastYear = PosData::whereMonth('date',$month)
                        ->whereYear('date',$year-1)
                        ->sum('sales');
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
                        "data"=> $salesLastYear,
                    ])

                ]            
        ]);
    }

    public function getTopSales() {

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', time() - 60 * 60 * 24);        
        
        $topSales = PosData::whereDate('date', $yesterday)
                        ->orderBy(DB::raw('CAST(qty AS SIGNED)'),'desc')
                        ->paginate(10);

        return json_encode($topSales);
    }

    public function getTotalSales() {
        
        $thisYear = date('Y');
        $thisMonth = date('m');
        $lastMonth = date('m', strtotime("previous month"));

        $total = PosData::whereYear('date', $thisYear)->sum('sales');

        $totalThisMonth = PosData::whereMonth('date', $thisMonth )
                                ->whereYear('date', $thisYear)
                                ->sum('sales');
        $totalLastMonth = PosData::whereMonth('date', $lastMonth )
                                ->whereYear('date', $thisYear)
                                ->sum('sales');

        $percentage = 0;
        $percentage = (($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100;



        return json_encode([
            'data' => number_format($total, 2,),
            'percentage' => number_format($percentage, 2,),
        ]);

        // return $percentage;

    }

   
}
