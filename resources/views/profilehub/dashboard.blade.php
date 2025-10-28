@extends('vendor.profilehub.layouts.admin')

@section('css') 
@endsection

@section('content')
<div class="card">
    <h5 class="card-header">{{ __('Dashboards') }}</h5>
    <div class="col-md-12 col-lg-12">
        <div class="card-body">
            <div class="row g-4">

                <!-- User Groups Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <i class="fas fa-users me-2"></i>
                            <span>User Groups</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage user groups and their permissions.</p>
                            <a href="{{ route('profilehub.admin.users.groups') }}" class="btn btn-primary btn-sm btn-block ">Go to Module</a>
                        </div>
                    </div>
                </div>

                <!-- User Management Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <i class="fas fa-user-cog me-2"></i>
                            <span>User Management</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Add, edit, or remove users from the system.</p>
                            <a href="{{ route('profilehub.admin.users') }}" class="btn btn-success btn-sm btn-block">Go to Module</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Fields Management Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-dark d-flex align-items-center">
                            <i class="fas fa-id-badge me-2"></i>
                            <span>Profile Fields Management</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Customize profile fields for user data collection.</p>
                            <a href="{{ route('profilehub.admin.users.profile.groups') }}" class="btn btn-sm btn-block btn-warning text-dark">Go to Module</a>
                        </div>
                    </div>
                </div>

            </div> 
        </div>
    </div>
</div>
@endsection