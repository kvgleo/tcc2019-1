<H2>ADMINISTRADOR</H2>
@if ($errors->any())
    <h2>{{$errors->first()}}</h2>
@endif
<form method="POST" action="{{ route('admin_login_submit') }}">
    @csrf
    <h3>Email</h3>
    <input id="email" type="text"  name="email" value="{{ old('email') }}" required >
    <h3>Senha</h3>
    <input id="password" type="password"  name="password" required>

    <button type="submit">Logar</button>

</form>
