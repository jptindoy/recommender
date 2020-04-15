<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PosData;
use App\Request as RequestItem;
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
                        "backgroundColor"=> '#99c2ff',
                        "borderColor"=> '#66a3ff',
                        "borderWidth"=> 2,
                        "pointBorderColor"=> '#249EBF',
                        "data"=> $salesThisYear,
                    ]),
                    ([
                        "label" => 'Last Year',
                        "backgroundColor"=> '#ced4da',
                        "borderColor"=> '#99a6b2',
                        "pointBackgroundColor"=> '#ced4da',
                        "borderWidth"=> 2,
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

    public function getMonthlySales(Request $request)
    {   
        if($request->from === null && $request->to === null) {
            $yearMonth = date('Y-m');
            $datas = PosData::select(DB::raw('SUM(sales) as sales'), 'date')
                            ->groupBy('date')
                            ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), $yearMonth)
                            ->orderBy('date', 'asc')
                            ->get();
            $itemSales = PosData::select(DB::raw('SUM(sales) as sales'), DB::raw('SUM(qty) as qty'), 'product_name')
                            ->groupBy('product_name')
                            ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), $yearMonth)
                            ->orderBy('product_name', 'asc')
                            ->get();
        } else {
            $datas = PosData::select(DB::raw('SUM(sales) as sales'), 'date')
                            ->groupBy('date')
                            ->whereBetween('date', [$request->from, $request->to])
                            ->orderBy('date', 'asc')
                            ->get();
            $itemSales = PosData::select(DB::raw('SUM(sales) as sales'), DB::raw('SUM(qty) as qty'), 'product_name')
                            ->groupBy('product_name')
                            ->whereBetween('date', [$request->from, $request->to])
                            ->orderBy('product_name', 'asc')
                            ->get();
        }
        
        
        $date = array();
        $sales = array();
        foreach($datas as $data){
            $date[] = $data->date;
            $sales[] = number_format($data->sales, 2, '.', '');
        }
        return json_encode([
            'sales' => ([
                'labels' => $date,
                'datasets'=> [([
                    'type'                => 'line',
                    'data'                => $sales,
                    'backgroundColor'     => 'rgb(0, 123, 255, 0.2)',
                    'borderColor'         => '#007bff',
                    'pointBorderColor'    => '#007bff',
                    'pointBackgroundColor'=> '#007bff',
                    'fill'                => true,
                    'pointHoverBackgroundColor'=> '#007bff',
                    'pointHoverBorderColor'    => '#007bff',
                    'lineTension' => 0,
                    ])]
            ]),
            'itemSales' => $itemSales,
        ]);
    }

    public function getMostRequest(Request $request) 
    {   
        if($request->from === null && $request->to === null) {
            $yearMonth = date('Y');
            $requestedItem = RequestItem::select(DB::raw('COUNT(id) as id'), 'product_name')
                            ->groupBy('product_name')
                            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $yearMonth)
                            ->where('action', 'approved')
                            ->orderBy('product_name', 'asc')
                            ->limit(30)
                            ->get();
        } else {
            $requestedItem = RequestItem::select(DB::raw('COUNT(id) as id'), 'product_name')
                            ->groupBy('product_name')
                            ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), [$request->from, $request->to])
                            ->where('action', 'approved')
                            ->orderBy('product_name', 'asc')
                            ->limit(30)
                            ->get();
        }
        
        
        $labels = array();
        $qty = array();
        foreach($requestedItem as $item) {
            $labels[] = $item->product_name;
            $qty[] = $item->id;
        }
        return json_encode([
            'requested' => ([
                'labels' => $labels,
                'datasets'=> [([

                    "label" => 'This Year',
                    "backgroundColor"=> '#99c2ff',
                    "borderColor"=> '#66a3ff',
                    "pointBackgroundColor"=> '#007bff',
                    "borderWidth"=> 2,
                    "pointBorderColor"=> '#249EBF',
                    "data"=> $qty,

                    ])]
            ]),
        ]);
    }

    public function getItemGraph(Request $request)
    {
        $daily = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
        $monthly = [1,2,3,4,5,6,7,8,9,10,11,12];
        $yearly = [2017,2018,2019,2020];

        $dailyItem = array();
        $monthlyItem = array();
        $yearlyItem = array();

        
        foreach($yearly as $year) {
            $dailySets = array();
            foreach($daily as $val) {
                $items = PosData::where('product_name', $request->all())
                                ->whereDay('date', $val)
                                ->whereYear('date', $year)
                                ->sum('qty');            
                
                $dailySets[] = $items;
                     
            }
            $dailyItem[] = $dailySets;
        }
        

        foreach($yearly as $year) {
            $monthlySets = array();
            foreach($monthly as $val) {
                $items = PosData::where('product_name', $request->all())
                                ->whereMonth('date', $val)
                                ->whereYear('date', $year)
                                ->sum('qty'); 
                $monthlySets[] = $items;
            }
    
            $monthlyItem[] = $monthlySets;
        }

        foreach($yearly as $val) {
            $items = PosData::where('product_name', $request->all())
                            ->whereYear('date', $val)->sum('qty');   
                       
            $yearlyItem[] = $items;
            
        }

        return json_encode([
            'dailyqty' => ([
                    "labels" => $daily,
                    'datasets' => [
                        ([
                            'label' => "2017",
                            'backgroundColor' => "#003d4d",
                            'data' => $dailyItem[0]
                        ]),
                        ([
                            'label' => "2018",
                            'backgroundColor' => "#008fb3",
                            'data' => $dailyItem[1]
                        ]),
                        ([
                            'label' => "2019",
                            'data' => $dailyItem[2],
                            'backgroundColor' => "#1ad1ff"
                        ]),
                        ([
                            'label' => "2020",
                            'data' => $dailyItem[3],
                            'backgroundColor' => "#99ebff"
                        ]),
                    ]
            ]),
            
            'monthlyqty' => ([
                    "labels" => $monthly,
                    'datasets' => [
                        ([
                            'label' => "2017",
                            'backgroundColor' => "#003d4d",
                            'data' => $monthlyItem[0]
                        ]),
                        ([
                            'label' => "2018",
                            'backgroundColor' => "#008fb3",
                            'data' => $monthlyItem[1]
                        ]),
                        ([
                            'label' => "2019",
                            'data' => $monthlyItem[2],
                            'backgroundColor' => "#1ad1ff"
                        ]),
                        ([
                            'label' => "2020",
                            'data' => $monthlyItem[3],
                            'backgroundColor' => "#99ebff"
                        ]),
                    ]
            ]),

            'yearlyqty' => ([
                    'labels' => $yearly,
                    'datasets'=> [([
                        'type'                => 'line',
                        'data'                => $yearlyItem,
                        'backgroundColor'     => 'transparent',
                        'borderColor'         => '#007bff',
                        'pointBorderColor'    => '#007bff',
                        'pointBackgroundColor'=> '#007bff',
                        'fill'                => false,
                        'pointHoverBackgroundColor'=> '#007bff',
                        'pointHoverBorderColor'    => '#007bff'
                        ])]
            ]),
        ]);
    }
}
