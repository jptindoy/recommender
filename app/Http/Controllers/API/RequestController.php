<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Request as RequestItem;

class RequestController extends Controller
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

    public function draftItem()
    {
        $item = RequestItem::where('status', 'draft')->get();
        $poNumber = RequestItem::max('po_number');
        return json_encode([
            'items' => $item,
            'poNumber' => $poNumber, 
        ]);
    }

    public function store(Request $request)
    {
        $item = new RequestItem;

        $item->po_numner = 'PO_'.time();
        $item->product_name = $request->all();
    }

    public function draft(Request $request)
    {   
        $ifExist = RequestItem::where('product_name', $request->input('name'))
                                ->where('status', 'draft')
                                ->get();

        if(count($ifExist) > 0) {
            return json_encode([
                'item' => $ifExist,
                'msg' => 'This item is already added!',
                'type' => 'warning',
            ]);
        } else {
                // return $request->input('0');
            $item = new RequestItem;

            $item->product_name = $request->input('name');;
            $item->qty = $request->input('qty');;
            
            if($item->save()){
                return json_encode([
                    'item' => $item,
                    'msg' => 'Item Added!',
                    'type' => 'success',
                ]);
            }
        }
        
    }

    public function saveRequest(Request $request)
    {   
        try {
            $saveRequest = RequestItem::where('status', 'draft')->update(
                ['date_needed' => $request->dateNeeded, 'po_number' => $request->PO_number, 'status' => 'requested']
            );
            return json_encode([
                'msg' => 'Request created!',
                'type' => 'success',
            ]);
        } catch (Exception $e) {
            return json_encode([
                'msg' => $e->getMessage(),
                'type' => 'error',
            ]);
        }
        
        
    }
    
    public function updateQty(Request $request, $id)
    {
        $qty = RequestItem::findOrFail($id);

        $qty->qty = $request->qty;
        
        if($qty->save()){
            return $qty;
        }
    }

    public function updateVariant(Request $request, $id)
    {
        $variant = RequestItem::findOrFail($id);

        $variant->variant = $request->variant;
        
        if($variant->save()){
            return $variant;
        }
    }

    public function updateRequest(Request $request)
    {   
        try {
            $updateRequest = RequestItem::where('po_number', $request->PO_number)
                                        ->update(['date_needed' => $request->dateNeeded, 
                                            'po_number' => $request->PO_number, 
                                            'action' => $request->action,
                                            'status' => 'requested']
                                        );
            return json_encode([
                'msg' => 'Request updated!',
                'type' => 'success',
            ]);
        } catch (Exception $e) {
            return json_encode([
                'msg' => $e->getMessage(),
                'type' => 'error',
            ]);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = RequestItem::findOrFail($id)->delete();
        return json_encode([
            'msg' => 'Item Remove!',
        ]);
    }

    public function deleteDraft()
    {   
        $items = RequestItem::where('status','draft')->delete();        
        return json_encode($items);
    }

    public function requestWidget()
    {
        $allRequest = RequestItem::select('po_number', 'date_needed', 'updated_at', 'action')
                                ->where('action', 'pending')
                                ->groupBy('po_number', 'date_needed', 'updated_at', 'action')
                                ->get();

        $cancelled = RequestItem::select('po_number', 'date_needed', 'updated_at', 'action')
                            ->where('action', 'disapproved')
                            ->groupBy('po_number', 'date_needed', 'updated_at', 'action')
                            ->get();

        $approved = RequestItem::select('po_number', 'date_needed', 'updated_at', 'action')
                            ->where('action', 'approved')
                            ->groupBy('po_number', 'date_needed', 'updated_at', 'action')
                            ->get();

        return json_encode([
            'countallRequest' => count($allRequest),
            'countcancelled' => count($cancelled),
            'countapproved' => count($approved),
            'allRequest' => $allRequest,
            'cancelled' => $cancelled,
            'approved' => $approved,
        ]);
    }

    public function editRequest($id)
    {       
        $items = RequestItem::where('po_number', $id)->get();
        
        return json_encode([
            'items' => $items,
        ]);
    }

    public function editAddItem(Request $request)
    {   
        $ifExist = RequestItem::where('product_name', $request->input('name'))
                                ->where('status', 'draft')
                                ->get();

        if(count($ifExist) > 0) {
            return json_encode([
                'item' => $ifExist,
                'msg' => 'This item is already added!',
                'type' => 'warning',
            ]);
        } else {
                // return $request->input('0');
            $item = new RequestItem;

            $item->po_number = $request->input('po');
            $item->product_name = $request->input('name');
            
            if($item->save()){
                return json_encode([
                    'item' => $item,
                    'msg' => 'Item Added!',
                    'type' => 'success',
                ]);
            }
        }
        
    }

    public function searchRequest($id)
    {
        $items = RequestItem::select('po_number')
                            ->where('po_number', 'like', '%'.$id.'%')
                            ->groupBy('po_number')
                            ->get();

        return json_encode([
            'items' => $items,
        ]); 
    }
}
