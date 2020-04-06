@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">System Recommendation</h1>
			</div><!-- /.col -->
			
		</div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">    
        <div class="row">
            <div class="col-xs-12 col-6">
                <salable-item></salable-item>
            </div>
            <div class="col-xs-12 col-6">
                <frequent-item-set></frequent-item-set>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <predict-item></predict-item>
            </div>            
        </div>
        <draft-item></draft-item>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
