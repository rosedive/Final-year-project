@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('content')

<div class="col-md-8 col-lg-6 col-xl-5 mx-auto mt-4" id="login">
    <div class="text-center">
        <img src="{{ url('assets/img/rplogo1.png') }}" alt="{{ settings('app_name') }}" height="50">
        <p class="text-success text-center" style="color: #0d563f;font-size: 18px;">ONLINE CLEARANCE SYSTEM</p>
    </div>

    <div class="card mt-4">
       <!--  <img src="./resources/img/logo.jpg" width="300px" height="auto" alt="IPRC" align="center"> -->
        <div class="card-body">
            <div class="p-4">
                @include('partials.messages')

                <form role="form" action="<?= url('staff-login') ?>" method="POST" id="login-form" autocomplete="off" class="mt-3">

                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <p class="text-success text-center" style="color: #0d563f;font-size: 30px;">Staff Login</p>

                    @if (Input::has('to'))
                        <input type="hidden" value="{{ Input::get('to') }}" name="to">
                    @endif

                    <div class="form-group">
                        <label for="username" class="sr-only">E-mail or username</label>
                        <input type="text"
                                name="username"
                                value="{{old('username')}}" 
                                id="username"
                                class="form-control"
                                placeholder="Username">
                    </div>

                    <div class="form-group password-field">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               placeholder="Password">
                    </div>


                    @if (settings('remember_me'))
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" value="1"/>
                            <label class="custom-control-label font-weight-normal" for="remember">
                                Remember me
                            </label>
                        </div>
                    @endif


                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-login">
                            @lang('app.log_in')
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="text-center text-muted">
        Select another option <a class="font-weight-bold" href="<?= url("/") ?>">Select</a>
    </div>

</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/login.js') !!}
    {!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#login-form') !!}
@stop