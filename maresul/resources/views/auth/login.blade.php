<!doctype html>
<html lang="en">
  <head>
    <title>Login Usuários</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Administrador </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body class="text-center">

    <form class="form-group col-md-3  mx-auto" style="margin-top:100px;" method="POST" action="{{ route('login') }}">
        @csrf
      <img class="mb-4" src="{{Storage::url('logo/maresul.jpg') }}" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Login Usuários</h1>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Credenciais incorretas
            </div>
        @endif

        <label for="inputEmail" style="float:left" >Email</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="endereço de email" required>
        <br>
        <label for="inputPassword" style="float:left" >Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="senha" name="password" required>
        <div class="form-group form-check" style="float:left">
            <input type="checkbox"  class="form-check-input" id="exampleCheck1" checked>
            <label class="form-check-label" for="exampleCheck1">Lembrar-se</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
        <a href="/register" class="btn btn-lg btn-secondary btn-block">Cadastrar-se</a>
        <p class="mt-5 mb-3 text-muted">&copy; MAR&SUL 2014-2019</p>
        </form>
  </body>
</html>