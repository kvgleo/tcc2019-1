
@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Ajuda</title>
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
    <h1 class="h2">Perguntas Frequentes</h1>
    <div class="mb-2">
        <button  type="button" onclick="clear_input()"class="btn btn-outline-danger btn-lg"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
    </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Perguntas Frequentes</li>
        </ol>
    </nav>
    <div class="card col-md-12" style="margin-bottom:20px; ">
        <div class="card-body text-secondary">
            <p class="card-text"> Nesta seção você pode adicionar as respostas para as maiores dúvidas recorridas, e que serão exibidas para os usuários no portal, para começar clique no botão de adição no canto superior direito.</p>
        </div>
    </div>

    <form id="searchForm" action="{{route('buscar_ajuda')}}" method="GET">
            <div class="input-group col-md-8 mx-auto" style="margin-top:10px; margin-bottom:10px;">
                  <input class="form-control py-2" type="search" placeholder="Pesquisar..." name="buscar" style="height:50px;">
                  <span class="input-group-append">
                    <button class="btn btn-outline-secondary" form="searchForm"type="submit" >
                        <i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>

          
        @if(!empty($src))
            <div class="input-group col-md-8 text-muted mx-auto" style="margin-top:10px; margin-bottom:10px;">
            <h2>Resultado da busca: {{$perguntas->total()}} encontrado(s).</h2>
            </div>
        @endif

    @if($perguntas[0]==null)
    <div class="alert alert-secondary col-md-8 mx-auto text-muted" role="alert">
        <h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i>  Aviso</h4>
        <hr>
        <p>Nenhum conteúdo foi encontrado!</p>
    </div>
    @endif

          <div id="accordion" class=" col-md-8 mx-auto">
            @foreach($perguntas as $p)
                <div class="card" style="margin-bottom:10px;">
                    <div class="card-header" id="a{{$p->id}}">
                        <h5>
                            <i class="fa fa-question-circle"></i>
                            <b>{{$p->question}}</b>
                            @if(Carbon\Carbon::parse($p->created_at)->startOfDay()==Carbon\Carbon::now()->startOfDay())
                            <span class="badge badge-danger">NOVO</span>
                            @endif
                            <button class="btn btn-link collapsed" style="font-size:20px;color: #e24646; float:right"data-toggle="collapse" data-target="#c{{$p->id}}" aria-expanded="false" aria-controls="{{$p->id}}"><i class="fa fa-angle-down"></i></button>  
                        </h5>
                        <small class="text-muted"> ( há {{Carbon\Carbon::parse($p->created_at)->diffForHumans(date(now())) }} ) </small>
                    </div>
                    <div id="c{{$p->id}}" class="collapse" aria-labelledby="ac{{$p->id}}" data-parent="#accordion">
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted">Resposta: </small></p>
                            <p>{!!$p->answer!!}</p>
                            <footer class="blockquote-footer"> criado em {{date('d-m-Y', strtotime($p->created_at))}}</footer>
                        </div>
                    </div>
                    <div id="c{{$p->id}}" class="collapse" aria-labelledby="ac{{$p->id}}" data-parent="#accordion">
                        <div class="modal-footer">
                            <a id="editar" href="" class="btn btn-light" onclick="edit('{{$p->id}}','{{$p->question}}', '{{route('pergunta_edit', ['id' => $p->id])}}')"  data-toggle="modal" data-target="#editModal"><i class="fa fa-pen"></i></a>
                            <button type="button" class="btn btn-danger"onclick="confirm('{{route('pergunta_del', ['id' => $p->id])}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$perguntas->links()}} 

        </div>






        



<!--MODAL CRIAR-->
<div class="modal fade " id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">NOVA INFO</h4>
                </div>
                <div class="modal-body">
                    <form id="formAnuncio"action="/ajuda" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="perg" >Pergunta</label>
                            <input type="text"  class="form-control"placeholder="duvida pertinente" name="perg" id="perg" required>
                        </div>
                        <div class="form-group">
                            <label for="resp" >Resposta</label>
                            <textarea rows="4" placeholder="resposta justificativa" class="form-control description" name="resp" id="resp" ></textarea>
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
                    <h4 class="modal-title">EDITAR PERGUNTA/RESPOSTA </h4>
                </div>
                <div class="modal-body">
                    <form id="formEdit" action="" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="pergEdit" >Pergunta</label>
                        <input type="text"  class="form-control"placeholder="duvida pertinente" name="pergEdit" id="pergEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="respEdit" >Resposta</label>
                        <textarea rows="4" placeholder="resposta justificativa" class="form-control description" name="respEdit" id="respEdit"></textarea>
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

    <p><strong>oi</strong></p>
 <p><em><span style="color: #33cccc;">asdasdasdasdasd</span></em></p>

 <p><em><span style="color: #33cccc;"><img src="https://cloud.tinymce.com/stable/plugins/emoticons/img/smiley-smile.gif" alt="smile" />
    <img src="https://cloud.tinymce.com/stable/plugins/emoticons/img/smiley-kiss.gif" alt="kiss" />
<img src="https://cloud.tinymce.com/stable/plugins/emoticons/img/smiley-kiss.gif" alt="kiss"/>
</span></em></p>

<p><span style="color: #00ffff; background-color: #33cccc;">ad<img src="https://cloud.tinymce.com/stable/plugins/emoticons/img/smiley-undecided.gif" alt="undecided" /></span></p>
    
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

    $('.toast').toast('show');//mostrar toast
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

    $(function() {
    $('#ajuda').addClass('btn-danger'); //indicar página ativa
    });


    function clear_input(){ //limpar campos
    document.getElementById("perg").value = "";
    tinyMCE.get('resp').setContent("");
    }

    function edit(id,perg,str){ //enviar campos para formulario de edição

        document.getElementById("formEdit").action = str;
        document.getElementById("pergEdit").value = perg;
        var desc = {!! json_encode($perguntas)!!};
        
    
        for(i=0;i<desc.data.length;i++){
            if(desc.data[i].id == id){
                tinyMCE.get('respEdit').setContent(desc.data[i].answer);
            }
            
        }

    }
    function confirm(str){
        document.getElementById("excluir").href = str; //enviar id para botão de remoção

    }

</script>
    
@endsection