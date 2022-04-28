@extends('adminlte::page')

@section('content')

    <div class="card">
        <div class="card-header">
            {{__('admin_labels.add_role')}}
        </div>

        <div class="card-body">

            <form action="{{ route("admin.roles.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title">{{__('admin_labels.title')}}</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}">
                    @if($errors->has('title'))
                        <p class="help-block error">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                    <label for="permissions">{{__('admin_labels.permissions')}}
                        <span class="btn btn-info btn-xs select-all">Select all</span>
                        <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                    <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple">
                        @foreach($permissions as $id => $permissions)
                            <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                {{ $permissions }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('permissions'))
                        <p class="help-block error">
                            {{ $errors->first('permissions') }}
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

@extends('admin.partials.style')
