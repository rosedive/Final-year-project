@extends('layouts.app')

@section('page-title', 'Registrations')
@section('page-heading', $edit ? $registration->name : 'New registration')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('registration.index') }}">Registrations</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['registration.update', $registration->id], 'method' => 'PUT', 'id' => 'registration-form-c']) !!}
@else
    {!! Form::open(['route' => 'registration.store', 'id' => 'registration-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="regno">Registration Number</label>
                    <input type="text" class="form-control" id="regno"
                            autocomplete="off" name="regno" placeholder="Reg. no" value="{{ $edit ? $registration->regno : old('regno') }}">
                </div>
                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <select name="academic_year" class="form-control" id="academic_year">
                        <option value="">--select--</option>
                        <option value="{{date('Y')}}" {{$edit && $registration->academic_year == date('Y') || date('Y') == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')-1}}-{{date('Y')}}
                        </option>
                        <option value="{{date('Y')-1}}" {{$edit && $registration->academic_year == date('Y')-1 || date('Y')-1 == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')-2}}-{{date('Y')-1}}
                        </option>
                        <option value="{{date('Y')-2}}" {{$edit && $registration->academic_year == date('Y')-2 || date('Y')-2 == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')-3}}-{{date('Y')-2}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="promotion_year">Promotion Year</label>
                    <select name="promotion_year" class="form-control" id="promotion_year">
                        <option value="">--select--</option>
                        <option value="{{date('Y')+1}}" {{$edit && $registration->promotion_year == date('Y')+1 || date('Y')+1 == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')}}-{{date('Y')+1}}
                        </option>
                        <option value="{{date('Y')}}" {{$edit && $registration->promotion_year == date('Y') || date('Y') == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')-1}}-{{date('Y')}}
                        </option>
                        <option value="{{date('Y')-1}}" {{$edit && $registration->promotion_year == date('Y')-1 || date('Y')-1 == old('academic_year') ? 'selected' : ''}}>
                            {{date('Y')-2}}-{{date('Y')-1}}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="level">Year of Study</label>
                    <select name="level" class="form-control" id="level">
                        <option value="">--select--</option>
                        <option value="1" {{($edit && $registration->level == '1') || old('level') == '1' ? 'selected' : ''}}>Year 1</option>
                        <option value="2" {{($edit && $registration->level == '2') || old('level') == '2' ? 'selected' : ''}}>Year 2</option>
                        <option value="3" {{($edit && $registration->level == '3') || old('level') == '3' ? 'selected' : ''}}>Year 3</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    {{ $edit ? 'Update' : 'Register' }}
</button>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Registration\UpdateRegistrationRequest', '#registration-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Registration\CreateRegistrationRequest', '#registration-form-u') !!}
    @endif
@stop