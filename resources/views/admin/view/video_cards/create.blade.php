@extends('admin.layouts.editable')

@section('assets.top')
    @parent
    <script src="{!! asset('assets/components/sysTranslit/js/jquery.synctranslit.min.js') !!}"></script>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {!! Form::model($model, array('enctype'=>'multipart/form-data','route' => 'admin.' . $module . '.store','class' => 'form-horizontal')) !!}

                @include('admin.view.' . $module . '.partials._form')

            {!! Form::close() !!}
        </div>
    </div>
@stop
