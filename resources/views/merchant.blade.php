@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Merchandiser Dashboard</h1>
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
               <!-- small box -->
               <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Pending Request</h3>

                        <p>Product most frequently consumed</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Approved Request</h3>

                        <p>Product most frequently consumed</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Trend Product</h3>
    
                        <p>Product most frequently consumed</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>                
        </div>                     
       
        <yesterday-sales></yesterday-sales>
    </div> 
</div>
<!-- /.content --> 
@endsection
