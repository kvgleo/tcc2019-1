<h2> Logado como usuário </h2>
<h5> Olá {{ Auth::user()->name }} </h5>

<ul>
    <li><a href="/a/le">Recado</a></li> 
    <li><a href="/regras">Regras</a>(COMPLETO)</li>
    <li><a href="/ajuda">Ajuda (COMPLETO)</a></li>
    <li> <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a></li>
</ul>

<ul>
    <li></li>
    <li><a href="#">Forum</a></li>
    <li><a href="/reservas">Reservas</a> (COMPLETO)</li>
    <li><a href="#">Comunidade</a></li>

</ul>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


