@section('plugins.bsCustomFileInput',true)

@php($file_hash = generate_file_hash($model->id))

<div class="form-group">
    <label for="slug" class="col-sm-2 control-label">
        {!! Form::label('slug', __('admin_labels.slug'), array('class' => "control-label")) !!}
    </label>

    <div class="col-sm-10">
        <div class="col-xs-6">
            {!! Form::text('slug', $model->slug, array('placeholder' => __('admin_labels.slug'), 'class' => 'form-control input-sm')) !!}
        </div>
        {!! $errors->first('slug', '<span class="error">:message</span>') !!}
        <br>
        <p>
            <button type="button" class="btn btn-success btn-sm slug-generate">{!! __('admin_labels.buttons.generate') !!}</button>
        </p>
    </div>
</div>

<div class="form-group">
    <label for="category_id" class="col-sm-2 control-label">
        {!! Form::label('category_id', __('admin_labels.main_category'),array('class' => "control-label")) !!}
    </label>

    <div class="col-sm-10">
        <div class="col-xs-6">
            {!! Form::select('category_id', $parents, $model->category_id, array('class' => 'form-control')) !!}
        </div>
        {!! $errors->first('category_id', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-sm-2 control-label">
        {!! Form::label('status', __('admin_labels.status'), array('class' => "control-label")) !!}
    </label>

    <div class="col-sm-10">
        <div class="col-xs-2">
            {!! Form::select('status', array("1" => __('admin_labels.visible'), "0" => __('admin_labels.no_visible')), $model->status, array('class' => 'form-control col-xs-1')) !!}
        </div>
        {!! $errors->first('status', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <label for="position" class="col-sm-2 control-label">
        {!! Form::label('position', __('admin_labels.position'),array('class' => "control-label")) !!}
    </label>

    <div class="col-sm-10">
        <div class="col-xs-1">
            {!! Form::text('position', $model->position ? $model->position : 0, array('placeholder' => __('admin_labels.position'), 'class' => 'form-control input-sm')) !!}
        </div>
        {!! $errors->first('position', '<span class="error">:message</span>') !!}
    </div>
</div>

<div class="form-group image-wrap" data-default="{{asset('storage/images/default/upload_image.png')}}">
    <label for="image" class="col-sm-2 control-label">
        {!! Form::label('preview_image', trans('admin_labels.preview_image'), array('class' => "control-label")) !!}
    </label>
    <div class="form-group col-sm-10">

        <img src="{{ isset($model->preview_image) ? file_url($model->preview_image) : asset('storage/images/default/upload_image.png')}}"
             id="image"
             class="img-thumbnail mb-1 lg-1 preview upload-preview-img-{{$file_hash}}"
             style="max-width: 250px; max-height: 250px"
        >
        <input class="isRemoveFile" type="text" id="isRemoveFile" name="isRemoveFile" hidden value="0">

        <div class="input-group mt-2">
            <input
                class="input-file form-control upload-label-img-{{$file_hash}} preview-link"
                name="preview_image"
                type="text" id="image_label"
                aria-label="Image"
                aria-describedby="button-image"
                value="{{file_url($model->preview_image)}}"
            >
            {!! $errors->first('image', '<span class="error">:message</span>') !!}

            <div class="input-group-append">
                <button class="btn btn-outline-secondary upload-button-image input-sm" type="button" id="button-image" data-tr-id="{{$file_hash}}">
                    {{__('admin_labels.select_file')}}
                </button>
                @if($model && $model->preview_image !== NULL)
                    <button type="button" id="removeFile"
                            class="btn btn-warning btn-sm removeFile ml-1">{!! __('admin_labels.delete_file') !!}</button>
                @else
                    <button type="button" id="removeFile" class="btn btn-warning btn-sm removeFile ml-1"
                            hidden>{!! __('admin_labels.delete_file') !!}</button>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="publication_date" class="col-sm-2 control-label">
        {!! Form::label('publication_date', __('admin_labels.publication_date'), array('class' => "control-label")) !!}
    </label>
    <div class="col-sm-10">
        <div class="col-xs-6">
            <input id="datetime" type="datetime-local" @if($model->publication_date) value="{{date('Y-m-d\TH:i', strtotime($model->publication_date))}}" @endif name="publication_date" class ="form-control input-sm">
        </div>
        {!! $errors->first('publication_date', '<span class="error">:message</span>') !!}
    </div>
</div>
