<h2> Logado como usuário </h2>
<h5> Olá {{ Auth::user()->name }} </h5>

<ul>
    <li><a href="#">Regras</a></li>
    <li><a href="#">Ajuda</a></li>
    <li> <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a></li>
</ul>

<ul>
    <li></li>
    <li><a href="#">Forum</a></li>
    <li><a href="#">Reservas</a></li>
    <li><a href="#">Comunidade</a></li>

</ul>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


