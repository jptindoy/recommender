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
		<users :user-id={{ Auth::user()->u_id }}></users>	
    
    <h5 class="mb-2">Modules Setting and Policies</h5>
    <modules :user-id={{ Auth::user()->u_role }}></modules>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
