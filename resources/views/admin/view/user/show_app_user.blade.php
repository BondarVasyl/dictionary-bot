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
                        {{ $user->profile->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.last_name')}}
                    </th>
                    <td>
                        {{ $user->profile->last_name }}
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
                        {{__('admin_labels.phone')}}
                    </th>
                    <td>
                        {{ $user->profile->phone }}
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
        <a class="btn btn-secondary" href="{{ url()->previous() ? url()->previous() : route('admin.user.index', ['type' => 'app']) }}">
            {{__('admin_labels.buttons.back')}}
        </a>
    </div>
</div>

@endsection
