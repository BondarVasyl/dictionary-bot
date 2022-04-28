@include('admin.partials._buttons', ['class' => 'buttons-top'])
<br>
<div class="card">
    <div class="card-header">
        @if($model->id)
            {{__('admin_labels.edit_user')}}
        @else
            {{__('admin_labels.add_user')}}
        @endif
    </div>
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            @include('admin.view.' . $module . '.partials.general')
        </div>
    </div>
</div>
</div>
@include('admin.partials._buttons')
