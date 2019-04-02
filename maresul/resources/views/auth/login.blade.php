<H2>USUARIO</H2>

@if ($errors->any())
    <h2>credenciais incorretas</h2>
@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h3>Email</h3>
    <input id="email" type="email"  name="email" value="{{ old('email') }}" >
    <h3>Senha</h3>
    <input id="password" type="password"  name="password" required>

    <button type="submit">Logar</button>

</form>

    

