@extends('layouts.app')

@section('page-title', trans('app.add_user'))
@section('page-heading', trans('app.create_new_user'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('user.list') }}">@lang('app.users')</a>
    </li>
    <li class="breadcrumb-item active">
        @lang('app.create')
    </li>
@stop

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('app.user_details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        A general user profile information.
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.details', ['edit' => false, 'profile' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="card hidden" id="student-details">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        Student Details
                    </h5>
                    <p class="text-muted font-weight-light">
                        Department, option and program of student.
                    </p>
                </div>
                <div class="col-md-9">
                    <input type="hidden" id="sd" name="student_details">
                    @include('user.partials.student', ['edit' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('app.login_details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        Details used for authenticating with the application.
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.auth', ['edit' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('app.create_user')
            </button>
        </div>
    </div>
{!! Form::close() !!}

<br>
@stop

@section('scripts')
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\User\CreateUserRequest', '#user-form') !!}

    <script>
        $('#sd').attr('value', "" );
        var checkRole = $('#roles :selected').text();
        studentDetails(checkRole);

        $("#roles").change(function() {
            $('#sd').attr('value', "" );
            $('#student-details').addClass('hidden');
            var role_id = $(this).val();
            var role = $('#roles :selected').text();

            studentDetails(role);
        });

        function studentDetails(role) {
            if ( role == 'student' || role == 'Student' ) 
            {
                $('#sd').attr('value', role );
                $('#student-details').removeClass('hidden');
            }
        }

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