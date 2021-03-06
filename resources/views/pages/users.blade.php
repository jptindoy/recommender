@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">System Management</h1>
                </div><!-- /.col -->
                
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">  
            <h5 class="mb-2">Users Setting</h5>
            <users-page :user-id={{ Auth::user()->id }} :user-role={{ Auth::user()->role_id }}></users-page>
        {{-- <div class="row">
            <div class="col-4">
                <users-page></users-page>
            </div>
            <div class="col-8">
                <profile-page :user-id={{ Auth::user()->id }}></profile-page>
            </div>
        </div> --}}
            <br>
            <h5 class="mb-2">Modules Setting and Policies</h5>
        <div class="modules">
            <module-page :user-id={{ Auth::user()->role_id}}></module-page>
        </div>
        {{-- 
                <users :user-id={{ Auth::user()->u_id }}></users>	
        
            
                <modules :user-id={{ Auth::user()->u_role }}></modules>--}}
        </div><!-- /.container-fluid --> 
    </div>
    <!-- /.content -->
@endsection