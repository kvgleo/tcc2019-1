@extends('adm.template.main')

@section('title-content')
    <title> MAR AZUL - Fórum Virtual</title>
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
        <h1 class="h2">Fórum Virtual</h1>
        <div class="mb-2">
            <button  type="button" class="btn btn-outline-danger btn-lg" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Fórum</li>
        </ol>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body text-secondary">
                <p class="card-text">Comunidade online</p>
            </div>
        </div>
    </nav>

    <div id="testetable" class="card col-md-8 " style="margin-bottom:20px; float:left; background:none; border:none; "> 
        <div class="input-group col-md-12" style="margin-top:10px; margin-bottom:10px;">
            <input class="form-control py-2 border-right-0 border" type="search" placeholder="Pesquisar..." id="searchinput">
            <span class="input-group-append">
                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
            </span>
        </div>
        <div class="card" style=" background:none; border:none; max-height:420px; overflow-y: auto; margin-top:10px;">

            @foreach($topicos as $top)
            <div class="card  col-md-12"  style="margin-bottom: 10px;">
                <div class="row no-gutters">
                    <div class="col-md-2">
                        <div class="card-body">
                            <img src="{{Storage::url('banner/topic.png') }}" class="img-thumbnail card-img" alt="...">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                             <h5 class="card-title">@if($top->status_top == false) <span class="badge badge-danger">ABERTO <i class="fa fa-unlock"></i> </span> @else  <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span> @endif <b>{{$top->top_titulo}} </b> </h5>
                            <h6 class="card-subtitle mb-2 text-muted"> <small>por @if($top->admin_post==false)<b> {{$top->author}} </b> @else <b class="text-danger"> {{$top->author}} </b> @endif , postado em 21/05/2019 -  <b>{{$top->cat}} </b></small></h6>
                            <p class="card-text text-muted">
                                <i class="fa fa-eye"></i> {{$top->top_views}} visitas |
                                <i class="far fa-thumbs-up"></i> 337 votos |
                                <i class="far fa-comments"></i> 86 respostas |
                                <i class="far fa-clock"></i> há 2 horas   
                                
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body">
                           
                            <a href="/forum/topico/{{$top->id}} " style="margin-top:20px" class="btn btn-danger">Entrar <i class="fa fa-angle-right"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- CARD-->   
        @endforeach
        </div>
    </div>
    <div class="card col-md-4 " style="margin-bottom:20px; border:none; background:none;">
        <div class="card col-md-12 " style="margin-bottom: 10px; border:none; background:none;">
            <div class="card-body">
                <h5 class="card-text"> Categorias </h5>
                <HR>
                <ul class="list-group list-group-flush">
                    @foreach($categorias as $cat)
                        <li class="list-group-item">
                            <a href="#" class="text-danger" data-trigger="hover" data-boundary="window" data-toggle="popover" data-placement="left" data-content="{{$cat->cat_desc}}">{{$cat->nome}} </a> 
                            <button type="button" onclick="confirm('{{route('del_cat', ['id' => $cat->id])}}')" style="float: right;" class="btn btn-link btn-sm text-danger" data-toggle="modal" data-target="#deleteModal"> <i class="fa fa-times"></i></button>
                            <button type="button" onclick="edit('{{$cat->nome}}','{{$cat->cat_desc}}','{{route('edit_cat', ['id' => $cat->id])}}')" style="float: right;"  class="btn btn-link btn-sm text-secondary"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


<!-- MODAL CREATE-->
<div class="modal fade" id="createModal" role="dialog" >
    <div class="modal-dialog" >
        <div class="modal-content" >
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="topm" data-toggle="tab" href="#top_model" role="tab" aria-controls="top_tab" aria-selected="true">Tópico</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="catm" data-toggle="tab" href="#cat_modal" role="tab" aria-controls="cat_tab" aria-selected="false">Categoria</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="top_model" role="tabpanel" aria-labelledby="top_tab">
                    <div class="modal-header">
                        <h4 class="modal-title">NOVO TÓPICO</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formTop" method="POST" action="/forum/topico">
                            @csrf
                            <div class="form-group">
                                <label for="top_tit">Título</label>
                                <input id="top_tit" type="text" class="form-control" name="top_tit"  placeholder="adicionar título..." required>
                            </div>
                            <div class="form-group" >
                                <label for="top_cat" >Categoria</label>
                                <div class="input-group">
                                    <select class="form-control" name="top_cat"  id="top_cat" required>
                                        <option hidden class="text-secondary">--Categoria--</option>
                                            @foreach($categorias as $cat)
                                                <option>{{$cat->nome}}</option>
                                            @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="top_desc">Discussão</label>
                                <textarea rows="7" id="top_desc"  class="form-control description" name="artigo" placeholder="adicione a discussão..." required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button form="formTop"type="submit" class="btn btn-danger">Criar</button> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="cat_modal" role="tabpanel" aria-labelledby="cat_tab">
                    <div class="modal-header">
                        <h4 class="modal-title">NOVA CATEGORIA</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formCat" method="POST" action="/forum/cat">
                            @csrf
                            <div class="form-group">
                                <label for="cat_nome" >Nome</label>
                                <input id="cat_nome" type="text" class="form-control" name="cat_nome"  placeholder="nome da categoria" required>
                            </div>
                            <div class="form-group">
                                <label for="cat_desc" >Descrição</label>
                                <textarea rows="4" id="cat_desc"  class="form-control" name="cat_desc" placeholder="adicionar breve descrição" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button form="formCat"type="submit" class="btn btn-danger">Adicionar</button> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- modal delete -->

<div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EXCLUIR?</h4>
                </div>
                <div class="modal-body">
                    <p>Remover esta categoria?</p>
                    <div class="alert alert-danger" role="alert">
                        Ao remover esta categoria, você irá excluir todos os tópicos/comentários atrelados à ela.
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>

        <!--MODAL EDITAR-->
        <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">EDITAR CATEGORIA</h4>
                        </div>
                        <div class="modal-body">
                            <form id="formEdit" action="" method="POST" >
                            @csrf
                            <div class="form-group">
                                    <label for="edit_cat_nome" >Nome</label>
                                    <input id="edit_cat_nome" type="text" class="form-control" name="edit_cat_nome"  placeholder="nome da categoria" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_cat_desc" >Descrição</label>
                                    <textarea rows="4" id="edit_cat_desc"  class="form-control" name="edit_cat_desc" placeholder="adicionar breve descrição" required></textarea>
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


$(function () {
    $('[data-toggle="popover"]').popover()
  });
    
    $(document).ready(function(){
      $("#searchinput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#testetable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

          $(function() {
    $('#forum').addClass('btn-danger');
  });

  
  function edit(tit,desc,str){
        document.getElementById("formEdit").action = str;
        document.getElementById("edit_cat_nome").value = tit;
        document.getElementById("edit_cat_desc").value = desc;
    }



    $('.toast').toast('show');

    $('#close').click(function(){
        $("#toast").remove();
    });

    function confirm(str){
        document.getElementById("excluir").href = str;

    }

</script>

    
@endsection