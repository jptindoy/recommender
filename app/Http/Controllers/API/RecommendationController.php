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

        $listItem = array();

        $invoice = PosData::select('invoice')->groupBy('invoice')->limit(200)->get();
        
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
            'itemset' => $associator->apriori(),
        ]);

        // return $associator->getRules();
        // return $associator->apriori();
        // return $associator->predict(['GBC Pre-Punched Binding Paper, Plastic, White, 8-1/2" x 11"','Xerox 1948']);
        
        // return [['beta']];

        // $associator->predict([['alpha','epsilon'],['beta','theta']]);
        // return [[['beta']], [['alpha']]]
    }


    public function itemSetToday()
    {   
        $today = date('d');
        $listItem = array();

        $invoice = PosData::select('invoice')
                            ->groupBy('invoice')
                            ->whereDay('date', $today)
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
            'itemset' => $associator->apriori(),
            // 'rules' => $associator->getRules(),
        ]);
    }
    
    public function searchItemSet($date)
    {
        $date = date('d', strtotime($date));
        $listItem = array();

        $invoice = PosData::select('invoice')
                            ->groupBy('invoice')
                            ->whereDay('date', $date)
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
            'itemset' => $associator->apriori(),
            // 'rules' => $associator->getRules(),
        ]);
    }

    public function salableForToday($id)
    {
        $today = date('d');
        
        if($id == null){
            $date = $today;
        }else{
            $date = date('d', strtotime($id));
        }

        $topSales = PosData::select(DB::raw('SUM(qty) as qty'), 'product_name')
                        ->groupBy('product_name',)
                        ->whereDay('date', $date)
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

        $invoice = PosData::select('invoice')->groupBy('invoice')->limit(200)->get();
        
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
            'predict' => $associator->predict($request->all()),
        ]);
    }
}   
