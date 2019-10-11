@extends('layouts.app')

@section('page-title', 'Departments')
@section('page-heading', $edit ? $department->name : 'New department')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('department.index') }}">Departments</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['department.update', $department->id], 'method' => 'PUT', 'id' => 'department-form-c']) !!}
@else
    {!! Form::open(['route' => 'department.store', 'id' => 'department-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name"
                            autocomplete="off" name="name" placeholder="Name" value="{{ $edit ? $department->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="hod">HOD</label>
                    <select name="hod" class="form-control" id="hod">
                        <option value="">--select--</option>
                        @foreach($hods as $hod)
                            <option value="{{ $hod->id }}" {{ $edit && $hod->id == $department->hod ? 'selected' : '' }}>
                                {{ $hod->present()->nameOrEmail }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    {{ $edit ? 'Update department' : 'Create department' }}
</button>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Department\UpdateDepartmentRequest', '#department-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Department\CreateDepartmentRequest', '#department-form-u') !!}
    @endif
@stop