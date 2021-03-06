@extends('layouts.app')

@section('page-title', 'Registrations')
@section('page-heading', 'Registrations')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of registrations
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
                                   placeholder="Search by reg. no">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('registration.index') }}"
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
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('registration.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Register Student
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th>Reg. No</th>
                        <th class="min-width-150">Name</th>
                        <th class="">Level</th>
                        <th class="">Academic Year</th>
                        <th class="">Promotion Year</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($registrations))
                            @foreach ($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->regno }}</td>
                                    <td>
                                        {{ $registration->first_name .' '. $registration->last_name }}
                                    </td>
                                    <td>{{ $registration->level }}</td>
                                    <td>
                                        {{$registration->academic_year-1 .'-'. $registration->academic_year}}
                                    </td>
                                    <td>
                                        {{$registration->promotion_year-1 .'-'. $registration->promotion_year}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('registration.edit', $registration->id) }}" class="btn btn-icon"
                                           title="Edit registration" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('registration.delete', $registration->id) }}" class="btn btn-icon"
                                           title="Delete registration"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="Comfirm"
                                           data-confirm-text="Are you sure that you want to delete this registration"
                                           data-confirm-delete="Yes, Delete it.">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8"><em>No students found</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
