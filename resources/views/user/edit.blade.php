@extends('layouts.app')

@section('page-title', trans('app.edit_user'))
@section('page-heading', $user->present()->nameOrEmail)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('user.list') }}">@lang('app.users')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.show', $user->id) }}">
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        @lang('app.edit')
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                            id="details-tab"
                            data-toggle="tab"
                            href="#details"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true">
                            User Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            id="authentication-tab"
                            data-toggle="tab"
                            href="#login-details"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true">
                            Login Details
                        </a>
                    </li>
                    @if ($user->role->name == 'student')
                        <li class="nav-item">
                            <a class="nav-link"
                                id="sd-tab"
                                data-toggle="tab"
                                href="#sd"
                                role="tab"
                                aria-controls="home"
                                aria-selected="true">
                                Student Details
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active px-2" id="details" role="tabpanel" aria-labelledby="nav-home-tab">
                        {!! Form::open(['route' => ['user.update.details', $user->id], 'method' => 'PUT', 'id' => 'details-form']) !!}
                            @include('user.partials.details', ['profile' => false])
                        {!! Form::close() !!}
                    </div>

                    <div class="tab-pane fade px-2" id="login-details" role="tabpanel" aria-labelledby="nav-profile-tab">
                        {!! Form::open(['route' => ['user.update.login-details', $user->id], 'method' => 'PUT', 'id' => 'login-details-form']) !!}
                            @include('user.partials.auth')
                        {!! Form::close() !!}
                    </div>

                    @if ($user->role->name == 'student')
                        <div class="tab-pane fade px-2" id="sd" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <?php $route = Authy::isEnabled($user) ? 'disable' : 'enable'; ?>

                            {!! Form::open(['route' => ['user.update.student.details', $user->id], 'method' => 'PUT', 'id' => 'sd-form']) !!}
                                @include('user.partials.student')
                            {!! Form::close() !!}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => ['user.update.avatar', $user->id], 'files' => true, 'id' => 'avatar-form']) !!}
                    @include('user.partials.avatar', ['updateUrl' => route('user.update.avatar.external', $user->id)])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateLoginDetailsRequest', '#login-details-form') !!}

    @if ($user->role->name == 'student')
        {!! JsValidator::formRequest('App\Http\Requests\User\UpdateStudentDetailsRequest', '#sd-form') !!}
    @endif

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#department").change(function() {

            $.ajax({
                type: "GET",
                url: "{{ route('user.create.student.options')}}?dpt_id="+ $(this).val(),
                // async: false,
                success: function( data ) {
                    $('#option').html(data);
                }
            });
        });
    </script>
@stop