
@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Estatísticas</title>
@endsection
@section('warn-content')

@if(Session::has('msg'))
@endif

@endsection
@section('main-content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
    <h1 class="h2">Estatísticas Financeiras</h1>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Estatísticas</li>
        </ol>
    </nav>
    <div class="card" style="margin-bottom:20px;">
        <div class="card-body text-secondary">
            <p class="card-text">Ver os principais índices de gastos</p>
        </div>
    </div>


    <div class="row mx-auto">
        <div class="col-md-1"></div>
        <div class=" card col-md-3" style="margin-bottom:15px; margin-right:20px;">
            <div class="row card-body">
                <div class="col-md-3 text-left card-text">
                    <h1 class="text-muted"><i class="fa fa-dollar-sign"></i></h1>
                </div>
                @if(count($sind2) == 0 || count($sind3) == 0)
                    <div class="col-md-9 text-right card-text">
                            <h2 class="text-dark">N/D </h2>
                        </div>

                        <div class=" col-md-6 card-text text-muted">
                            <small class="card-text"> Aplicações Sindicais</small>
                        </div>
                        <div class=" col-md-6 card-text text-right">
                                <small class="card-text text-muted"> /indefinido</small>
                            </div>
                    <div class=" col-md-12 card-text">

                        <div class="progress" style="height: 3px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width:0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>                                                              
                    </div>
                @else
                    <div class="col-md-9 text-right card-text">
                            <h2 class="text-dark"> R$  {{number_format($sind2[0]->val,2,",",".")}} </h2>
                        </div>

                        <div class=" col-md-6 card-text text-muted">
                            <small class="card-text"> Aplicações Sindicais</small>
                        </div>
                        <div class=" col-md-6 card-text text-right">
                                <small class="card-text text-muted"> /{{number_format( (($sind2[0]->val *100)/$sind[0]->total) ,2)}}% ({{Date::parse($sind2[0]->dat)->format('M , Y') }})</small>
                            </div>
                    <div class=" col-md-12 card-text">

                        <div class="progress" style="height: 3px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width:{{number_format( (($sind2[0]->val *100)/$sind[0]->total) ,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>                                                              
                    </div>
                @endif
            </div>
        </div>

        
        <div class="card col-md-3"  style="margin-bottom:15px;margin-right:20px;">

            <div class="row card-body">
                @if( count($users) == 0)
                    <div class="col-md-3 text-left card-text">
                        <h1 class="text-muted"><i class="fa fa-user-alt-slash"></i></h1>
                    </div>

                        <div class="col-md-9 text-right">
                        <h2 class="text-danger" style="display:inline" >N/D</h2>

                        </div>
                        <div class=" col-md-6 card-text text-muted">
                            <small class="card-text"> Inadimplência</small>
                        </div>
                        <div class=" col-md-6 card-text text-right text-muted">
                                <small class="card-text">  /indefinido</small>
                            </div>
                    <div class=" col-md-12 card-text">

                    <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width:0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>   
                @else
                    <div class="col-md-3 text-left card-text">
                        <h1 class="text-muted"><i class="fa fa-user-alt-slash"></i></h1>
                    </div>

                        <div class="col-md-9 text-right">
                        <h2 class="text-danger" style="display:inline" >{{$in[0]->inp}}</h2>
                        <h5 class="text-muted" style="display:inline">/{{$users[0]->total}}</h5> 

                        </div>
                        <div class=" col-md-6 card-text text-muted">
                            <small class="card-text"> Inadimplência</small>
                        </div>
                        <div class=" col-md-6 card-text text-right text-muted">
                                <small class="card-text">  /{{number_format(($in[0]->inp *100)/$users[0]->total,0)}}% já quitados</small>
                            </div>
                    <div class=" col-md-12 card-text">

                    <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width:{{($in[0]->inp *100)/$users[0]->total}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>   
                @endif
            </div>
        </div>


        <div class="card col-md-3"  style="margin-bottom:15px;margin-right:20px;">
            <div class="row card-body">
                    @if(count($res2) == 0 || count($res) == 0)
                    <div class="col-md-3 text-left card-text">
                            <h1 class="text-muted"><i class="fa fa-wallet"></i></h1>
                        </div>
                        <div class="col-md-9 text-right card-text">
                                <h2 class="text-success" > N/D</h2>
                            </div>
        
                            <div class=" col-md-6 card-text">
                                <small class="card-text"> Fundo de Reserva</small>
                            </div>
                            <div class=" col-md-6 card-text text-right">
                                    <small class="card-text text-muted"> /indefinido</small>
                                </div>
                        <div class=" col-md-12 card-text">
        
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width:0%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @else
                    <div class="col-md-3 text-left card-text">
                            <h1 class="text-muted"><i class="fa fa-wallet"></i></h1>
                        </div>
                        <div class="col-md-9 text-right card-text">
                                <h2 class="text-success" > R$ {{number_format($res2[0]->val,2,",",".")}}</h2>
                            </div>
        
                            <div class=" col-md-6 card-text">
                                <small class="card-text"> Fundo de Reserva</small>
                            </div>
                            <div class=" col-md-6 card-text text-right">
                                    <small class="card-text text-muted"> {{number_format( (($res2[0]->val *100)/$res[0]->total) ,2)}}% ({{Date::parse($res2[0]->dat)->format('M , Y') }})</small>
                                </div>
                        <div class=" col-md-12 card-text">
        
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width:{{number_format( (($res2[0]->val *100)/$res[0]->total) ,2)}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                    @endif
            </div>
        </div>

        <div class="col-md-1"></div>
      </div>

      <div class="row">
          <div class="col-md-12" style="margin-bottom:15px;"> 
                <div class="card col-md-12">
                        <div class="card-body">
                            @if(count($res3) ==0 || count($sind3) ==0)
                                <h5 class="card-title">Despesas e Rendimentos  Anuais</h5>
                                <h6 class="card-subtitle text-muted">Gráficos indisponíveis </h6>
                                <hr>
                            @else
                                <h5 class="card-title">Despesas e Rendimentos  Anuais</h5>
                                <h6 class="card-subtitle text-muted">Veja a quantia total de suas despesas e redimentos do último ano cadastrado ({{$anoc}}).</h6>
                                <p class="card-text" style="margin-top:15px;"><canvas id="lineChart" style="position: relative; height: 30vh"></canvas></p>
                            @endif
                        </div>
                        </div>
          </div>
      </div>

      <div class="row">
        <div class="col-md-6" style="margin-bottom:15px;"> 
            <div class="card col-md-12">
                    <div class="card-body">
                        <h5 class="card-title">Menores Consumos</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Lançamentos que obtiveram a menor taxa de consumo</h6>
                            <div class="row">
                                <!-- -->

                                <div class="col-md-12">
                                    <hr>
                                    @if(count($mconc)==0)
                                        <p class="text-muted"> N/D </p>
                                    @else
                                        <span class="badge badge-success">{{$mconc[0]->tipo}}</span>
                                        <small class="text-muted" style="display:inline" > {{$mconc[0]->lanc_desc}} ({{date('d/m/Y', strtotime( $mconc[0]->reportdate))  }})</small> 
                                        <p class="text-success text-right" style="display:inline"> R$: {{number_format($mconc[0]->valor,2,",",".")}}</p>
                                        <button type="button" class="btn btn-link btn-sm" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="right" data-content="{{$mconc[0]->info_tipo}}">
                                            <i style="color:grey" class="fa fa-info-circle"></i> 
                                        </button> 
                                    @endif
                                </div>
                                <!---- -->
                                <div class="col-md-12">
                                    <hr>
                                    @if(count($madm)==0)
                                        <p class="text-muted"> N/D </p>
                                    @else
                                        <span class="badge badge-success">{{$madm[0]->tipo}}</span>
                                        <small class="text-muted" style="display:inline" > {{$madm[0]->lanc_desc}} ({{date('d/m/Y', strtotime( $madm[0]->reportdate))  }})</small> 
                                        <p class="text-success text-right" style="display:inline"> R$: {{number_format($madm[0]->valor,2,",",".")}} </p>
                                        <button type="button" class="btn btn-link btn-sm" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="right" data-content="{{$madm[0]->info_tipo}}">
                                            <i style="color:grey" class="fa fa-info-circle"></i> 
                                        </button> 
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    @if(count($mccmi)==0)
                                        <p class="text-muted"> N/D </p>
                                    @else
                                        <span class="badge badge-success">{{$mccmi[0]->tipo}}</span>
                                        <small class="text-muted" style="display:inline" > {{$mccmi[0]->lanc_desc}} ({{date('d/m/Y', strtotime( $mccmi[0]->reportdate))  }})</small> 
                                        <p class="text-success text-right" style="display:inline">R$: {{number_format($mccmi[0]->valor,2,",",".")}} </p>
                                        <button type="button" class="btn btn-link btn-sm" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="right" data-content="{{$mccmi[0]->info_tipo}}">
                                            <i style="color:grey" class="fa fa-info-circle"></i> 
                                        </button> 
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    @if(count($mpes)==0)
                                        <p class="text-muted"> N/D </p>
                                    @else
                                        <span class="badge badge-success">{{$mpes[0]->tipo}}</span>
                                        <small class="text-muted" style="display:inline" > {{$mpes[0]->lanc_desc}} ({{date('d/m/Y', strtotime( $mpes[0]->reportdate))  }})</small> 
                                        <p class="text-success text-right" style="display:inline"> R$: {{number_format($mpes[0]->valor,2,",",".")}}</p>
                                        <button type="button" class="btn btn-link btn-sm" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="right" data-content="{{$mpes[0]->info_tipo}}">
                                            <i style="color:grey" class="fa fa-info-circle"></i> 
                                        </button> 
                                    @endif
                                </div>
                            </div>


                    </div>
                    </div>
        </div>

        <div class="col-md-6" style="margin-bottom:15px;"> 
                <div class="card col-md-12" >
                        <div class="card-body">
                            <h5 class="card-title">Despesas Anuais</h5>
                            <h6 class="card-subtitle text-muted">Veja a quantia total de suas despesas separadas por categoria anual.</h6>
                            <p class="card-text "><canvas id="bChart" style="position: relative; height: 27vh"></canvas></p>
                            <p></p>
                        </div>
                        </div>

        </div>
    </div>



@endsection


@section('js-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>


<script>
      $(function() {
    $('#estatisticas').addClass('btn-danger');
  });

$(function () {
    $('[data-toggle="popover"]').popover()
  })

</script>



<script>

     Chart.defaults.global.legend.display = false;
    var ctx2 = document.getElementById("bChart").getContext('2d');
    var Chart2 = new Chart(ctx2, {
    type: "horizontalBar",
    data: {
      labels: ["Pessoal", "Obras", "Concessionárias", "Administrativo", "Reserva", "Sindical",],
      datasets: [{
        label: "My First Dataset",
        data: [{!! json_encode($pes[0]->pes)!!}, {!! json_encode($ccmi[0]->ccmi)!!}, {!! json_encode($conc[0]->conc)!!},{!! json_encode($adm[0]->adm)!!}, {!! json_encode($fundo[0]->fundo)!!}, {!! json_encode($as[0]->sind)!!}],
        fill: false,
        backgroundColor: ["#F7464A", "#F7464A","#F7464A", "#F7464A", "#1f7742","#bc4410"
        ],
        borderWidth: 1
      }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                ticks: {
                beginAtZero: true
                }
            }]
      }
    }
  });

  </script>
    
@endsection

@section('js-content2')

@if (count($sind3)==0 || count($res3)==0)

@else

    Chart.defaults.global.legend.display = false;
    var ctx1 = document.getElementById("lineChart").getContext('2d');
    var Chart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ["Jan","Fev","Mar","Abr","Maio","Jun","Jul","Ago","Set","Out","Nov","Dez",],
        datasets: [{
            label: "Aplicações sindicais",
            data: [@for($i=1;$i<=12;$i++)
                @foreach($sind3 as $s) 
                    @php $j = false; @endphp
                    @if($s->mes == $i) 
                        {{$s->val}},
                        @php $j = true; @endphp
                        @break;
                    @endif 
                    
                @endforeach 
                @if($j!=true)
                    0,
                    @php $j = false; @endphp
                @endif
            @endfor  ],
            backgroundColor: [
            'rgba(244, 66, 66, 0.1)',
            ],
            borderColor: [
            '#F7464A',
            ],
            borderWidth: 2
        },
        {
            label: "Fundo de reserva",
            data: [    @for($l=1;$l<=12;$l++)
            @foreach($res3 as $r) 
                @php $k = false; @endphp
                @if($r->mes == $l) 
                    {{$r->val}},
                    @php $k = true; @endphp
                    @break;
                @endif 
                
            @endforeach 
            @if($k!=true)
                0,
                @php $j = false; @endphp
            @endif
        @endfor],
            backgroundColor: [
            'rgba(201, 203, 207, 0.8)',
            ],
            borderColor: [
                '#555759',
            ],
            borderWidth: 2
        }
        ]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true
    }
    });
@endif

@endsection