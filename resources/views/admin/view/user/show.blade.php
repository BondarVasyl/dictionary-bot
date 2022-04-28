@extends('adminlte::page')
@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.view_user')}}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{__('admin_labels.name')}}
                    </th>
                    <td>
                        {{ $user->profile ? $user->profile->name : ''}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.email')}}
                    </th>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.roles')}}
                    </th>
                    <td>
                        @foreach($user->roles as $id => $roles)
                            <a href="{{route('admin.roles.edit', ['role' => $roles])}}">{{ $roles->title }}</a>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.user.index') }}">
            {{__('admin_labels.buttons.back')}}
        </a>
    </div>
</div>

@endsection
