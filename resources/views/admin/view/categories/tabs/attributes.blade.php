<div class="form-group attributes">
    <label for="attributes" class="col-sm-2 control-label">
        {!! Form::label('attributes', __('admin_labels.attribute'), ['class' => "control-label"]) !!}
    </label>
    <div class="col-sm-10">
        <div class="col-xs-5">
            {!! Form::select('attributes', $attributes, $model->attributes, ['class' =>'form-control select2', 'multiple'=>'multiple', 'name' => 'attributes[]']) !!}

        </div>
        {!! $errors->first('attributes', '<span class="error">:message</span>') !!}
    </div>
</div>
