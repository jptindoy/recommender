<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- icon --}}
    <link rel="shortcut icon" href="{{asset('storage/img/aup-logo.png')}}" type="image/ico">
    <!-- Scripts -->
    {{-- icon --}}
    {{-- <link rel="shortcut icon" href="{{asset('storage/img/aup-logo.png')}}" type="image/ico"> --}}
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('admin-lte/plugins/toastr/toastr.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-lte/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed" >
    
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">{{ Auth::user()->role->role }} Account</a>
            </li>
        </ul>
    
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            
            <!-- Notifications Dropdown Menu -->
            <notification :user-id={{ Auth::user()->role_id}}></notification>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                    <i class="fas fa-cogs"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header"><strong></i> Settings</strong></span>
                    <div class="dropdown-divider"></div>

                    @can('isAdmin', User::class)
                        <a href="{{route('users')}}" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> System Management
                            {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
                        </a>
                    @endcan
                    
                    @can('viewAny', [\App\ModuleRight::class, 'Profile Management'])
                        <div class="dropdown-divider"></div>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                            {{-- <span class="float-right text-muted text-sm">12 hours</span> --}}
                        </a>
                    @endcan
                    
                    @can('isAdmin', User::class)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('import-data')}}" class="dropdown-item">
                            <i class="fas fa-file-import mr-2"></i> Import Data
                            {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
                        </a>
                    @elsecan('isMerchant', User::class)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('import-data')}}" class="dropdown-item">
                            <i class="fas fa-file-import mr-2"></i> Import Data
                            {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
                        </a>
                    @endcan
                    <div class="dropdown-divider"></div>
                    {{-- <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a> --}}
                    <div class="dropdown-divider"></div>
                    
                    <a class="dropdown-item dropdown-footer" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                </div>
                
            </li>
            
        </ul>
        </nav>
        <!-- /.navbar -->
    
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="javascript:void(0)" class="brand-link">
            <img src="{{asset('storage/img/aup-logo.png')}}" alt="AUP Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('storage/img/profile-img/'.Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image">
                </div>
                @can('viewAny', [\App\ModuleRight::class, 'Profile Management'])
                    <div class="info">
                        <a href="{{route('profile')}}" class="d-block">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</a>
                    </div>
                @endcan
            </div>
    
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                @can('isAdmin', Auth::user()->role_id)
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Administrator Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('accountant')}}" class="nav-link {{ (request()->is('accountant')) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Accountant Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('merchant')}}" class="nav-link {{ (request()->is('merchant')) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Merchandiser Dashboard</p>
                            </a>
                        </li>
                        </ul>
                    </li>
                @elsecan('isAccountant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Accountant Dashboard</p>
                        </a>
                    </li>
                @elsecan('isMerchant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Merchandizer Dashboard</p>
                        </a>
                    </li>
                @endcan
                
                @can('isAdmin', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('recommended')}}" class="nav-link {{ (request()->is('recommended')) ? 'active' : '' }}">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Recomnended Product
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @elsecan('isMerchant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('recommended')}}" class="nav-link {{ (request()->is('recommended')) ? 'active' : '' }}">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Recomnended Product
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @endcan
                
                @can('isAdmin', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('requested')}}" class="nav-link {{ (request()->is('requested')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Product Request
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @elsecan('isMerchant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('requested')}}" class="nav-link {{ (request()->is('requested')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Product Request
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @elsecan('isAccountant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('requested')}}" class="nav-link {{ (request()->is('requested')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Product Request
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @endcan

                @can('isAdmin', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('sales-report')}}" class="nav-link {{ (request()->is('sale-report')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Sales Report
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @elsecan('isAccountant', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('sales-report')}}" class="nav-link {{ (request()->is('sales-report')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Sales Report
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                        </a>
                    </li>
                @endcan

                {{-- @can('isAdmin', Auth::user()->role_id)
                    <li class="nav-item">
                        <a href="{{route('under-dev')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Summary Report
                            <span class="right badge badge-danger">New</span>
                        </p>
                        </a>
                    </li>
                @endcan --}}

                <li class="nav-header">INFORMATIONAL</li>
                <li class="nav-item">
                    <a href="{{route('documentation')}}" class="nav-link">
                    <i class="nav-icon fas fa-file"></i>
                    <p class="text">Documentation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon far fa-circle text-danger"></i>
                    <p class="text">Important <small><i>(Red Color)</i></small></p>
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon far fa-circle text-warning"></i>
                    <p>Warning <small><i>(Yellow Color)</i></small></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon far fa-circle text-info"></i>
                    <p>Informational <small><i>(Blue Color)</i></small></p>
                    </a>
                </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
        </aside>
    
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            
                @yield('content')
          
        </div>
        <!-- /.content-wrapper -->
    
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Profile</h5>
                <ul>
                    
                </ul>
            </div>
        </aside>
        <!-- /.control-sidebar -->
    
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
            Version 1.0
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2019-2020 <a href="http://web1.aup.edu.ph/">AUP Store</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->       

        
   
    <!-- jQuery -->
    <script src="{{asset('admin-lte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{asset('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('admin-lte/plugins/toastr/toastr.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-lte/dist/js/adminlte.min.js')}}"></script>    
    {{-- Chart --}}
    {{-- <script src="{{asset('admin-lte/plugins/chart.js/Chart.min.js')}}"></script>     --}}
    

</body>
</html>
