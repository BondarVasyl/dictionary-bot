@extends('adminlte::page')

@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.edit_permission')}}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{__('admin_labels.title')}}</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}">
                @if($errors->has('title'))
                    <p class="help-block error">
                        {{ $errors->first('title') }}
                    </p>
                @endif
            </div>
            @include('admin.partials._buttons')
        </form>
    </div>
</div>
@endsection

