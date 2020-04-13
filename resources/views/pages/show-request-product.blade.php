@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Create Request</h1>
			</div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/requested">Back</a></li>
                    <li class="breadcrumb-item active">Create Request</li>
                </ol>
            </div>
		</div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">            
        <request-item :request-id={{$_GET['id']}} :user-role={{Auth::user()->role_id }} :user-id={{Auth::user()->id }}></request-item>
        
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
