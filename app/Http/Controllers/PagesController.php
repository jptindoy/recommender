<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
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

    public function accountant() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            return view('accountant');
        }
    }

    public function merchandizer() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id)) {
            return view('merchant');
        }
    }

    public function profile() {
        if (Gate::check('canAccessPage', [Auth::user()->role_id, 'Profile Management'])) {
            
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Profile Management']);
            return view('pages.profile');
        }else{
            return "it look's like you don't have access to this page!";
        }
        
    }

    public function users() {
        if (Gate::check('canAccessPage', [Auth::user()->role_id, 'User Management'])) {            
            $this->authorize('viewAny', [\App\ModuleRight::class, 'User Management']);
            return view('pages.users');
        }else{
            return "it look's like you don't have access to this page!";
        }
        
    }

    public function importData() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id)) {
            // $this->authorize('viewAny', [\App\ModuleRight::class, 'User Management']);
            return view('pages.import-data');
        }
    }

    public function documentation() {
        return view('welcome');
    }

    public function salesReport() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Sales Report']);
            return view('pages.sales-report');
        }
    }

    public function recommendedProduct() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id)) {
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Recommended Product']);
            return view('pages.recommended-product');
        }
    }

    public function productRequest() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Product Request']);
            return view('pages.request-product');
        }
    }

    public function productRequested() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Product Request']);
            return view('pages.requested-product');
        }
    }

    public function NotificaitonRequest() {
        if (Gate::allows('isAdmin', Auth::user()->role_id) || Gate::allows('isMerchant', Auth::user()->role_id) || Gate::allows('isAccountant', Auth::user()->role_id)) {
            $this->authorize('viewAny', [\App\ModuleRight::class, 'Product Request']);
            return view('pages.show-request-product');
        }
    }

    public function underDev(){
        return view('pages.under-development');
    }
}
