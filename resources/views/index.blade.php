@extends('template.template')

@section('title','Adson Cotações - Home')

@section('content')
    <div class="album text-muted">
        <div class="container">
            <div class="row">
                <div class="card cardConversor">
                    <div>

                    </div>
                    <div class="card-body">
                        <i class="far fa-money-bill-alt" title=""></i>
                        <h5 class="card-title">Cotação de ações</h5>

                        <form method="POST" id="formCotar" action="{{route('cotacao')}}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <span>Símbolo</span>
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="simbolo" id="simbolo" maxlength="6">
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="valor_moeda_liberada" id="valor_moeda_liberada" />
                                    <button type="submit" class="btn btn-primary botaoCotar">Cotar</button>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 text-center">
                                    <a href="https://iexcloud.io">Data provided by IEX Cloud</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>

    <script>

        function newRequest(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type:'GET',
                url:"/consulta",

                success:function(data){
                    var json = JSON.parse(data);
                    var selecionada = $('#liberada').val()+''+$('#padrao').val();
                    $('#valorliberada').text("R$: "+Number(json[selecionada]['bid']).toFixed(2));
                    $('#valor_moeda_liberada').val(Number(json[selecionada]['bid']).toFixed(2))
                    $('#valorliberada').css("color", "red");
                    setTimeout(function() {
                        $('#valorliberada').css("color", "black");
                    }, 2000);

                },
                error:function(){
                    alert('Erro');
                },
                complete:function (){
                    setTimeout(function() {
                        newRequest();
                    }, 30000);
                }
            });
        }


        $(document).ready(function(){

            $('#liberada').on('change', function(e){
                newRequest();
            });

            $( "#formCotar" ).submit(function( event ) {
               if($('#simbolo').val() == '' || $('#simbolo').val() == ' '){
                  alert('Informe o símbolo para cotação');
                   event.preventDefault();
               }
            });

            function checkChar(e) {
                var char = String.fromCharCode(e.keyCode);

                var pattern = '[0-9]';
                if (char.match(pattern)) {
                    return true;
                }

            }

        });

    </script>
@endsection
