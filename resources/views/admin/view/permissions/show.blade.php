@extends('adminlte::page')

@section('content')

    <div class="card">
        <div class="card-header">
            {{__('admin_labels.view_access')}}
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{__('admin_labels.title')}}
                    </th>
                    <td>
                        {{ $model->title }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('admin.permissions.index') }}">
                {{__('admin_labels.buttons.back')}}
            </a>
        </div>
    </div>

@endsection
