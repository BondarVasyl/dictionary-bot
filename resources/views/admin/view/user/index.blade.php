@extends('admin.layouts.listable')

@section('content_header')
    @if(!$active_tab)
        @can('user_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route('admin.user.create') }}">
                        {{__('admin_labels.add_user')}}
                    </a>
                </div>
            </div>
        @endcan
    @else
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

            </div>
        </div>
    @endif
@stop

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
            <li class="">
                <a class="nav-link {{!isset($active_tab) ? 'active':''}}"
                   href="{!! route('admin.user.index') !!}">{{__('admin_labels.admin_panel_users')}}</a>
            </li>

            <li class="">
                <a class="nav-link {{ isset($active_tab) && $active_tab=='app' ? 'active' : '' }}"
                   href="{!! route('admin.user.index',['type' => 'app']) !!}">{{__('admin_labels.app_users')}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="groups-table">
                                {!!
                                    TablesBuilder::create(
                                        ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover w-100"],
                                        [
                                            'bStateSave' => true,
                                            'order' => [[ 0, 'desc' ]],
                                            "columns" => [
                                                [ "data" => "id" ],
                                                [ "data" => "email" ],
                                                [ "data" => "roles_id" ],
                                                [ "data" => "actions" ],
                                            ],
                                        ]
                                    )
                                    ->addHead([
                                        ['text' => __('admin_labels.id')],
                                        ['text' => __('admin_labels.email')],
                                        ['text' => __('admin_labels.roles')],
                                        ['text' => __('admin_labels.actions')]
                                    ])
                                    ->addFoot([
                                        ['attr' => ['colspan' => 4]]
                                    ])
                                    ->makehtml()
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!!
                            TablesBuilder::create(
                                ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover"],
                                [
                                    'bStateSave' => true,
                                    'order' => [[ 0, 'desc' ]],
                                    "columns" => [
                                        [ "data" => "id" ],
                                        [ "data" => "email" ],
                                        [ "data" => "roles_id" ],
                                        [ "data" => "actions" ],
                                    ],
                                ]
                            )
                            ->addHead([
                                ['text' => trans('labels.id')],
                                ['text' => trans('labels.email')],
                                ['text' => 'Роли'],
                                ['text' => trans('labels.actions')]
                            ])
                            ->addFoot([
                                ['attr' => ['colspan' => 4]]
                            ])
                            ->makejs()
                        !!}
@stop
