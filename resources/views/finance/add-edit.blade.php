@extends('layouts.app')

@section('page-title', 'Finances')
@section('page-heading', $edit ? $finance->name : 'New finance')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('finance.index') }}">Finances</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit' : 'Create' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['finance.update', $finance->id], 'method' => 'PUT', 'id' => 'finance-form-c']) !!}
@else
    {!! Form::open(['route' => 'finance.store', 'id' => 'finance-form-u']) !!}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="regno">Registration Number</label>
                    <input type="text" class="form-control" id="regno"
                            autocomplete="off" name="regno" placeholder="Reg. No" value="{{ $edit ? $finance->regno : old('regno') }}">
                </div>
                <div class="form-group">
                    <label for="level">Year of Study</label>
                    <select name="level" class="form-control" id="level">
                        <option value="">--select--</option>
                        <option value="1" {{($edit && $finance->level == '1') || old('level') == '1' ? 'selected' : ''}}>Year 1</option>
                        <option value="2" {{($edit && $finance->level == '2') || old('level') == '2' ? 'selected' : ''}}>Year 2</option>
                        <option value="3" {{($edit && $finance->level == '3') || old('level') == '3' ? 'selected' : ''}}>Year 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bankslip_no">Bankslip. No</label>
                    <input type="text" class="form-control" id="bankslip_no"
                            autocomplete="off" name="bankslip_no" placeholder="Bankslip. No" value="{{ $edit ? $finance->bankslip_no : old('bankslip_no') }}">
                </div>
                <div class="form-group">
                    <label for="expected_amount">Expected Amount /FRW</label>
                    <input type="text" class="form-control" id="expected_amount"
                            autocomplete="off" name="expected_amount" placeholder="Expected amount" value="{{ $edit ? $finance->expected_amount : old('expected_amount') }}">
                </div>
                <div class="form-group">
                    <label for="amount_paid">Amount Paid /FRW</label>
                    <input type="text" class="form-control" id="amount_paid"
                            autocomplete="off" name="amount_paid" placeholder="Amount paid" value="{{ $edit ? $finance->amount_paid : old('amount_paid') }}">
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
        {!! JsValidator::formRequest('App\Http\Requests\Finance\UpdateFinanceRequest', '#finance-form-c') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Finance\CreateFinanceRequest', '#finance-form-u') !!}
    @endif
@stop