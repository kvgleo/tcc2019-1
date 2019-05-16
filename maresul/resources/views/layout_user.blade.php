<!doctype html>
<head>

    @yield('title-content')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    @yield('style-content')
</head>


<body>

        <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color:#3a79e0;">
                <a class="navbar-brand" href="#">MAR AZUL- Usuários </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
          
                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                  <ul class="navbar-nav mr-auto">
                      <li class="nav-item ">
                          <button type="button" class="nav-link btn" title="Recados" data-toggle="modal" data-target="#createModal"><i class="fa fa-paper-plane"></i> </button>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="/regras"  title="Regras" id="regras"><i class="fa fa-gavel"></i></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="/ajuda"  title="Ajuda" id="ajuda"><i class="fa fa-question"></i></a>
                        </li>
                      </li>
                  </ul>
                  <ul class="navbar-nav navbar-right">
                      @if(Auth::user()->inp == false)
                        <li class="nav-item">
                                <a class="nav-link"><small>  <button type="button" id="pop" class="btn btn-sm btn-link text-success"  data-trigger="hover" data-placement="bottom" data-boundary="window" data-toggle="popover"  data-content="Status: Adimplente"><i class="fa fa-check-circle"></i></button>  </small>  </a>
                              </li>
                        @else
                        <li class="nav-item">
                                <a class="nav-link"><small>  <button type="button" id="pop" class="btn btn-sm btn-link" style="border:gold; color:#e24646;" data-trigger="hover" data-placement="bottom" data-boundary="window" data-toggle="popover"  data-content="Status: Inadimplente "><i class="fa fa-exclamation-circle"></i></button> </small>  </a>
                              </li>
                        @endif
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{Storage::url('user_img/userpic.png') }}" style="width:25px; height:25px; ">
                              <i class="fa fa-profile"></i> Olá {{ Auth::user()->name }}
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a   class="dropdown-item"href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a>
                          </div>
                        </li>
                  </ul>
                </div>

                @yield('warn-content')
              </nav>

              <div class="modal fade" id="createModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">NOVO RECADO</h4>
                            </div>
                            <div class="modal-body">
                                <p> Deixe seu recado para a zeladoria: </p>
                                <form id="formAnuncio"action="/ajuda" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="perg" >Assunto</label>
                                        <input type="text"  class="form-control"placeholder="assunto" name="assu" id="assu" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="resp" >Recado</label>
                                        <textarea rows="4" placeholder="descrição" class="form-control" name="desc" id="desc" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button form="formAnuncio"type="submit" class="btn btn-success">ENVIAR <i class="fa fa-paper-plane"></i></button> 
                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                    </div>
                </div>

              <main role="main">
                  

                @yield('main-content')
              </main>

              <footer class="container bottom">
                    <p>&copy; MAR&SUL 2014-2019</p>
                  </footer>
              





<script src="{{ asset('js/app.js') }}"></script>
@yield('js-content')

<script type="text/javascript">
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    
    $(function () {
    $('[data-toggle="popover"]').popover()
  })
    
    </script>

    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


</body>
</html>