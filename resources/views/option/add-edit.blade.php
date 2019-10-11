@extends('layouts.app')

@section('page-title', 'Options')
@section('page-heading', $edit ? $option->name : 'New option')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('option.index') }}">Options</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['option.update', $option->id], 'method' => 'PUT', 'id' => 'option-form-c']) !!}
@else
    {!! Form::open(['route' => 'option.store', 'id' => 'option-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name"
                            autocomplete="off" name="name" placeholder="Name" value="{{ $edit ? $option->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select name="department_id" class="form-control" id="department_id">
                        <option value="">--select--</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $edit && $department->id == $option->department_id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    {{ $edit ? 'Update option' : 'Create option' }}
</button>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Option\UpdateOptionRequest', '#option-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Option\CreateOptionRequest', '#option-form-u') !!}
    @endif
@stop