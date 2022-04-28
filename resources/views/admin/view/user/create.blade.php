@extends('admin.layouts.editable')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route("admin." . $module . ".store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.view.' . $module . '.partials._form')

            </form>
        </div>
    </div>
@endsection
