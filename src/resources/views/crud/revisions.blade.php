@extends(xylophone_view('layouts.top_left'))

@php
  $defaultBreadcrumbs = [
    trans('xylophone::crud.admin') => url(config('xylophone.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('xylophone::crud.revisions') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('xylophone::crud.revisions') !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('xylophone::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
    </h2>
  </div>
@endsection

@section('content')
<div class="row m-t-20">
  <div class="{{ $crud->getRevisionsTimelineContentClass() }}">
    <!-- Default box -->

    @if(!count($revisions))
      <div class="card">
        <div class="card-header with-border">
          <h3 class="card-title">{{ trans('xylophone::crud.no_revisions') }}</h3>
        </div>
      </div>
    @else
      @include('crud::inc.revision_timeline')
    @endif
  </div>
</div>
@endsection


@section('after_styles')
  <link rel="stylesheet" href="{{ asset('packages/xylophone/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('packages/xylophone/crud/css/revisions.css') }}">
@endsection

@section('after_scripts')
  <script src="{{ asset('packages/xylophone/crud/js/crud.js') }}"></script>
  <script src="{{ asset('packages/xylophone/crud/js/revisions.js') }}"></script>
@endsection
