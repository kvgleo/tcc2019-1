<html>

<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark sticky-top flex-md-nowrap  bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

<h2> Logado como administrador </h2>
<h5> Olá {{ Auth::user()->email }} </h5>

<h1>DASHBOARD</h1>
<ul>
    <li><b>Financeiro</b></li>
    <li><a href="#">Despesas</a></li>
    <li><a href="#">Estatisticas</a></li>
    <li><a href="#">Historico</a></li>
    <li><b>Administrativo</b></li>
    <li><a href="/a/a">Anúncios</a></li>
    <li><a href="/reservas">Reservas</a></li>
    <li><a href="/a/d">Documentos</a></li>
    <li><b>Social</b></li>
    <li><a href="#">Fórum</a></li>
    <li><a href="#">Estatisticas</a></li>
    <li><a href="#">Historico</a></li>
    
</ul>


<ul>
    <li><a href="/regras">Regras</a></li>
    <li><a href="#">Ajuda</a></li>
    <li><a href="/a/le">Lembretes</a></li>
    <li> <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a></li>
</ul>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>



<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript"></script>
</body>
</html>