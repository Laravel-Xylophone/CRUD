@extends(xylophone_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('xylophone::base.welcome'),
        'content'     => trans('xylophone::base.use_sidebar'),
        'button_link' => xylophone_url('logout'),
        'button_text' => trans('xylophone::base.logout'),
    ];
@endphp

@section('content')
@endsection
