@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Sales Report</h1>
			</div><!-- /.col -->
			
		</div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">    
        <div class="row">
            <div class="col-12">
                <sales-report></sales-report>
            </div>
        </div>    
        <div class="row">
            <div class="col">
                <sales-per-date></sales-per-date>
            </div>
        </div>                 
        <div class="row">
            <div class="col">
                <chart-per-item></chart-per-item>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <request-item-chart></request-item-chart>
            </div>
        </div>
    {{-- <h5 class="mb-2">Users Setting</h5> --}}
    
        
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
