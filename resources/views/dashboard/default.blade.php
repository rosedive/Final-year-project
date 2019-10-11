@extends('layouts.app')

@section('page-title', trans('app.dashboard'))
@section('page-heading', trans('app.dashboard'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('app.dashboard')
    </li>
@stop

@section('content')

<div class="row">
    
    @permission('clearance.request.manage')
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('student.clearance.request') }}" class="text-center no-decoration">
                <div class="icon my-3">
                    <i class="fas fa-list fa-2x"></i>
                </div>
                <p class="lead mb-0">Clearance Request</p>
                </a>
            </div>
        </div>
    </div>
    @endpermission
    
    @permission('clearance.manage')
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('student.clearance') }}" class="text-center no-decoration">
                <div class="icon my-3">
                    <i class="fas fa-list fa-2x"></i>
                </div>
                <p class="lead mb-0">Clearance</p>
                </a>
            </div>
        </div>
    </div>
    @endpermission

    @permission('results.manage')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('result.index') }}" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Record result</p>
                    </a> 
                </div>
            </div>
        </div>
    @endpermission

    @permission('hostel.manage')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('hostel.index') }}" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Hostel</p>
                    </a>
                </div>
            </div>
        </div>
    @endpermission

    @permission('library.manage')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('library.create') }}?action=add-book" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Borrowed Books</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('library.create') }}?type=finalbook&action=submit" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Record Final Year Book</p>
                    </a>
                </div>
            </div>
        </div>
    @endpermission

    @permission('registration.manage')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('registration.index') }}" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">View Student List</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('registration.student') }}" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Register Student</p>
                    </a>
                </div>
            </div>
        </div>
    @endpermission

    @permission('income.manage')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('finance.index') }}" class="text-center no-decoration">
                        <div class="icon my-3">
                            <i class="fas fa-server fa-2x"></i>
                        </div>
                        <p class="lead mb-0">Receipts</p>
                    </a>
                </div>
            </div>
        </div>
    @endpermission
</div>

@stop

@section('scripts')
@stop