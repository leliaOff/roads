<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        window.baseurl = "<?=getenv('APP_URL');?>";
    </script>
    

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ URL::asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('css/vue2-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/ol.css') }}">

    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">

    <title>Безопасные дороги</title>
    <link rel="icon" type="image/png" href="favicon.png" />
    
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

<script src="{{ url('js/ol.js') }}"></script>
<script src="{{ url('js/app.js') }}"></script>
</body>
</html>