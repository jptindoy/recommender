<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Request as RequestItem;
use App\Notification;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('create', [\App\ModuleRight::class, 'Product Request']);
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

            $getUnits = RequestItem::select('product_name','variant')
                                    ->groupBy('product_name', 'variant')
                                    ->where('product_name', $request->input('name'))
                                    ->get();

            if(count($getUnits) > 0){
                foreach($getUnits as $item)
                $units = $item->variant;

            } else {
                $units = null;
            }
                // return $request->input('0');
            $item = new RequestItem;

            $item->product_name = $request->input('name');
            $item->qty = $request->input('qty');
            $item->variant = $units;
            
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
        $this->authorize('create', [\App\ModuleRight::class, 'Product Request']);
        try {
            $saveRequest = RequestItem::where('status', 'draft')->update(
                ['date_needed' => $request->dateNeeded, 'po_number' => $request->PO_number, 'status' => 'requested', 'action' => 'pending', 'created_by' => $request->user]
            );

            $notify = new Notification;

            $notify->po_number = $request->PO_number; 
            $notify->sender = Auth::user()->id;
            $notify->recipient = 2;
            $notify->message = 'New Request Created';
            $notify->save();

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
        $this->authorize('create', [\App\ModuleRight::class, 'Product Request']);
        $qty = RequestItem::findOrFail($id);

        $qty->qty = $request->qty;
        
        if($qty->save()){
            return $qty;
        }
    }

    public function updateVariant(Request $request, $id)
    {   
        $this->authorize('create', [\App\ModuleRight::class, 'Product Request']);
        $variant = RequestItem::findOrFail($id);

        $variant->variant = $request->variant;
        
        if($variant->save()){
            return $variant;
        }
    }

    public function updateRequest(Request $request)
    {      
        $this->authorize('update', [\App\ModuleRight::class, 'Product Request']);
        try {
            $updateRequest = RequestItem::where('po_number', $request->PO_number)
                                        ->update(['date_needed' => $request->dateNeeded, 
                                            'po_number' => $request->PO_number, 
                                            'action' => $request->action,
                                            'status' => 'requested',
                                            'updated_by' => $request->user]
                                        );

            $notify = new Notification;

            $notify->po_number = $request->PO_number;
            $notify->sender = Auth::user()->id;
            $notify->recipient = 3;
            $notify->message = 'New request '.$request->action;
            $notify->save();
            
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
        if($items > 0){
            return json_encode([
                'err' => false,
                'msg' => 'Request List Cancelled!',
            ]);
        } else {
            return json_encode($items);
        }    
        
    }

    public function requestWidget()
    {   
        $this->authorize('viewAny', [\App\ModuleRight::class, 'Product Request']);
        if(Auth::user()->role_id == 1){
            $noti = Notification::where('admin_status', 'unread')
                                ->update(['admin_status' => 'read']);
        } else {
            $noti = Notification::where('recipient', Auth::user()->role_id)
                                ->where('status', 'unread')
                                ->update(['status' => 'read']);
        }

        $allRequest = RequestItem::select('updated_at', 'date_needed', 'action','po_number')
                                ->where('action', 'pending')
                                ->groupBy('po_number')
                                ->get();

        $cancelled = RequestItem::select('updated_at', 'date_needed', 'action','po_number')
                            ->where('action', 'disapproved')
                            ->groupBy('po_number')
                            ->get();

        $approved = RequestItem::select('updated_at', 'date_needed', 'action','po_number')
                            ->where('action', 'approved')
                            ->groupBy('po_number')
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
        if(Auth::user()->role_id == 1){
            $noti = Notification::where('po_number', $id)
                                ->where('admin_status', 'unread')
                                ->update(['admin_status' => 'read']);
        } else {
            $noti = Notification::where('po_number', $id)
                                ->where('recipient', Auth::user()->role_id)
                                ->where('status', 'unread')
                                ->update(['status' => 'read']);
        }
        $items = RequestItem::where('po_number', $id)->get();
        
        return json_encode([
            'items' => $items,
        ]);
    }

    public function editAddItem(Request $request)
    {   
        $this->authorize('create', [\App\ModuleRight::class, 'Product Request']);
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
            $getUnits = RequestItem::select('product_name','variant')
                                    ->groupBy('product_name', 'variant')
                                    ->where('product_name', $request->input('name'))
                                    ->get();

            if(count($getUnits) > 0){
                foreach($getUnits as $item)
                $units = $item->variant;

            } else {
                $units = null;
            }

                // return $request->input('0');
            $item = new RequestItem;

            $item->po_number = $request->input('po');
            $item->product_name = $request->input('name');
            $item->variant = $units;
            
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
