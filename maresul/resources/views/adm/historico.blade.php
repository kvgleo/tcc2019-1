@extends('adm.template.main')

@section('title-content')
<title>MAR AZUL- Histórico</title>

@endsection
@section('warn-content')


@if(Session::has('msg'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-success" role="alert" data-autohide="false"  style="margin-top:7rem;">
            <div class="toast-body alert-success"><i class="fa fa-check-circle mr-2"></i>{{ Session::get('msg') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif

@if(Session::has('avs'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-danger" role="alert" data-autohide="false"  style="margin-top:7rem;">
            <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i>{{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif

@endsection
@section('main-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
        <h1 class="h2">Historico</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-danger btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Request()->ano }}
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                @foreach($anos as $a)
                    <a class="dropdown-item" href={{route('historico', $a->ano)}}>{{$a->ano}}</a>
                @endforeach
            </div>
          </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Histórico</li>
        </ol>
    </nav>

    @if(count($lancamentos)==0)

    <div class="card col-md-12 " style="margin-bottom:20px; float:left; background:none; border:none;">
        <div class="card alert-secondary" style="margin-bottom:20px;">
            <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Aviso</div>
            <div class="card-body">
                <p class="card-text"> O histórico requerido não possuí registros!</p>
            </div>
        </div>
    </div>

    @else

        <div class="card col-md-6 " style="margin-bottom:20px; float:left; background:none; border:none;">
            <h4 ><b>Histórico de {{Request()->ano}}</b> <button style="float: right" class="btn btn-danger"> imprimir <i class="fa fa-print"></i></button></h4>
            <!--<button onClick="window.print()">Print this page</button>-->

                @if(12-count($meses) == 0)
                    <h6 style=" color:green" ><i class="fa fa-exclamation-circle"> </i> Histórico de {{Request()->ano}} foi completamente preenchido</h6>
                @else
        <h6 style=" color:rgba(244, 66, 66)" ><i class="fa fa-exclamation-circle"> </i> Histórico de {{Request()->ano}} não está completamente preenchido </h6>
                @endif
                <hr>


            <div class="card" style="border:none; background:none; max-height:480px; overflow-y: auto;">
                <div class="card-body">

                    <!-- begin -->

                    @for($i=0;$i<count($meses); $i++)

                    <div class="card" style="margin-bottom:10px;"> 
                        <div class="card-body">
                            <div class="card-title">
                                <h3 style="color:rgba(244, 66, 66)"> {{Date::createFromFormat('!m', $meses[$i]->mesl)->format('M') }} {{Request()->ano}}
                                </h3>
                            </div>
                            <ul class="list-group list-group-flush">

                                @for($j=0; $j<count($lancamentos);$j++)
                                    @if($lancamentos[$j]->mes == $meses[$i]->mesl)
                                        <li class="list-group-item">
                                            {{$lancamentos[$j]->tipo}}
                                            <button type="button" class="btn btn-link btn-sm" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="right" data-content="{{$lancamentos[$j]->info_tipo}}">
                                                <i style="color:grey" class="fa fa-info-circle"></i> 
                                            </button> 
                                            <span id="value" style="float:right; color:rgba(244, 66, 66)">R$: {{number_format($lancamentos[$j]->valor,2,",",".")}}</span>

                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                    </div>

                    @endfor

                    
    
                    
                    <!-- cards -->




                    </div>
                </div>
            </div>
        

            <div class="card col-md-6 infos" style="margin-bottom:20px; background:none; border:none;">

                <div class="card col-md-12 " style=" float:left; margin-bottom: 10px;">

                <div class="card-body text-secondary" >
                        <p class="card-title"><b> Todos lançamentos de {{ Request()->ano}} </b></p>
                        <div class="input-group col-md-12 row" style="margin-top:10px; margin-bottom:10px;">
                                <input class="form-control py-2 border-right-0 border input-sm " type="search" placeholder="Pesquisar..." id="searchinput">
                                <span class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                </span>
                        </div>
                        <div  style="max-height:130px; overflow-y: auto;">
                        <table class="table table-hover text-muted table-sm col-md-12" id="searchtable">
                                <thead>
                                  <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Ações </th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($all as $l)
                                  <tr>
                                    <td scope="col">{{date('d/m/Y', strtotime($l->reportdate))}} </td>
                                    <td scope="col">{{$l->lanc_desc}}</td>
                                    <td scope="row"><b>{{$l->valor}}</b></td>
                                    <td scope="col">{{$l->tipo}}</td>
                                    <td>
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                    <button type="button" onclick="edit('{{$l->id}}','{{$l->valor}}','{{$l->lanc_desc}}','{{$l->tipo}}','{{$l->reportdate}}','{{ Request()->ano }}')" data-toggle="modal" data-target="#editModal" style="float:right"class="btn btn-light btn-sm"><i class="fa fa-pen"></i></button>
                                                    <button type="button" onclick="confirm('{{$l->id}}','{{ Request()->ano }}')" data-toggle="modal" data-target="#deleteModal"  class="btn btn-link btn-sm text-danger"><i class="fa fa-times"></i></button>
                                            </div>
                                    </td>
                                  </tr>
                                  @endforeach

                                </tbody>
                              </table>
                        </div>
                    
                </div>
            </div>

            <div class="card col-md-12 " style=" float:left; margin-bottom: 10px; ">
                <div class="card-body text-muted">
                    <h5 class="card-title"><b>GRÁFICOS MONETÁRIOS </b> <i style="float:right; color:rgba(244, 66, 66)"class="fa fa-dollar-sign"></i></h5>
                    <p class="card-text">O gráfico abaixo indica a maior concentração em R$, separados por aplicações</p>
                    <div class="card-text col-md-11" style="padding-bottom:20px;">
                    <canvas id="doughnutChart" ></canvas>
                    </div>
                </div>
            </div>
        </div>


            <!--MODAL EDITAR-->
    <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="datEdit">EDITAR REGISTRO</h4>
                    </div>
                    <div class="modal-body">
                            <form class= "form-group"id="formEdit" action="/lancamentos" method="post">
                                @csrf
                                <div class="form-group row col-sm-12">
                                        <label for="datEdit" > Data</label>
                                        <input type="date"  class="form-control" id="datEdit" name="datEdit" required>
                                    </div>
            
                                <div class="form-group row col-sm-12">
                                        <label for="descEdit" > Descrição</label>
                                            <textarea rows="4" type="text" maxlength="15" step=".01" min="0" placeholder="descrição..." class="form-control" id="descEdit" name="descEdit" required></textarea>
                                    </div>
            
                                    <div class="form-group row col-sm-12">
                                            <label for="valEdit" > Valor</label>     
                                    <input type="number"  onkeydown="return event.keyCode !== 69"  maxlength="15" step=".01" min="0" class="form-control" id="valEdit" name="valEdit" placeholder="valor..." required>
                                        </div>
            
                                    <div class="form-group row col-sm-12" >
                                            <label for="tipoEdit" >Tipo</label>
                                            <div class="input-group">
                                                <select class="form-control" name="tipoEdit"  id="tipoEdit" required>
                                                    <option hidden class="text-secondary">--Categoria--</option>
                                                    <option>Pessoal</option>
                                                    <option>Concessionárias</option>
                                                    <option>Obras</option>
                                                    <option>Administrativo</option>
                                                    <option>Reserva</option>
                                                    <option>Síndico</option>
                                                </select>
                                            </div>
                                        </div>   
                            </form>         
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="formEdit"class="btn btn-danger">SALVAR</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL EXCLUIR-->
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EXCLUIR?</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir este registro?</p>
                    <small class="text-muted">Você pdoe refazê-lo na aba lançamentos do mês</small>
                </div>
                <div class="modal-footer">
                    <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>


    @endif

@endsection

@section('js-content')
<script type="text/javascript">

        $(document).ready(function(){
      $("#searchinput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#searchtable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    $(function () {
    $('[data-toggle="popover"]').popover()
  });

    $('.toast').toast('show');
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

      $(function() {
    $('#historico').addClass('btn-danger');
  });


function confirm(id,ano){
    document.getElementById("excluir").href = "/historico/del/"+ id+'/'+ano; // inserir rota para o botao de deletar
}

    function edit(id,val,desc,tipo,dat,ano){
        document.getElementById("formEdit").action = "/historico/edit/"+ id+'/'+ano;
        document.getElementById("valEdit").value = val;
        document.getElementById("tipoEdit").value = tipo;
        document.getElementById("descEdit").value = desc;

        var t = document.querySelector('input[type="date"]');
        t.value = dat;
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
        //doughnut
        //Chart.defaults.global.legend.display = false;
        var ctxD = document.getElementById("doughnutChart").getContext('2d');
        var myLineChart = new Chart(ctxD, {
            width: 900,
          type: 'doughnut',
          data: {
            labels: ["Despesas com o pessoal", "Concessionárias ", "Contratos, manutenção e insumos", "Seguros e dispesas administrativas", "Fundo de Reserva","Aplicações Sindicais"],
            datasets: [{
              data: [{!! json_encode($pes[0]->pes)!!}, {!! json_encode($conc[0]->conc)!!}, {!! json_encode($ccmi[0]->ccmi)!!}, {!! json_encode($adm[0]->adm)!!},{!! json_encode($fundo[0]->fundo)!!},{!! json_encode($as[0]->sind)!!}],
              backgroundColor: ["#8B0000", "#B22222", "#F7464A ", "#FF4500", "#FF6347","#FF7F50"],
              hoverBackgroundColor: ["#c13f3f", "#e54040", "#ff6669","#ff6d38", "#ff6e54","#ff8f66"]
            }]
          },
          options: {

            responsive: true,
            legend: {
                display: true,
                position: 'right',
                labels: {
                    boxWidth: 20,
                    padding: 20
                }
            }
          }
  
        });
      
      </script>


    
@endsection