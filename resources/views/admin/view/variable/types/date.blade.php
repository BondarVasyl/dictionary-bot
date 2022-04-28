<br>
<div class="form-group required @if ($errors->has('date_from')) has-error @endif">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
        {!! Form::date('value', null , array('class' => 'datepicker form-control input', 'rows' => '5')) !!}
        {!! $errors->first('value', '<p class="help-block error">:message</p>') !!}
    </div>

</div>
