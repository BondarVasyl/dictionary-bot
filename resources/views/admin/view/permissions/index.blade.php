@extends('adminlte::page')

@section('content_header')
    @can('permissions_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.permissions.create') }}">
                {{__('admin_labels.add_permission')}}
            </a>
        </div>
    </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="groups-table">
                        {!!
                            TablesBuilder::create(
                                ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover"],
                                [
                                    'bStateSave' => true,
                                    'order' => [[ 0, 'desc' ]],
                                    "columns" => [
                                        [ "data" => "id" ],
                                        [ "data" => "title" ],
                                        [ "data" => "actions" ],
                                    ],
                                ]
                            )
                            ->addHead([
                                ['text' => trans('admin_labels.id')],
                                ['text' => trans('admin_labels.title')],
                                ['text' => trans('admin_labels.actions')],
                            ])
                            ->addFoot([
                                ['attr' => ['colspan' => 2]]
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
                                ['id' => "datatable1", 'class' => "table table-bordered table-striped table-hover"],
                                [
                                    'bStateSave' => true,
                                    'order' => [[ 0, 'desc' ]],
                                    "columns" => [
                                        [ "data" => "id" ],
                                        [ "data" => "title" ],
                                        [ "data" => "actions" ],
                                    ],
                                ]
                            )
                            ->addHead([
                                ['text' => trans('labels.id')],
                                ['text' => trans('labels.email')],
                                ['text' => trans('labels.actions')],
                            ])
                            ->addFoot([
                                ['attr' => ['colspan' => 3]]
                            ])
                            ->makejs()
                        !!}

{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            table = $('#example').DataTable({--}}
{{--                "processing": true,--}}
{{--                "serverSide": true,--}}
{{--                "ajax": "",--}}
{{--                dom: '<"html5buttons">Bfrtip',--}}
{{--                buttons: [--}}
{{--                    {extend: 'colvis', postfixButtons: ['colvisRestore']},--}}
{{--                    {extend: 'csv'},--}}
{{--                    {extend: 'pdf', title: 'Contoh File PDF Datatables'},--}}
{{--                    {extend: 'excel', title: 'Contoh File Excel Datatables'},--}}
{{--                    {extend: 'print', title: 'Contoh Print Datatables'},--}}
{{--                ],--}}
{{--                "language": {--}}
{{--                    "lengthMenu": "_MENU_ записей на странице",--}}
{{--                    "zeroRecords": "Записей не найдено",--}}
{{--                    "info": "Показано с _START_ по _END_ записей с _TOTAL_",--}}
{{--                    "infoEmpty": "Не найдено записей",--}}
{{--                    "search": "Поиск:",--}}
{{--                    "infoFiltered": " - отфильтрировано с _MAX_ записей",--}}
{{--                    "paginate": {--}}
{{--                        "first": "В начало",--}}
{{--                        "last": "В конец",--}}
{{--                        "next": "Следующая",--}}
{{--                        "previous": "Предыдущая"--}}
{{--                    }--}}
{{--                },--}}
{{--                "columns": [--}}
{{--                    {data: 'id', name: 'id'},--}}
{{--                    {data: 'email', name: 'email'},--}}
{{--                    {data: 'actions', name: 'actions'},--}}
{{--                ]--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            var opt = {--}}
    {{--                // sPaginationType: "bootstrap_alt",--}}
    {{--                processing: !0,--}}
    {{--                serverSide: !0,--}}
    {{--              --}}
    {{--                ajax: "",--}}
    {{--                sAjaxSource: "",--}}
    {{--                dataSrc: "data",--}}
    {{--                "language": {--}}
    {{--                    "lengthMenu": "datatables.lengthMenu",--}}
    {{--                    "zeroRecords": "datatables.zeroRecords",--}}
    {{--                    "info": "datatables.info",--}}
    {{--                    "infoEmpty": "datatables.infoEmpty",--}}
    {{--                    "search": "datatables.search",--}}
    {{--                    "infoFiltered": "datatables.infoFiltered",--}}
    {{--                    "paginate": {--}}
    {{--                        "first": "datatables.paginate.first",--}}
    {{--                        "last": "datatables.paginate.last",--}}
    {{--                        "next": "datatables.paginate.next",--}}
    {{--                        "previous": "datatables.paginate.previous"--}}
    {{--                    }--}}
    {{--                },--}}

    {{--                columnDefs: [{targets: "_all", defaultContent: ""}],--}}
    {{--                fnDrawCallback: function () {--}}
    {{--                    // return initToggles()--}}
    {{--                }--}}
    {{--            };--}}
    {{--            var userOpt = {"bStateSave":true,"order":[[0,"desc"]],"columns":[{"data":"id"},{"data":"email"},{"data":"actions"}]};--}}
    {{--            opt = $.extend(opt, userOpt);--}}
    {{--            if (typeof datatableСallbacks != "undefined") {--}}
    {{--                opt = $.extend(opt, datatableСallbacks);--}}
    {{--            }--}}
    {{--            var t = $("#datatable1").DataTable(opt);--}}
    {{--            t.columns().eq(0).each(function (e) {--}}
    {{--                return $("select", t.column(e).footer()).on("keyup change", function () {--}}
    {{--                    if(!$(this).closest(".dataTables_length")) {--}}
    {{--                        return t.column(e).search(this.value).draw();--}}
    {{--                    }--}}
    {{--                })--}}
    {{--            });--}}
    {{--        })--}}
    {{--    </script>--}}
@stop
