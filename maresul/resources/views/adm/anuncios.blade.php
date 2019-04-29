
@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Anúncios/Comunicados</title>
@endsection
@section('warn-content')

@if(Session::has('msg'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-success" role="alert" data-autohide="false" style="margin-top:7rem;">
            <div class="toast-body alert-success"><i class="fa fa-check-circle mr-2"></i>{{ Session::get('msg') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif
@if(Session::has('avs'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-danger" role="alert" data-autohide="false" style="margin-top:7rem;">
            <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i>{{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif

@endsection
@section('main-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
    <h1 class="h2">Anúncios e Comunicados</h1>
    <div class="mb-2">
        <button  type="button" onclick="clear_input()"class="btn btn-outline-danger"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
    </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Anúncios e Comunicados</li>
        </ol>
    </nav>
    <div class="card" style="margin-bottom:20px;">
        <div class="card-body text-secondary">
            <p class="card-text"> Nesta seção você pode adicionar cominucados gerais que serão exibidos para usuários do portal, para começar clique no botão de adição no canto superior direito.</p>
        </div>
    </div>
    @if($anuncios[0]==null)
        <div class="card alert-secondary" style="margin-bottom:20px;">
            <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Aviso</div>
            <div class="card-body">
                <p class="card-text"> Nenhum conteudo foi adicionado ainda! Para ver mais informações nesta página, adicione um novo tópico no menu secundário clicando no botão de adição no canto superior direito.</p>
            </div>
        </div>
    @endif

          <div id="accordion" >
            @foreach($anuncios as $a)
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header" id="a{{$a->id}}">
                        <h3 class="mb-0">
                            <i class="fa fa-paperclip"></i>
                            <b>{{$a->title}}</b>
                            <button class="btn btn-link collapsed" style="font-size:20px;color: #e24646; float:right"data-toggle="collapse" data-target="#c{{$a->id}}" aria-expanded="false" aria-controls="{{$a->id}}"><i class="fa fa-angle-down"></i></button>  
                        </h3>
                        <small class="text-muted">  postado em {{date('d/m/Y', strtotime($a->reportdate))}}</small>
                    </div>
                    <div id="c{{$a->id}}" class="collapse" aria-labelledby="ac{{$a->id}}" data-parent="#accordion">
                        <div class="card-body">
                            <p>{{$a->description}}</p>
                            <div class="card" style="margin-bottom:20px;">
                                <div class="card-body text-secondary">
                                <p class="card-text text-muted">{{$a->ps}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="c{{$a->id}}" class="collapse" aria-labelledby="ac{{$a->id}}" data-parent="#accordion">
                        <div class="modal-footer">
                            <a id="editar" href="" class="btn btn-light" onclick="edit('{{$a->id}}','{{$a->title}}', '{{$a->description}}','{{$a->ps}}')"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></a>
                            <button type="button" class="btn btn-danger"onclick="confirm('{{$a->id}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$anuncios->links()}} 
        </div>



<!-- Modal EDITAR-->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EDITAR ANUNCIO</h4>
             </div>
            <div class="modal-body">
                 <form id="formEdit" action="" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="titEdit">Título</label>
                        <input type="text" class="form-control" placeholder="adicione um titulo" name="titEdit" id="titEdit">
                    </div>
                    <div class="form-group">
                        <label for="descEdt">Descrição</label>
                        <textarea rows="4" class="form-control" placeholder="adicione uma descriçao" name="descEdit" id="descEdit"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="obsEdit">Oservações</label>
                    <textarea rows="4" class="form-control" placeholder="adicione observações" name="obsEdit" id="obsEdit"> </textarea>
                    </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="formEdit"class="btn btn-danger">Salvar</button>
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <p>Tem certeza que deseja excluir o anuncio selecionado?</p>
            </div>
            <div class="modal-footer">
                <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
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
            <h4 class="modal-title">NOVO ANUNCIO</h4>
            </div>
            <div class="modal-body">
                <form id="formAnuncio" action="/anuncios" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tit">Título</label>
                        <input type="text" class="form-control" placeholder="adicione um titulo" name="tit" id="tit" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Descrição</label>
                        <textarea rows="4" class="form-control" placeholder="descriçao" name="desc" id="desc" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="obs">Oservações</label>
                        <textarea rows="4" class="form-control" placeholder="adicione observações" name="obs" id="obs"> </textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="formAnuncio"type="submit" class="btn btn-danger">Salvar</button> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
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
    $('#anuncios').addClass('btn-danger');
  });

    function clear_input(){
        document.getElementById("tit").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("obs").value = "";

    }

    function edit(id,tit,desc,ps){
        document.getElementById("formEdit").action = "anuncios/edit/"+ id;
        document.getElementById("titEdit").value = tit;
        document.getElementById("descEdit").value = desc;
        document.getElementById("obsEdit").value = ps;
    }
    function confirm(id){
        document.getElementById("excluir").href = "anuncios/del/"+ id;

    }

    </script>
    
@endsection