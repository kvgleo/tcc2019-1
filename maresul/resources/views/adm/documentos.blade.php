<html>
<head>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <form action="{{URL::to('/teste')}}" method="post">
        <input type="file" name="file" value="">
        <button type="submit">upar teste</button>
    </form>

</body>
</html>