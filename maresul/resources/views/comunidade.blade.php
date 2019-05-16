@extends('layout_user')


@section('title-content')
<title> MAR&SUL - Regras de Convivência</title>
@endsection


@section('style-content')
<style>
    .MultiCarousel { float: left; overflow: hidden; padding: 15px; width: 100%; position:relative; }
    .MultiCarousel .MultiCarousel-inner { transition: 1s ease all; float: left; }
        .MultiCarousel .MultiCarousel-inner .item { float: left;}
        .MultiCarousel .MultiCarousel-inner .item > div { text-align: center; margin:10px; background:#f1f1f1; color:#666;}
    .MultiCarousel .leftLst, .MultiCarousel .rightLst { position:absolute; border-radius:50%;top:calc(50% - 20px); }
    .MultiCarousel .leftLst { left:0; }
    .MultiCarousel .rightLst { right:0; }
    
        .MultiCarousel .leftLst.over, .MultiCarousel .rightLst.over { pointer-events: none; background:#ccc; }
</style>
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
            <div class="toast-body alert-danger"><i class="fa fa-times-circle mr-2"></i> {{ Session::get('avs') }}<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span id="close" aria-hidden="true">×</span></button></div>
        </div>
</div>
@endif

@endsection

@section('main-content')
<main role="main" class="col-md-8  mx-auto col-lg-8 " style="background-color:white; padding-top:25px; padding-bottom:25px;">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-5 border-bottom" style="margin-top:70px; ">
    <h1 class="h2 text-secondary">Comunidade</h1>
    <a href="/home" class="btn btn-link"> <i class="fa fa-chevron-left"></i> Voltar</a>
</div>
      <nav aria-label="breadcrumb" style="margin-top:-25px;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
              <li class="breadcrumb-item " ><a class="text-muted"href="/home">Comunidade</a></li>
            </ol>

        </nav>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">

            
                <div class="card  col-md-12"  style="margin-bottom: 10px;">
                        <div class="row no-gutters">
                        <div class="col-md-4">
                            <div class="card-body">
                                    <h1 class="h2 text-secondary">Perfil</h1>
                                    <hr>
                            <img src="{{Storage::url('user_img/userpic.png') }}" class="img-thumbnail card-img" alt="...">
                        </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                            <h5 class="card-title">{{ Auth::user()->name }} <button style ="float:right" onclick="edit('{{ Auth::user()->name }}','{{ Auth::user()->email}}','{{ Auth::user()->bio }}')"class="btn btn-light" data-toggle="modal" data-target="#editModal"> <i class="fa fa-cog"></i></button></h5>
                            <h6 class="card-subtitle mb-2 text-muted"> Apto. Nº {{ Auth::user()->apto }} </h6>
                            <hr>
                            @if(empty(Auth::user()->bio))
                                <p class="card-text text-muted"> (sem descrição) </p>
                            @else
                            <p class="card-text text-muted"> {{ Auth::user()->bio }} </p>
                            @endif
                            @if(Auth::user()->inp==0)
                            <div class="alert alert-success" role="alert">
                                   <i class="fa fa-check-circle"></i> Adimplente! - Suas contas estão em dia!
                                  </div>
                            @else
                            <div class="alert alert-danger" role="alert">
                                    <i class="fa fa-exclamation-circle"></i>  Status: Inadimplente! - Você possui dívidas pendentes, favor consultar a sede administrativa!
                                  </div>
                            @endif
                            </div>
                            <div class="card-footer">
                                    <p class="card-text"><small class="text-muted">{{ Auth::user()->email }} </small></p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <br>
                    <h1 class="h2 text-secondary">Usuários do Site</h1>
                    <hr>
                    <div class="container">
                            <div class="row">
                                <div class="MultiCarousel" data-items="1,3,4,4" data-slide="1" id="MultiCarousel"  data-interval="1000">
                                    <div class="MultiCarousel-inner">
                                        @foreach($admins as $a)
                                        <div class="item">
                                            <div class="pad15">
                                                <p class="lead">  <button type="button" style = " margin-right:5px; margin-top:5px; margin-bottom: 5px; float:right"class="btn btn-primary btn-sm"> <i class="fa fa-comment-dots"></i></button> </p>
                                                <div class="card  col-md-12"  style="margin-bottom: 10px;">
                                                    <div class="col-md-12">
                                                        <div class="card-body">
                                                        <img src="{{Storage::url('user_img/adminpic.png') }}" class="img-thumbnail card-img" style="margin-bottom:5px;">
                                                        <h5 class="card-text text-primary bold">{{$a->name}} </h5>
                                                        <p class="card-text">Administrador</p>
                                                        <p class="card-text"><small class="text-muted">{{$a->email}}</small></p>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @foreach($users as $u)

                                        <div class="item">
                                                <div class="pad15">
                                                    <p class="lead">  <button type="button" style = "margin-right:5px; margin-top:5px; margin-bottom: 5px; float:right"class="btn btn-primary btn-sm"> <i class="fa fa-comment-dots"></i></button></p>
                                                    <div class="card  col-md-12"  style="margin-bottom: 10px;">
                                                        <div class="col-md-12">
                                                            <div class="card-body">
                                                            <img src="{{Storage::url('user_img/userpic.png') }}" class="img-thumbnail card-img" style="margin-bottom:5px;">
                                                            <h5 class="card-text">{{$u->name}}</h5>
                                                            <p class="card-text">Apto, Nº {{$u->apto}}</p>
                                                            <p class="card-text"><small class="text-muted">{{$u->email}} </small></p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </div>
                                            </div>
                                            @endforeach
                                    
                                    </div>
                                    <button class="btn btn-primary leftLst"><</button>
                                    <button class="btn btn-primary rightLst">></button>
                                </div>
                            </div>
                        
                        </div>
                     
                        
        </main>


        <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">EDITAR PERFIL </h4>
                         </div>
                        <div class="modal-body">
                        <form id="editUser" autocomplete="off" method="POST" action="/comunidade/edit/{{ Auth::user()->id }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="editname" >Nome</label>
                                        <input id="editname" type="text" class="form-control" name="editName"  placeholder="nome de usuário..." required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editemail" >Email</label>
                                        <input id="editemail" type="text" class="form-control" name="editEmail" placeholder="alterar email..." required>
                                    </div>
                                    <div class="form-group">
                                            <label for="editemail" >Bio</label>
                                            <textarea rows="4" id="editBio" type="email" class="form-control" name="editBio" placeholder="informe uma breve descrição sua..." required></textarea>
                                        </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" form="editUser"class="btn btn-success">Salvar</button>
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

@endsection



@section('js-content')

    <script type="text/javascript">
    $('.toast').toast('show');//exibir toast

$('#close').click(function(){
    $("#toast").remove();
});
    function edit(name,email,bio){

        document.getElementById("editname").value = name;
        document.getElementById("editemail").value = email;
        document.getElementById("editBio").value = bio;
    }


$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});

    </script>
@endsection