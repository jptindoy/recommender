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
                        ->sum('total');
            $salesThisYear[] = number_format($sumThisYear, 2, '.', '');

            $sumLastYear = PosData::whereMonth('file_date',$month)
                        ->whereYear('file_date',$year-1)
                        ->sum('total');
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
}
