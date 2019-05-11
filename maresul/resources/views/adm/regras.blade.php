
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
    <h1 class="h2">Regras de Convivência</h1>
    <div class="mb-2">
        <button  type="button" onclick="clear_input()"class="btn btn-outline-danger btn-lg"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
    </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active " >Regras de Convivência</li>
        </ol>
    </nav>
    <div class="card col-md-12" style="float: left; margin-bottom:20px; margin-right: 15px; ">
        <div class="card-body text-secondary">
            <p class="card-text"> Publique as regras do condomínio aqui, elas ficaram disponíveis para os usuários do portal.</p>
        </div>
    </div>
    
    <form id="searchForm" action="{{route('buscar_regra')}}" method="GET">
            <div class="input-group col-md-8 mx-auto" style="margin-top:10px; margin-bottom:10px;  margin-left:-15px;">
                  <input class="form-control py-2" type="search" placeholder="Pesquisar..." name="buscar" style="height:50px;">
                  <span class="input-group-append">
                    <button class="btn btn-outline-secondary" form="searchForm"type="submit" >
                        <i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>

          
        @if(!empty($src))
        <div class="input-group col-md-8 mx-auto text-muted" style="margin-top:10px; margin-bottom:10px;">
        <h2>Resultado da busca: {{$regras->total()}} encontrado(s).</h2>
        </div>
    @endif

    @if($regras[0]==null)
    <div class="alert alert-secondary col-md-8 mx-auto text-muted" role="alert">
            <h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i>  Aviso</h4>
            <hr>
            <p>Nenhum conteúdo foi encontrado!</p>
        </div>
    @endif



          <div id="accordion" class="col-md-8 mx-auto">
            @foreach($regras as $re)
                <div class="card" style="margin-bottom:10px;">
                    <div class="card-header" id="a{{$re->id}}">
                        <h5>
                            <i class="fa fa-shield-alt"></i>
                            <b>{{$re->title}}</b>
                            @if(Carbon\Carbon::parse($re->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                            <span class="badge badge-danger">NOVO</span>
                            @endif
                            <button class="btn btn-link collapsed" style="font-size:20px;color: #e24646; float:right"data-toggle="collapse" data-target="#c{{$re->id}}" aria-expanded="false" aria-controls="{{$re->id}}"><i class="fa fa-angle-down"></i></button>  
                        </h5>
                        <small class="text-muted"> ( há {{Carbon\Carbon::parse($re->created_at)->diffForHumans(date(now())) }} ) </small>
                    </div>
                    <div id="c{{$re->id}}" class="collapse" aria-labelledby="ac{{$re->id}}" data-parent="#accordion">
                        <div class="card-body">
                            <p class="text-right"> <button type="button" class="btn btn-primary btn-sm"><i class="fab fa-facebook-f"></i></button>  <button type="button" class="btn btn-success btn-sm"><i class="fab fa-whatsapp"></i></button>  <button type="button" class="btn btn-info btn-sm"><i class="fab fa-twitter"></i></button></p>
                            <p class="card-text">{!!$re->desc!!}</p>
                            <footer class="blockquote-footer"> assinado por {{$re->author}},  pauta autorizada em {{date('d-m-Y', strtotime($re->reportdate))}}</footer>
                        </div>
                    </div>
                    <div id="c{{$re->id}}" class="collapse" aria-labelledby="ac{{$re->id}}" data-parent="#accordion">
                        <div class="modal-footer">
                            <a id="editar" href="" class="btn btn-light btn-sm" onclick="edit('{{$re->id}}','{{$re->title}}', '{{$re->reportdate}}','{{$re->author}}','{{route('regras_edit', ['id' => $re->id])}}')"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></a>
                            <button type="button" class="btn btn-danger btn-sm"onclick="confirm('{{route('regras_del', ['id' => $re->id])}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$regras->links()}}

        </div>

        


<!--MODAL CRIAR-->
<div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">NOVA REGRA</h4>
                </div>
                <div class="modal-body">
                    <form id="formAnuncio"action="/regras" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tit" >Título</label>
                            <input type="text" class="form-control"  placeholder="nome da regra" name="tit" id="tit" required>
                            
                        </div>
                        <div class="form-group">
                            <label for="desc" >Descrição</label>
                            <textarea rows="4" class="form-control description" placeholder="detalhes e condições" name="desc" id="desc" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dat" >Data do encaminhamento</label>
                            <input type="date" class="form-control" placeholder="data de criação" name="dat" id="dat" required>
                        </div>
                        <div class="form-group">
                            <label for="aut" >Assinante</label>
                            <input type="text" class="form-control" placeholder="nome do autor" name="aut" id="aut" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="formAnuncio"type="submit" class="btn btn-danger">ADICIONAR</button> 
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
                    <h4 class="modal-title">EDITAR REGRA </h4>
                </div>
                <div class="modal-body">
                    <form id="formEdit" action="" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="titEdit" >Título</label>
                        <input type="text" class="form-control"placeholder="nome da regra" name="titEdit" id="titEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="descEdit" >Descrição</label>
                        <textarea row="4" class="form-control description" placeholder="detalhes e condições" name="descEdit" id="descEdit" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="datEdit" >Data</label>
                        <input type="date" class="form-control"placeholder="data de criação" name="datEdit" id="datEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="autEdit" >Autor</label>
                        <input type="text" class="form-control" placeholder="nome do autor" name="autEdit" id="autEdit" required>
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
                        <p>Remover a regra desejada?</p>
                    </div>
                    <div class="modal-footer">
                        <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    </div>
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


    $('.toast').toast('show');
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

      $(function() {
    $('#regras').addClass('btn-danger');
  });

    function clear_input(){
    document.getElementById("tit").value = "";
    document.getElementById("dat").value = "";
    document.getElementById("aut").value = "";
    tinyMCE.get('desc').setContent("");
    }

    function edit(id,tit,dat,aut,str){
        document.getElementById("formEdit").action = str;
        document.getElementById("titEdit").value = tit;
        document.getElementById("datEdit").value = dat;
        document.getElementById("autEdit").value = aut;

        var desc = {!! json_encode($regras)!!};
        
    
        for(i=0;i<desc.data.length;i++){
            if(desc.data[i].id == id){
                tinyMCE.get('descEdit').setContent(desc.data[i].desc);
            }
                //tinyMCE.get('descEdit').setContent(desc[i].desc);
            
        }
    }


    function confirm(str){
        document.getElementById("excluir").href = str;

    }

</script>
    
@endsection