@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Accountant Dashboard</h1>
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">    
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
      
                    <div class="info-box-content">
                        <span class="info-box-text">Sales This Month</span>
                        <span class="info-box-number">
                            10
                        <small>%</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>
      
                    <div class="info-box-content">
                        <span class="info-box-text">On Proccess Request</span>
                        <span class="info-box-number">
                            10
                        <small>%</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-truck"></i></span>
      
                    <div class="info-box-content">
                        <span class="info-box-text">Delivered Request</span>
                        <span class="info-box-number">
                            10
                        <small>%</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>    
        </div>                     
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <sales-report></sales-report>
            </div>
            <div class="col-xs-12 col-md-6">
                <sales-report></sales-report>
            </div>
        </div>
        
    </div> 
</div>
<!-- /.content --> 
@endsection
