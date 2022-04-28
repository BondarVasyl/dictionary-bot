@extends('admin.layouts.listable')
@section('content_header')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

        </div>
    </div>

@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="pages-table">
                        {!!
                            TablesBuilder::create(
                                ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover w-100"]
                            )->addHead([
                                    ['text' => trans('admin_labels.id')],
                                    ['text' => trans('admin_labels.name')],
                                    ['text' => trans('admin_labels.email')],
                                    ['text' => trans('admin_labels.actions')],
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

@endsection

@section('js')
    {!!
                           TablesBuilder::create(
                                ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover w-100"],

                                [
                                    'bStateSave' => true,
                                    'order' => [[ 0, 'desc' ]],
                                    "columns" => [
                                        [ "data" => "id" ],
                                        [ "data" => "name"],
                                        [ "data" => "email"],
                                        [ "data" => "actions" ],
                                    ],
                                ]
                            )
                             ->makejs()
                        !!}

@endsection
