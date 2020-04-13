<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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

    public function getNotification($id)        
    {   
        if(Auth::user()->role_id === 1){
            $noti = Notification::where('admin_status','unread')->orderBy('id', 'desc')->get();
            $all = Notification::where('admin_status','read')->orderBy('id', 'desc')->paginate(5);
        } else {
            $noti = Notification::where('recipient', $id)->where('status', 'unread')->get();
            $all = Notification::where('recipient', $id)->where('status', 'read')->orderBy('id', 'desc')->paginate(5);
        }
        
        return json_encode([
            'data' => $noti,
            'all' => $all,
        ]);
    }
}
