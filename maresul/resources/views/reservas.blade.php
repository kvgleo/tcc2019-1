<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id='app'>
            <a href="/home">Voltar</a><br>
            <button type="button" class="btn btn-primary" onclick="see('l1')">Quadra de Esportes</button>
            <button type="button" class="btn btn-primary" onclick="see('l2')">Pátio Interno</button>
            <button type="button" class="btn btn-primary" onclick="see('l3')">Salão de Festas I</button>
            <button type="button" class="btn btn-primary" onclick="see('l4')">Salão de Festas II</button>
            @if ($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            @if(Session::has('success'))
                <div class="alert-box success">
                        <div class="alert alert-success">{{ Session::get('success') }}</div> 
                </div>
            @endif

            <div id="info_view">
                <div id="l1"class="infos">
                    <h1>LOCAL 1</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Local</th>
                                <th scope="col">Agendado por </th>
                                <th scope="col">Registrado em </th>
                                <th scope="col">Para o dia </th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $r)
                            <tr>
                                @if($r->local_targ =='quadra')
                                <th scope="row">Quadra de Esportes</th>
                                <td scope="col">{{$r->name}}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->reportdate))}}</td>
                                <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                @if(Auth::user()->id==$r->id_user)
                                    <td scope="col"><a href="reservas/del/{{$r->id}}/{{$r->id_user}}"class="btn btn-danger"><i class="fa fa-trash"></i></a> </td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5> </h5>
                    <form id="form1" action="/reservas" method="post">
                        @csrf
                        <input name="local" type="hidden" value="quadra">
                        <input name="dia" type="date">
                        <button type="submit" form="form1" class="btn btn-success">Agendar</button>
                    </form>
                </div>

                <div  id="l2" class="infos" style="display:none;">
                    <h1>LOCAL 2</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Local </th>
                                <th scope="col">Agendado por  </th>
                                <th scope="col">Registrado em </th>
                                <th scope="col">Para o dia </th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $r)
                            <tr>
                                @if($r->local_targ =='patio')
                                <th scope="row">Pátio Interno</th>
                                <td scope="col">{{$r->name}}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->reportdate))}}</td>
                                <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                @if(Auth::user()->id==$r->id_user)
                                    <td scope="col"><a href="reservas/del/{{$r->id}}/{{$r->id_user}}"class="btn btn-danger"><i class="fa fa-trash"></i></a> </td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form id="form2" action="/reservas" method="post">
                        @csrf
                        <input name="local" type="hidden" value="patio">
                        <input name="dia" type="date">
                        <button type="submit" form="form2" class="btn btn-success">Agendar</button>
                    </form>
                </div>

                <div  id="l3" class="infos" style="display:none;">
                    <h1>LOCAL 3</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Local </th>
                                <th scope="col">Agendado por </th>
                                <th scope="col">Registrado em </th>
                                <th scope="col">Para o dia </th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $r)
                            <tr>
                                @if($r->local_targ =='sfestas1')
                                <th scope="row">Salão de Festas I</th>
                                <td scope="col">{{$r->name}}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->reportdate))}}</td>
                                <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                @if(Auth::user()->id==$r->id_user)
                                    <td scope="col"><a href="reservas/del/{{$r->id}}/{{$r->id_user}}"class="btn btn-danger"><i class="fa fa-trash"></i></a> </td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form id="form3" action="/reservas" method="post">
                        @csrf
                        <input name="local" type="hidden" value="sfestas1">
                        <input name="dia" type="date">
                        <button type="submit" form="form3" class="btn btn-success">Agendar</button>
                    </form>
                </div>

                <div  id="l4" class="infos" style="display:none;">
                    <h1>LOCAL 4</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Local </th>
                                <th scope="col">Agendado por </th>
                                <th scope="col">Registrado em </th>
                                <th scope="col">Para o dia </th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $r)
                            <tr>
                                @if($r->local_targ =='sfestas2')
                                <th scope="row">Salão de Festas II</th>
                                <td scope="col">{{$r->name}}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td scope="col">{{date('d-m-Y', strtotime($r->reportdate))}}</td>
                                <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                @if(Auth::user()->id==$r->id_user)
                                    <td scope="col"><a href="reservas/del/{{$r->id}}/{{$r->id_user}}"class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form id="form4" action="/reservas" method="post">
                        @csrf
                        <input name="local" type="hidden" value="sfestas2">
                        <input name="dia" type="date">
                        <button type="submit" form="form4" class="btn btn-success">Agendar</button>
                    </form>
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
    
    </script>
</body>
</html>