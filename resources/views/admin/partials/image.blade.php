@if (empty($attributes['width']))
    <?php $attributes['width'] = 104; ?>
@endif

@if (empty($attributes['height']))
    <?php $attributes['height'] = 142; ?>
@endif

<img src="{!! thumb($src, $attributes['width'], $attributes['height']) !!}"
    @if (!empty($attributes) && count($attributes))
        @foreach($attributes as $key => $value)
            {!! $key !!}="{!! $value !!}"
        @endforeach
    @endif
/>
