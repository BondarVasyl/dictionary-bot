@push('css')
    {{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset('themes/default/css/admin/adminltev3.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/default/css/admin/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/default/css/admin/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @toastr_css
@endpush
@push('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('themes/default/js/admin/app.min.js') }}"></script>
    {{--    <script>--}}
    {{--        $(document).on("product-images-selected", function(event, files) {--}}
    {{--            for(var iterator in files) {--}}
    {{--                $('#product-images-duplicator').find('a').click(); //create new instance of duplication row--}}

    {{--                var $tr = $('table.product-images tr.duplication-row:not(.duplicate)').last();--}}

    {{--                var $image_input = $tr.find('input[data-related-image]'),--}}
    {{--                    $image = $image_input.closest('div.form-group').find('img'),--}}
    {{--                    $position_input = $tr.find('input[name*="position"]'),--}}
    {{--                    image_path = '/' + files[iterator].path;--}}

    {{--                $image_input.val(image_path);--}}

    {{--                $image.attr('src', image_path);--}}

    {{--                $position_input.val($tr.index());--}}

    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    @toastr_js
    @toastr_render
@endpush
