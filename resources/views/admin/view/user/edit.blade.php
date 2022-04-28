@extends('admin.layouts.editable')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form data-toggle="validator" action="{{ route("admin." . $module . ".update",$model->id) }}" method="POST" enctype="multipart/form-data" role = "form" style="padding: 0 15px">
                @csrf
                @method('PUT')
                @include('admin.view.' . $module . '.partials._form')

            </form>
        </div>
    </div>
@endsection
