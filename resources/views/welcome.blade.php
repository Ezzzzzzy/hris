<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRIS</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style type="text/css">
            html, body{
                font-family: 'Lato', sans-serif;
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <!-- <body id="scroll-body" data-spy="scroll" data-target="#section_id" data-offset="100"> -->
    <body>
        <div id="root"></div>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('js/fontawesome.js') }}"></script>
    </body>
</html>
