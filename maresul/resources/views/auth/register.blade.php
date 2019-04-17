<!doctype html>
<html lang="en">
  <head>
    <title>Login Usuários</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrar-se </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body class="text-center">

    <form class="form-group col-md-3  mx-auto" style="margin-top:50px;" method="POST" action="{{ route('register') }}">
        @csrf
      <img class="mb-4" src="{{Storage::url('logo/maresul.jpg') }}" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Registrar-se</h1>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Erro ao cadastrar.
            </div>
        @endif

        <label for="name" style="float:left" >Nome</label>
        <input id="name" type="text" class="form-control" name="name"  placeholder="nome de usuário" required>
        <br>
        <label for="email" style="float:left" >Email</label>
        <input id="email" type="email" class="form-control" name="email" placeholder="email" required>
        <br>
        <label for="password" style="float:left" >Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="senha" name="password" required>
        <br>
        <label for="password-confirm" style="float:left" >Confirmar senha</label>
        <input id="password-confirm" type="password" class="form-control" placeholder="confirme a senha" name="password_confirmation" required>
        <br>

        <button type="submit" class="btn btn-lg btn-success btn-block">Cadastrar-se</button>
        <a href="/" class="btn btn-lg btn-secondary btn-block">Voltar</a>
        <p class="mt-5 mb-3 text-muted">&copy; MAR&SUL 2014-2019</p>
        </form>
  </body>
</html>
