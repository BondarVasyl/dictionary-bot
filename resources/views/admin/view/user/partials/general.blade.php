<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <div class="col-md-6">
    <label for="name">{{__('admin_labels.name')}}</label>
    </div>
    <div class="col-md-6">
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) && $user->profile? $user->profile->name : '') }}">
    @if($errors->has('name'))
        <p class="help-block error">
            {{ $errors->first('name') }}
        </p>
    @endif
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <div class="col-md-6">
    <label for="email">{{__('admin_labels.email')}}</label>
    </div>
    <div class="col-md-6">
    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">
    @if($errors->has('email'))
        <p class="help-block error">
            {{ $errors->first('email') }}
        </p>
    @endif
    </div>
</div>

<div class="form-group col-md-6 {{ $errors->has('roles') ? 'has-error' : '' }}">
    <label for="roles">{{__('admin_labels.roles')}}
        <span class="btn btn-info btn-xs select-all">Select all</span>
        <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple">
        @foreach($roles as $id => $roles)
            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                {{ $roles }}
            </option>
        @endforeach
    </select>
    @if($errors->has('roles'))
        <p class="help-block error">
            {{ $errors->first('roles') }}
        </p>
    @endif
    </div>
    @if(empty($model->id))
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
    @endif
</div>

