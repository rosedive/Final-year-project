@extends('layouts.app')

@section('page-title', 'Hostels')
@section('page-heading', 'Hostels')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of hostels
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
                                   placeholder="Search hostel">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('hostel.index') }}"
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
                        <a href="{{ route('hostel.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Hostel
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="">Reg. No</th>
                        <th class="min-width-150">Name</th>
                        <th class="">Level</th>
                        <th class="">Room</th>
                        <th class="">Room Amount</th>
                        <th class="">Paid</th>
                        <th class="">Debit</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($hostels))
                            @foreach ($hostels as $hostel)
                                <tr>
                                    <td>{{ $hostel->regno }}</td>
                                    <td>
                                        {{ $hostel->first_name .' '. $hostel->last_name }}
                                    </td>
                                    <td>{{ $hostel->level }}</td>
                                    <td>{{ $hostel->room }}</td>
                                    <td>Rwf {{ $hostel->expected_amount }}</td>
                                    <td>Rwf {{ $hostel->amount_paid }}</td>
                                    <td>Rwf 
                                        @if(($hostel->expected_amount - $hostel->amount_paid) > 0)
                                            <span class="text-danger">
                                                {{ $hostel->expected_amount - $hostel->amount_paid }}
                                            </span>
                                        @elseif(($hostel->expected_amount - $hostel->amount_paid) < 0)
                                            <span class="text-success">
                                                {{ ($hostel->expected_amount - $hostel->amount_paid) * -1 }} Over
                                            </span>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hostel.edit', $hostel->id) }}" class="btn btn-icon"
                                           title="Edit hostel" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('hostel.delete', $hostel->id) }}" class="btn btn-icon"
                                           title="Delete hostel"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="Comfirm"
                                           data-confirm-text="Are you sure that you want to delete this hostel"
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
