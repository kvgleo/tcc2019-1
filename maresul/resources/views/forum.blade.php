@extends('layout_user')


@section('title-content')
<title> MAR AZUL - Forum Virtual</title>
    
@endsection

@section('warn-content')
    @if(Session::has('msg'))
    <div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
            <div class="toast ml-auto alert-success" role="alert" data-autohide="false"  style="margin-top:7rem;">
                <div class="toast-body alert-success"><i class="fa fa-check-circle mr-2"></i>{{ Session::get('msg') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span id="close"aria-hidden="true">×</span></button></div>
            </div>
        </div>
    @endif
    @if(Session::has('avs'))
    <div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
            <div class="toast ml-auto alert-danger" role="alert" data-autohide="false"  style="margin-top:7rem;">
                <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i>{{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span id="close" aria-hidden="true">×</span></button></div>
            </div>
        </div>
    @endif
@endsection


@section('main-content')
<div class="row">
<main role="main" class="col-md-2   col-lg-2 " style="background-color:none; padding-top:25px; padding-bottom:25px;">
    
</main>
<main role="main" class="col-md-8   col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
    <h1 class="h2 text-secondary">O Fórum</h1>
    <a href="/home" class="btn btn-link"> <i class="fa fa-chevron-left"></i> Voltar</a>
</div>
<nav aria-label="breadcrumb" style="margin-top:-25px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
        <li class="breadcrumb-item "><a href="/forum" class="text-secondary">Forum </a></li>
    </ol>
</nav>

<div class="row">

<div class="col-md-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal" >Novo Tópico <i class="fa fa-plus"></i></button>
</div>

<form id="searchForm" class="col-md-9" action="{{route('buscar_topico')}}" method="GET">
        <div class="input-group">
            <input class="form-control py-2" type="search" placeholder="Pesquisar..." name="buscar" >
            <span class="input-group-append">
            <button class="btn btn-outline-secondary" form="searchForm"type="submit" >
                <i class="fa fa-search"></i>
            </button>
            </span>
        </div>
    </form>

    <div class="dropdown col-md-12" style="margin-top:20px">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              filtro
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Quentes</a>
              <a class="dropdown-item" href="#">Recentes</a>
              <a class="dropdown-item" href="#">Abertos</a>
            </div>
          </div>
</div>
      


    @if(!empty($src))
    <div class="input-group col-md-12 text-muted" style="margin-top:10px; margin-bottom:10px;">
    <h2>Resultado da busca: {{$topicos->total()}} encontrado(s).</h2>
    </div>

@endif

    @if($topicos[0]==null)
    <div class="card alert-primary" style="margin-bottom:20px;">
            <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Ops!...</div>
            <div class="card-body">
                <p class="card-text"> Nenhum conteúdo encontrado! </p>
            </div>
        </div>
    @endif
      
            <div class="card" style=" background:none; border:none; margin-top:10px;">
    
                @foreach($topicos as $top)
                <div class="card  col-md-12"  style="margin-bottom: 10px;">
                    <div class="row no-gutters">
                        <div class="col-md-1 " >
                            <div class="card-body col-md12" >
                                <a class=" align-items-center d-flex justify-content-center card-title" href="#"><i class="fa fa-angle-up "></i></a>
                                <p class=" align-items-center d-flex justify-content-center  text-secondary h3 ">856</p>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                    <h5 class="card-title"> <b>{{$top->top_titulo}} </b> @if($top->status_top == false)  <span class="badge badge-primary">ABERTO <i class="fa fa-unlock"></i> </span> @else <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i> </span>  @endif</h5>
                                <h6 class="card-subtitle mb-2 text-muted"> <small>por @if($top->admin_post==false)<b> {{$top->author}} </b> @else <b class="text-primary"> {{$top->author}} </b> @endif , postado em {{date('d/m/Y', strtotime($top->created_at))}} -  <b>{{$top->cat}} </b></small></h6>
                                <p class="card-text text-muted">
                                    <i class="fa fa-eye"></i> {{$top->top_views}} visitas |
                                    <i class="far fa-comments"></i> 86 respostas |
                                    <i class="far fa-clock"></i>  há {{Carbon\Carbon::parse($top->created_at)->diffForHumans(date(now())) }} 
                                    
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card-body">
                                
                                <a href="/forum/topico/{{$top->id}} " style="margin-top:20px" class="btn btn-primary float-right">Entrar <i class="fa fa-angle-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- CARD-->   
            @endforeach
            {{$topicos->links()}}
            </div>
       
       
</main>

<main role="main" class=" card col-md-2  col-lg-2" style=" border:none; background:none; padding-top:65px; padding-bottom:25px; ">
    <div class="card-body">
        <h5 class="card-text"> Categorias </h5>
        <br>
        <ul class="list-group list-group-flush">
            @foreach($categorias as $cat)
                <li class="list-group-item">
                    <a href="#" class="text-primary" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="left" data-content="{{$cat->cat_desc}}">{{$cat->nome}} </a> 
                </li>
            @endforeach
        </ul>
    </div>
</main>

</div>


    <!--MODAL CRIAR-->
    <div class="modal fade" id="createModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">NOVO TÓPICO</h4>
                    </div>
                    <div class="modal-body">
                            <form id="formTop" method="POST" action="/forum/topico">
                                @csrf
                                <div class="form-group">
                                    <label for="top_tit">Título</label>
                                    <input id="top_tit" type="text" class="form-control" name="top_tit"  placeholder="adicionar título..." required>
                                </div>
                                <div class="form-group" >
                                    <label for="top_cat" >Categoria</label>
                                    <div class="input-group">
                                        <select class="form-control" name="top_cat"  id="top_cat" required>
                                            <option hidden class="text-secondary">--Categoria--</option>
                                                @foreach($categorias as $cat)
                                                    <option>{{$cat->nome}}</option>
                                                @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="top_desc">Discussão</label>
                                    <textarea rows="7" id="top_desc"  class="form-control description" name="artigo" placeholder="adicione a discussão..."></textarea>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                            <button form="formTop"type="submit" class="btn btn-primary">Criar</button> 
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        
@endsection



@section('js-content')
<script type="text/javascript">


    $('.toast').toast('show');

$('#close').click(function(){
    $("#toast").remove();
});

    </script>
    
@endsection