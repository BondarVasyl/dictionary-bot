<div id="sortable">
    <table class="product-image table duplication">
        <thead>
        <tr>
            <th>{!! trans('admin_labels.info') !!}</th>
            <th style="display: flex; justify-content: flex-end">{!! trans('admin_labels.actions') !!}</th>
        </tr>
        </thead>
        @if(isset($patreons))
            @foreach($patreons as $item)
                @php($file_hash = generate_file_hash($item->id))
                <tr class="productimages-row duplication_row">
                    <td class="link" style="width: 100%">

                        <div class="image-wrap" data-default="{{asset('storage/images/default/upload_image.png')}}">

                            <img
                                src="{{( isset($item->image) && $item->image != '') ? file_url($item->image) : asset('storage/images/default/upload_image.png')}}"
                                id="preview"
                                class="img-thumbnail mb-1 lg-1 preview upload-preview-img-{{$file_hash}}"
                                style="max-width: 250px; max-height: 250px"
                            >

                            <input class="isRemoveFile" type="text" id="isRemoveFile"
                                   name="patreons[new][{{$item->id}}][isRemoveFile]" hidden
                                   value="0">

                            <div class="input-group mt-2">
                                <input
                                    type="text" id="image_label"
                                    class="input-file form-control upload-label-img-{{$file_hash}} preview-link"
                                    name="patreons[new][{{$item->id}}][image]"
                                    aria-label="Image"
                                    aria-describedby="button-image"
                                    value="{{isset($item->image) ? file_url($item->image) : ''}}"
                                >

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary upload-button-image" type="button"
                                            id="button-image" data-tr-id="{{$file_hash}}">
                                        {{__('admin_labels.select_file')}}
                                    </button>
                                    @if($item && $item->image !== NULL && $item->image !== '')
                                        <button type="button" id="removeFile"
                                                class="btn btn-warning btn-sm removeFile ml-1">{!! __('admin_labels.delete_file') !!}</button>
                                    @else
                                        <button type="button" id="removeFile"
                                                class="btn btn-warning btn-sm removeFile ml-1"
                                                hidden>{!! __('admin_labels.delete_file') !!}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                            <label for="patreons[new][{{$item->id}}][card_number]"
                                   style="padding: 5px 0">{{__('admin_labels.card_number')}}</label>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <input
                                class="form-control @if ($errors->has("patreons[new][{$item->id}][card_number]")) is-invalid @endif"
                                type="text" name="patreons[new][{{$item->id}}][card_number]"
                                value="{{old("patreons[new][{$item->id}][card_number]", $item->card_number)}}">
                        </div>
                        @if ($errors->has("patreons[new][{$item->id}][card_number]")) <span
                            style=" color:red">{{$errors->messages()["patreons[new][{$item->id}][card_number]"][0]}}</span> @endif

                        <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                            <label for="patreons[new][{{$item->id}}][link]"
                                   style="padding: 5px 0">{{__('admin_labels.link')}}</label>
                        </div>

                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <input
                                class="form-control @if ($errors->has("patreons[new][{$item->id}][link]")) is-invalid @endif"
                                type="text" name="patreons[new][{{$item->id}}][link]"
                                value="{{old("patreons[new][{$item->id}][link]", $item->link)}}">
                        </div>
                        @if ($errors->has("patreons[new][{$item->id}][link]")) <span
                            style=" color:red">{{$errors->messages()["patreons[new][{$item->id}][link]"][0]}}</span> @endif
                    </td>
                    <td style="display: flex; justify-content: flex-end">
                        <a class="btn btn-danger destroy exists" data-id="{!! $item->id !!}">x</a>
                    </td>
                    <td></td>
                </tr>
            @endforeach
        @endif

        <tr class="productimages-row duplication_row duplicat hidden">
            <td class="link" style="width: 100%">
                <div class="image-wrap" data-default="{{asset('storage/images/default/upload_image.png')}}">
                    <img
                        src="{{asset('storage/images/default/upload_image.png')}}"
                        id="preview"
                        class="img-thumbnail mb-1 lg-1 preview upload-preview-img-replaseme"
                        style="max-width: 250px; max-height: 250px"
                    >

                    <div class="input-group mt-2">
                        <input
                            class="input-file form-control upload-label-img-replaseme preview-link"
                            type="text" id="image_label"
                            name="patreons[new][replaseme][image]"
                            aria-label="Image"
                            aria-describedby="button-image"
                        >
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary upload-button-image" type="button"
                                    id="button-image" data-tr-id="replaseme">
                                {{__('admin_labels.select_file')}}
                            </button>
                            <button type="button" id="removeFile" class="btn btn-warning btn-sm removeFile"
                                    hidden>{!! __('admin_labels.delete_file') !!}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                    <label for="patreons[new][replaseme][card_number]"
                           style="padding: 5px 0">{{__('admin_labels.card_number')}}</label>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <input
                        class="form-control @if ($errors->has("patreons[new][replaseme][card_number]")) is-invalid @endif"
                        type="text" name="patreons[new][replaseme][card_number]"
                        value="{{old("patreons[new][replaseme][card_number]", '')}}">
                </div>
                @if ($errors->has("patreons[new][replaseme][card_number]")) <span
                    style=" color:red">{{$errors->messages()["patreons[new][replaseme][card_number]"][0]}}</span> @endif

                <div class="col-xs-2 col-sm-2 col-md-2 text-right">
                    <label for="patreons[new][replaseme][link]"
                           style="padding: 5px 0">{{__('admin_labels.link')}}</label>
                </div>

                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <input
                        class="form-control @if ($errors->has("patreons[new][replaseme][link]")) is-invalid @endif"
                        type="text" name="patreons[new][replaseme][link]"
                        value="{{old("patreons[new][replaseme][link]", '')}}">
                </div>
                @if ($errors->has("patreons[new][replaseme][link]")) <span
                    style=" color:red">{{$errors->messages()["patreons[new][replaseme][link]"][0]}}</span> @endif
            </td>
            <td style="display: flex; justify-content: flex-end">
                <a class="btn btn-success action create" style="margin-right: 5px">+</a>
                <a class="btn btn-danger action destroy">x</a>
            </td>
            <td></td>
        </tr>
    </table>


</div>

@section('js')
    <script>
        $(function () {
            $(document).on('change', '.productimages-row .tab-content input.form-control', function (e) {
                var check = false;
                var $row = $(this).closest('.productimages-row');
                $row.find('.tab-content input.form-control').each(function (i, v) {
                    if ($(v).val() != '') check = true;
                });
                if (check) {
                    $row.find('.link input.form-control').prop('required', true);
                    $row.find('.status input.form-control').prop('required', true);
                } else {
                    $row.find('.link input.form-control').prop('required', false);
                    $row.find('.status input.form-control').prop('required', false);
                }
            });
        })
    </script>
@endsection
