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
        <h1 class="h2">{{$top->top_titulo}}</h1>
        <div class="mb-2">
        </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" ><a href="/forum">Fórum</a></li>
            <li class="breadcrumb-item active" > {{$top->top_titulo}}</li>
        </ol>
    </nav>

    <div id="testetable" class="card col-md-8 " style="float:left; background:none; border:none; "> 
        <div class="card" style=" background:none; border:none; margin-top:10px;">

            
            <div class="card  col-md-12"  style="margin-bottom: 30px;">
                <div class="row no-gutters">

                    @if($top->admin_post==false)
                    <div class="col-md-12 ">
                            <small><p class="text-right card-text text-muted" style="margin-top:5px;"> 
                                <i class="fa fa-eye"></i> {{$top->top_views}} visitas | 
                                <i class="far fa-thumbs-up"></i> 337 votos |
                                <i class="far fa-clock"></i> há 2 horas  | 
                                <button type="button" class="btn btn-link btn-sm text-danger" onclick="edit('{{$top->top_titulo}}','{{$top->id_cat}}','{{$top->id}} ','{{route('edit_top', ['id' => $top->id])  }}')" data-toggle="modal" data-target="#editModal">  editar <i class="fa fa-pen"></i></button> | 
                                <button type="button" class="btn btn-link btn-sm text-danger" onclick="confirm('{{route('del_top', ['id' => $top->id, 'id_user' => Auth::user()->id])  }}')" data-toggle="modal" data-target="#deleteModal"> excluir <i class="fa fa-trash"></i></button> | 
                                <button type="button" class="btn btn-link btn-sm text-danger"  data-toggle="modal" data-target="#closeModal">  fechar <i class="fa fa-lock"></i></button> 
                            
                                </p></small>
                    </div>
                    <div class="col-md-3">
                        <div class="card-body">
                            <img src="{{Storage::url('user_img/userpic.png') }}" class="mx-auto img-thumbnail" width="100" height="100" style="display:block; margin-bottom:5px;">
                        <p class="card-text" style="text-align:center"> {{$user->name}} </p>
                            <p class="card-text text-muted text-center" >Apto Nº {{$user->apto}} </p>
                            <small><p class="text-muted text-center" >{{$user->email}} </p></small>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <p class="card-title"> <b> <i class="fa fa-quote-left"></i> {{$top->top_titulo}}</b>
                                @if($top->status_top ==false)
                                <span class="badge badge-success">ABERTO <i class="fa fa-unlock"></i></span>
                                 @else 
                                <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span>
                                 @endif
                            </p>
                            <hr>
                            <h6 class="card-subtitle mb-2 text-muted"> <small>por <b> {{$user->name}}</b> , postado em 21/05/2019 -  <b> {{$cat->nome}}</b></small></h6>
                            <br>
                            <p class="card-text text-secondary">{!!$top->artigo!!}</p>
                            
                        </div>
                    </div>
                    @else

                    <div class="col-md-12 ">
                            <small><p class="text-right card-text text-muted" style="margin-top:5px;"> 
                                <i class="fa fa-eye"></i> {{$top->top_views}} visitas | 
                                <i class="far fa-thumbs-up"></i> 337 votos |
                                <i class="far fa-clock"></i> há 2 horas  | 
                                <button type="button" class="btn btn-link btn-sm text-danger" onclick="edit('{{$top->top_titulo}}','{{$top->id_cat}}','{{$top->id}} ','{{route('edit_top', ['id' => $top->id])  }}')" data-toggle="modal" data-target="#editModal">  editar <i class="fa fa-pen"></i></button> | 
                                <button type="button" class="btn btn-link btn-sm text-danger"  onclick="confirm('{{route('del_top', ['id' => $top->id,'id_user' => Auth::user()->id])}}')" data-toggle="modal" data-target="#deleteModal"> excluir <i class="fa fa-trash"></i></button> | 
                                <button type="button" class="btn btn-link btn-sm text-danger"  data-toggle="modal" data-target="#closeModal">  fechar <i class="fa fa-lock"></i></button> 
                            
                                </p></small>
                    </div>
                    <div class="col-md-3">
                        <div class="card-body">
                            <img src="https://image.flaticon.com/icons/png/512/21/21294.png" class="mx-auto img-thumbnail" width="100" height="100" style="display:block; margin-bottom:5px;">
                        <p class="card-text text-danger" style="text-align:center"> {{$admin->name}} </p>
                            <small><p class="text-muted" style="text-align:center">{{$admin->email}} </p></small>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <p class="card-title"> <b> <i class="fa fa-quote-left"></i> {{$top->top_titulo}}</b>
                                @if($top->status_top ==false)
                                <span class="badge badge-success">ABERTO <i class="fa fa-unlock"></i></span>
                                 @else 
                                <span class="badge badge-secondary">FECHADO <i class="fa fa-lock"></i></span>
                                 @endif
                            </p>
                            <hr>
                            <h6 class="card-subtitle mb-2 text-muted"> <small>por <b class="text-danger"> {{$admin->name}}</b> , postado em 21/05/2019 -  <b> {{$cat->nome}}</b></small></h6>
                            <br>
                            <p class="card-text text-secondary">
                                    {!!$top->artigo!!}
                            </p>

                        </div>
                    </div>

                    @endif
                  
                </div>
            </div>
        <!-- CARD-->   

        @if ($top->status_top == false)

        <div class="card col-md-12" style="margin-bottom:20px; ">
            <div class="card-body">
                <p class="card-title h4"><b> Responder tópico? </b></p>
                <form action="#" class="form-group" method="POST">
                    @csrf
                    <textarea rows="5" class="form-control description" placeholder="envie seu comentário..."></textarea>
                    <small><p class="text-muted card-text"> pulicar como nome_user</p></small>
                </form>
                    <button type="submit" class="btn btn-danger float-right"> Responder </a>
            </div>

        </div>
        @endif

        <h1 class="h2 text-secondary">Respostas (42)</h1>
        <hr>
            
            <div class="card col-md-12" style="max-height:420px; overflow-y: auto; background:none; border:none;">

                <div class="card col-md-12" style="margin-bottom:20px;">
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <div class="card-body">
                                <img src="{{Storage::url('user_img/userpic.png') }}" class="mx-auto img-thumbnail" width="80" height="80" style="display:block; margin-bottom:5px;">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><small> Resposta por <b> USUARIO </b> , em 21/05/2019 -  </small></h6>
                                <br>
                                <p class="card-text text-secondary">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="card col-md-4 " style="margin-bottom:20px; border:none; background:none;">
        <div class="card col-md-12 " style="margin-bottom: 10px;">
            <div class="card-body">
                <h5 class="card-text"> Regras! </h5>
                <HR>
                <p class="card-text">O uso do espaço coletivo permite você expor suas ideias e opiniões mas lembre-se de manter o respeito e ética com os demais membros, o tópio/mensagens podem ser removidas ou editadas pela moderação caso for necessário!</p>
                <div class="alert alert-primary">
                    Se você precisar de resposta dos administradores, aguarde até que sua duvida seja respondida!
                </div>
            </div>
        </div>
    </div>


    <!-- modal close-->

<div class="modal fade" id="closeModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">MARCAR COMO "ENCERRADO"?</h4>
            </div>
            <div class="modal-body">
                <p>Deseja marcar o tópico como "encerrado"?</p>
                <small class="text-danger"><i class="fa fa-exclamation-circle"></i> Ao encerrar o tópico, não será possível postagem de comentários nele.</small>
              
            </div>
            <div class="modal-footer">
                <a  href="{{route('close_top',['id' => $top->id])}} " class="btn btn-danger">ENCERRAR</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
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
                    <p>Remover esta tópico?</p>
                    <small class="text-danger"><i class="fa fa-exclamation"></i> Aoremover este tópico, você irá excluir todos os comentários atrelados à ele.</small>
                  
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
                        <button form="editForm"type="submit" class="btn btn-danger">SALVAR</button> 
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




    $('.toast').toast('show');

    $('#close').click(function(){
        $("#toast").remove();
    });

    function confirm(str){
        document.getElementById("excluir").href = str;

    }

</script>

    
@endsection
