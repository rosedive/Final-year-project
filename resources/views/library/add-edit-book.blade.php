@extends('layouts.app')

@section('page-title', 'Library')
@section('page-heading', $edit ? $library->name : 'New Book')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('library.index') }}">Library</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['library.update', $library->id], 'method' => 'PUT', 'id' => 'library-form-c']) !!}
@else
    {!! Form::open(['route' => 'library.store', 'id' => 'library-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="type" value="borrowed">

                <div class="form-group">
                    <label for="regno">Registration Number</label>
                    <input type="text" class="form-control" id="regno"
                            autocomplete="off" name="regno" placeholder="Reg. No" value="{{ $edit ? $library->regno : old('regno') }}">
                </div>
                <div class="form-group">
                    <label for="book_title">Book Title</label>
                    <input type="text" class="form-control" id="book_title"
                            autocomplete="off" name="book_title" placeholder="Book Title" value="{{ $edit ? $library->book_title : old('book_title') }}">
                </div>
                <div class="form-group">
                    <label for="book_isbn">Book ISBN</label>
                    <input type="text" class="form-control" id="book_isbn"
                            autocomplete="off" name="book_isbn" placeholder="Book ISBN" value="{{ $edit ? $library->book_isbn : old('book_isbn') }}">
                </div>
                @if($edit)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="status" id="status" value="Returned"/>
                    <label class="custom-control-label font-weight-normal" for="status">
                        Return Book
                    </label>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    {{ $edit ? 'Update' : 'Save' }}
</button>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('App\Http\Requests\Library\UpdateLibraryRequest', '#library-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Library\CreateLibraryRequest', '#library-form-u') !!}
    @endif
@stop