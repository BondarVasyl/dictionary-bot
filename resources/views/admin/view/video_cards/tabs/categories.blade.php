<div class="form-group categories">
    <label for="categories" class="col-sm-8 control-label">
        {!! Form::label('categories', __('admin_labels.categories'), ['class' => "control-label"]) !!}
    </label>
    <div class="col-sm-10">
        <div class="col-xs-5">
            {!! Form::select('categories', $parents, $model->categories, ['class' =>'form-control select2', 'style' => 'width:600px', 'multiple'=>'multiple', 'name' => 'categories[]']) !!}
        </div>
        {!! $errors->first('categories', '<span class="error">:message</span>') !!}
    </div>
</div>
