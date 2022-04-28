@foreach($list->permissions as $key => $item)
    <span class="badge badge-info">{{ $item->title }}</span>
@endforeach
