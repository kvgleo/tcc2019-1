<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id='app'>
        <a href="/a/h"class="btn btn-link">Voltar</a>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert"><h2>{{$errors->first()}}</h2></div>
        @endif
            @if(Session::has('success'))
            <div class="alert-box success">
                    <div class="alert alert-success">{{ Session::get('success') }}</div> 
            </div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Local</th>
                    <th scope="col">Agendado por</th>
                    <th scope="col">Registrado em</th>
                    <th scope="col">Para o dia </th>
                    <th scope="col">Status </th>
                    <th scope="col"> </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $r)
                <tr>
                    <td scope="col">{{$r->local_targ}}</td>
                    <td scope="col">{{$r->name}}</td>
                    <td scope="col">{{date('d-m-Y', strtotime($r->created_at))}}</td>
                    <td scope="col">{{date('d-m-Y', strtotime($r->reportdate))}}</td>
                    <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                <td scope="col"><button type="button" onclick="confirm('{{$r->id}}','{{$r->id_user}}')" class = "btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i></button> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$reservas->links()}}
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


    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        function see(id) {
        var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div de iformações para ficar oculta
            for(i=0;i<x.length;i++){
                x[i].style.display = "none";
            }
        document.getElementById(id).style.display = "block"; //revela o id com informações adicionais.
        };

        function confirm(id,id_user){
            document.getElementById("excluir").href = 'reservas/del/'+id+'/'+id_user;
        };
    
    </script>
</body>
</html>