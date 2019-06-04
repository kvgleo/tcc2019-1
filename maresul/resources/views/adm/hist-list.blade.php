<!DOCTYPE html>
<head>

    @yield('title-content')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>



    <body>

        <div class="row">

            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2 style="display:inline"> Lançamentos de {{Request()->ano}} <h4 >Mar Azul condomínios</h4>  <button type="button" onclick="window.print();" class="btn btn-danger float-right"><i class="fa fa-print"></i></button></h2> 
                <small><a href="{{route('historico', ['ano' => Request()->ano])}}" class="text-danger"> <i class="fa fa-angle-left"></i> Voltar para a página anterior </a></small>
                    <table class="table table-hover text-muted table-sm col-md-12" id="searchtable" style="margin-top:50px;">
                            <thead>
                              <tr>
                                <th scope="col">Data</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Tipo</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($lancamentos as $l)
                              <tr>
                                <td scope="col">{{date('d/m/Y', strtotime($l->reportdate))}} </td>
                                <td scope="col">{{$l->lanc_desc}}</td>
                                <td scope="row"><b>R$ {{number_format($l->valor,2,",",".")}} </b></td>
                                <td scope="col">{{$l->tipo}}</td>

                              </tr>
                              @endforeach

                            </tbody>
                          </table>
            </div>
            <div class="col-md-2"></div>
        </div>



        <script src="{{ asset('js/app.js') }}"></script>

        <script type="text/javascript">
            window.onload = function() { window.print(); }
       </script>

    </body>

</html>