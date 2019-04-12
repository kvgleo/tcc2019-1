<html>
<head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id='app'>
    <a href="/a/h">Voltar</a>
    <button type="button" onclick="clear_input()" class="btn btn-danger"data-toggle="modal" data-target="#createModal">Novo Documento</button>

    @foreach($docs as $d)
    <div>
        <h3>{{$d->doc_title}}</h3>
        <p></p> 
        <button type="button" onclick="see('{{$d->id}}')">ver</button>
        <hr>
    </div>
    @endforeach


    {{$docs ->links()}}

    <div id="info_view">
    @foreach($docs as $d) <!--informações adicionais ocultas que são reveladas com o click no botão ver-->
    
    <div id="{{$d->id}}" class="infos" style="display:none;">
        <h3>{{$d->doc_desc}}</h3>
        <button type="button"  onclick="confirm('{{$d->id}}')" class = "btn btn-danger" data-toggle="modal" data-target="#deleteModal">Excluir</button> 
        <a href="{{Storage::url($d->doc_path) }}" download>Baixar</a>
        <hr>
    </div>

    @endforeach
    </div>

<!--MODAL CRIAR-->
<div class="modal fade" id="createModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">NOVO DOCUMENTO</h4>
            </div>
            <div class="modal-body">
                <form id="formDoc"action="/a/d" enctype="multipart/form-data" method="POST"> //
                    @csrf
                    <br>
                    <input type="text" name="doc_title" id="doc_title" placeholder="adicione um titulo.." required>
                    <br>
                    <textarea row="6" name="doc_desc" id="doc_desc" placeholder="adicione uma descrição..." required></textarea>
                    <br>
                    <input  class="form-control" type="file" name="file" id="file" required>
                    <br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="formDoc"class="btn btn-danger">Salvar</button> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
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


<script src="{{ asset('js/app.js') }}"> </script>
<script type="text/javascript">

        function clear_input(){
        document.getElementById("doc_tit").value = "";
        document.getElementById("doc_desc").value = "";
        document.getElementById("file").value = "";

    }

    function see(id) {
        var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
        document.getElementById(id).style.display = "block"; //revela o id com informações adicionais.
    };
    
    function confirm(id){
        document.getElementById("excluir").href = href="/a/d/d/"+ id; //preencher o link do botão com a url+id do documento que sera excluido
    };

    </script>
</body> 
</html>