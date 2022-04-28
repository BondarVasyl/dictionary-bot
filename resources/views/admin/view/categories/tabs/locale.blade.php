<div class="form-group">
    <label for="{!! $locale . '[title]' !!}" class="col-sm-2 control-label">
        {!! Form::label($locale.'[title]', __('admin_labels.title'), array('class' => "control-label")) !!}
    </label>

    <div class="col-xs-6">
        {!! Form::text($locale.'[title]', isset($model->translate($locale)->title) ? $model->translate($locale)->title : '', array('placeholder' => __('admin_labels.title'), 'class' => 'form-control input-sm name_'.$locale)) !!}
        {!! $errors->first($locale.'.title', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <label for="{!! $locale . '[meta_title]' !!}" class="col-sm-2 control-label">
        {!! Form::label($locale.'[meta_title]', __('admin_labels.meta_title'), array('class' => "control-label")) !!}
    </label>

    <div class="col-xs-6">
        {!! Form::text( $locale.'[meta_title]', isset($model->translate($locale)->meta_title) ? $model->translate($locale)->meta_title : '', array('placeholder' => __('admin_labels.meta_title'), 'class' => 'form-control input-sm')) !!}
        {!! $errors->first($locale.'.meta_title', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <label for="{!! $locale . '[meta_keywords]' !!}" class="col-sm-2 control-label">
        {!! Form::label($locale.'[meta_keywords]', __('admin_labels.meta_keywords'), array('class' => "control-label")) !!}
    </label>

    <div class="col-xs-6">
        {!! Form::text( $locale.'[meta_keywords]', isset($model->translate($locale)->meta_keywords) ? $model->translate($locale)->meta_keywords : '', array('placeholder' => __('admin_labels.meta_keywords'), 'class' => 'form-control')) !!}
        {!! $errors->first($locale.'.meta_keywords', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <label for="{!! $locale . '[meta_description]' !!}" class="col-sm-2 control-label">
        {!! Form::label($locale.'[meta_description]', __('admin_labels.meta_description'), array('class' => "control-label")) !!}
    </label>

    <div class="col-xs-6">
        {!! Form::textarea( $locale.'[meta_description]', isset($model->translate($locale)->meta_description) ? $model->translate($locale)->meta_description : '', array('placeholder' => __('admin_labels.meta_description'), 'class' => 'form-control ckeditor', 'rows' => '5')) !!}
        {!! $errors->first($locale.'.meta_description', '<span class="error">:message</span>') !!}
    </div>
</div>
