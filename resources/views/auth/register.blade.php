@extends('layouts.auth')

@section('page-title', trans('app.sign_up'))

@if (settings('registration.captcha.enabled'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif

@section('content')

    <div class="col-md-10 col-lg-10 col-xl-10 mx-auto mt-4">
        <div class="text-center">
            <img src="{{ url('assets/img/app-logo.png') }}" alt="{{ settings('app_name') }}" height="50">
        </div>

        @include('partials/messages')

        <div class="card mt-4">
            <div class="card-body">
                <div class="p-4">
                    <form role="form" action="<?= url('register') ?>" method="post" id="registration-form" autocomplete="off" class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" value="<?= csrf_token() ?>" name="_token">

                                <div class="form-group">
                                    <input type="text" class="form-control" id="first_name"
                                           name="first_name" placeholder="Firstname" value="{{ old('first_name') }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Lastname" value="{{ old('last_name') }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Reg. No#"  value="{{ old('username') }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="{{ old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                 <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password">
                                </div>

                            </div>
                            <div class="col-md-6">

                                @if (settings('tos'))
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="tos" id="tos" value="1"/>
                                        <label class="custom-control-label font-weight-normal" for="tos">
                                            @lang('app.i_accept')
                                            <a href="#tos-modal" data-toggle="modal">@lang('app.terms_of_service')</a>
                                        </label>
                                    </div>
                                @endif

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-login">
                                        @lang('app.register')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center text-muted">
            @if (settings('reg_enabled'))
                @lang('app.already_have_an_account')
                <a class="font-weight-bold" href="<?= url("student-login") ?>">@lang('app.login')</a>
            @endif
        </div>

    </div>

    @if (settings('tos'))
        <div class="modal fade" id="tos-modal" tabindex="-1" role="dialog" aria-labelledby="tos-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tos-label">@lang('app.terms_of_service')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>1. Terms</h4>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Donec quis lacus porttitor, dignissim nibh sit amet, fermentum felis.
                            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                            cubilia Curae; In ultricies consectetur viverra.
                        </p>

                        <h4>2. Use License</h4>

                        <ol type="a">
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Donec quis lacus porttitor, dignissim nibh sit amet, fermentum felis.
                                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                                cubilia Curae; In ultricies consectetur viverra.
                            </li>
                        </ol>

                        <p>...</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Auth\RegisterRequest', '#registration-form') !!}
@stop