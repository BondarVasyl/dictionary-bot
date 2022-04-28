@extends('adminlte::page')

@section('content')
    @include('admin.partials.messages')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="translations-table">

                        <form action="{!! route('admin.translation.update', $group) !!}" method="post" role="form"
                              class="without-js-validation">

                            {!! csrf_field() !!}

                            <input type="hidden" name="page" value="{!! $page !!}">

                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td colspan="{!! count($locales) + 1 !!}">
                                        @include('admin.partials._buttons')
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="{!! count($locales) + 1 !!}">
                                        <div class="text-center">
                                            {{--{!! $list->links() !!}--}}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 9%">{{__('admin_labels.key')}}</th>

                                    @foreach($locales as $locale)
                                        <th style="width: 13%">{!! trans('admin_labels.tab_' . $locale) !!}</th>
                                    @endforeach
                                </tr>
                                </tbody>

                                @foreach($list as $key => $items)
                                    <tr>
                                        <td>
                                            {!! $key !!}
                                        </td>

                                        @foreach($locales as $locale)
                                            <td class="form-group
                                            @if ($errors->has($locale.'.'.$key)) has-error @endif">
                                            <textarea rows="1" cols="1"
                                                    name="{!! $locale !!}[{!! $key !!}]"
                                                    id="{!! $locale !!}_{!! str_replace(' ', '_', $key) !!}"
                                                    class="form-control input-sm"
                                            >{!! isset($items[$locale]) ? $items[$locale] : null !!}</textarea>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="{!! count($locales) + 1 !!}">
                                        <div class="text-center">
                                            {{--{!! $list->links() !!}--}}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="{!! count($locales) + 1 !!}">
                                        @include('admin.partials._buttons')
                                    </td>
                                </tr>
                            </table>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@extends('admin.partials.style')
