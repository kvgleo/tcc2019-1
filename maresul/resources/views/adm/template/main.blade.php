<!doctype html>
<head>

    @yield('title-content')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<style>
    a{
        color: #bbc1c9;
    }
    a:hover{
        color:#e24646;
    }

    #ativo{
        background-color: #e24646;
        border: #e24646;
    }
    .pagination a{
        color: #e24646;
    }
    .pagination a:hover{
    color: #7c1010;
    }

</style>

<body>
       

    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-dark sticky-top flex-md-nowrap" style="background-color:black">
            <a class="navbar-brand" href="#">MARESUL - Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-links" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav-links">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a id="lembretes"class="nav-link " href="/lembretes" data-toggle="tooltip" data-placement="bottom" title="Lembretes"><i class="fa fa-sticky-note"></i></a>
                    </li>
                    <li class="nav-item">
                        <a id="regras"class="nav-link" href="/regras"  data-toggle="tooltip" data-placement="bottom" title="Regras"><i class="fa fa-gavel"></i></a>
                    </li>
                    <li class="nav-item">
                        <a id="ajuda"class="nav-link " href="/ajuda"  data-toggle="tooltip" data-placement="bottom" title="Ajuda"><i class="fa fa-question"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-profile"></i> Olá, {{ Auth::user()->email }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
            @yield('warn-content')
        </nav>
        

        <div class="container-fluid">
        <div class="row"> 
        <nav class=" navbar col-md-2 d-none d-md-block  bg-dark sidebar text-white" id="nav1"style= "position:fixed; left: 0; height: 100%">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item ">
                <a id="dashboard" class="nav-link" href="/dashboard" data-toggle="tooltip" data-placement="right" title="Visão geral administrativa"><i class="fa fa-th" ></i> Dashboard</a>
                </li>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span> Financeiro</span><i class="fa fa-dollar-sign"></i></h6>
                <li class="nav-item">
                <a id="despesas"class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="resumo e relatórios mensais"><i class="fa fa-coins"></i> Despesas</a>
                </li>
                <li class="nav-item">
                <a id="estatistica"class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="gráficos financeiros"><i class="fa fa-chart-bar"></i> Estatísticas</a>
                </li>
                <li class="nav-item">
                <a id="historico" class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="históricos monetáros anuais"><i class="fa fa-layer-group"></i> Histórico</a>
                </li>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span> Administrativo</span><i class="fa fa-toolbox"></i></h6>
                <li class="nav-item">
                <a id="reservas" class="nav-link" href="/reservas" data-toggle="tooltip" data-placement="right" title="reservas e cancelamentos"><i class="fa fa-check-circle"></i> Reservas</a>
                </li>
                <li class="nav-item">
                <a id="anuncios"class="nav-link" href="/anuncios" data-toggle="tooltip" data-placement="right" title="comunicados e anunciamentos"><i class="fa fa-paperclip"></i> Anúncios</a>
                </li>
            </ul>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                <a id="documentos"class="nav-link" href="/documentos" data-toggle="tooltip" data-placement="right" title="arquivos importantes"><i class="fa fa-file-alt"></i> Documentos</a></li>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>Social</span><i class="fa fa-comments"></i>              </h6>
                <li class="nav-item">
                    <a id="comunidade"class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="ver cadastros gerais"><i class="fa fa-users"></i> Comunidade</a>
                </li>
                <li class="nav-item">
                <a id="forum" class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="interações da comunidade"><i class="fa fa-quote-left"></i> Fórum Virtual</a>
                </li>
                <li class="nav-item">
                <a id="mural"class="nav-link" href="#" data-toggle="tooltip" data-placement="right" title="recados pessoais dos moradores"><i class="fa fa-clipboard-list"></i> Mural</a>
                </li>
            </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            @yield('main-content')
                    
        </main>

        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('js-content')

<script type="text/javascript">
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })</script>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->


</body>
</html>
 