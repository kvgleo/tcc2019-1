@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Regras de Convivência</title>

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
        <h1 class="h2">Lembretes</h1>
        <div class="mb-2">
            <button  type="button" onclick="clear_input()"class="btn btn-outline-danger"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Lembretes</li>
        </ol>
    </nav>
    <div class="card" style="margin-bottom:20px;">
        <div class="card-body text-secondary">
            <p class="card-text"> Nesta seção você pode adicionar anotações importantes para evitar esquecimentos.</p>
        </div>
    </div>
    @if($lembretes[0]==null)
        <div class="card alert-secondary" style="margin-bottom:20px;">
            <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Aviso</div>
            <div class="card-body">
                <p class="card-text"> Nenhum conteudo foi adicionado ainda! Para ver mais informações nesta página, adicione um novo tópico no menu secundário clicando no botão de adição no canto superior direito.</p>
            </div>
        </div>
    @endif


        <div class="card col-md-6 " style="margin-bottom:20px; background:none; border:none; float:left; max-height:520px; margin-right:30px; overflow-y: auto; ">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="list-group" id="listinha" role="tablist">
                    @foreach($lembretes as $l)
                        <a class="list-group-item  list-group-item-action">{{$l->lemb_title}} <button type="button" class="btn btn-danger"style="float:right" onclick="see('{{$l->id}}')" ><i class="fa fa-arrow-right" ></i></button></a>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
          {{$lembretes ->links()}}
        </div>

        <div id="info_view">
            @foreach($lembretes as $l)
            <div class="card col-md-5 infos" style="margin-bottom:20px; display:none;" id="{{$l->id}}">
                <div class="card-body">
                    <h5 class="card-title"><b>{{$l->lemb_title}}</b> <i style="float:right"class="fa fa-bookmark"></i></h5>
                    <p class="card-text"> {{$l->lemb_desc}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="edit('{{$l->id}}','{{$l->lemb_title}}', '{{$l->lemb_desc}}')"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></button> 
                    <button type="button" class="btn btn-outline-danger" onclick="confirm('{{$l->id}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            @endforeach
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
    <!-- Modal EDITAR-->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR NOTA</h4>
                 </div>
                <div class="modal-body">
                     <form id="formEdit" action="" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="titEdit" >Título</label>
                            <input type="text" class="form-control"placeholder="titulo para lembrar-se" name="titEdit" id="titEdit">
                        </div>
                        <div class="form-group">
                            <label for="descEdit">Descrição</label>
                            <textarea rows="4" class="form-control" placeholder="descriçao" name="descEdit" id="descEdit"></textarea>
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
    <!--MODAL CRIAR-->
    <div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">NOVA NOTA</h4>
                </div>
                <div class="modal-body">
                    <form id="formLem" action="/lembretes" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="lemb_tit" >Título</label>
                            <input type="text" class="form-control" placeholder="assunto para lembrar-se" name="lemb_tit" id="lemb_tit" required>
                        </div>
                        <div class="form-group">
                            <label for="lemb_desc" >Descrição</label>
                            <textarea rows="4" class="form-control"placeholder="descriçao" name="lemb_desc" id="lemb_desc" required></textarea>
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button form="formLem"type="submit" class="btn btn-danger">ADICIONAR</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
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
    $('#lembretes').addClass('btn-danger');
  });

function clear_input(){
    document.getElementById("lemb_tit").value = "";
    document.getElementById("lemb_desc").value = "";

}

function confirm(id){
    document.getElementById("excluir").href = "/lembretes/del/"+ id; // inserir rota para o botao de deletar
}

  function see(id) {
    var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div de iformações para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
    document.getElementById(id).style.display = "inline-block"; //revela o id com informações adicionais.
    };

    function edit(id,tit,desc,ps){
        document.getElementById("formEdit").action = "lembretes/edit/"+ id; //insere no form a action de editar
        document.getElementById("titEdit").value = tit;
        document.getElementById("descEdit").value = desc;
    }

</script>
    
@endsection