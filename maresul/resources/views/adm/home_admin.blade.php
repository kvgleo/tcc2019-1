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
    <li><a href="#">Reservas</a></li>
    <li><a href="#">Documentos</a></li>
    <li><b>Social</b></li>
    <li><a href="#">Fórum</a></li>
    <li><a href="#">Estatisticas</a></li>
    <li><a href="#">Historico</a></li>
    
</ul>


<ul>
    <li><a href="#">Regras</a></li>
    <li><a href="#">Ajuda</a></li>
    <li><a href="#">Lembretes</a></li>
    <li> <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a></li>
</ul>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>



