@extends('layouts.app')

@section('page-title', 'Hostels')
@section('page-heading', $edit ? $hostel->name : 'New hostel')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('hostel.index') }}">Hostels</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['hostel.update', $hostel->id], 'method' => 'PUT', 'id' => 'hostel-form-c']) !!}
@else
    {!! Form::open(['route' => 'hostel.store', 'id' => 'hostel-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="regno">Registration Number</label>
                    <input type="text" class="form-control" id="regno"
                            autocomplete="off" name="regno" placeholder="Reg. No" value="{{ $edit ? $hostel->regno : old('regno') }}">
                </div>
                <div class="form-group">
                    <label for="level">Year of Study</label>
                    <select name="level" class="form-control" id="level">
                        <option value="">--select--</option>
                        <option value="1" {{($edit && $hostel->level == '1') || old('level') == '1' ? 'selected' : ''}}>Year 1</option>
                        <option value="2" {{($edit && $hostel->level == '2') || old('level') == '2' ? 'selected' : ''}}>Year 2</option>
                        <option value="3" {{($edit && $hostel->level == '3') || old('level') == '3' ? 'selected' : ''}}>Year 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sponsorship">Sponsorship</label>
                    <select class="form-control" id="sponsorship" name="sponsorship">
                        <option value="">--select</option>
                        <option value="Goverment Sponsored" {{ $edit && $hostel->sponsorship =='Goverment Sponsored' ? 'selected' : '' }}>
                            Goverment Sponsored
                        </option>
                        <option value="Private Sponsored" {{ $edit && $hostel->sponsorship =='Private Sponsored' ? 'selected' : '' }}>
                            Private Sponsored
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room">Room</label>
                    <input type="text" class="form-control" id="room"
                            autocomplete="off" name="room" placeholder="Room" value="{{ $edit ? $hostel->room : old('room') }}">
                </div>
                <div class="form-group">
                    <label for="expected_amount">Expected Amount /FRW</label>
                    <input type="text" class="form-control" id="expected_amount"
                            autocomplete="off" name="expected_amount" placeholder="Expected amount" value="{{ $edit ? $hostel->expected_amount : old('expected_amount') }}">
                </div>
                <div class="form-group">
                    <label for="amount_paid">Amount Paid /FRW</label>
                    <input type="text" class="form-control" id="amount_paid"
                            autocomplete="off" name="amount_paid" placeholder="Amount paid" value="{{ $edit ? $hostel->amount_paid : old('amount_paid') }}">
                </div>

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
        {!! JsValidator::formRequest('App\Http\Requests\Hostel\UpdateHostelRequest', '#hostel-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Hostel\CreateHostelRequest', '#hostel-form-u') !!}
    @endif
@stop