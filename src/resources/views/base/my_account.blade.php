@extends('xylophone::layouts.top_left')

@section('after_styles')
    <style media="screen">
        .xylophone-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
  $breadcrumbs = [
      trans('xylophone::crud.admin') => url(config('xylophone.base.route_prefix'), 'dashboard'),
      trans('xylophone::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('xylophone::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">

        @if (session('success'))
        <div class="col-lg-8">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if ($errors->count())
        <div class="col-lg-8">
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- UPDATE INFO FORM --}}
        <div class="col-lg-8">
            <form class="form" action="{{ route('xylophone.account.info') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('xylophone::base.update_account_info') }}
                    </div>

                    <div class="card-body xylophone-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @php
                                    $label = trans('xylophone::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input required class="form-control" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>

                            <div class="col-md-6 form-group">
                                @php
                                    $label = config('xylophone.base.authentication_column_name');
                                    $field = xylophone_authentication_column();
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input required class="form-control" type="{{ xylophone_authentication_column()=='email'?'email':'text' }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('xylophone::base.save') }}</button>
                        <a href="{{ xylophone_url() }}" class="btn">{{ trans('xylophone::base.cancel') }}</a>
                    </div>
                </div>

            </form>
        </div>

        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-lg-8">
            <form class="form" action="{{ route('xylophone.account.password') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('xylophone::base.change_password') }}
                    </div>

                    <div class="card-body xylophone-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('xylophone::base.old_password');
                                    $field = 'old_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('xylophone::base.new_password');
                                    $field = 'new_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('xylophone::base.confirm_password');
                                    $field = 'confirm_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('xylophone::base.change_password') }}</button>
                            <a href="{{ xylophone_url() }}" class="btn">{{ trans('xylophone::base.cancel') }}</a>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection
