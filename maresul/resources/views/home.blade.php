@extends('layout_user')


@section('title-content')
<title> MAR&SUL - Home</title>
    
@endsection

@section('main-content')



<div class="jumbotron mx-auto" style="margin-top:40px; background-image: url('{{Storage::url('banner/banner2.png') }}'); background-repeat: no-repeat;">
        <div class="container" >
          <h1 class="display-3">BEM-VINDO!</h1>
          <p style="max-width:500px;">Caro usuário, você está na página principal do portal dos moradores do condomínio MAR&SUL, se você tiver qualquer dúvida entre em contato com os líderes da zeladoria e não deixe de ficar atualizado sobre as notícias recentes clicando no botão abaixo. Boas vindas!</p>
          <p><button type="button" class="btn btn-primary btn-lg"data-toggle="modal" data-target="#anunciosModal" role="button">Anuncios</button></p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row " style="justify-content: center;">
          <div class=" card col-md-3" style="margin-right:20px; margin-bottom: 50px;">
            <div class="card-body">
                <h4 class="card-title">Fórum Virtual <i class="fa fa-quote-left" style="float:right; color:#3a79e0;"></i></h4>
                <p>Interaja ideias com os moradores do condomínio ou crie um tópico para discutir algum assunto.</p>
                <p><a class="btn btn-primary" href="/forum" role="button">Acessar </a></p>
            </div>
          </div>
          <div class=" card col-md-3" style="margin-right:20px;margin-bottom: 50px;">
            <div class="card-body">
                    <h4 class="card-title">Reservas <i class="fa fa-check-square" style="float:right; color:#3a79e0; " ></i></h4>
                <p>Entre aqui caso você precisar reservar uma das áreas coletivas do condomínio.</p>
                <p><a class="btn btn-primary" href="/reservas" role="button">Acessar </a></p>
            </div>
        </div>
        <div class=" card col-md-3" style="margin-bottom: 50px; margin-right:20px;">
            <div class="card-body">
                    <h4 class="card-title">Comunidade <i class="fa fa-users" style="float:right;color:#3a79e0; "></i></h4>
                <p>Veja os membros que estão participando da comunidade online.</p>
                <p><a class="btn btn-primary" href="#" role="button">Acessar</a></p>
            </div>
        </div>

        </div>

        <hr>

      </div> 

      <!--MODAL CRIAR-->
<div class="modal fade" id="anunciosModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="overflow:hidden;">
                <div class="modal-header">
                <h4 class="modal-title">ANUNCIOS OFICIAIS</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll;  height:380px;">
                        @foreach($anuncios as $a)
                        <div class="card" style="margin-bottom:20px;">
                                <div class="card-body ">
                                        <button type="button" id="pop" class="btn btn-sm btn-link" style="float:right;" data-trigger="hover" data-boundary="window" data-toggle="popover" title="Observações" data-content="{{$a->ps}}"><i class="fa fa-exclamation-circle"></i></button>
                                    <h5 class="card-title"> <i class="fa fa-paperclip" style="margin-right:5px;"></i>{{$a->title}}  </h5>
                                    <small class="card-text text-muted">  postado em {{date('d/m/Y', strtotime($a->reportdate))}}</small>
                                    <p class="card-text text-secondary"> {{$a->description}}</p>
                                </div>
                            </div>
                    
                        @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    
@endsection

@section('js-content')
<script type="text/javascript">
    $(function () {
    $('#pop').popover();
    $('div').on('scroll', function () {
        var $container = $(this);
        $(this).find('.popover').each(function () {
            $(this).css({
                top:  - $container.scrollTop()
            });
        });
    });
});

    $(function () {
    $('[data-toggle="popover"]').popover()
  })
</script>

    
@endsection