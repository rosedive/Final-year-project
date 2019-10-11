@extends('layouts.app')

@section('page-title', 'Options')
@section('page-heading', 'Options')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of options
    </li>
@stop

@section('content')

    @include('partials.messages')
 
    <div class="card">
        <div class="card-body">
            <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
                <div class="row my-3 flex-md-row flex-column-reverse">
                    <div class="col-md-4 mt-md-0 mt-2">
                        <div class="input-group custom-search-form">
                            <input type="text"
                                   class="form-control input-solid"
                                   name="search"
                                   autocomplete="off" 
                                   value="{{ Input::get('search') }}"
                                   placeholder="Search option">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('option.index') }}"
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

                    <div class="col-md-2 mt-2 mt-md-0">
                        <!-- {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control input-solid']) !!} -->
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('option.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Add option
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="min-width-150">Option</th>
                        <th>Department</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($options))
                            @foreach ($options as $option)
                                <tr>
                                    <td>{{ $option->name }}</td>
                                    <td>{{ $option->dpt_name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('option.edit', $option->id) }}" class="btn btn-icon"
                                           title="Edit option" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('option.delete', $option->id) }}" class="btn btn-icon"
                                           title="Delete option"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="Comfirm"
                                           data-confirm-text="Are you sure that you want to delete this option"
                                           data-confirm-delete="Yes, Delete it.">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"><em>No records found</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
