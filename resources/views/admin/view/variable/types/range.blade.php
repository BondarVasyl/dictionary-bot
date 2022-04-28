<div class="row form-group">
    <div class="col-xs-12 col-sm-4 col-md-3">
        {!! Form::text('value[from]', array_get($item->value, 'from'), ['id' => 'value_from', 'placeholder' => trans('labels.from'), 'required' => true, 'class' => 'form-control input-sm']) !!}
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3">
        {!! Form::text('value[to]', array_get($item->value, 'to'), ['id' => 'value_to', 'placeholder' => trans('labels.to'), 'required' => true, 'class' => 'form-control input-sm']) !!}
    </div>
</div>