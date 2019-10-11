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

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-primary flex-1">
                        <i class="fa fa-users fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['total']) }}</h2>
                        <div class="text-muted">@lang('app.total_users')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-success flex-1">
                        <i class="fa fa-user-plus fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['new']) }}</h2>
                        <div class="text-muted">@lang('app.new_users_this_month')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-danger flex-1">
                        <i class="fa fa-user-slash fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['banned']) }}</h2>
                        <div class="text-muted">@lang('app.banned_users')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="p-3 text-info flex-1">
                        <i class="fa fa-user fa-3x"></i>
                    </div>

                    <div class="pr-3">
                        <h2 class="text-right">{{ number_format($stats['unconfirmed']) }}</h2>
                        <div class="text-muted">@lang('app.unconfirmed_users')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
@stop