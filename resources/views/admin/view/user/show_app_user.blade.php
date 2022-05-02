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
                        {{__('admin_labels.telegram_id')}}
                    </th>
                    <td>
                        {{ $user->telegram_id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.is_bot')}}
                    </th>
                    <td>
                        {{ $user->is_bot ? __('admin_labels.yes') : __('admin_labels.no') }}
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
                        {{__('admin_labels.first_name')}}
                    </th>
                    <td>
                        {{ $user->profile->first_name }}
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
                        {{__('admin_labels.username')}}
                    </th>
                    <td>
                        {{ $user->profile->username }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.language_code')}}
                    </th>
                    <td>
                        {{ $user->profile->language_code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.last_requested_word')}}
                    </th>
                    <td>
                        {{ $user->profile->last_requested_word }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{__('admin_labels.dictionary')}}
                    </th>
                    <td>
                        @foreach($user->dictionary as $item)
                            {{$item->word . ' - ' . $item->translation}}
                            <br>
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
