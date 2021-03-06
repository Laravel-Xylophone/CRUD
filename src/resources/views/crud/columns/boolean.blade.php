{{-- converts 1/true or 0/false to yes/no/lang --}}
@php
    $value = data_get($entry, $column['name']);
@endphp

<span data-order="{{ $value }}">
	@if ($value === true || $value === 1 || $value === '1')
        @if ( isset( $column['options'][1] ) )
            {!! $column['options'][1] !!}
        @else
            {{ Lang::has('xylophone::crud.yes')?trans('xylophone::crud.yes'):'Yes' }}
        @endif
    @else
        @if ( isset( $column['options'][0] ) )
            {!! $column['options'][0] !!}
        @else
            {{ Lang::has('xylophone::crud.no')?trans('xylophone::crud.no'):'No' }}
        @endif
    @endif
</span>
