<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resultado do Ping</title>
        <!-- Link para o CSS do Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->

        <style>
            .fixed-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                background-color: #343a40;
                color: white;
                padding: 10px 0;
                text-align: center;
                z-index: 1030;
            }
        </style>
    </head>
    <body>

        <div class="fixed-header">
            <p><center><strong> Desenvolvido pelo NIT - Diretoria de Ensino de Mogi das Cruzes - <img src="img/mogi-bandeira.jpg" alt="" style="height: 30px; margin-left: 20px"/></strong></center></p>

    </div>

    <div class="container mt-5 ">

        <div class="jumbotron bg-secondary-subtle rounded" style="padding:15px">
            <h1 class="display-4">Ping DVRs</h1>
            <p class="lead"> Este programa faz ping nos ips dos DVRs e retorna o resultado na tabela abaixo.</p>

        </div>


        <div class="container mt-5">
            <h2 class="mb-4">Selecione uma Escola</h2>


            <div class="mb-3">

                <select id="opcoes" name="opcoes" class="form-select">
                    <option value="todas">Todas</option>
                </select>
            </div>

            <button type="" class="btn btn-primary" onclick="mostrarMensagem(); ping()">Enviar</button>


            <button class="btn btn-danger" id="btnLimpar" onclick="limparTabela()">Limpar</button>

            <br>
            <br>
        </div>


        <table class="table table-bordered table-striped" style="margin-bottom: 100px">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>DVR 1</th>
                    <th>Status</th>
                    <th>DVR 2</th>
                    <th>Status</th>
                    <th>DVR 3</th>
                    <th>Status</th>
                    <th>DVR 4</th>
                    <th>Status</th>
                    <th>DVR 5</th>
                    <th>Status</th>
                    <th>DVR 6</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="processamentoPing">
            </tbody>
        </table>
    </div>

    <!-- Footer fixo -->
    <div class="fixed-footer" style="padding-top: 0px">
        <div id="statusProcessando" style="display: none">

            <p class="mt-2 processandoStatus">📢 Status: Processando, aguarde... <img src="img/management.gif" alt="" style="display: none;height: 35px; border-radius: 10px;margin-left: 15px "/><img src="img/hourglass.png" alt="" style="height: 35px;" /></p>


        </div> 

        <div id="statusProcessado" style="display: none">

            <p class="mt-2 processandoStatus">📢 Status: Processado <img src="img/check-button.png" alt="" style="height: 35px;margin-left: 15px"/></p>


        </div>


    </div>



    <!-- Modal de Processando -->
    <div class="modal " id="modalProcessando" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!--<div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>-->
                    <p class="mt-2">Processando, aguarde o status abaixo ficar como processado!</p>
                    <button type="button" class="btn btn-primary" onclick="esconderMensagemProcessando()">OK</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            listarEscolas();
        });

        let valores = [];
        var contadorCadaVez = 0;

        var processamento = false;


        function listarEscolas() {

            // $('#modalProcessando').show();
            $.ajax({
                url: 'lista_escolas.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {

                    $('#opcoes').append(response);

                },
                error: function () {
                    alert('Erro ao processar lista de escolas.');

                }
            });
        }

        function processarPing(valor) {

            contadorCadaVez++;
            processamento = true;

            event.preventDefault(); // Evita o recarregamento da página
            //data: {id: valores[contadorCadaVez],numero:contadorCadaVez},
            $.ajax({
                url: "processar_ping.php",
                method: "POST",
                data: {id: valor, numero: contadorCadaVez},
                dataType: "json"
            }).done(function (resposta) {
                console.log("Resposta do servidor:", resposta);
                $('#processamentoPing').append(resposta);

                // O código aqui será executado APÓS a resposta ser recebida
            }).fail(function (erro) {
                console.log("Erro na requisição:", erro);

            }).always(function () {
                console.log("Requisição finalizada");
                esconderMensagem();
            });




        }


        function processarPingCadaVez() {

            event.preventDefault(); // Evita o recarregamento da página
            contadorCadaVez++;
            processamento = true;


            $.ajax({
                url: "processar_ping.php",
                method: "POST",
                data: {id: valores[contadorCadaVez], numero: contadorCadaVez},
                dataType: "json"
            }).done(function (resposta) {
                console.log("Resposta do servidor:", resposta);
                $('#processamentoPing').append(resposta);

                console.log(contadorCadaVez);

                if (contadorCadaVez < valores.length - 1) {

                    processarPingCadaVez();
                } else {
                    console.log("fim");
                    esconderMensagem();

                }



                // O código aqui será executado APÓS a resposta ser recebida
            }).fail(function (erro) {
                console.log("Erro na requisição:", erro);

            }).always(function () {
                console.log("Requisição finalizada");
                processamento = false;
            });




        }

        function ping() {


            if (processamento) {
                //alert("Há um processamento em andamento! Aguarde o status abaixo ficar em processado para tentar novamente.");
                
                mostrarMensagemProcessando();
                return;
            }


            if ($('#opcoes').val() === 'todas') {


                var contador = 0;
                var x = 1;

                $('#opcoes').find('option').each(function () {

                    var valor = $(this).val();



                    if (valor === 'todas') {
                        contador++;


                    }

                    if (contador > 1) {
                        return;
                    } else {

                        if (valor != 'todas') {

                            valores[x] = valor;
                            x++;

                        }
                    }
                });

                limparTabela();
                processarPingCadaVez();



            } else {

                processarPing($('#opcoes').val());
            }



        }

        function mostrarMensagem() {
            //$('#modalProcessando').show();
            $('#statusProcessado').hide();
            $('#statusProcessando').show();


        }

        function esconderMensagem() {
            //$('#modalProcessando').hide();
            $('#statusProcessando').hide();
            $('#statusProcessado').show();
            processamento = false;
        }




        function limparTabela() {
            event.preventDefault(); // Evita o recarregamento da página

            $('#processamentoPing').empty();
            contadorCadaVez = 0;
        }
        
        function mostrarMensagemProcessando(){
            $("#modalProcessando").show();
        }
        
        function esconderMensagemProcessando(){
            $("#modalProcessando").hide();
        }
        
    </script>

    <!-- Link para o JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>




</html>

<script>


</script>
