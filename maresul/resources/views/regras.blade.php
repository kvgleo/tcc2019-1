@extends('layout_user')


@section('title-content')
<title> MAR&SUL - Regras de Convivência</title>
    
@endsection

@section('main-content')
<main role="main" class="col-md-8  mx-auto col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
    <h1 class="h2 text-secondary">Regras de Convivência</h1>
</div>
      <nav aria-label="breadcrumb" style="margin-top:-25px;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
              <li class="breadcrumb-item active" >Regras de Convivência</li>
            </ol>
            <div class="card" style="margin-bottom:20px;">
                <div class="card-body text-secondary">
                    <p class="card-text"> Caro condôminio, para que a vida em comum seja tranquila e harmoniosa, todos os moradores devem fazer sua parte, respeitando seu espações e o do vizinho. Portanto, é muito importante que  as dicas abaxo - além das já previstas na conveção e regimento interno sejam seguidas.</p>
                    <p class="card-text"> As consequências do não cumprimento das regras incluem:</p>
                    <ul>
                        <li>Indenizações pela comunidade</li>
                        <li>Licença de estadia confiscada </li>
                        <li>Restrições de locais</li>
                        <li>Multas de até R$ 300,00</li>
                    </ul>
                    <p class="card-text"> Entre em contato com a zeladoria para mais informações de penalidades ao infringir regras.</p>
                    <footer class="blockquote-footer"> att, Equipe Condominal </footer>
                </div>
            </div>
          </nav>
          @if($regras[0]==null)
            <div class="card alert-primary" style="margin-bottom:20px;">
                    <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Ops!...</div>
                    <div class="card-body">
                        <p class="card-text"> Por enquanto não foi adicionado nada nesta seção! </p>
                    </div>
                </div>
            @endif
            

          <div id="accordion" >
            @foreach($regras as $re)
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header" id="a{{$re->id}}">
                        <h3 class="mb-0 text-secondary">
                            <i class="fa fa-shield-alt"></i>
                        <b class="card-text">{{$re->title}} </b>
                            <button class="btn btn-link collapsed " style="font-size:20px; float:right"data-toggle="collapse" data-target="#c{{$re->id}}" aria-expanded="false" aria-controls="{{$re->id}}"><i class="fa fa-angle-down"></i></button>  
                        </h3>
                    <p class="card-text"><small class="text-muted"> criado em {{date('d-m-Y', strtotime($re->created_at))}}</small></p>
                    </div>
                    <div id="c{{$re->id}}" class="collapse" aria-labelledby="ac{{$re->id}}" data-parent="#accordion">
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted"> data de aprovação {{date('d-m-Y', strtotime($re->reportdate))}}</small></p>
                            <p>{{$re->desc}}</p>
                            <footer class="blockquote-footer"> assinado por {{$re->author}}</footer>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$regras->links()}} 
        </div>
    </div>
</main>
@endsection



@section('js-content')
<script type="text/javascript">

    $(function() {
        $('#regras').addClass('btn-info');
      });

    </script>
    
@endsection