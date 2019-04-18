<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id='app'>

@if($regras[0]==null)
<h1>Não há conteudo nesta seção até o momento</h1>
@endif

<a href="/home" class="btn btn-primary">Voltar</a>

@foreach($regras as $re)
<h3>{{$re->title}}</h3>
<h5>{{$re->desc}}</h5>
<h6>{{$re->reportdate}}</h6>
<h6>{{$re->author}}</h6>
@endforeach
{{$regras->links()}}

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>