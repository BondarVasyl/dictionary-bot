<div class="row form-group" style="margin-top: 30px; margin-left: 3px">
    <div class="col-xs-12 col-sm-4 col-md-4">
        {!! Form::select('value', ['0' => __('admin_labels.status_off'), '1' => __('admin_labels.status_on')], null, ['id' => 'value', 'class' => 'form-control input-sm', 'aria-hidden' => 'true']) !!}
    </div>
</div>
