@can($type.'_show')
    <a class="btn btn-xs btn-primary" href="{{$type .'/'. $model->id}}">
        {{__('datatables.show')}}
    </a>
@endcan
