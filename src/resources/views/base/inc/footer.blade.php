@if (config('xylophone.base.show_powered_by') || config('xylophone.base.developer_link'))
    <div class="text-muted ml-auto mr-auto">
      @if (config('xylophone.base.developer_link') && config('xylophone.base.developer_name'))
      {{ trans('xylophone::base.handcrafted_by') }} <a target="_blank" href="{{ config('xylophone.base.developer_link') }}">{{ config('xylophone.base.developer_name') }}</a>.
      @endif
      @if (config('xylophone.base.show_powered_by'))
      {{ trans('xylophone::base.powered_by') }} <a target="_blank" href="http://xylophoneforlaravel.com?ref=panel_footer_link">Xylophone for Laravel</a>.
      @endif
    </div>
@endif
