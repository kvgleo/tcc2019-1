@extends('layout_user')


@section('title-content')
<title> MAR$SUL - Home</title>
    
@endsection

@section('main-content')



<div class="jumbotron" style="margin-top:40px; background-image: url('{{Storage::url('banner/banner2.png') }}'); background-repeat: no-repeat;">
        <div class="container">
            <img src="{{Storage::url('banner/banner1.png') }}" style="width:420px;height:250px; float:left; margin-right: 20px;">
          <h1 class="display-3">BEM-VINDO!</h1>
          <p>Caro usuário, você está na página principal do portal dos moradores do condomínio MAR&SUL, se você tiver qualquer dúvida entre em contato com os líderes da zeladoria e não deixe de ficar atualizado sobre as notícias recentes clicando no botão abaixo. Boas vindas!</p>
          <p><a class="btn btn-primary btn-lg" href="#" role="button">Anuncios</a></p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row " style="justify-content: center;">
          <div class=" card col-md-3" style="margin-right:20px; margin-bottom: 50px;">
            <div class="card-body">
                <h4 class="card-title">Fórum Virtual <i class="fa fa-quote-left" style="float:right; color:#3a79e0;"></i></h4>
                <p>Interaja ideias com os moradores do condomínio ou crie um tópico para discutir algum assunto!</p>
                <p><a class="btn btn-primary" href="#" role="button">Acessar </a></p>
            </div>
          </div>
          <div class=" card col-md-3" style="margin-right:20px;margin-bottom: 50px;">
            <div class="card-body">
                    <h4 class="card-title">Reservas <i class="fa fa-check-square" style="float:right; color:#3a79e0; " ></i></h4>
                <p>Interaja ideias com os moradores do condomínio ou crie um tópico para discutir algum assunto!</p>
                <p><a class="btn btn-primary" href="/reservas" role="button">Acessar </a></p>
            </div>
        </div>
        <div class=" card col-md-3" style="margin-bottom: 50px; margin-right:20px;">
            <div class="card-body">
                    <h4 class="card-title">Comunidade <i class="fa fa-users" style="float:right;color:#3a79e0; "></i></h4>
                <p>Interaja ideias com os moradores do condomínio ou crie um tópico para discutir algum assunto!</p>
                <p><a class="btn btn-primary" href="#" role="button">Acessar</a></p>
            </div>
        </div>

        </div>

        <hr>

      </div> <!-- /container -->
    
@endsection

@section('js-content')
    
@endsection