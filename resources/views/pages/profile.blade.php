@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Profile Management</h1>
			</div><!-- /.col -->
			
		</div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">  

    {{-- <h5 class="mb-2">Users Setting</h5> --}}
		<show-profile :user-id={{ Auth::user()->u_id }}></show-profile>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
