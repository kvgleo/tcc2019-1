@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Despesas</title>

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
        <h1 class="h2">Despesas</h1>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Despesas</li>
        </ol>
    </nav>


    <div class="card col-md-5 " style="margin-bottom:20px; float:left; background:none; border:none;  ">
        <div class="card">
            <div class="card-header"> 
                <h2 class="card-title"> Formulário de Lançamentos</h2>
            </div>
            <div class="card-body" style="max-height:430px; overflow-y: auto;">
                
                <form class="form-group" id="despForm" action="/despesas" method="post">
                    @csrf
                    <div class="form-group row col-sm-12">
                            <label for="dia" > Data</label>
                            <input type="date"  class="form-control" id="dia" name="reportdate" required>
                        </div>

                    <div class="form-group row col-sm-12">
                            <label for="desc" > Descrição</label>
                                <textarea rows="4" type="text" step=".01" min="0" placeholder="descrição..." class="form-control" id="desc" name="desc" required></textarea>
                        </div>

                        <div class="form-group row col-sm-12">
                                <label for="valor" > Valor</label>     
                        <input type="number"  onkeydown="return event.keyCode !== 69"  maxlength="15" step=".01" min="0" class="form-control" id="valor" name="valor" placeholder="valor..." required>
                            </div>

                        <div class="form-group row col-sm-12" >
                                <label for="tipo" >Tipo</label>
                                <div class="input-group">
                                    <select class="form-control" name="tipo"  id="tipo" required>
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
                <button form="despForm" type="submit" class="btn btn-danger">Enviar <i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>

    <div class="card col-md-7 " style="margin-bottom:20px; border:none; background:none;">

        <div class="card col-md-12 " style=" float:left; margin-bottom: 10px;">
            <div class="card-body text-secondary">
                <h2 class="card-title">Guia Básico</h2>
                <p class="card-text"> Adicione as despesas do meses nesta seção, preencha o formulario de forma correta com a data que corresponde o mês do registro.</p>
                <p class="card-text"> Os registro mensais dos formulários podem ser acessados na aba de histórico bem como suas remoções, só é permitdo 1 registro por mês, veja abaixo algumas instruções:</p>
                <p class="card-text">
                    <ul>
                        <li> 
                            No formulário, voce deve informar a data atual referente ao mês que deseja adicionar o relatório de gastos. Por exemplo: se a data for 01/01/2019 o relatório corresponde à janeiro de 2019.
                        </li>
                        <li>
                            Não é permitido adicionar outro relatório cuja data tenha o mesmo mês e ano que um relatório já postado.
                        </li>
                        <li>
                            Você pode verificar os meses do ano que não possuem relatórios na aba histórico, informados como "pendentes".
                        </li>
                        <li>
                            Você pode remover um relatório na aba historico e faze-lo novamente.
                        </li>
                    </ul>
                </p>
            </div>
        </div>

            <div class="card col-md-12 " style=" float:left; margin-bottom: 10px;">
                <div class="card-body">
                        @if(count($lancamentos) == null)
                            <div class="card alert" style="margin-bottom:20px;">
                                <div class="card-body">
                                        <h5 class="card-title text-left"> Último relatório:  </h5>
                                        <h5 class="card-text text-right text-muted"> (INDEFINIDO)  </h5>
                                </div>
                            </div>
                        @else
                    <h5 class="card-text" style="float:left;" > Último relatório: 
                                <h2 style="float:right; color:rgba(244, 66, 66)" id="conc">  {{Date::parse($lancamentos[0]->reportdate)->format('M , Y') }} </h2> 
                    </h5>
                    @endif
                </div>
                </div>
    </div>

   


@endsection

@section('js-content')
<script type="text/javascript">

    $('.toast').toast('show');
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

      $(function() {
    $('#despesas').addClass('btn-danger');
  });


$(function () {
    $('[data-toggle="popover"]').popover()
  })

</script>
    
@endsection