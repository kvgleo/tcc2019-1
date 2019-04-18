<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id='app'>

@if($perguntas[0]==null)
<h1>Não há conteudo nesta seção até o momento</h1>
@endif

<a href="/home" class="btn btn-primary">Voltar</a>

@foreach($perguntas as $p)
<hr>
<h3>{{$p->question}}</h3>
<h5>{{$p->answer}}</h5>
<hr>
@endforeach

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>