@if ($crud->hasAccess('revisions') && count($entry->revisionHistory))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/revisions') }}" class="btn btn-sm btn-link"><i class="fa fa-history"></i> {{ trans('xylophone::crud.revisions') }}</a>
@endif
