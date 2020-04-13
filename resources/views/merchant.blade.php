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
            <div class="col-xs-12 col-md-6">
                <yesterday-sales></yesterday-sales>              
            </div>
            <div class="col-xs-12 col-md-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Request Progress</h3>

                        <p>Show the Progress of the created request</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('requested')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>       
        </div>                     
        <frequent-item-set></frequent-item-set>
        <draft-item></draft-item>
    </div> 
</div>
<!-- /.content --> 
@endsection
