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
            <button  type="button" onclick="clear_input()" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#createModal">Novo <i class="fa fa-plus"></i></button>
            
            @foreach($regras as $re)
                <hr>
                <h3>{{$re->title}}</h3>
                <h5>{{$re->desc}}</h5>
                <h6>{{$re->reportdate}}</h6>
                <h6>{{$re->author}}</h6>
                <button class = "btn btn-light" onclick="edit('{{$re->id}}','{{$re->title}}', '{{$re->desc}}','{{$re->reportdate}}','{{$re->author}}')"  data-toggle="modal" data-target="#editModal"> <i class="fa fa-pencil"></i></button> 
                <button class = "btn btn-outline-danger"onclick="confirm('{{$re->id}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button> 
                <hr>
            @endforeach

            {{$regras->links()}}

        
    <!--MODAL CRIAR-->
    <div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">NOVA REGRA</h4>
                </div>
                <div class="modal-body">
                    <form id="formAnuncio" action="/regras" method="POST">
                        @csrf
                        <input type="text" placeholder="titulo" name="tit" id="tit" required>
                        <br>
                        <textarea row="4" placeholder="descriçao" name="desc" id="desc" required></textarea>
                        <br>
                        <input type="date" placeholder="data" name="dat" id="dat" required>
                        <br>
                        <br>
                        <input type="text" placeholder="autor" name="aut" id="aut" required>
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
                            <input type="text" placeholder="tit" name="titEdit" id="titEdit" required>
                            <br>
                            <textarea row="4" placeholder="desc" name="descEdit" id="descEdit" required></textarea>
                            <br>
                            <input type="date" placeholder="dat" name="datEdit" id="datEdit" required>
                            <br>
                            <input type="text" placeholder="aut" name="autEdit" id="autEdit" required>
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
                        <p>Cancelar Reserva?</p>
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

        function edit(id,tit,desc,dat,aut){
            document.getElementById("formEdit").action = "regras/edit/"+ id;
            document.getElementById("titEdit").value = tit;
            document.getElementById("descEdit").value = desc;
            document.getElementById("datEdit").value = dat;
            document.getElementById("autEdit").value = aut;
        }
        function confirm(id){
            document.getElementById("excluir").href = "regras/delete/"+ id;

        }
    
    </script>
</body>
</html>