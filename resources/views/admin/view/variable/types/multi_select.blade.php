<div class="row form-group">
    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
        {!! Form::select('value[]', $values, $item->value, ['class' => 'select2', 'multiple' => 'multiple']) !!}
    </div>
</div>