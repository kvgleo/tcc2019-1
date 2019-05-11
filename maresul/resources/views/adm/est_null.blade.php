@extends('adm.template.main')

@section('title-content')
<title>MARESUL- Estatísticas</title>

@endsection

@section('main-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom">
        <h1 class="h2">Estatísticas</h1>
    </div>
    <nav aria-label="breadcrumb" style="margin-top:-25px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" >Estatísticas</li>
        </ol>
    </nav>

    <div class="card col-md-12 " style="margin-bottom:20px; float:left; background:none; border:none;">
        <div class="card alert-secondary" style="margin-bottom:20px;">
            <div class="card-body">
                    <div class="card-title"> <h2>  Aviso <i class="fa fa-question" style="float:right"></i></h2></div>
                <h4 class="card-text"> Sem Registros! </h4>
                <hr>
                <p class="card-text"> Não foi encontrado nada no histórico para calcular as estatísticas, adicione lançamentos na aba despesas para ver o histórico atual clicando <a href="/despesas" class="alert-link">aqui</a></p>
            </div>
        </div>
    </div>

@endsection