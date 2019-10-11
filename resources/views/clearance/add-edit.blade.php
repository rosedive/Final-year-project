@extends('layouts.app')

@section('page-title', 'Clearances')
@section('page-heading', $edit ? $clearance->name : 'New clearance')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('student.clearance') }}">Clearances</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['clearance.update', $clearance->id], 'method' => 'PUT', 'id' => 'clearance-form-c']) !!}
@else
    {!! Form::open(['route' => 'clearance.store', 'id' => 'clearance-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        @if(!$edit)
            <div class="alert alert-info">
                Please check your information before proceed. <br>
                If some information are not correct, ask to correct it because it may delay your application.
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <p>Registration Number: <strong>{{Auth::user()->username}}</strong></p>
        <p>Names: <strong>{{Auth::user()->first_name .' '. Auth::user()->last_name}}</strong></p>
        <p>Department: <strong>{{Auth::user()->department->name}}</strong></p>
        <p>Option: <strong>{{Auth::user()->option->name}}</strong></p>
        <p>Program: <strong>{{Auth::user()->program}}</strong></p>
        <p>Sponsorship: <strong>{{Auth::user()->sponsorship}}</strong></p>
    </div>
    <div class="col-md-6"> 
        <div class="form-group">
            <input type="hidden" class="form-control" id="regno" name="regno" placeholder="Reg. No" value="{{Auth::user()->username}}" readonly>
        </div>
       <!--  <div class="form-group">
            <label for="level">Year of Study</label>
            <select name="level" class="form-control" id="level">
                <option value="">--select--</option>
                <option value="1" {{($edit && $clearance->level == '1') || old('level') == '1' ? 'selected' : ''}}>Year 1</option>
                <option value="2" {{($edit && $clearance->level == '2') || old('level') == '2' ? 'selected' : ''}}>Year 2</option>
                <option value="3" {{($edit && $clearance->level == '3') || old('level') == '3' ? 'selected' : ''}}>Year 3</option>
            </select>
        </div> -->
        <div class="form-group">
            <label for="level">Year of Study</label>
            <input type="number" name="level" class="form-control" id="level" value="3" {{($edit && $clearance->level == '3') || old('level') == '3' ? 'selected' : ''}} readonly>
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <select name="reason" class="form-control" id="reason">
                <option value="">--select--</option>
                @foreach($reasons as $key => $reason)
                    <option value="{{$key}}" {{$edit && $key == $clearance->reason? 'selected' : ''}}>{{$reason}}</option>
                @endforeach
            </select>
        </div>
    </div> 
</div>

<button type="submit" class="btn btn-primary">
    {{ $edit ? 'Update Reuqest' : 'Send Clearance Request' }}
</button>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Clearance\UpdateClearanceRequest', '#clearance-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Clearance\CreateClearanceRequest', '#clearance-form-u') !!}
    @endif
@stop