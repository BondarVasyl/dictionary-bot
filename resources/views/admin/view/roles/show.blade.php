@extends('adminlte::page')
@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.view_role')}}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{__('admin_labels.title')}}
                    </th>
                    <td>
                        {{ $role->title }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.permissions')}}
                    </th>
                    <td>
                        @foreach($role->permissions as $id => $permissions)
                            <span class="badge badge-info">{{ $permissions->title }}</span>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.roles.index') }}">
            {{__('admin_labels.buttons.back')}}
        </a>
    </div>
</div>
@endsection
