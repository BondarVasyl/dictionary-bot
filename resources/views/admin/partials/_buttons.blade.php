<div class="row box-footer @if (!empty($class)) {!! $class !!} @endif">
    <div class="col-md-6">
        @if($module != 'translation')
        <a href="{!! empty($back_url) ? url()->previous() : $back_url !!}" class="btn btn-secondary">{{__('admin_labels.buttons.back')}}</a>
        @endif
    </div>

    <div class="col-md-6 justify-content-end text-right">
        <input class="btn btn-success btn-flat button" type="submit" value="{{__('admin_labels.buttons.save')}}">
        @if($module == 'user' && $model->id && !$without_password_change)
            <a href="{!! route('admin.user.new_password.get', $model->id) !!}" class="btn btn-warning margin-right-15 btn-flat">{!! trans("admin_labels.buttons.change_password") !!}</a>
        @endif

    </div>

</div>
