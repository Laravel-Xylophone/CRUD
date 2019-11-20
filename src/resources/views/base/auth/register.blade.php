@extends(xylophone_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ trans('xylophone::base.register') }}</h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('xylophone.auth.register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="name">{{ trans('xylophone::base.name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="{{ xylophone_authentication_column() }}">{{ config('xylophone.base.authentication_column_name') }}</label>

                            <div>
                                <input type="{{ xylophone_authentication_column()=='email'?'email':'text'}}" class="form-control{{ $errors->has(xylophone_authentication_column()) ? ' is-invalid' : '' }}" name="{{ xylophone_authentication_column() }}" id="{{ xylophone_authentication_column() }}" value="{{ old(xylophone_authentication_column()) }}">

                                @if ($errors->has(xylophone_authentication_column()))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(xylophone_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password">{{ trans('xylophone::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation">{{ trans('xylophone::base.confirm_password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('xylophone::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (xylophone_users_have_email())
                <div class="text-center"><a href="{{ route('xylophone.auth.password.reset') }}">{{ trans('xylophone::base.forgot_your_password') }}</a></div>
            @endif
            <div class="text-center"><a href="{{ route('xylophone.auth.login') }}">{{ trans('xylophone::base.login') }}</a></div>
        </div>
    </div>
@endsection
