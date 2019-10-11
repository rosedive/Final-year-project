@extends('layouts.app')

@section('page-title', 'Results')
@section('page-heading', $edit ? $result->name : 'New result')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('result.index') }}">Results</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

<!-- @if ($edit)
    {!! Form::open(['route' => ['result.update', $result->id], 'files' => true, 'method' => 'PUT', 'id' => 'result-form-c']) !!}
@else
    {!! Form::open(['route' => 'result.store', 'files' => true, 'id' => 'result-form-u']) !!}
@endif -->
 {!! Form::open(['route' => ['result.update', $result->id], 'files' => true, 'method' => 'PUT', 'id' => 'result-form-c']) !!}


                     @if(Session::has('message'))
                    <p >{{ Session::get('message') }}</p>
                @endif
                      @csrf

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="regno">Registration Number</label>
            <input type="text" name="regno" class="form-control" 
                placeholder="Reg. No" 
                autocomplete="off" value="{{$edit ? $result->regno : old('regno')}}">
        </div>

        <div class="form-group">
            <label for="level">Year of Study</label>
            <select name="level" class="form-control" id="level">
                <option value="">--select--</option>
                <option value="1" {{($edit && $result->level == '1') || old('level') == '1' ? 'selected' : ''}}>Year 1</option>
                <option value="2" {{($edit && $result->level == '2') || old('level') == '2' ? 'selected' : ''}}>Year 2</option>
                <option value="3" {{($edit && $result->level == '3') || old('level') == '3' ? 'selected' : ''}}>Year 3</option>
            </select>
        </div>

        <div class="form-group">
            <label for="term">Term</label>
            <select name="term" class="form-control" id="term">
                <option value="">--select--</option>
                <option value="1" {{($edit && $result->term == '1') || old('term') == '1' ? 'selected' : ''}}>Semester 1</option>
                <option value="2" {{($edit && $result->term == '2') || old('term') == '2' ? 'selected' : ''}}>Semester 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="marks">Marks /100</label>
            <input type="text" name="marks" class="form-control" 
                placeholder="Marks" 
                autocomplete="off"
                value="{{$edit ? $result->marks : old('marks')}}">
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">Update</button
</form>

<!-- @stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Result\UpdateResultRequest', '#result-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Result\CreateResultRequest', '#result-form-u') !!}
    @endif
@stop -->