@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Administrator Dashboard</h1>
                </div><!-- /.col -->
                
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">    
            <sales-report></sales-report>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <yesterday-sales></yesterday-sales>
                </div>
                <div class="col-xs-12 col-md-6">
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
                    <div class="note">
                        <p>The presentation of data on each window are base to the data of the POS Sytem of the University Store. The data that imported to the database are being proccess base to the need information to each window.</p>
                        <label for="">Note:</label>
                        <p><i>To maintain the accuracy of the graph and table, you need to import everyday the POS Sales Data to this System.</i> </p>
                    </div>
                </div>                
            </div>            
        </div> 
    </div>
    <!-- /.content --> 

@endsection
