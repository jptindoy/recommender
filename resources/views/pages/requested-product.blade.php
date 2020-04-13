@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Product Request</h1>
			</div><!-- /.col -->
			
		</div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">    
        <requested-item :user-role={{Auth::user()->role_id}} :user-id={{Auth::user()->id}}></requested-item>        
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
