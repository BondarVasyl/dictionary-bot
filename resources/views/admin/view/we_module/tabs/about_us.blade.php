@php($file_hash = generate_file_hash($about_us->id))
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <div class="form-group image-wrap" data-default="{{asset('storage/images/default/upload_image.png')}}">
                <label for="image" class="col-sm-2 control-label">
                    {!! Form::label('video', trans('admin_labels.video'), array('class' => "control-label")) !!}
                </label>
                <div class="form-group col-sm-10">
                    <iframe width="420" height="315"
                            src="{{ isset($about_us->video) &&  $about_us->video != "" ? file_url($about_us->video) : asset('storage/images/default/upload_image.png')}}"
                            id="image"
                            class="img-thumbnail mb-1 lg-1 preview upload-preview-img-{{$file_hash}}"
                            style="max-width: 250px; max-height: 250px"
                    >
                    </iframe>
                    <input class="isRemoveFile" type="text" id="isRemoveFile" name="about_us[isRemoveFile]" hidden value="0">

                    <div class="input-group mt-2">
                        <input
                            class="input-file form-control upload-label-img-{{$file_hash}} preview-link"
                            name="about_us[video]"
                            type="text" id="image_label"
                            aria-label="Image"
                            aria-describedby="button-image"
                            value="{{file_url($about_us->video)}}"
                        >
                        {!! $errors->first('image', '<span class="error">:message</span>') !!}

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary upload-button-image input-sm" type="button" id="button-image" data-tr-id="{{$file_hash}}">
                                {{__('admin_labels.select_file')}}
                            </button>
                            @if($about_us && $about_us->video !== NULL)
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
            <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
                @foreach (\App\Http\Middleware\LocaleMiddleware::$languages as $key => $locale)
                    <li class="nav-item">
                        <a class="{{($key == 0)?'nav-link active':'nav-link'}}"
                           data-toggle="pill" href="#about_us_tab_{!! $locale !!}" role="tab"
                           aria-controls="tab_{!! $locale !!}"
                           aria-selected="true">
                            <i>{{country_flag(detect_locale($locale))}}</i>
                            {{__('admin_labels.tab_'.$locale)}}</a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content pt-4 pb-4 pl-2 pr-2">

                @foreach (\App\Http\Middleware\LocaleMiddleware::$languages as $key => $locale)
                    <div class="tab-pane fade @if($key == 0)active show @endif" id="about_us_tab_{!! $locale !!}"
                         role="tabpanel"
                         aria-labelledby="tab_{!! $locale !!}">
                        <div class="form-group row">
                            <label for="{!!'about_us['. $locale . '][content]' !!}" class="col-sm-2 control-label">
                                {!! Form::label('about_us['. $locale . '][content]', __('admin_labels.description'), array('class' => "control-label")) !!}
                            </label>

                            <div class="col-xs-6">
                                {!! Form::textarea('about_us['. $locale . '][content]', isset($about_us->translate($locale)->content) ? $about_us->translate($locale)->content : '', array('placeholder' => __('admin_labels.content'), 'class' => 'form-control ckeditor', 'rows' => '5')) !!}
                                {!! $errors->first('about_us['. $locale . '][content]', '<span class="error">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
