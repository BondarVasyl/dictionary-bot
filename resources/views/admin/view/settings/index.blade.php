@extends('adminlte::page')

@section('content')
    <div class="container">
        @if(Session::has('status'))
            <div class="alert alert-info" style="margin-top: 10px">
                @php
                    if (is_array(Session::get('status'))) {
                        $status= Session::get('status')['ok'];
                        $info = Session::get('status')['result'];

                        if (isset(Session::get('status')['description'])) {
                            $description = Session::get('status')['description'];
                        }
                    } else {
                        $message = Session::get('status');
                    }
                @endphp
                @if(isset($message))
                    <span> {{$message}}</span>
                @else
                    <span> {{__('admin_labels.status') . ' : ' . __('admin_labels.' . $status)}}</span>
                    <br>
                    @if(is_array($info))
                        @foreach($info as $key => $item)
                            @if($key == 'pending_update_count')
                                <span> {{__('admin_labels.'.$key) . ' : ' . $item }}</span>
                            @else
                                @if($item === false || $item == 0)
                                    <span> {{__('admin_labels.'.$key) . ' : ' . 'false' }}</span>
                                @elseif($item === true || $item == 1)
                                    <span> {{__('admin_labels.'.$key) . ' : ' . 'true' }}</span>
                                @else
                                    <span> {{__('admin_labels.'.$key) . ' : ' . $item }}</span>
                                @endif
                            @endif
                            <br>
                        @endforeach
                    @else
                        <span> {{__('admin_labels.result') . ' : ' . __('admin_labels.' . $info) }}</span>
                        <br>
                    @endif

                    @if(isset($description))
                        <span> {{__('admin_labels.description') . ' : ' . $description }}</span>
                        <br>
                    @endif
                @endif

            </div>
        @endif

        <form action="{{route('admin.settings.store')}}" method="post" style=" margin-top: 10%">
            {{csrf_field()}}
            <div class="form-group">
                <label style="font-size: 20px"> {{__('admin_labels.url_for_telegram_bot')}}</label>

                <div class="input-group">
                    <div class="input-group-btn test">
                        <button type="button" class="btn btn-default dropdown-toggle action_form" data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false" style="padding-top: 4px">
                            {{__('admin_labels.actions')}}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"
                                   onclick="document.getElementById('url_callback_bot').value ='{{url('')}}'"> {{__('admin_labels.copy_domain')}} </a>
                            </li>
                            <li>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('setwebhook').submit();"> {{__('admin_labels.create_webhook')}} </a>
                            </li>
                            <li>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('getwebhookinfo').submit();"> {{__('admin_labels.get_webhook_info')}}</a>
                            </li>
                            <li>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('deletewebhook').submit();"> {{__('admin_labels.delete_webhook')}}  </a>
                            </li>
                        </ul>
                    </div>
                    <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot"
                           value="{{$url_callback_bot ?? ''}}">
                </div>
            </div>
            <button class="btn btn-primary" type="submit"> {{__('admin_labels.buttons.save')}} </button>
        </form>

        <form id="setwebhook" action=" {{route('admin.settings.setWebhook')}}" method="POST" style=" display: none;">
            {{csrf_field()}}
            <input type="hidden" name="url" value="{{$url_callback_bot ?? ''}}">
        </form>

        <form id="getwebhookinfo" action="{{route('admin.settings.getWebhookInfo')}}" method="POST"
              style=" display: none;">
            {{csrf_field()}}
        </form>

        <form id="deletewebhook" action="{{route('admin.settings.deleteWebhook')}}" method="POST"
              style=" display: none;">
            {{csrf_field()}}
        </form>
    </div>
@endsection
