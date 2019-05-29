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
        <h1 class="h2">Documentos</h1>
        <div class="mb-2">
            <button  type="button" onclick="clear_input()"class="btn btn-outline-danger btn-lg"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Documentos</li>
        </ol>
    </nav>
    <div class="card col-md-12" style="margin-bottom:20px;">
        <div class="card-body text-secondary">
            <p class="card-text"> Nesta seção você pode adicionar  e manter seguro os documentos importantes para a administração do condomínio.</p>
        </div>
    </div>


    @if($docs[0]==null)
        <div class="card alert-secondary" style="margin-bottom:20px;">
            <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Aviso</div>
            <div class="card-body">
                <p class="card-text"> Nenhum conteudo foi encontrado!</p>
            </div>
        </div>
    @endif


        <div class="card col-md-6 " style="margin-bottom:20px; border:none; background:none; float:left; max-height:490px;">
            <div class="input-group col-md-8" style="margin-top:10px; margin-bottom:10px;">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Pesquisar..." id="searchinput">
                    <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
                </div>

          <div class="card-body" style=" margin-right:30px; overflow-y: auto; ">
            <div class="row">
              <div class="col-12">
                <div class="list-group" id="listinha" role="tablist">
                    @foreach($docs as $d)
                        <a class="list-group-item  list-group-item-action"> <i class="far fa-file"></i> {{$d->doc_title}} <small class="text-muted"> ( há {{Carbon\Carbon::parse($d->created_at)->diffForHumans(date(now())) }} ) </small>
                            @if(Carbon\Carbon::parse($d->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                            <span class="badge badge-danger">NOVO</span>
                            @endif
                            <button type="button" class="btn btn-danger"style="float:right" onclick="see('{{$d->id}}')" ><i class="fa fa-arrow-right" ></i></button></a>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card col-md-6" style="margin-bottom:10px;  float:right">
                <div class="card-body text-secondary">
                <h6 class="card-text" style="float:left"> Total de arquivos:  <h4 style="float:right; color:rgba(244, 66, 66)"><b>{{count($docs)}}</b></h4></h6>
                </div>
            </div>

        <div id="info_view">
            @foreach($docs as $d)
            <div class="card col-md-6 infos" style="margin-bottom:20px; display:none;" id="{{$d->id}}">
                <div class="card-body">
                    <h5 class="card-title"><b>{{$d->doc_title}}</b> <i style="float:right" class="far fa-file"></i></h5>
                    <p class="card-text"> {{$d->doc_desc}}</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger"href="{{Storage::url($d->doc_path) }}" download>Baixar <i class="fa fa-download"></i></a>
                    <button type="button" class="btn btn-light" onclick="confirm('{{$d->id}}')" data-toggle="modal" data-target="#deleteModal">Excluir</button>
                </div>
            </div>
            @endforeach
        </div>

<!-- MODAL EXCLUIR-->
<div class="modal fade" id="deleteModal" role="dialog"> <!-- Antes de excluir exibe um modal mensagem de confirmação-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EXCLUIR?</h4>
            </div>
            <div class="modal-body">
                    <p>Tem certeza que deseja excluir o documento selecionado?</p>
            </div>
            <div class="modal-footer">
                <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
</div>

<!--MODAL CRIAR-->
<div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">NOVO DOCUMENTO</h4>
                </div>
                <div class="modal-body">
                    <form id="formDoc"action="/documentos" enctype="multipart/form-data" method="POST"> 
                        @csrf
                        <div class="form-group">
                            <label for="doc_title" >Título</label>
                            <input type="text" class="form-control"name="doc_title" id="doc_title" placeholder="adicione um titulo.." required>
                        </div>
                        <div class="form-group">
                            <label for="doc_desc" >Descrição</label>
                        <textarea rows="4" class="form-control"name="doc_desc" id="doc_desc" placeholder="adicione uma descrição..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="file" >Arquivo</label>
                            <input  class="form-control" type="file" name="file" id="file" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formDoc"class="btn btn-danger">Salvar</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
        $("#listinha a").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    $('.toast').toast('show');
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

      $(function() {
    $('#documentos').addClass('btn-danger');
  });

        function clear_input(){
        document.getElementById("doc_title").value = "";
        document.getElementById("doc_desc").value = "";
        document.getElementById("file").value = "";

    }

    function see(id) {
        var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
        document.getElementById(id).style.display = "inline-block"; //revela o id com informações adicionais.
    };
    
    function confirm(id){
        document.getElementById("excluir").href = href="/documentos/del/"+ id; //preencher o link do botão com a url+id do documento que sera excluido
    };


</script>
    
@endsection