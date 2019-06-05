@extends('adm.template.main')

@section('title-content')
<title>MAR AZUL- Dashboard</title>

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
            <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i>{{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span id="close"aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif

@endsection

@section('main-content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
  <h1 class="h2">Dashboard</h1>
  </div>
  <nav aria-label="breadcrumb" style="margin-top:-25px;">
      <ol class="breadcrumb">
          <li class="breadcrumb-item active" >Dashboard</li>
      </ol>
  </nav>

<div class="row" style="margin-bottom:10px;">
  <div class="col-md-6" >
    <div class="row">
      <div class="col-md-12">
        <div class="card" style="background:none; border:none;">
          <div class="card-body">
          <p class=" card-text text-danger h3"><i class="fa fa-calendar-alt"></i> @php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); @endphp {{strftime('%A, %d de %B de %Y', strtotime('today'))}} - Imbé/RS</p>
          </div> 
        </div>
      </div>
      <div class="col-md-12" style="margin-bottom:5px;">
        <div class="card">
          <div class="card-body">
            <p class="card-title"> <b> <i class="fa fa-list"></i> Últimos Lançamentos </b></p>
            <div  style="max-height:150px; overflow-y: auto;">
                <table class="table table-hover text-muted table-sm col-md-12" id="searchtable">
                        <thead>
                          <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Tipo</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($lancamentos as $l)
                          <tr>
                            <td scope="col">{{date('d/m/Y', strtotime($l->reportdate))}} </td>
                            <td scope="col">{{$l->lanc_desc}}</td>
                            <td scope="row" class="text-danger"><b>R$ {{number_format($l->valor,2,",",".")}}</b></td>
                            <td scope="col">{{$l->tipo}}</td>
                          </tr>
                          @endforeach

                        </tbody>
                      </table>
                </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
          <div class="card">
            <div class="card-body">
                <p class="card-title"><b> <i class="fab fa-diaspora"></i> Tópicos Novos</b></p>
              <div class="card" style=" background:none; border:none; margin-top:-20px;">
                <div class="card-body" style=" background:none; border:none; max-height:250px; overflow-y: auto; margin-top:10px;">
              @foreach($topicos as $top)
              <div class="card  col-md-12"  style="margin-bottom: 10px;">
                  <div class="row no-gutters">
                      <div class="col-md-9">
                          <div class="card-body">
                               <h5 class="card-title"><b>{{$top->top_titulo}} </b> @if($top->status_top == false) <span class="badge badge-danger">ABERTO <i class="fa fa-unlock"></i> </span> @else  <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span> @endif  </h5>
                              <small class="card-text text-muted">
                                  <i class="fa fa-eye"></i> {{$top->top_views}} visitas |
                                  <i class="far fa-thumbs-up"></i> {{$top->votos}}  votos |
                                  <i class="far fa-comments"></i> {{$top->comentarios}}  respostas |
                                  <i class="far fa-clock"></i> há {{Carbon\Carbon::parse($top->created_at)->diffForHumans(date(now())) }}                                  
                              </small>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card-body">
                            <br>
                          <a href="/forum/topico/{{$top->id}} " class="btn btn-danger btn-sm float-right">Ver <i class="fa fa-angle-right"></i> </a>  
                          </div>

                      </div>
                  </div>
              </div>
          <!-- CARD-->   
          @endforeach
            </div>
            </div>
            <p class="card-text">  <a href="{{route('forum')}} " class="btn btn-link text-danger float-right"> Ver Tudo <i class="fa fa-external-link-alt"></i></a> </p>
            </div>
          </div>
      </div>
    </div>
  </div>


  <div class="col-md-6">
    <div class="row">
    <div class="card col-md-12" style="margin-bottom:10px;">
      <div class="card-body" style="overflow-y:auto max-height:200px;">
        <p class="card-title"> <b><i class="far fa-calendar"></i> Recados recentes </b></p>
          <div class="list-group" id="listinha" role="tablist">
              @foreach($recados as $r)
              <a class="list-group-item  list-group-item" style="margin-bottom:5px;">
                  <i class="fa fa-tag"></i>
                  <b> ({{ $r->name}})</b>                          
                  {{$r->assunto}}
                   <small class="text-muted"> ( há {{Carbon\Carbon::parse($r->created_at)->diffForHumans(date(now())) }} ) </small>
                  @if(Carbon\Carbon::parse($r->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                  <span class="badge badge-danger">NOVO</span>
                  @endif
                </a>
              @endforeach
          </div>
          <a href="{{route('recados')}} " class="btn btn-link text-danger float-right"> Ver Tudo <i class="fa fa-external-link-alt"></i></a>
      </div>
    </div>
    <div class="card col-md-12">
        <div class="card-body">
            <p class="card-text"> <i class="fa fa-angle-double-right"></i> <b>Lembrete rápido </b></p>
            <hr>
            <form id="formLem" action="/lembretes/2" method="POST">
              @csrf
              <div class="form-group">
                  <label for="lemb_tit" >Título</label>
                  <input type="text" class="form-control" placeholder="assunto..." name="lemb_tit" id="lemb_tit" required>
              </div>
              <div class="form-group">
                  <label for="lemb_desc" >Descrição</label>
                  <textarea rows="4" class="form-control description" placeholder="descrição..." name="lemb_desc" id="lemb_desc"></textarea>
              </div>
              <button type="submit" class="btn btn-danger float-right" form="formLem"> Enviar</button>
            </form>
        </div>
      </div>
    </div>


  </div>
</div>

@endsection
@section('js-content')
<script>

      $('.toast').toast('show');

$('#close').click(function(){
    $("#toast").remove();
});

  $(function() {
    $('#dashboard').addClass('btn-danger');
  });
</script>
@endsection