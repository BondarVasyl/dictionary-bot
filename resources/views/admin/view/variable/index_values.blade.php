@extends('admin.layouts.editable')

@section('content')
    <div class="row" style="margin-top: 10px">
        <div class="col-lg-12">
            <div class="variables-table margin-top-10">

                @foreach($list as $item)

                    @if (!$item->is_hidden)
                        <div class="card">
                        <div class="box @if ($item->is_hidden) box-danger @else box-primary @endif">
                            {!! Form::model($item, ['role' => 'form', 'method' => 'post', 'route' => ['admin.variable.value.update'],'enctype'=>'multipart/form-data', 'class' => 'variable-value-form form-horizontal']) !!}

                            <input type="hidden" name="variable_id" value="{!! $item->id !!}">

                            <div class="box-body">
                                <input type="hidden" name="type" value="{!! $item->type !!}">
                                <input type="hidden" name="multilingual" value="{!! $item->multilingual !!}">

                                <div class="card-header">
                                    <label class="control-label text-right">
                                        {!! $item->name !!}
                                    </label>
                                    <div>{!! $item->description !!}</div>
                                    <br>
                                </div>

                                <div class="col-xs-12 col-sm-8 col-md-9">
                                    @include('admin.view.variable.types.' . $item->getStringType())

                                    <div class="form-group">
                                        <label for="status" class="col-sm-2 control-label">
                                            {!! Form::label('status', __('admin_labels.status'), array('class' => "control-label")) !!}
                                        </label>

                                        <div class="col-sm-10">
                                            <div class="col-xs-2">
                                                {!! Form::select('status', array("1" => __('admin_labels.visible'), "0" => __('admin_labels.no_visible')), $item->status, array('class' => 'form-control col-xs-1')) !!}
                                            </div>
                                            {!! $errors->first('status', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-left: 15px">
                                    <div class="row form-group">

                                            <div class="col-md-4 pull-right ta-right">
                                                {!! Form::submit(trans('admin_labels.buttons.save'), ['class' => 'btn btn-success btn-flat save-variable-value']) !!}
                                            </div>
                                    </div>
                                </div>

                            </div>

                            {!! Form::close() !!}
                        </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
@endsection
