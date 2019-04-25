<!doctype html>
<html lang="en">
  <head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Administrador </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body class="text-center bg-dark text-white">

    <form class="form-signin col-md-3  mx-auto" style="margin-top:100px;" method="POST" action="{{ route('admin_login_submit') }}">
        @csrf

      <img class="mb-4" src="{{Storage::url('banner/icon_adm.png') }}" alt="" width="72" height="72">

      <h1 class="h3 mb-3 font-weight-normal">Login Administrativo</h1>
      <p class=" mb-3 font-weight-normal">Entre com as credenciais corretas para acessar a parte interna do sistema.</p>
      <p><a href="/">Voltar para página principal</a></p>
      @if ($errors->any())
      <p style="color:#ce4444;"><b><i class="fa fa-exclamation-triangle"></i> {{$errors->first()}}</b></p>
      @endif
    
      <label for="inputEmail"  style="float:left">Email </label>
      <input type="text" id="inputEmail" class="form-control" placeholder="endereço de email" name="email">
      <br>
      <label for="inputPassword"  style="float:left">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="senha"  name="password" required>
      <div class="form-group form-check" style="float:left">
          <input type="checkbox"  class="form-check-input" id="exampleCheck1" checked>
          <label class="form-check-label" for="exampleCheck1">Lembrar-se</label>
        </div>
      <button class="btn btn-lg btn-danger btn-block" type="submit">Logar</button>
      <p class="mt-5 mb-3 text-muted">&copy; MAR&SUL 2014-2019</p>
    </form>
  </body>
</html>
