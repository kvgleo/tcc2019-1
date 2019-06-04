@extends('layout_user')


@section('title-content')
    <title> MAR AZUL - Forum Virtual</title>
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
<div class="row">
<main role="main" class="col-md-2   col-lg-2 " style="padding-top:25px; padding-bottom:25px;">
</main>
<main role="main" class="col-md-8   col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
    <h1 class="h2 text-secondary">{{$top->top_titulo}}</h1>
    <a href="/forum" class="btn btn-link"> <i class="fa fa-chevron-left"></i> Voltar</a>
</div>
<nav aria-label="breadcrumb" style="margin-top:-25px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
        <li class="breadcrumb-item "><a href="/forum">Forum </a></li> 
        <li class="breadcrumb-item "><a href="{{route('categoria', ['id' => $top->id_cat])}}">  @foreach($categorias as $c) @if($c->id == $cat->id) {{$c->nome}} @endif @endforeach </a></li>
        <li class="breadcrumb-item text-secondary ">{{$top->top_titulo}} </li>
    </ol>
</nav>

<div class="row">

    <div  class="card col-md-12 " style="float:left; border:none; background:none; border:none; "> 
            <div class="card" style=" background:none; border:none; margin-top:10px;">
    
                
                <div class="card  col-md-12"  style="border: none; margin-bottom: 30px;">
                    <div class="row no-gutters">
    
                        @if($top->admin_post==false)
                       
                        <div class="col-md-3">
                            <div class="card-body">
                                <img src="{{Storage::url('user_img/userpic.png') }}" class="img-thumbnail card-img" alt="..." style="margin-bottom:5px;">
                            <p class="card-text" style="text-align:center"> {{$user->name}} </p>
                                <p class="card-text text-muted" style="text-align:center">Apto Nº {{$user->apto}} </p>
                                <small><p class="text-muted" style="text-align:center">{{$user->email}} </p></small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <p class="card-title text-secondary"> 
                                    <b> <i class="fa fa-quote-left"></i> {{$top->top_titulo}}</b>
                                    @if($top->status_top ==false)
                                    <span class="badge badge-success">ABERTO <i class="fa fa-unlock"></i></span>
                                     @else 
                                    <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span>
                                     @endif
                                
                                </p>
                                <hr>
                                <small class="text-muted">
                                    <i class="fa fa-eye"></i> {{$top->top_views}} visitas | 
                                    <i class="far fa-thumbs-up"></i>  {{$top->votos}} votos |
                                    <i class="far fa-clock"></i> há {{Carbon\Carbon::parse($top->created_at)->diffForHumans(date(now())) }} 
                                    @if ($user->id == Auth::user()->id)
                                    | <button type="button" class="btn btn-link btn-sm text-primary" onclick="edit('{{$top->top_titulo}}','{{$top->id_cat}}','{{$top->id}} ','{{route('edit_top', ['id' => $top->id])  }}')" data-toggle="modal" data-target="#editModal">  editar <i class="fa fa-pen"></i></button> | 
                                    <button type="button" class="btn btn-link btn-sm text-primary" onclick="confirm('{{route('del_top', ['id' => $top->id])  }}')" data-toggle="modal" data-target="#deleteModal"> excluir <i class="fa fa-trash"></i></button>
                                    @endif
                                    @foreach($categorias as $c) @if($c->id == $cat->id) | {{$c->nome}} @endif @endforeach
                                </small>
                                    
                                <br>
                                <br>
                                <p class="card-text text-secondary">
                                       {!!$top->artigo!!}
                                </p>
                            </div>
                        </div>
                        
                        @else
                            <!-- ADMIN A PARTIR DAQUI -------------------------------------------------------------- -->
                        <div class="col-md-12 ">
                                <small><p class="text-right card-text text-muted" style="margin-top:5px;"> 
                                    
                                
                                    </p></small>
                        </div>
                        <div class="col-md-3">
                            <div class="card-body">
                                <img src="{{Storage::url('user_img/adminpic.png') }} " class="mx-auto img-thumbnail" width="100" height="100" style="display:block; margin-bottom:5px;">
                                <p class="card-text text-primary" style="text-align:center"> {{$admin->name}} </p>
                                <small><p class="text-muted" style="text-align:center">{{$admin->email}} </p></small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <p class="card-title text-secondary"> 
                                    <b> <i class="fa fa-quote-left"></i> {{$top->top_titulo}}</b>
                                    @if($top->status_top ==false)
                                    <span class="badge badge-success">ABERTO <i class="fa fa-unlock"></i></span>
                                     @else 
                                    <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span>
                                     @endif
                                </p>
                                <hr>
                               <small class="text-muted">
                                    <i class="fa fa-eye"></i> {{$top->top_views}} visitas | 
                                    <i class="far fa-thumbs-up"></i> {{$top->votos}} votos |
                                    <i class="far fa-clock"></i> há {{Carbon\Carbon::parse($top->created_at)->diffForHumans(date(now())) }} 
                               </small>
                                <br>
                                <br>
                                <p class="card-text text-secondary">
                                        {!!$top->artigo!!}
                                </p>
                            </div>
                        </div>
    
                        @endif
                      
                    </div>
                    <div class="modal-footer">
                        @if ($top->status_top == false) <button type="button" onclick="show()" class="btn btn-lg btn-primary">Responder</button> @else  <button type="button" class="btn btn-lg btn-primary" disabled>Responder</button> @endif
                    </div>
                </div>
            <!-- CARD-->   
    
            @if ($top->status_top == false)

            <div id="comment" class="card col-md-12" style="margin-bottom:20px; " hidden>
                <div class="card-body">
                    <p class="card-title text-secondary h4"><b> Envie uma resposta </b></p>
                    <form id="cForm" action="/forum/comentario/{{$top->id}}" class="form-group" method="POST">
                        @csrf
                        <textarea rows="8" class="form-control description" name="msg" placeholder="envie seu comentário..."></textarea>
                        <small><p class="text-muted card-text"> pulicar como {{Auth::user()->name}} </p></small>
                    </form>
                        <button type="submit" form="cForm" class="btn btn-primary btn-lg float-right"> Enviar </button>
                </div>
    
            </div>
            @endif
            <h1 class="h2 text-secondary">Respostas @if(count($comentarios)==0) (0) @else  <p style="display:inline"> ({{ count($comentarios) }}) </p> @endif</h1>
            <hr>
                
                    @if(count($comentarios)==0)
                    <div class="card alert-primary" style="margin-bottom:20px;">
                        <div class="card-header"> <i class="fa fa-exclamation-circle"></i> Nenhum comentário!</div>
                        <div class="card-body">
                            <p class="card-text"> O tópico não possui comentários ainda, seja o primeiro a interagir deixando um comentário na caixa de texto acima. </p>
                        </div>
                    </div>
                    @else
                        @foreach($comentarios as $co)
                            @if($co->admin_c == true)
                            <div class="card col-md-12" style="margin-bottom:20px;">
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            <img src="{{Storage::url('user_img/adminpic.png') }}" class="mx-auto img-thumbnail" width="100" height="100" style="display:block; margin-bottom:5px;">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">  <b class="text-primary"> {{$co->author}} </b> <small> -  há {{Carbon\Carbon::parse($co->created_at)->diffForHumans(date(now())) }}  </small></h6>
                                            <p class="card-text text-secondary">
                                                    {!!$co->mensagem!!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="card col-md-9" style="margin-bottom:20px;">
                                    <div class="row no-gutters">
                                        <div class="col-md-2">
                                            <div class="card-body col-md-12">
                                                <img src="{{Storage::url('user_img/userpic.png') }}" class="mx-auto img-thumbnail card-img" style="display:block; margin-bottom:5px;">
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">  <b> {{$co->author}} </b> <small> -  há {{Carbon\Carbon::parse($co->created_at)->diffForHumans(date(now())) }}  </small> 
                                                    @if($co->author == Auth::user()->name)
                                                        <button class="btn btn-link float-right " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <button type="button" onclick="editC('{{route('edit_comment', ['id' => $co->id,'id_top' => $top->id])  }}','{{$co->id}}')" class="dropdown-item"  data-toggle="modal" data-target="#editComment">Editar</button>
                                                            <button type="button" onclick="delC('{{route('del_comment', ['id' => $co->id,'id_top' => $top->id])  }}')" class="dropdown-item"  data-toggle="modal" data-target="#delComment">Excluir</button>
                                                        </div>
                                                    @endif
                                                </h6>
                                                <p class="card-text text-secondary">
                                                        {!!$co->mensagem!!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    
                
            </div>
        </div>
       
       
</main>

<main role="main" class=" card col-md-2  col-lg-2" style=" border:none; background:none; padding-top:65px; padding-bottom:25px; ">
    <div class="card-body">
        <h5 class="card-text text-secondary"> <i class="fa fa-exclamation-circle"></i> Regras! </h5>
        <HR>
        <p class="card-text text-secondary">O uso do espaço coletivo permite você expor suas ideias e opiniões mas lembre-se de manter o respeito e ética com os demais membros, o tópio/mensagens podem ser removidas ou editadas pela moderação caso for necessário!</p>
        <div class="alert alert-primary">
            Se você precisar de resposta dos administradores, aguarde até que sua duvida seja respondida!
        </div>
    </div>
</main>

</div>


<!-- modal delete comment -->

<div class="modal fade" id="delComment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EXCLUIR?</h4>
            </div>
            <div class="modal-body">
                <p>Remover o seu comentário?</p>              
            </div>
            <div class="modal-footer">
                <a id="excluirC" href="" class="btn btn-primary">EXCLUIR</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
<!-- modal edit comment-->

<div class="modal fade" id="editComment" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR COMENTÁRIO?</h4>
                </div>
                <div class="modal-body">
                        <p class="card-text">Comentário: </p>
                    <form id="editC" action="" class="form-group" method="POST">
                        @csrf
                        <textarea id="msgC" rows="5" class="form-control description" name="msg" ></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editC" class="btn btn-primary float-right"> SALVAR </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>
<!-- delete modal -->

<div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EXCLUIR?</h4>
                </div>
                <div class="modal-body">
                    <p>Remover este Tópico?</p>
                        <small class="text-primary"> <i class="fa fa-exclamation-circle"></i> Ao remover este tópico, você irá excluir todos os comentários atrelados a ele. </small>
                    
                </div>
                <div class="modal-footer">
                    <a id="excluir" href="" class="btn btn-primary">EXCLUIR</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>

<!-- edit modal-->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR TÓPICO</h4>
                </div>
                <div class="modal-body">
                        <form id="editForm" method="POST" action="/forum/topico">
                            @csrf
                            <div class="form-group">
                                <label for="editTit">Título</label>
                                <input id="editTit" type="text" class="form-control" name="editTit"  placeholder="adicionar título..." required>
                            </div>
                            <div class="form-group" >
                                <label for="editCat" >Categoria</label>
                                    <select class="form-control" name="editCat"  id="editCat" required>
                                        <option hidden class="text-secondary">--Categoria--</option>
                                            @foreach($categorias as $cat)
                                                <option>{{$cat->nome}}</option>
                                            @endforeach 
                                    </select>
                                
                            </div>
                            <div class="form-group">
                                <label for="editDesc">Discussão</label>
                                <textarea rows="7" id="editDesc"  class="form-control description" name="editDesc" placeholder="adicione a discussão..."></textarea>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                        <button form="editForm" type="submit" class="btn btn-primary">SALVAR</button> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>


@endsection



@section('js-content')

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

<script type="text/javascript">

    function editC(str,id){
        document.getElementById("editC").action  = str;
        var desc = {!! json_encode($comentarios)!!};
    
        for(i=0;i<desc.length;i++){
            if(desc[i].id == id){
                tinyMCE.get('msgC').setContent(desc[i].mensagem);
            } 
        }
    }

    function show(){
        var x = document.getElementById("comment");
        x.removeAttribute("hidden");
    }
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

$('#close').click(function(){
    $("#toast").remove();
});

function delC(str){
    document.getElementById("excluirC").href = str;
}
    function confirm(str){
        document.getElementById("excluir").href = str;

    }

       function edit(tit,cat,id,str){
        document.getElementById("editForm").action = str;
        document.getElementById("editTit").value = tit;

        var categoria =  {!! json_encode($categorias)!!};

        for(i=0;i<categoria.length;i++){
            
            if(categoria[i].id == cat){
                document.getElementById("editCat").value = categoria[i].nome;
            }
        }
        
        var desc = {!! json_encode($topicos)!!};
    
        for(i=0;i<desc.length;i++){
            if(desc[i].id == id){
                tinyMCE.get('editDesc').setContent(desc[i].artigo);
            }
               
        }
    }


    </script>
    
@endsection