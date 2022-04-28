@extends('admin.layouts.editable')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form data-toggle="validator" action="{{ route("admin." . $module . ".new_password.post",$model->id) }}" method="POST" enctype="multipart/form-data" role = "form" style="padding: 0 15px">
                @csrf
                @include('admin.view.' . $module . '.partials.change_password')

            </form>
        </div>
    </div>
@endsection
