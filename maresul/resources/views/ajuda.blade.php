@extends('layout_user')


@section('title-content')
<title> MAR&SUL - Regras de Convivência</title>
    
@endsection

@section('main-content')
<main role="main" class="col-md-8  mx-auto col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
    <h1 class="h2 text-secondary">Perguntas Frequentes</h1>
    <a href="/home" class="btn btn-link"> <i class="fa fa-chevron-left"></i> Voltar</a>
</div>
      <nav aria-label="breadcrumb" style="margin-top:-25px;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
              <li class="breadcrumb-item active" ><a href="/ajuda" class="text-muted"> Pergunta Frequentes </a></li>
            </ol>
            <div class="card" style="margin-bottom:20px;">
                <div class="card-body text-secondary">
                    <p class="card-text"> Caro condôminio, suas dúvidas são muito importantes para nós, para isso separamos um lugar para encontrar as respostas para as perguntas recorrentes dos moradores, se caso sua questão não estiver na lista a baixo, procure uma das sedes de atendimento primeiro andar, horario de atendimento: seg à sab, das 13:00 às 18:30.</p>
                    <footer class="blockquote-footer"> att, Equipe Condominal </footer>
                </div>
            </div>
          </nav>
          <form id="searchForm" action="{{route('buscar_ajuda')}}" method="GET" style="margin-left:-15px;">
                <div class="input-group col-md-5" style="margin-top:10px; margin-bottom:10px;">
                      <input class="form-control py-2" type="search" placeholder="Pesquisar..." name="buscar" style="height:50px;">
                      <span class="input-group-append">
                        <button class="btn btn-outline-secondary" form="searchForm"type="submit" >
                            <i class="fa fa-search"></i>
                        </button>
                      </span>
                </div>
              </form>
    
              
            @if(!empty($src))
            <div class="input-group col-md-12 text-muted" style="margin-top:10px; margin-bottom:10px;">
            <h2>Resultado da busca: {{$perguntas->total()}} encontrado(s).</h2>
            </div>
        @endif

          @if($perguntas[0]==null)
          <div class="card alert-primary" style="margin-bottom:20px;">
                  <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Ops!...</div>
                  <div class="card-body">
                      <p class="card-text"> Por enquanto não foi adicionado nada nesta seção! </p>
                  </div>
              </div>
          @endif
            

          <div id="accordion" >
            @foreach($perguntas as $p)
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header" id="a{{$p->id}}">
                        <h3 class="mb-0 text-secondary">
                            <i class="fa fa-question-circle"></i>
                            <b class="card-text">{{$p->question}}
                            @if(Carbon\Carbon::parse($p->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                            <span class="badge badge-primary">NOVO</span>
                            @endif
                            </b>
                            <button class="btn btn-link collapsed " style="font-size:20px; float:right"data-toggle="collapse" data-target="#c{{$p->id}}" aria-expanded="false" aria-controls="{{$p->id}}"><i class="fa fa-angle-down"></i></button>  
                        </h3>
                        <small class="text-muted">postado há {{Carbon\Carbon::parse($p->created_at)->diffForHumans(date(now())) }} </small>
                    </div>
                    <div id="c{{$p->id}}" class="collapse" aria-labelledby="ac{{$p->id}}" data-parent="#accordion">
                        <div class="card-body">
                                <p class="card-text"><small class="text-muted">Resposta: </small></p>
                            <p class="card-text">{!!$p->answer!!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$perguntas->links()}} 
        </div>
    </div>
</main>
@endsection



@section('js-content')
<script type="text/javascript">

    $(function() {
        $('#ajuda').addClass('btn-info');
      });

    </script>
    
@endsection