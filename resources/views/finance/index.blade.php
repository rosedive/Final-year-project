@extends('layouts.app')

@section('page-title', 'Finances')
@section('page-heading', 'Finances')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of finances
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
                                   placeholder="Search by Reg. No">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('finance.index') }}"
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
                        <a href="{{ route('finance.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Add finance
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="min-width-150">Reg. No</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Bankslip No</th>
                        <th>Expected Amount</th>
                        <th>Paid Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($finances))
                            @foreach ($finances as $finance)
                                <tr>
                                    <td>{{ $finance->regno }}</td>
                                    <td>
                                        {{ $finance->first_name .' '. $finance->last_name }}
                                    </td>
                                    <td>{{ $finance->level }}</td>
                                    <td>{{ $finance->bankslip_no }}</td>
                                    <td>{{ $finance->expected_amount }}</td>
                                    <td>{{ $finance->amount_paid }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('finance.edit', $finance->id) }}" class="btn btn-icon"
                                           title="Edit finance" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('finance.delete', $finance->id) }}" class="btn btn-icon"
                                           title="Delete finance"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="Comfirm"
                                           data-confirm-text="Are you sure that you want to delete this finance"
                                           data-confirm-delete="Yes, Delete it.">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
