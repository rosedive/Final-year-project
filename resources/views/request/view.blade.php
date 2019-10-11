@extends('layouts.app')

@section('page-title', 'CLearance Request')
@section('page-heading', 'Request Details')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        Clearance
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
              <h2>Student Details</h2>
              <br>
              <table>
                <tr>
                  <td class="min-width-100">First Name</td>
                  <td><strong>{{$user->first_name}}</strong></td>
                </tr>
                <tr>
                  <td>Last Name</td>
                  <td><strong>{{$user->last_name}}</strong></td>
                </tr>
                <tr>
                  <td>Department</td>
                  <td><strong>{{$department->name}}</strong></td>
                </tr>
                <tr>
                  <td>Option</td>
                  <td><strong>{{$option->name}}</strong></td>
                </tr>
                <tr>
                  <td>Level</td>
                  <td><strong>Year {{$clearance->level}}</strong></td>
                </tr>
                <tr>
                  <td>Program</td>
                  <td><strong>{{$user->program}}</strong></td>
                </tr>
                <tr>
                  <td>Sponsorship</td>
                  <td><strong>{{$user->sponsorship}}</strong></td>
                </tr>
              </table>

              <p class="mt-5">
                Request: <strong>Clearance</strong> <br>
                Reason:
                @foreach($reasons as $key => $reason)
                    @if($clearance->reason == $key)
                        <strong>{{ $reason }}</strong>
                    @endif
                @endforeach
                <br>
                Requested on: <strong>{{ $clearance->created_at->format(config('app.date_time_format')) }}</strong>
              </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content mt-4">
                  @include('request.partials.'.$allowcheck)
                  <!-- Decision -->
                  @include('request.partials.decision')
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
  {!! JsValidator::formRequest('App\Http\Requests\Clearance\UpdateRequest', '#request-form') !!}
@stop