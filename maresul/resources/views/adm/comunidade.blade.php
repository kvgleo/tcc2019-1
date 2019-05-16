@extends('adm.template.main')
@section('title-content')
<title>MAR AZUL- Comunidade</title>

@endsection

@section('warn-content')

@if(Session::has('msg'))
<div class="position-absolute w-100 d-flex flex-column p-4 " id="toast">
        <div class="toast ml-auto alert-success" role="alert" data-autohide="false"  style="margin-top:7rem;">
            <div class="toast-body alert-success"><i class="fa fa-check-circle mr-2"></i>{{ Session::get('msg') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span id="close" aria-hidden="true">×</span></button></div>
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
    <h1 class="h2">Comunidade</h1>
    <div class="mb-2">
        <button  type="button" onclick="clear_input()"class="btn btn-outline-danger btn-lg"data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i></button>
    </div>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active " >Comunidade</li>
        </ol>
    </nav>
    <div class="card col-md-12" style="float: left; margin-bottom:20px; margin-right: 15px; ">
        <div class="card-body text-secondary">
            <p class="card-text"> Administre os moradores cadastrados no seu condomínio</p>
        </div>
    </div>

    <div class="card col-md-4 " style="margin-bottom:20px; margin-top:-10px; background:none; border:none; float:left; ">

            <div class="col-md-12" style="margin-top:10px;">
                    <h3 class="h2">Administradores</h3>
                    <hr>

             </div>
<!--card admin -->
            @foreach($admins as $adm)
                <div class="card  col-md-12"  style="margin-bottom: 10px;">
                    <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="card-body">
                        <img src="https://image.flaticon.com/icons/png/512/21/21294.png" class="img-thumbnail card-img" alt="...">
                    </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        <h5 class="card-title">{{$adm->name}} <span style = "float:right"class="badge badge-danger"> ADMIN</span></h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$adm->email}}</h6>
                        <p class="card-text"> Administrador do Sistema</p>
                        <p class="card-text"><small class="text-muted">Cadastrado em: {{date('d/m/Y', strtotime( $adm->created_at))  }} </small></p>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach

<!---->


                
    </div>

    <div class="card col-md-8" style="margin-bottom:10px;">
            <div class="card-body text-secondary">
            <h6 class="card-text">Listagem de moradores  <button type="button"  class="btn btn-danger" style="float:right"  data-toggle="modal" data-target="#cModal">Resetar <i class="fab fa-rev"></i></button></h6>
            </div>

            <div class="input-group col-md-8" style="margin-top:10px; margin-bottom:10px;">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Pesquisar..." id="searchinput">
                    <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
                </div>

            <div class="col-md-12"  style=" max-height:490px;  overflow-y: auto;">
                    <table id="users"class="table table-hover">
                            <thead>
                              <tr>
                                <th scope="col">Morador</th>
                                <th scope="col">Residência</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                              </tr>
                            </thead>
                            <tbody >
                                @foreach($users as $u)
                              <tr >
                              <td scope="col"><img class="rounded-circle" widht="30px;" height="30px;"src="https://image.flaticon.com/icons/png/512/21/21294.png"/> {{$u->name}}</td>
                              <td scope="col">Apt. Nª {{$u->apto}}</td>
                                <td scope="col">{{$u->email}}</td>
                                @if($u->inp == false)
                              <td scope="col"><a href="/status/i/{{$u->id}}" id="status1" class="btn btn-success btn-sm">Adimplente <i class="fa fa-user-check"></i></a></td>
                                @elseif($u->inp==true)
                                    <td scope="col"><a href="/status/a/{{$u->id}}" id="status2" class="btn btn-danger btn-sm">Inadimplente <i class="fa fa-user-slash"></i></a></td>
                                @endif
                                <td scope="col"> 
                                <button type="button" class="btn btn-light btn-sm"><i class="fa fa-pen"  onclick="edit('{{$u->email}}','{{$u->apto}}','{{$u->name}}','{{route('edit_users', ['id' => $u->id])}}')"  data-toggle="modal" data-target="#editModal"></i></button>
                                     <button type="button" class="btn btn-danger btn-sm" onclick="confirm('{{route('del_users', ['id' => $u->id])}}')" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></button>
                                </td>

                              </tr>
                              @endforeach

                            </tbody>
                          </table>
                </div>

        </div>
      


        <div class="modal fade" id="createModal" role="dialog" >
                <div class="modal-dialog" >
                    <div class="modal-content" >
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                      <a class="nav-link active" id="usersm" data-toggle="tab" href="#user_model" role="tab" aria-controls="user_tab"
                                        aria-selected="true">Usuários</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" id="adminm" data-toggle="tab" href="#admin_modal" role="tab" aria-controls="admin_tab"
                                        aria-selected="false">Admin</a>
                                    </li>
                                  </ul>
                                  <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="user_model" role="tabpanel" aria-labelledby="user_tab">
                                            <div class="modal-header">
                                                    <h4 class="modal-title">NOVO CADASTRO DE MORADOR</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formUser" method="POST" action="/comunidade/0">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="name" >Nome</label>
                                                                <input id="name" type="text" class="form-control" name="name"  placeholder="nome de usuário" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email" >Email</label>
                                                                <input id="email" type="email" class="form-control" name="email" placeholder="email" required>
                                                            </div>
                            
                                                            <div class="form-group">
                                                                    <label for="apto">Residência</label>
                                                                    <input type="number" id="apto" class="form-control" placeholder="Número do apartamento" name="apto" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <p><small class="card-text text-muted">Gere uma senha provisória para o novo usuário ao clicar no botão abaixo:</small></p>
                                                                        <p>
                                                                            <button id="senha_g" type="button" onclick="senha(6)" class="btn btn-danger card-text" aria-required="true">Gerar senha</button>
                                                                        </p>
                                                                        <div class="text-right">
                                                                            <h3 style="display:inline"class="card-text text-muted"> Senha gerada: </h3> <h3 class="text-danger card-text" style="display:inline;" id="campo_senha"> (N/D)</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            <div class="form-group">
                                                                <input type="text" id="senha_user" class="form-control" placeholder="senha" name="password" hidden>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button form="formUser"type="submit" class="btn btn-danger">Registrar</button> 
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    </div>


                                    </div>
                                    <div class="tab-pane fade" id="admin_modal" role="tabpanel" aria-labelledby="admin_tab">
                                            <div class="modal-header">
                                                    <h4 class="modal-title">NOVO CADASTRO DE ADMINSTRADOR</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formAdmin" method="POST" action="/comunidade/1">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="nameadm" >Nome</label>
                                                                <input id="nameadm" type="text" class="form-control" name="name"  placeholder="nome de usuário" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="emailadm" >Email</label>
                                                                <input id="emailadm" type="email" class="form-control" name="email" placeholder="email" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <p><small class="card-text text-muted">Gere uma senha provisória para o novo usuário ao clicar no botão abaixo:</small></p>
                                                                        <p>
                                                                            <button id="senha_g" type="button" onclick="senhaAdmin(6)" class="btn btn-danger card-text" aria-required="true">Gerar senha</button>
                                                                        </p>
                                                                        <div class="text-right">
                                                                            <h3 style="display:inline"class="card-text text-muted"> Senha gerada: </h3> <h3 class="text-danger card-text" style="display:inline;" id="campo_senha_adm"> (N/D)</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            <div class="form-group">
                                                                <input type="text" id="senha_adm" class="form-control" placeholder="senha" name="password" hidden>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button form="formAdmin"type="submit" class="btn btn-danger">Registrar</button> 
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    </div>

                                    </div>
                                   
                                  </div>
                      
                    </div>
                </div>
            </div>

            <!-- MODAL reset-->
            <div class="modal fade" id="cModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">CONFIRMAR</h4>
                            </div>
                            <div class="modal-body">
                                <p>Marcar todos moradores como "inadimplêntes"?</p>
                            </div>
                            <div class="modal-footer">
                                <a  href="/status/all/0" class="btn btn-danger">SIM</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
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
                    <p>Tem certeza que deseja excluir o usuário selecionado?</p>
                </div>
                <div class="modal-footer">
                    <a id="excluir" href="" class="btn btn-danger">EXCLUIR</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>


<!-- Modal EDITAR-->
<div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR PERFIL DE MORADOR</h4>
                 </div>
                <div class="modal-body">
                        <form id="editUser" method="POST" action="/comunidade/0">
                            @csrf
                            <div class="form-group">
                                <label for="editname" >Nome</label>
                                <input id="editname" type="text" class="form-control" name="editName"  placeholder="nome de usuário" required>
                            </div>
                            <div class="form-group">
                                <label for="editemail" >Email</label>
                                <input id="editemail" type="email" class="form-control" name="editEmail" placeholder="email" required>
                            </div>

                            <div class="form-group">
                                    <label for="editapto">Residência</label>
                                    <input type="number" id="editapto" class="form-control" placeholder="Número do apartamento" name="editApto" required>
                            </div>
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-body">
                                        <p><small class="card-text text-muted">Se necessário, redefina a senha clicando no botão abaixo:</small></p>
                                        <p>
                                            <button id="senha_g" type="button" onclick="editSenha(6)" class="btn btn-danger card-text" aria-required="true">Redefinir</button>
                                        </p>
                                        <div class="text-right">
                                            <h3 style="display:inline"class="card-text text-muted"> Nova Senha: </h3> <h3 class="text-danger card-text" style="display:inline;" id="editcampo_senha"> (N/D)</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" id="editsenha" class="form-control" placeholder="senha" name="editPassword" hidden>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editUser"class="btn btn-danger">Salvar</button>
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js-content')
<script>

  $(function() {
    $('#comunidade').addClass('btn-danger');
  });

  function confirm(str){
      console.log(str);
        document.getElementById("excluir").href = str;

    }

    $('.toast').toast('show');

    $('#close').click(function(){
        $("#toast").remove();
    });

function editSenha(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   document.getElementById("editcampo_senha").innerHTML = result;
   document.getElementById("editsenha").value = result;
}

function senha(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   document.getElementById("campo_senha").innerHTML = result;
   document.getElementById("senha_user").value = result;
}

function senhaAdmin(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   document.getElementById("campo_senha_adm").innerHTML = result;
   document.getElementById("senha_adm").value = result;
}
    function clear_input(){
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("apto").value = "";
        document.getElementById("campo_senha").innerHTML = "N/D";
        document.getElementById("nameadm").value = "";
        document.getElementById("emailadm").value = "";
        document.getElementById("campo_senha_adm").innerHTML = "N/D";
        document.getElementById("senha_adm").value = "";
        document.getElementById("senha_user").value = "";
    }


    function edit(email,apto,name,str){
        
        document.getElementById("editcampo_senha").innerHTML = "(N/D)";
        document.getElementById("editsenha").value = "";
        document.getElementById("editUser").action = str;
        document.getElementById("editname").value = name;
        document.getElementById("editemail").value = email;
        document.getElementById("editapto").value = apto;
    }


 $(document).ready(function(){
      $("#searchinput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#users tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });



     $('a[id=status2]').mouseover(function() {
        this.innerHTML = 'Adimplente <i class="fa fa-user-check"></i>';
        this.className = 'btn btn-success btn-sm';

    }).mouseout(function() {
        this.innerHTML = 'Inadimplente <i class="fa fa-user-slash"></i>';
        this.className = 'btn btn-danger btn-sm';
    });

         $('a[id=status1]').mouseover(function() {
        this.innerHTML = 'Inadimplente <i class="fa fa-user-slash"></i>';
        this.className = 'btn btn-danger btn-sm';

    }).mouseout(function() {
        this.innerHTML = 'Adimplente <i class="fa fa-user-check"> </i>';
        this.className = 'btn btn-success btn-sm';
    });




</script>
@endsection