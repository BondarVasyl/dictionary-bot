@extends('adminlte::page')
@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.view_category')}}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                       data-toggle="pill" href="#tab_seo" role="tab" aria-controls="tab_seo"
                       aria-selected="true">
                        {{__('admin_labels.tab_seo')}}</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="false">{{__('admin_labels.tab_general')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab_attributes" role="tab" aria-controls="tab_attributes" aria-selected="false">{{__('admin_labels.tab_attributes')}}</a>
            </li>

        </ul>
        <div class="tab-content pt-4 pb-4 pl-2 pr-2">
            <div class="tab-pane fade active show" id="tab_seo" role="tabpanel" aria-labelledby="tab_seo">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{__('admin_labels.title')}}
                        </th>
                        <td>
                            {{ $model->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.meta_title')}}
                        </th>
                        <td>
                            {{ $model->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.meta_keywords')}}
                        </th>
                        <td>
                            {{ $model->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.meta_description')}}
                        </th>
                        <td>
                            {{ $model->meta_description }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="general">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{__('admin_labels.guid')}}
                        </th>
                        <td>
                            {{ $model->guid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.slug')}}
                        </th>
                        <td>
                            {{ $model->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.image')}}
                        </th>
                        <td>
                            {{ view('admin.partials.image',
                        ['src'=>$model->image]
                    ) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.parent')}}
                        </th>
                        <td>
                            {{ ($model->parent_id)?$parents[$model->parent_id]:''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.status')}}
                        </th>
                        <td>
                            {{ ($model->status)?__('admin_labels.visible'):__('admin_labels.no_visible')}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{__('admin_labels.position')}}
                        </th>
                        <td>
                            {{$model->position}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.roles.index') }}">
            {{__('admin_labels.buttons.back')}}
        </a>
    </div>
</div>
@endsection
