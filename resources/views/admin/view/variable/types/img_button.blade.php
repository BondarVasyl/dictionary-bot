@if($item->multilingual)
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach (config('app.locales') as $key => $locale)
                <li @if ($key == 0) class="active" @endif>
                    <a aria-expanded="false" href="#tab_{!! $item->id !!}_{!! $locale !!}" data-toggle="tab">
                        <i class="flag flag-{!! $locale !!}"></i>
                        @lang('labels.tab_'.$locale)
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach (config('app.locales') as $key => $locale)
                <div class="tab-pane fade in @if ($key == 0) active @endif" id="tab_{!! $item->id !!}_{!! $locale !!}">
						<div class="form-group">
						    <label for="image" class="col-sm-2 control-label">
						        {!! Form::label($locale . '[json][image]', trans('labels.image'), array('class' => "control-label")) !!}
						    </label>
						
						    <div class="col-sm-10">
						        <div class="col-xs-1 file-add-dialog">
						            <div class="fileinput fileinput-new" data-provides="fileinput">
						                <div class="fileinput-new thumbnail">
						                    @if (isset($item->translate($locale)->json['image']) )
						                        <a target=_blank href="{!! $item->translate($locale)->json['image'] !!}">
						                            <img src="{!! $item->translate($locale)->json['image'] !!}">
						                        </a>
												 {!! Form::hidden($locale . '[json][image]',$item->translate($locale)->json['image']) !!}
						                    @else
						                        <img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&text=no+image" />
						                    @endif
						
						                </div>
						                <div class="fileinput-preview fileinput-exists thumbnail"></div>
						
						                <div>
						                <span class="btn btn-default btn-file">
						                    <span class="fileinput-new"><i class="icon-uploadalt"></i></span>
						                    <span class="fileinput-exists"><i class="icon-uploadalt"></i></span>
						                    {!! Form::file($locale . '[json][image]') !!}
						                </span>
						                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="icon-remove-sign"></i></a>
						                </div>
						            </div>
						        </div>
						        {!! $errors->first('image', '<span class="error">:message</span>') !!}
						    </div>
						</div>                    

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12">
                            {!! Form::text($locale . '[json][url]', isset($item->translate($locale)->json) ? $item->translate($locale)->json['url'] : '', ['id' => 'value_url', 'placeholder' => trans('labels.url'), 'required' => true, 'class' => 'form-control input-sm']) !!}
                        </div>
					</div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12">
                            {!! Form::text($locale . '[json][header]', isset($item->translate($locale)->json) ? $item->translate($locale)->json['header'] : '', ['id' => 'value_header', 'placeholder' => trans('labels.title'), 'required' => false, 'class' => 'form-control input-sm']) !!}
                        </div>
					</div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12">
                            {!! Form::textarea($locale . '[json][text]', isset($item->translate($locale)->json) ? $item->translate($locale)->json['header'] : '', ['id' => 'value_text', 'placeholder' => trans('labels.text'), 'required' => false, 'class' => 'form-control input-sm']) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else

	<div class="form-group">
	    <label for="image" class="col-sm-2 control-label">
	        {!! Form::label('value[image]', trans('labels.image'), array('class' => "control-label")) !!}
	    </label>
	
	    <div class="col-sm-10">
	        <div class="col-xs-1 file-add-dialog">
	            <div class="fileinput fileinput-new" data-provides="fileinput">
	                <div class="fileinput-new thumbnail">
	                    @if (isset($item->value['image']) )
	                        <a target="_blank" href="{!! $item->value['image'] !!}">
	                            <img src="{!! $item->value['image'] !!}">
	                        </a>
	                    @else
	                        <img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&text=no+image" />
	                    @endif
	
	                </div>
	                <div class="fileinput-preview fileinput-exists thumbnail"></div>
	
	                <div>
	                <span class="btn btn-default btn-file">
	                    <span class="fileinput-new"><i class="icon-uploadalt"></i></span>
	                    <span class="fileinput-exists"><i class="icon-uploadalt"></i></span>
	                    {!! Form::file('value[image]') !!}
	                </span>
	                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="icon-remove-sign"></i></a>
	                </div>
	            </div>
	        </div>
	        {!! $errors->first('image', '<span class="error">:message</span>') !!}
	    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12">
            {!! Form::text('value[url]', isset($item->value['url']) ? $item->value['url'] : '', ['id' => 'value_url', 'placeholder' => trans('labels.url'), 'required' => true, 'class' => 'form-control input-sm']) !!}
        </div>
	</div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12">
            {!! Form::text('value[header]', isset($item->value['header']) ? $item->value['header'] : '', ['id' => 'value_header', 'placeholder' => trans('labels.title'), 'required' => false, 'class' => 'form-control input-sm']) !!}
        </div>
	</div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12">
            {!! Form::textarea('value[text]', isset($item->value['header']) ? $item->value['header'] : '', ['id' => 'value_text', 'placeholder' => trans('labels.text'), 'required' => false, 'class' => 'form-control input-sm']) !!}
        </div>
    </div>

</div>
    @endif
