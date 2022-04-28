@if ($item->multilingual)

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
            @foreach (config('app.locales') as $key => $locale)
                <li class="nav-item">

                    <a class="{{($key == 0)?'nav-link active':'nav-link'}}"
                       data-toggle="pill" href="#tab_{!! $locale !!}_{{$item->id}}" role="tab" aria-controls="tab_{!! $locale !!}"
                       aria-selected="true">
                        <i>{{country_flag($locale)}}</i>
                        {{__('admin_labels.tab_'.$locale)}}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach (config('app.locales') as $key => $locale)
                <div class="tab-pane fade @if($key == 0)active show @endif" id="tab_{!! $locale !!}_{{$item->id}}" role="tabpanel"
                     aria-labelledby="tab_{!! $locale !!}_{{$item->id}}">
                    <div class="row form-group">
                        <div class="col-xs-12">
                            {!! Form::textarea($locale.'[text]', isset($item->translate($locale)->text) ? $item->translate($locale)->text : '', ['id' => $item->id . '_' . $locale . '_text', 'placeholder' => trans('labels.text'), 'required' => true, 'class' => 'form-control ckeditor '. $item->id . '_' . $locale . '_text']) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@else

    <div class="row form-group">
        <div class="col-xs-12">
            {!! Form::textarea('value', null, ['id' => $item->id . '_value', 'placeholder' => trans('labels.value'), 'required' => true, 'class' => 'form-control ckeditor' . $item->id . '_value']) !!}
        </div>
    </div>

@endif
