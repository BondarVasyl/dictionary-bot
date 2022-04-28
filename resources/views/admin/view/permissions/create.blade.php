@extends('adminlte::page')

@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.add_permission')}}
    </div>

    <div class="card-body">
        <form action="{{route('admin.permissions.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{__('admin_labels.title')}}</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}">
                @if($errors->has('title'))
                    <p class="help-block error">
                        {{ $errors->first('title') }}
                    </p>
                @endif
            </div>
            <div>
                @include('admin.partials._buttons')
            </div>
        </form>
    </div>
</div>
@endsection
