@include('admin.partials._buttons', ['class' => 'buttons-top'])

<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab_contacts" role="tab" aria-controls="tab_contacts" aria-selected="true">{{__('admin_labels.tab_contacts')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab_about_us" role="tab" aria-controls="tab_about_us" aria-selected="false">{{__('admin_labels.tab_about_us')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#tab_patreons" role="tab" aria-controls="tab_patreons" aria-selected="false">{{__('admin_labels.tab_patreons')}}</a>
                </li>
            </ul>

            <div class="tab-content pt-4 pb-4 pl-2 pr-2">

                <div class="tab-pane active show" id="tab_contacts">
                    @include('admin.view.' . $module . '.tabs.contacts')
                </div>

                <div class="tab-pane" id="tab_about_us">
                    @include('admin.view.' . $module . '.tabs.about_us')
                </div>

                <div class="tab-pane" id="tab_patreons">
                    @include('admin.view.' . $module . '.tabs.patreons')
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.partials._buttons')
