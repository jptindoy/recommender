<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Phpml\Association\Apriori;
use App\PosData;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $month = date('m');
        $listItem = array();
        $listqty = array();

        $invoice = PosData::select('invoice')
                            ->groupBy('invoice')
                            ->whereMonth('date', $month)
                            ->orderBy('id', 'desc')
                            ->limit(100)
                            ->get();
        
        foreach($invoice as $val){   
            $itemSet = array();        
            $itemqty = array();        
            $items = PosData::where('invoice', $val->invoice)->get();
            foreach($items as $item){
               $itemSet[] = $item->product_name;
               $itemqty[] = ['name' =>  $item->product_name, 'qty' => $item->qty];
            }
            $listItem[] = $itemSet;
            $listqty[] = $itemqty;
        }

        $labels  = [];

        $associator = new Apriori($support = 0, $confidence = 0);
        $associator->train($listItem, $labels);

        $items = $associator->apriori();
        
        $productqty = array();   

        foreach ($items[1] as $item) {
            $sum = 0;
            for ($x=0; $x < count($listqty); $x++) {                
                for ($y=0; $y < count($listqty[$x]); $y++) {
                    if($item[0] === $listqty[$x][$y]['name']){
                        $sum += $listqty[$x][$y]['qty'];
                    }           
                }          
            } 
            $productqty[] = ['name' => $item[0], 'qty' => $sum];
        }

        return json_encode([
            'qty' => $productqty,
            'itemset' => $items,
            'rules' => $associator->getRules(),
        ]);

        //return $associator->getRules();
        // return $associator->apriori();
        // return $associator->predict(['GBC Pre-Punched Binding Paper, Plastic, White, 8-1/2" x 11"','Xerox 1948']);
        
        // return [['beta']];

        // $associator->predict([['alpha','epsilon'],['beta','theta']]);
        // return [[['beta']], [['alpha']]]
    }

    
    public function searchItemSet(Request $request)
    {
        $from = date('m-d', strtotime($request->from));
        $to = date('m-d', strtotime($request->to));
        
        $listItem = array();
        $listqty = array();

        $invoice = PosData::select('invoice')
                            ->groupBy('invoice')
                            ->whereBetween(DB::raw("DATE_FORMAT(date, '%m-%d')"), [$from, $to])
                            ->orderBy('id', 'desc')
                            ->limit(100)
                            ->get();
      
        foreach($invoice as $val){   
            $itemSet = array();        
            $itemqty = array();        
            $items = PosData::where('invoice', $val->invoice)->get();
            foreach($items as $item){
               $itemSet[] = $item->product_name;
               $itemqty[] = ['name' =>  $item->product_name, 'qty' => $item->qty];
            }
            $listItem[] = $itemSet;
            $listqty[] = $itemqty;
        }

        $labels  = [];

        $associator = new Apriori($support = 0, $confidence = 0);
        $associator->train($listItem, $labels);

        $items = $associator->apriori();
        
        $productqty = array();   

        foreach ($items[1] as $item) {
            $sum = 0;
            for ($x=0; $x < count($listqty); $x++) {                
                for ($y=0; $y < count($listqty[$x]); $y++) {
                    if($item[0] === $listqty[$x][$y]['name']){
                        $sum += $listqty[$x][$y]['qty'];
                    }           
                }          
            } 
            $productqty[] = ['name' => $item[0], 'qty' => $sum];
        }

        return json_encode([
            'qty' => $productqty,
            'itemset' => $items,
            'rules' => $associator->getRules(),
        ]);
    }

    public function salableForToday($id)
    {
        $today = date('m');
        
        if($id == null){
            $date = $today;
        }else{
            $date = date('m', strtotime($id));
        }

        $topSales = PosData::select(DB::raw('SUM(qty) as qty'), 'product_name')
                        ->groupBy('product_name',)
                        ->whereMonth('date', $date)
                        ->orderBy('qty','desc')
                        ->paginate(10);

        return json_encode($topSales);
    }
    
    public function itemList()
    {
        $itemList = PosData::select('product_name')
                        ->groupBy('product_name')
                        ->orderBy('product_name','asc')
                        ->get();

        return json_encode([
            'itemlist' => $itemList,
        ]);
    }

    public function itemListSearch($id)
    {
        $itemList = PosData::select('product_name')
                        ->groupBy('product_name')
                        ->where('product_name', 'like', '%'.$id.'%')
                        ->orderBy('product_name','asc')
                        ->get();

        return json_encode([
            'itemlist' => $itemList,
        ]);
    }

    public function predictItem(Request $request)
    {
        // return $request;
        $listItem = array();
        $from = date('m-d', strtotime($request->from));
        $to = date('m-d', strtotime($request->to));

        $invoice = PosData::select('invoice')
                            ->whereBetween(DB::raw("DATE_FORMAT(date, '%m-%d')"), [$from, $to])
                            ->groupBy('invoice')
                            ->orderBy('id', 'desc')
                            ->limit(100)
                            ->get();
        
        foreach($invoice as $val){   
            $itemSet = array();        
            $items = PosData::where('invoice', $val->invoice)->get();
            foreach($items as $item){
               $itemSet[] = $item->product_name;
            }
            $listItem[] = $itemSet;
        }
        
        $labels  = [];

        $associator = new Apriori($support = 0, $confidence = 0);
        $associator->train($listItem, $labels);

        return json_encode([
            'predict' => $associator->predict($request->itemToPredict),
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

    public function test()
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
                $items = PosData::where('product_name', 'Staples')
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
                $items = PosData::where('product_name', 'Staples')
                                ->whereMonth('date', $val)
                                ->whereYear('date', $year)
                                ->sum('qty'); 
                $monthlySets[] = $items;
            }
    
            $monthlyItem[] = $monthlySets;
        }

        foreach($yearly as $val) {
            $items = PosData::where('product_name', 'Staples')
                            ->whereYear('date', $val)->sum('qty');   
                       
            $yearlyItem[] = $items;
            
        }

        return json_encode([
            'dailyqty' => ([
                    "labels" => $daily,
                    'datasets' => [
                        ([
                            'label' => "2017",
                            'backgroundColor' => "#f91642",
                            'data' => $dailyItem[0]
                        ]),
                        ([
                            'label' => "2018",
                            'backgroundColor' => "#636e72",
                            'data' => $dailyItem[1]
                        ]),
                        ([
                            'label' => "2019",
                            'data' => $dailyItem[2],
                            'backgroundColor' => "#4b81f3"
                        ]),
                        ([
                            'label' => "2020",
                            'data' => $dailyItem[3],
                            'backgroundColor' => "#4b8134"
                        ]),
                    ]
            ]),
            
            'monthlyqty' => ([
                    "labels" => $monthly,
                    'datasets' => [
                        ([
                            'label' => "2017",
                            'backgroundColor' => "#f91642",
                            'data' => $monthlyItem[0]
                        ]),
                        ([
                            'label' => "2018",
                            'backgroundColor' => "#636e72",
                            'data' => $monthlyItem[1]
                        ]),
                        ([
                            'label' => "2019",
                            'data' => $monthlyItem[2],
                            'backgroundColor' => "#4b81f3"
                        ]),
                        ([
                            'label' => "2020",
                            'data' => $monthlyItem[3],
                            'backgroundColor' => "#4b8134"
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
