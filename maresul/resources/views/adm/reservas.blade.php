@extends('adm.template.main')

@section('title-content')
<title>MAR&SUL- Reservas</title>

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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
        <h1 class="h2">Reservas</h1>
      </div>
      <nav aria-label="breadcrumb" style="margin-top:-25px;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" >Reservas</li>
            </ol>
            <div class="card" style="margin-bottom:20px;">
                    <div class="card-body text-secondary">
                        <p class="card-text"> Veja e monitore o andamento das reservas dos locais do seu condomínio.</p>
                    </div>
                </div>
          </nav>
          <div id="testetable"class="card col-md-7 " style="margin-bottom:20px; float:left; background:none; border:none; "> 
             
            <div class="input-group col-md-12" style="margin-top:10px; margin-bottom:10px;">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Pesquisar..." id="searchinput">
                    <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
                </div>
    
            <div class="card" style=" max-height:420px; overflow-y: auto; margin-top:10px;">
          <table class="table table-hover" style="">
              <thead>
                <tr>
                    <th scope="col">Local</th>
                    <th scope="col">Reservante</th>
                    <th scope="col">Registro em</th>
                    <th scope="col">Dia previsto</th>
                    <th scope="col">Status </th>
                    <th scope="col"> </th>
                </tr>
              </thead>
              <tbody>
                    @foreach($reservas as $r)
                    <tr>
                        <td scope="col">{{$r->local_targ}}</td>
                        <td scope="col">{{$r->name}}</td>
                        <td scope="col">{{date('d/m/Y', strtotime($r->created_at))}}</td>
                        <td scope="col">{{date('d/m/Y', strtotime($r->reportdate))}}</td>
                        <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                        <td scope="col"><button type="button" onclick="confirm('{{$r->id}}','{{$r->id_user}}')" class = "btn btn-link text-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button> </td>
                    </tr>
                    @endforeach


              </tbody>
            </table>
            </div>
        </div>

            <div class="card col-md-5 " style="margin-bottom:20px; border:none; background:none;">

                <div class="card col-md-12 " style=" float:left; margin-bottom: 10px;">
                <div class="card-body">
                    <h5 class="card-text" style="float:left;" > Concluídas<h2 style="float:right; color:rgba(244, 66, 66)" id="conc"> </h2> <h2 style="float:right; color:rgba(244, 66, 66); margin-right:10px;"><i class="far fa-check-square"></i> </h2></h5>
                  </div>
                  <div class="modal-footer">  {{$inicio[0]->num}} nova(s) hoje</div>
              </div>

                <div class="card col-md-12 " style="float:left; margin-bottom: 10px;">
                  <div class="card-body" >
                      <h5 class="card-text"style="float:left;" >  Pendentes <h2 style="float:right; color:rgba(244, 66, 66)" id="pen"></h2> <h2 style="float:right; color:rgba(244, 66, 66); margin-right:10px;"><i class="far fa-clock"></i> </h2> </h5>
                  </div>
                  <div class="modal-footer"> {{$fim[0]->num}} encerrada(s) hoje</div>
                </div>

                      
                  <div class="card col-md-12" >
                      <div class="card-body">
                          <h5 class="card-title"> <i style="float:right; color:rgba(244, 66, 66);"class="fa fa-chart-pie"></i></h5>
                          <canvas id="myChart" style="max-width: 370px;"></canvas>
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
                        <p>Tem certeza que deseja excluir o lembrete selecionado?</p>
                    </div>
                    <div class="modal-footer">
                        <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('js-content')

<script type="text/javascript">

    
    $(document).ready(function(){
      $("#searchinput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#testetable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });



          $(function() {
    $('#reservas').addClass('btn-danger');
  });

    $('#conc').each(function () { //animação de contar
    $(this).prop('Counter',0).animate({
        Counter: {!! json_encode($conc[0]->num)!!}
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

    $('#pen').each(function () { //animação de contar
    $(this).prop('Counter',0).animate({
        Counter: {!! json_encode($pen[0]->num)!!}
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

    $('.toast').toast('show');

$('#close').click(function(){
    $("#toast").remove();
});

    function confirm(id,id2){

        document.getElementById("excluir").href = "/reservas/del/"+ id+'/'+id2; // inserir rota para o botao de deletar
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>

    Chart.defaults.global.legend.display = false;
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Quadra", "Pátio", "Salão I", "Salão II"],
        datasets: [{
          label: '',
          data: [{!! json_encode($quadra[0]->num)!!},{!! json_encode($patio[0]->num)!!},{!! json_encode($salao1[0]->num)!!},{!! json_encode($salao2[0]->num)!!}],
          backgroundColor: [
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)'
          ],
          borderColor: [
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)',
            'rgba(244, 66, 66)'
          ],
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  
      </script>
    
@endsection