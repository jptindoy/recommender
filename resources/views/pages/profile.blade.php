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
    <div class="row">
        <div class="col-8"> 
            <profile-page :user-id={{ Auth::user()->id }} :user-role={{ Auth::user()->role_id }}></profile-page>
        </div>
        <div class="col-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#modal-profile-picture"  data-toggle="modal" class="nav-link">
                                <i class="fas fa-user-circle"></i> Chage Profile Picture
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#modal-password" data-toggle="modal" class="nav-link">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </li>                        

                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <change-profile :user-id={{ Auth::user()->id }}></change-profile>
            <change-password :user-id={{ Auth::user()->id }}></change-password>
        </div>
    </div> 
    {{-- <h5 class="mb-2">Users Setting</h5> --}}
    
        
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
