@include('admin.partials._buttons', ['class' => 'buttons-top','without_password_change' => true])
<br>
<div class="card">
    <div class="card-header">
        {{__('admin_labels.buttons.change_password')}}
    </div>
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <div class="form-group @if ($errors->has('password')) has-error @endif">
                {!! Form::label('password', __('admin_labels.password'), ['class' => 'col-md-3 control-label']) !!}

                <div class="col-md-6">
                    {!! Form::text('password', null, ['placeholder' => __('admin_labels.password'), /*'required' => true,*/ 'class' => 'form-control input-sm']) !!}

                    {!! $errors->first('password', '<p class="help-block error">:message</p>') !!}
                </div>
            </div>

            <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                {!! Form::label('password_confirmation', __('admin_labels.password_confirmation'), ['class' => 'col-md-3 control-label']) !!}

                <div class="col-md-6">
                    {!! Form::text('password_confirmation', null, ['placeholder' => __('admin_labels.password_confirmation'), /*'required' => true, */'class' => 'form-control input-sm']) !!}

                    {!! $errors->first('password_confirmation', '<p class="help-block error">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('admin.partials._buttons',['without_password_change' => true])
