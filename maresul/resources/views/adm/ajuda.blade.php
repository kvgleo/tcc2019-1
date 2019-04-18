<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id='app'>
        <a href="/a/h"class="btn btn-link">Voltar</a>
        @if(Session::has('msg'))
            <div class="alert-box success">
                    <div class="alert alert-success">{{ Session::get('msg') }}</div> 
            </div>
        @endif
        @if(Session::has('avs'))
            <div class="alert-box success">
                    <div class="alert alert-warning">{{ Session::get('avs') }}</div> 
            </div>
        @endif

        @if($perguntas[0]==null)
            <h1>Não há conteudo nesta seção até o momento</h1>
        @endif
        <button  type="button" onclick="clear_input()" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#createModal">Novo <i class="fa fa-plus"></i></button>
        
        @foreach($perguntas as $p)
            <hr>
            <h3>{{$p->question}}</h3>
            <h5>{{$p->answer}}</h5>
            <button class = "btn btn-light" onclick="edit('{{$p->id}}','{{$p->question}}', '{{$p->answer}}')"  data-toggle="modal" data-target="#editModal"> <i class="fa fa-pencil"></i></button> 
            <button class = "btn btn-outline-danger"onclick="confirm('{{$p->id}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button> 
            <hr>
        @endforeach

        {{$perguntas->links()}}

    

    <!--MODAL CRIAR-->
    <div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">NOVA REGRA</h4>
                </div>
                <div class="modal-body">
                    <form id="formAnuncio" action="/ajuda" method="POST">
                        @csrf
                        <label for="perg" >Pergunta</label>
                        <input type="text" class="form-control"placeholder="titulo" name="perg" id="perg" required>
                        <br>
                        <label for="resp" >Resposta</label>
                        <textarea row="4"class="form-control" placeholder="descriçao" name="resp" id="resp" required></textarea>
                        <br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="formAnuncio"type="submit" class="btn btn-danger">Adicionar</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL EDITAR-->
    <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR PERGUNTA </h4>
                     </div>
                    <div class="modal-body">
                         <form id="formEdit" action="" method="POST" >
                            @csrf
                            <label for="pergEdit" >Pergunta</label>
                            <input type="text"  class="form-control"placeholder="pergunta" name="pergEdit" id="pergEdit" required>
                            <br>
                            <label for="respEdit" >Resposta</label>
                            <textarea row="4" placeholder="desc" class="form-control" name="respEdit" id="respEdit" required></textarea>
                            <br>
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
                        <p>Excluir pergunta?</p>
                    </div>
                    <div class="modal-footer">
                        <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">

        function clear_input(){
        document.getElementById("tit").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("dat").value = "";
        document.getElementById("aut").value = "";
        }

        function edit(id,perg,resp){
            document.getElementById("formEdit").action = "ajuda/edit/"+ id;
            document.getElementById("pergEdit").value = perg;
            document.getElementById("respEdit").value = resp;

        }
        function confirm(id){
            document.getElementById("excluir").href = "ajuda/delete/"+ id;

        }
    
    </script>
</body>
</html>