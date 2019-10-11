@extends('layouts.app')

@section('page-title', 'Requests')
@section('page-heading', 'Requests')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of requests
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
                                   placeholder="Search request">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('student.request') }}"
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
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="">Reg</th>
                        <th class="min-width-100">Names</th>
                        <th>Reason</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($requests))
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->regno }}</td>
                                    <td>
                                        {{ $request->first_name .' '. $request->last_name }}
                                    </td>
                                    <td>
                                        @foreach($reasons as $key => $reason)
                                            @if($request->reason == $key)
                                                {{ $reason }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">

                                        @if($request->$my_task == 1 || $request->$my_task == 3)
                                            <strong>
                                                <span class="text-info">My task done</span>
                                            </strong>
                                        @else
                                        <a href="{{ url('clearance/view?request='.$request->id .'&check='. $redirect) }}" class="btn btn-icon"
                                           title="View Request" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                            Check {{ $redirect }}
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10" style="padding: 0; padding-bottom: 6px;">
                                        <i class="fas fa-arrow-up"></i>
                                        Application status: {{$request->status}}
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

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
