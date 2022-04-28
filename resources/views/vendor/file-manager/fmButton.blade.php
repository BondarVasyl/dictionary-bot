<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'File Manager') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="fm-main-block">
            <div id="fm"></div>
        </div>
    </div>
</div>

<!-- File manager -->
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // set fm height
        document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');

        // Add callback to file manager
        fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
            let url_string = window.location.href
            let url = new URL(url_string)
            let dataId = url.searchParams.get('attr-id')
            let dataLocale = url.searchParams.get('locale')

            window.opener.fmSetLink(fileUrl, dataId, dataLocale);

            window.close();
        });
    });
</script>
</body>
</html>

