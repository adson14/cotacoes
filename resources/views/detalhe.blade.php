@extends('template.template')

@section('title','Adson Cotações')

@section('content')
    <div class="album text-muted">
        <div class="container">
            <div class="row">
                <div class="card cardConversor" style="min-width: 50%">
                    <div class="card-body">
                        <i class="far fa-money-bill-alt" title=""></i>
                        <h5 class="card-title">Dados da Organização</h5>
                        <ul class="list-group">
                            <li class="list-group-item">Organização:&ensp;<b>{{$dados->organizacao}}</b></li>
                            <li class="list-group-item">Símbolo:&ensp; <b>{{$dados->simbolo}}</b> </li>
                            <li class="list-group-item">Exchange:&ensp; <b>{{$dados->exchange}}</b> </li>
                            <li class="list-group-item">Ramo:&ensp; <b>{{$dados->ramo}} </b></li>
                            <li class="list-group-item">Site:&ensp;<b>{{$dados->site}}</b> </li>
                            <li class="list-group-item">CEO: <b>{{$dados->ceo}}</b></li>
                            <li class="list-group-item">Descrição: <b>{{$dados->descricao}}</b></li>
                        </ul>
                        <div class="row">

                            <div class="col-md">
                                <a href="https://iexcloud.io">IEX Cloud</a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="">
                                    <ul class="nav justify-content-center">

                                        <li class="nav-item">
                                            <a class="nav-link" href="/"><i class="fas fa-redo"></i>

                                                Refazer</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>

    <script>

        function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

        $(document).ready(function(){
            $(document).on("keydown", disableF5);
        });

    </script>
@endsection
