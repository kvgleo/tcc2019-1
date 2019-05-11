@extends('layout_user')


@section('title-content')
<title>MARESUL- Regras de Convivência</title>

@endsection
@section('warn-content')

@if(Session::has('msg'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-success" role="alert" data-autohide="false"  style="margin-top:2rem;">
            <div class="toast-body alert-success"><i class="fa fa-check-circle mr-2"></i>{{ Session::get('msg') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
    </div>
@endif

@if(Session::has('avs'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-danger" role="alert" data-autohide="false"  style="margin-top:2rem;">
            <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i> {{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button></div>
        </div>
</div>
@endif

@endsection
@section('main-content')

    <main role="main" class="col-md-12  mx-auto col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
            <h1 class="h2 text-secondary">Reservas</h1>
            <a href="/home" class="btn btn-link"> <i class="fa fa-chevron-left"></i> Voltar</a>
        </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
            <li class="breadcrumb-item active" ><a class="text-muted"href="/reservas"> Reservas</a> </li>
        </ol>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body text-secondary">
                <p class="card-text"> Caro condôminio, clique nos botões dos locais abaixo para acessar a lista de reservas de cada local. Lembre-se que datas de reservas não podem ser iguais às datas já existentes para cada local.</p>
                <footer class="blockquote-footer"> att, Equipe Condominal </footer>
            </div>
        </div>
    </nav>

    <main role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">

        <!-- botoes-->

        <div class="card col-md-2 " style="margin-bottom:20px;  float:left; border:none;  overflow-y: auto; ">
            <div class="form-group" style="margin-top:5px;"> 
                <button type="button" class="btn btn-primary btn-lg form-control"onclick="see('l1')">Quadra</button>
            </div>
            <div class="form-group"> 
                <button type="button" class="btn btn-primary btn-lg form-control"onclick="see('l2')">Pátio</button>
            </div>
            <div class="form-group"> 
                    <button type="button" class="btn btn-primary btn-lg form-control"onclick="see('l3')">Salão I</button>
                </div>
            <div class="form-group"> 
                    <button type="button" class="btn btn-primary btn-lg form-control"onclick="see('l4')">Salão II</button>
                </div>
        </div>

        <!-- cards-->


        <div class="card col-md-3 " style=" float:left; margin-bottom:20px;  border:none;">

            <div class="card col-md-12 " style="height:370px;" id="ll1">
                <div class="card-body">
                    <img id="img"src="{{Storage::url('res_imgs/quadra.jpg') }}" style="width:150px; height:90px; margin-bottom:10px;">
                    <h5 class="card-title"><b  id="title_local">Quadra de Esportes</b></h5>
                    <p class="card-text" id="desc_local">Reserve a quadra se você busca um dia para praticar esportes com os amigos ou atividades físicas!</p>
                </div>
                <div class="modal-footer" id="nota_local"> Nota:  <i class='fa fa-star' style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;''></i> <i class='fa fa-star' style='color:grey'></i>  </div>
            </div>
        </div>

    <!-- table-->

    <div class="card col-md-7 " style="margin-bottom:20px;height:370px; border:none; max-height:370px;  overflow-y: auto;" >
            <div id="info_view">

                

                <!--infos-->
                    <div id="l1"class="infos">
                        <h1>QUADRA
                            <form id="form1" class="form-inline" action="/reservas" method="post" style="float:right;">
                                @csrf
                                <input name="local" type="hidden" value="quadra">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input name="dia" class="form-control" type="date" style="float:left;" id="dia">
                                </div>
                                <button type="submit" form="form1" class="btn btn-success mb-2">Agendar</button>
                            </form> 
                        </h1>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Local </th>
                                    <th scope="col">Reservante </th>
                                    <th scope="col">Registro em</th>
                                    <th scope="col">Dia previsto </th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservas as $r)
                                <tr>
                                    @if($r->local_targ =='quadra')
                                    <th scope="row">Quadra </th>
                                    <td scope="col">{{$r->name}}</td>
                                    <td scope="col">{{date('d/m/Y', strtotime($r->created_at)) }}</td>
                                    <td scope="col">{{date('d/m/Y', strtotime($r->reportdate))}}</td>
                                    <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                    @if(Auth::user()->id==$r->id_user)
                                        <td scope="col"><button type="button" class="btn btn-link"onclick="confirm('{{$r->id}}','{{$r->id_user}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button></td>
                                    @else 
                                        <td></td>
                                    @endif
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- ------ -->

                    <div  id="l2" class="infos" style="display:none;">
                            <h1>PÁTIO
                            <form id="form2" class="form-inline" action="/reservas" method="post" style="float:right;">
                                @csrf
                                <input name="local" type="hidden" value="patio">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input name="dia" class="form-control" type="date" id="dia">
                                </div>
                                <button type="submit" form="form2" class="btn btn-success mb-2">Agendar</button>
                            </form> </h1>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Local </th>
                                        <th scope="col">Reservante </th>
                                        <th scope="col">Registro em</th>
                                        <th scope="col">Dia previsto </th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservas as $r)
                                    <tr>
                                        @if($r->local_targ =='patio')
                                        <th scope="row">Pátio</th>
                                        <td scope="col">{{$r->name}}</td>
                                        <td scope="col">{{date('d/m/Y', strtotime($r->created_at)) }}</td>
                                        <td scope="col">{{date('d/m/Y', strtotime($r->reportdate))}}</td>
                                        <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                        @if(Auth::user()->id==$r->id_user)
                                            <td scope="col"><button type="button" class="btn btn-link"onclick="confirm('{{$r->id}}','{{$r->id_user}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button></td>
                                        @else 
                                            <td></td>
                                        @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- -->

                        <div  id="l3" class="infos" style="display:none;">
                                <h1 id="salao1"> SALÃO I
                                    <form id="form3" class="form-inline" action="/reservas" method="post" style="float:right;">
                                        @csrf
                                        <input name="local" type="hidden" value="sfestas1">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input name="dia" class="form-control" type="date"  id="dia">
                                        </div>
                                        <button type="submit" form="form3" class="btn btn-success mb-2">Agendar</button>
                                    </form>

                                 </h1>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Local </th>
                                            <th scope="col">Reservante </th>
                                            <th scope="col">Registro em</th>
                                            <th scope="col">Dia previsto </th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservas as $r)
                                        <tr>
                                            @if($r->local_targ =='sfestas1')
                                            <th scope="row">Salão I</th>
                                            <td scope="col">{{$r->name}}</td>
                                            <td scope="col">{{date('d/m/Y', strtotime($r->created_at)) }}</td>
                                            <td scope="col">{{date('d/m/Y', strtotime($r->reportdate))}}</td>
                                            <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído" : "pendente" }}</th>
                                            @if(Auth::user()->id==$r->id_user)
                                            <td scope="col"><button type="button" class="btn btn-link"onclick="confirm('{{$r->id}}','{{$r->id_user}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button></td>
                                            @else 
                                                <td></td>
                                            @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- -->

                            <div  id="l4" class="infos" style="display:none;">
                                
                                    <h1 id="salao2">SALÃO II
                                        <form id="form4" class="form-inline" action="/reservas" method="post" style="float:right;">
                                            @csrf
                                            <input name="local" type="hidden" value="sfestas2">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <input name="dia" class="form-control" type="date"  id="dia">
                                            </div>
                                            <button type="submit" form="form4" class="btn btn-success mb-2">Agendar</button>
                                        </form>
                                    </h1>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Local </th>
                                                <th scope="col">Reservante </th>
                                                <th scope="col">Registro em</th>
                                                <th scope="col">Dia previsto </th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservas as $r)
                                            <tr>
                                                @if($r->local_targ =='sfestas2')
                                                <th scope="row">Salão  II</th>
                                                <td scope="col">{{$r->name}}</td>
                                                <td scope="col">{{date('d/m/Y', strtotime($r->created_at)) }}</td>
                                                <td scope="col">{{date('d/m/Y', strtotime($r->reportdate))}}</td>
                                                <th scope="row">{{(Carbon\Carbon::now()>$r->reportdate)? "concluído " : "pendente" }}</th>
                                                @if(Auth::user()->id==$r->id_user)
                                                    <td scope="col"><button type="button" class="btn btn-link"onclick="confirm('{{$r->id}}','{{$r->id_user}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button></td>
                                                @endif
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                </div>

    

    </div>
        
    </main>
    </main>

    <!-- MODAL EXCLUIR-->
    <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">CANCELAR?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente cancelar a reserva?</p>
                    </div>
                    <div class="modal-footer">
                        <a id="excluir" href="" class="btn btn-outline-danger">EXCLUIR</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('js-content')
<script type="text/javascript">

    $('.toast').toast('show');//exibir toast
    $("#toast").fadeToggle(4000, "swing",function(){ //remover toast
        this.remove();
    });

    function see(id) { //preencher card com informações ao clicar no botão
        switch(id){
            case 'l1':
            console.log('oi');
                document.getElementById('img').src="{{Storage::url('res_imgs/quadra.jpg') }}";
                title_local.innerText = "Quadra de Esportes";
                desc_local.innerText = "Reserve a quadra se você busca um dia para praticar esportes com os amigos ou atividades físicas!";
                document.getElementById('nota_local').innerHTML ="Nota:  <i class='fa fa-star' style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star' style='color:grey'></i>";
            break;
            case'l2':
                document.getElementById('img').src="{{Storage::url('res_imgs/patio.jpeg') }}";
                title_local.innerText = "Pátio Interno";
                desc_local.innerText = "O pático é um ótimo lugar para playground para as crianças e outras atividades de entretenimento para a família!";
                document.getElementById('nota_local').innerHTML ="Nota:  <i class='fa fa-star' style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star' style='color:#3a79e0;'></i> ";
            break;
            case 'l3':
                document.getElementById('img').src="{{Storage::url('res_imgs/salao1.jpg') }}";
                title_local.innerText = "Salão de Festas I";
                desc_local.innerText = "O salão de festas primario é uma ótima escolha para fazer festas caseiras e privadas!";
                document.getElementById('nota_local').innerHTML ="Nota:  <i class='fa fa-star' style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star' style='color:grey'></i>";
            break;
            case 'l4':
                document.getElementById('img').src="{{Storage::url('res_imgs/salao2.jpg') }}";
                title_local.innerText = "Salão de Festas II";
                desc_local.innerText = "O salão de festas secundário é otimo para grandes festas e produções acústicas!";
                document.getElementById('nota_local').innerHTML ="Nota:  <i class='fa fa-star' style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star'  style='color:#3a79e0;'></i> <i class='fa fa-star' style='color:#3a79e0;'></i>";
        }
        var x = document.getElementById("info_view").querySelectorAll(".infos");  //reseta toda div de iformações para ficar oculta
        for(i=0;i<x.length;i++){
            x[i].style.display = "none";
        }
        document.getElementById(id).style.display = "block"; //revela o id com informações adicionais.
    };

        function confirm(id1, id2){
    document.getElementById("excluir").href = "reservas/del/"+id1+'/'+id2;

}

</script>
    
@endsection