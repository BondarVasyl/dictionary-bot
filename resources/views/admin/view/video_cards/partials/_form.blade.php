@include('admin.partials._buttons', ['class' => 'buttons-top'])
<br>
<div class="card">
    <div class="card-header">
        @if($model->id)
            {{__('admin_labels.edit_video_card')}}
        @else
            {{__('admin_labels.add_video_card')}}
        @endif
    </div>
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

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#general" role="tab" aria-controls="general"
                           aria-selected="false">{{__('admin_labels.tab_general')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tab_categories" role="tab"
                           aria-controls="tab_categories"
                           aria-selected="false">{{__('admin_labels.tab_categories')}}</a>
                    </li>

                </ul>
                <div class="tab-content pt-4 pb-4 pl-2 pr-2">
                    @foreach (\App\Http\Middleware\LocaleMiddleware::$languages as $key => $locale)
                        <div class="tab-pane fade @if($key == 0)active show @endif" id="tab_{!! $locale !!}"
                             role="tabpanel"
                             aria-labelledby="tab_{!! $locale !!}">
                            @include('admin.view.' . $module . '.tabs.locale', array('errors' => $errors , 'locale' => $locale))
                        </div>
                    @endforeach

                    <div class="tab-pane" id="general">
                        @include('admin.view.' . $module . '.tabs.general')
                    </div>

                    <div class="tab-pane" id="tab_categories">
                        @include('admin.view.' . $module . '.tabs.categories')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('admin.partials._buttons')
