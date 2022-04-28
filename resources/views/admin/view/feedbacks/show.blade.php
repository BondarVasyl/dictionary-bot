@extends('adminlte::page')
@section('content')

<div class="card">
    <div class="card-header">
        {{__('admin_labels.view_feedback')}}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{__('admin_labels.name')}}
                    </th>
                    <td>
                        {{ $model->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.email')}}
                    </th>
                    <td>
                        {{ $model->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.message')}}
                    </th>
                    <td>
                        {{ $model->message }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.feedbacks.index') }}">
            {{__('admin_labels.buttons.back')}}
        </a>
    </div>
</div>

@endsection
