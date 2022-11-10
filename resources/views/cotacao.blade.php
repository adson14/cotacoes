@extends('template.template')

@section('title','Adson Cotações')

@section('content')
    @csrf
    <div class="album text-muted">
        <div class="container">
            <div class="row">
                <div class="card cardConversor" style="min-width: 50%">
                    <div class="card-body">
                        <i class="far fa-money-bill-alt" title=""></i>
                        <h5 class="card-title">Resultado Detalhado</h5>
                        <ul class="list-group">
                            <li class="list-group-item">Organização:&ensp;<a href={{ route('cotacao_detalhe', ['simbolo'=>$dados->simbolo]) }}><b>{{$dados->organizacao}}</b></a></li>
                            <li class="list-group-item">Símbolo:&ensp; <b>{{$dados->simbolo}}</b> </li>
                            <li class="list-group-item">Moeda:&ensp; <b>{{$dados->moeda}}</b> </li>
                            <li class="list-group-item">Último preço:&ensp; <b id="ultimo_preco">{{$dados->simbolo_moeda}}{{$dados->ultimo_preco}} </b></li>
                            <li class="list-group-item">Volume:&ensp;<b id="volume">{{$dados->volume}}</b> </li>
                            <li class="list-group-item">Abertura: <b id="abertura">{{$dados->simbolo_moeda}}{{$dados->abertura}}</b></li>
                            <li class="list-group-item">Fechamento: <b id="fechamento">{{$dados->simbolo_moeda}}{{$dados->fechamento}}</b></li>
                        </ul>
                        <div class="row">

                            <div class="col-md">
                                <a href="https://iexcloud.io">IEX Cloud</a>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md">
                                <div class="divresultado">
                                    Preço: <span class="badge badge-success preco">{{$dados->simbolo_moeda}} {{$dados->ultimo_preco}}</span>
                                </div>
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
            setTimeout(function() {
                newRequest();
            }, 300000);
        });

        function newRequest(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type:'POST',
                url:"/consulta",
                data:{simbolo:'<?php echo $dados->simbolo?>'},

                success:function(data){
                    $('#ultimo_preco').text(data.ultimo_preco);
                    $('#volume').text(data.volume);
                    $('#abertura').text(data.abertura);
                    $('#fechamento').text(data.fechamento);
                    $('.preco').css("color", "red");
                    setTimeout(function() {
                        $('.preco').css("color", "white");
                    }, 2000);

                },
                error:function(eee){
                    console.log(eee);
                },
                complete:function (){
                    setTimeout(function() {
                        newRequest();
                    }, 300000);
                }
            });
        }

    </script>
@endsection
