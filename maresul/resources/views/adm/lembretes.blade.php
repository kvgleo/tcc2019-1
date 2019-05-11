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
            <button  type="button" onclick="clear_input()"class="btn btn-outline-danger btn-lg"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Lembretes</li>
        </ol>
    </nav>
    <div class="card col-md-12" style="float:left; margin-bottom: 20px;">
        <div class="card-body text-secondary">
            <p class="card-text"> Anote coisas importantes que serão úteis para você no futuro.</p>
        </div>
    </div>

    @if(count($lembretes)==0)
    <div class="alert alert-secondary col-md-8 mx-auto text-muted" role="alert">
            <h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i>  Aviso</h4>
            <hr>
            <p>Nenhum conteúdo foi encontrado!</p>
        </div>
    @endif


        <div class="card col-md-6 " style="margin-bottom:20px; margin-top:-10px; background:none; border:none; float:left; ">

        <div class="input-group col-md-8" style="margin-top:10px; margin-bottom:10px;">
                <input class="form-control py-2 border-right-0 border" type="search" placeholder="Pesquisar..." id="searchinput">
                <span class="input-group-append">
                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                </span>
            </div>
          <div class="card-body" style=" max-height:490px;  overflow-y: auto;">
            <div class="row">
              <div class="col-12">
                    
                <div class="list-group" id="listinha" role="tablist">
                    @foreach($lembretes as $l)
                        <a class="list-group-item  list-group-item-action">{{$l->lemb_title}} <small class="text-muted"> ( há {{Carbon\Carbon::parse($l->created_at)->diffForHumans(date(now())) }} ) </small>
                        @if(Carbon\Carbon::parse($l->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                        <span class="badge badge-danger">NOVO</span>
                        @endif
                        <button type="button" class="btn btn-danger"style="float:right" onclick="see('{{$l->id}}')" ><i class="fa fa-arrow-right" ></i></button></a>
                        @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card col-md-6" style="margin-bottom:10px;">
                <div class="card-body text-secondary">
                <h6 class="card-text" style="float:left"> Todos lembretes:  <h6 style="float:right; color:rgba(244, 66, 66)"><b>{{count($lembretes)}}</b></h6></h6>
                </div>
            </div>
        <div id="info_view">
            @foreach($lembretes as $l)
            <div class="card col-md-6 infos" style="margin-bottom:20px; margin-top:10px;display:none;" id="{{$l->id}}">
                <div class="card-body">
                    <h5 class="card-title"><b>{{$l->lemb_title}}</b> <i style="float:right"class="fa fa-bookmark"></i></h5>
                    <hr>
                    <p class="card-text"> {!!$l->lemb_desc!!}</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="edit('{{$l->id}}','{{$l->lemb_title}}');"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></button> 
                    
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
                            <textarea rows="4" class="form-control description" placeholder="descriçao" name="descEdit" id="descEdit"></textarea>
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
                            <textarea rows="4" class="form-control description" placeholder="descriçao" name="lemb_desc" id="lemb_desc"></textarea>
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

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

<script type="text/javascript">
    tinymce.init({
    selector:'textarea.description',
    theme: 'modern',
    plugins: ['advlist autolink lists link image charmap preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
   toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
   image_advtab: true,
   templates: [
   { title: 'Test template 1', content: 'Test 1' },
   { title: 'Test template 2', content: 'Test 2' }
   ]
});

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
    $('#lembretes').addClass('btn-danger');
  });

function clear_input(){
    document.getElementById("lemb_tit").value = "";
    document.getElementById("lemb_desc").value = "";
    tinyMCE.get("lemb_desc").setContent("");

};

function confirm(id){
    document.getElementById("excluir").href = "/lembretes/del/"+ id; // inserir rota para o botao de deletar
};

  function see(id) {
    var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div de iformações para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
    document.getElementById(id).style.display = "inline-block"; //revela o id com informações adicionais.
    };


    function edit(id,tit){ //enviar campos para formulario de edição
        document.getElementById("formEdit").action = "lembretes/edit/"+ id;
        document.getElementById("titEdit").value = tit;

        var desc = {!! json_encode($lembretes)!!};

        for(i=0;i<desc.length;i++){
            if(desc[i].id == id){
                tinyMCE.get('descEdit').setContent(desc[i].lemb_desc);
            }
            }
        }


    function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}

function htmlDecode(value) {
    if (value) {
        return $('<div />').html(value).text();
    } else {
        return '';
    }
}

    

</script>
    
@endsection