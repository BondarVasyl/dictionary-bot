@extends('admin.layouts.editable')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            {!! Form::model($model, ['role' => 'form', 'method' => 'put', 'class' => 'form-horizontal', 'route' => ['admin.variable.update', $model->id]]) !!}

            @include('admin.view.variable.partials._form')

            {!! Form::close() !!}
        </div>
    </div>

@endsection
