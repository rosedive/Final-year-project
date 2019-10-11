@extends('layouts.app')

@section('page-title', 'Clearances')
@section('page-heading', 'Clearances')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of clearances
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
                                   placeholder="Search clearance">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('student.clearance') }}"
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
                        {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control input-solid']) !!}
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('clearance.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Clearance request
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="">Track ID</th>
                        <th class="">Reg</th>
                        <th class="min-width-100">Names</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($clearances))
                            @foreach ($clearances as $clearance)
                                <tr>
                                    <td>{{ $clearance->id }}</td>
                                    <td>{{ $clearance->regno }}</td>
                                    <td>
                                        {{ $clearance->first_name .' '. $clearance->last_name }}
                                    </td>
                                    <td>
                                        @foreach($reasons as $key => $reason)
                                            @if($clearance->reason == $key)
                                                {{ $reason }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $clearance->status }}
                                    </td>
                                    <td class="text-center">
                                        @if($clearance->status == 'Approved')
                                            <a href="{{ route('clearance.download.document', $clearance->id) }}" class="btn btn-icon"
                                               title="Download your document" data-toggle="tooltip" data-placement="top">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        @if ($clearance->status == 'Requested')
                                            <a href="{{ route('clearance.edit', $clearance->id) }}" class="btn btn-icon"
                                               title="Update request reason" data-toggle="tooltip" data-placement="top">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('clearance.delete', $clearance->id) }}" class="btn btn-icon"
                                               title="Delete request"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               data-method="DELETE"
                                               data-confirm-title="Comfirm"
                                               data-confirm-text="Are you sure that you want to delete this request"
                                               data-confirm-delete="Yes, Delete it.">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('student.clearance.request.track') }}" class="btn btn-icon"
                                               title="Tracking Reuqest" data-toggle="tooltip" data-placement="top">
                                                <i class="fas fa-map"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"><em>No records found</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
