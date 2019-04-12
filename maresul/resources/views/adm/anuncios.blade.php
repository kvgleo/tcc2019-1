<html>
<head>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div id='app'>
<h2> Logado como administrador </h2>
<h5> Olá {{ Auth::user()->email }} </h5>

<a href="/a/h">Voltar</a>
<h1>ANUNCIAMENTOS/COMUNICADOS</h1>
<button  type="button" onclick="clear_input()" class="btn btn-danger" data-toggle="modal" data-target="#createModal">Novo anuncio</button>


@foreach($anuncios as $a)
<div>
<hr>
<button class = "btn btn-default" onclick="edit('{{$a->id}}','{{$a->title}}', '{{$a->description}}','{{$a->ps}}')"  data-toggle="modal" data-target="#editModal"> Editar</button> 
<button class = "btn btn-danger"onclick="confirm('{{$a->id}}')" data-toggle="modal" data-target="#deleteModal">Excluir</button> 
<h3>{{$a->title}}</h3>
<p>{{$a->reportdate}}</p>
<p> {{$a->description}}</p>
<p>{{$a->ps}}</p>
<hr>
</div>
@endforeach

{{$anuncios ->links()}}

  
      
<!-- Modal EDITAR-->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">//Janela Modal2</h4>
             </div>
            <div class="modal-body">
                 <form id="formEdit" action="" method="POST" >
                    @csrf
                    <input type="text" placeholder="titulo" name="titEdit" id="titEdit">
                    <br>
                    <textarea row="4" placeholder="descriçao" name="descEdit" id="descEdit"></textarea>
                    <br>
                    <input type="text" placeholder="observações" name="obsEdit" id="obsEdit">
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
                <form id="formAnuncio" action="/a/a" method="POST">
                    @csrf
                    <input type="text" placeholder="titulo" name="tit" id="tit" required>
                    <br>
                    <textarea row="4" placeholder="descriçao" name="desc" id="desc" required></textarea>
                    <br>
                    <input type="text" placeholder="observações" name="obs" id="obs" required>
                    <br>
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
            
         
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">

    function clear_input(){
        document.getElementById("tit").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("obs").value = "";

    }

    function edit(id,tit,desc,ps){
        document.getElementById("formEdit").action = "a/e/"+ id;
        document.getElementById("titEdit").value = tit;
        document.getElementById("descEdit").value = desc;
        document.getElementById("obsEdit").value = ps;
    }
    function confirm(id){
        document.getElementById("excluir").href = "a/d/"+ id;

    }

    </script>
</body>
</html>
