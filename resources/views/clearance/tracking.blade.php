@extends('layouts.app')

@section('page-title', 'Tracking application')
@section('page-heading', 'Clearance')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        Tracking request
    </li>
@stop

@section('content')

    @include('partials.messages')
 
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form action="" method="GET" id="users-form" class="">
                        <div class="row my-3 flex-md-row flex-column-reverse">
                            <div class="col-md-12 mt-md-0 mt-2">
                                <div class="input-group custom-search-form">
                                    <input type="text"
                                           class="form-control input-solid"
                                           name="track-id"
                                           autocomplete="off" 
                                           value="{{ Input::get('track-id') }}"
                                           placeholder="Enter tracking ID">

                                        <span class="input-group-append">
                                            @if (Input::has('track-id') && Input::get('track-id') != '')
                                                <a href="{{ route('student.clearance.request.track') }}"
                                                       class="btn btn-light d-flex align-items-center text-muted"
                                                       role="button">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-light" type="submit" id="search-users-btn">
                                                <i class="fas fa-search text-muted"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($tracking)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="users-table-wrapper">
                        @if (!empty($clearance))
                            <h5>Application Details</h5>
                            <hr>
                            <table style="font-size: 13px;">
                                <tr>
                                    <td width="130">Application for:</td>
                                    <th>Clearance</th>
                                </tr>
                                <tr>
                                    <td>Level:</td>
                                    <th>Year {{$clearance->level}}</th>
                                </tr>
                                <tr>
                                    <td>Reason:</td>
                                    <th>
                                        @foreach($reasons as $key => $reason)
                                            @if($clearance->reason == $key)
                                                {{ $reason }}
                                            @endif
                                        @endforeach
                                    </th>
                                </tr>
                                <tr>
                                    <td>Application status:</td>
                                    <th>
                                        <span class="text-{{$notfiyCode}}">
                                            {{$clearance->status}}
                                        </span>
                                    </th>
                                </tr>
                                <tr>
                                    <td>Sent:</td>
                                    <td>
                                        {{ $clearance->created_at->format(config('app.date_time_format')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last update:</td>
                                    <td>
                                        {{ $clearance->updated_at->format(config('app.date_time_format')) }}
                                    </td>
                                </tr>
                            </table>

                            <br>
                            <h5>Application Events</h5>
                            <hr>

                            <table width="100%" cellpadding="5" style="font-size: 12px;">
                                @if (count($data))
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr style="background: #e6e6e6; font-weight: bold;">
                                            <td>
                                                <i class="fa fa-arrow-down"></i>
                                                {{ $info['date']->format('l, F jS Y') }}
                                            </td>
                                            <td>Time</td>
                                        </tr>
                                        @foreach ($info['message'] as $notify)
                                            <tr>
                                                <td>{!! $notify->message !!}</td>
                                                <td>
                                                    {{ date('H:i', strtotime($notify->time)) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="1"><em>No info found</em></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-danger">Invalid Tracking ID</h6>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
