<html>
<head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id='app'>
    <a href="/a/h">Voltar</a>
    <button type="button" onclick="clear_input()" class="btn btn-danger"data-toggle="modal" data-target="#createModal">Novo Lembrete</button>

@foreach($lembretes as $l)
    <div>
    <hr>
    <h3>{{$l->lemb_title}}</h3>
    <button type="button" onclick="see('{{$l->id}}')">ver</button>
    <hr>
    </div>
@endforeach
{{$lembretes ->links()}}

<div id="info_view">
    @foreach($lembretes as $l) <!--informações adicionais ocultas que são reveladas com o click no botão ver-->

    <div id="{{$l->id}}" class="infos" style="display:none;">
        <h3>{{$l->lemb_title}}</h3>
        <h3>{{$l->lemb_desc}}</h3>
        <button class = "btn btn-default" onclick="edit('{{$l->id}}','{{$l->lemb_title}}', '{{$l->lemb_desc}}')"  data-toggle="modal" data-target="#editModal"> Editar</button> 
        <button type="button"  onclick="confirm('{{$l->id}}')" class = "btn btn-danger" data-toggle="modal" data-target="#deleteModal">Excluir</button> 
        <hr>
    </div>
    @endforeach
</div>

<!-- Modal EDITAR-->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EDITAR LEMBRETE</h4>
             </div>
            <div class="modal-body">
                 <form id="formEdit" action="" method="POST" >
                    @csrf
                    <input type="text" placeholder="titulo" name="titEdit" id="titEdit">
                    <br>
                    <textarea row="4" placeholder="descriçao" name="descEdit" id="descEdit"></textarea>
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
                <p>Tem certeza que deseja excluir o Lembrete selecionado?</p>
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
            <h4 class="modal-title">NOVO LEMBRETE</h4>
            </div>
            <div class="modal-body">
                <form id="formLem" action="/a/le" method="POST">
                    @csrf
                    <input type="text" placeholder="titulo" name="lemb_tit" id="lemb_tit" required>
                    <br>
                    <textarea row="4" placeholder="descriçao" name="lemb_desc" id="lemb_desc" required></textarea>
                    <br>
                </form>
                
            </div>
            <div class="modal-footer">
                <button form="formLem"type="submit" class="btn btn-danger">Salvar</button> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">

function clear_input(){
    document.getElementById("lemb_tit").value = "";
    document.getElementById("lemb_desc").value = "";

}

function confirm(id){
    document.getElementById("excluir").href = "/a/le/d/"+ id; //EDITAR ROTA
}

  function see(id) {
    var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div de iformações para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
    document.getElementById(id).style.display = "block"; //revela o id com informações adicionais.
    };

    function edit(id,tit,desc,ps){
        document.getElementById("formEdit").action = "/a/le/e/"+ id; //EDITAR
        document.getElementById("titEdit").value = tit;
        document.getElementById("descEdit").value = desc;
    }

</script>
</body>
</html>