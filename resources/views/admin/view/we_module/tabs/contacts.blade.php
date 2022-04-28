<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
                @foreach (\App\Http\Middleware\LocaleMiddleware::$languages as $key => $locale)
                    <li class="nav-item">
                        <a class="{{($key == 0)?'nav-link active':'nav-link'}}"
                           data-toggle="pill" href="#tab_{!! $locale !!}" role="tab"
                           aria-controls="tab_{!! $locale !!}"
                           aria-selected="true">
                            <i>{{country_flag(detect_locale($locale))}}</i>
                            {{__('admin_labels.tab_'.$locale)}}</a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content pt-4 pb-4 pl-2 pr-2">
                @foreach (\App\Http\Middleware\LocaleMiddleware::$languages as $key => $locale)
                    <div class="tab-pane fade @if($key == 0)active show @endif" id="tab_{!! $locale !!}"
                         role="tabpanel"
                         aria-labelledby="tab_{!! $locale !!}">
                        @foreach($contacts as $item)
                            <div class="form-group row">
                                <div class="col-xs-1 col-sm-1 col-md-1 text-right">
                                    <label for="contacts[{{$item->name}}][{{$locale}}][value]" style="padding: 5px 0">{{__('admin_labels.' . $item->name)}}</label>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <input class="form-control @if ($errors->has("contacts[{$item->name}][{$locale}][value]")) is-invalid @endif" type="text"  name="contacts[{{$item->name}}][{{$locale}}][value]" value="{{old("contacts[{$item->name}][{$locale}][value]", $item->translate($locale)->value)}}">
                                </div>
                                @if ($errors->has("contacts[{$item->name}][{$locale}][value]")) <span style=" color:red">{{$errors->messages()["contacts[{$item->name}][{$locale}][value]"][0]}}</span> @endif



                                <div class="col-xs-1 col-sm-1 col-md-1 text-right">
                                    <label for="contacts[{{$item->name}}][position]" style="padding: 5px 0">{{__('admin_labels.position')}}</label>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <input class="form-control @if ($errors->has("contacts[{$item->name}][position]")) is-invalid @endif contact-position" type="text"  name="contacts[{{$item->name}}][position]" value="{{old("contacts[{$item->name}][position]", $item->position)}}">
                                </div>
                                @if ($errors->has("contacts[{$item->name}][position]")) <span style=" color:red">{{$errors->messages()["contacts[{$item->name}][position]"][0]}}</span> @endif



                                <div class="col-xs-1 col-sm-1 col-md-1 text-right">
                                    <label for="contacts[{{$item->name}}][status]" style="padding: 5px 0">{{__('admin_labels.status')}}</label>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    {!! Form::select("contacts[{$item->name}][status]", array("1" => __('admin_labels.visible'), "0" => __('admin_labels.no_visible')), $item->status, array('class' => 'form-control col-xs-1 contact-status')) !!}
                                </div>
                                @if ($errors->has("contacts[{$item->name}][status]")) <span style=" color:red">{{$errors->messages()["contacts[{$item->name}][status]"][0]}}</span> @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
