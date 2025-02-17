<?php
// Caminho do arquivo CSV
$arquivo = 'ips.csv';

// Verifica se o arquivo existe
if (!file_exists($arquivo) || !is_readable($arquivo)) {
    die("Arquivo CSV não encontrado ou não pode ser lido.");
}

// Função para fazer o ping e verificar se o IP está online
function fazerPing($ip) {
    // Comando para fazer ping (variação para Windows e Linux)
    $comando = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "ping -n 2 $ip" : "ping -c 2 $ip";
    $saida = shell_exec($comando);

    // Verifica se a resposta contém "TTL=" (Windows) ou "bytes from" (Linux/Mac)
    return (strpos($saida, "TTL=") !== false || strpos($saida, "bytes from") !== false);
}

// Abre o arquivo CSV para leitura
$dados = array();
if (($handle = fopen($arquivo, 'r')) !== FALSE) {
    // Lê a primeira linha para capturar os cabeçalhos (colunas)
    $cabecalhos = fgetcsv($handle, 1000, ',');

    // Lê as linhas seguintes e armazena os dados
    while (($linha = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $dados[] = array_combine($cabecalhos, $linha);
    }
    fclose($handle);
}

// Exibe os resultados em uma tabela com Bootstrap
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resultado do Ping</title>
        <!-- Link para o CSS do Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5 ">

            <div class="jumbotron bg-secondary-subtle rounded" style="padding:15px">
                <h1 class="display-4">Ping DVRs</h1>
                <p class="lead"> Este programa faz ping nos ips dos DVRs e retorna o resultado na tela abaixo.</p>

            </div>


            <div class="container mt-5">
                <h2 class="mb-4">Selecione uma Escola</h2>

                <form action="http://localhost/pingdvr/index.php" method="POST">
                    <div class="mb-3">

                        <select id="opcoes" name="opcao" class="form-select">
                            <option value="todas">Todas</option>

                            <?php
                            $contador = 0;
                            
                            foreach ($dados as $linha) {
                                
                                $contador++;
                                
                                $nome = $linha['Nome'];
                                ?>
                                <option value="<?php echo $nome ?>"><?php echo"$contador - $nome" ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" onclick="mostrarProcessando()">Enviar</button>
                </form>

                <br>
            </div>

            <?php
            if (count($_POST) == 0) {
                return;
            }
            ?>

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
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


                <tbody>
                    <?php
// Exibe as linhas de dados


                    foreach ($dados as $linha) {

                        if ($_POST['opcao'] <> "todas") {

                            if ($_POST['opcao'] <> $linha['Nome']) {
                                continue;
                            }
                        }

                        $nome = $linha['Nome'];

                        $ipDvr1 = $linha['DVR 1'];
                        $ipDvr2 = $linha['DVR 2'];
                        $ipDvr3 = $linha['DVR 3'];
                        $ipDvr4 = $linha['DVR 4'];
                        $ipDvr5 = $linha['DVR 5'];
                        $ipDvr6 = $linha['DVR 6'];

                        $statusDvr1 = "-";
                        $statusDvr2 = "-";
                        $statusDvr3 = "-";
                        $statusDvr4 = "-";
                        $statusDvr5 = "-";
                        $statusDvr6 = "-";

                        //                $statusDvr1 = fazerPing($ipDvr1) ? '🟢 ONLINE' : '🔴 OFFLINE';





                        if (trim($ipDvr1) <> "-") {

                            $statusDvr1 = fazerPing($ipDvr1) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }


                        if (trim($ipDvr2) <> "-") {

                            $statusDvr2 = fazerPing($ipDvr2) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }

                        if (trim($ipDvr3) <> "-") {

                            $statusDvr3 = fazerPing($ipDvr3) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }

                        if (trim($ipDvr4) <> "-") {

                            $statusDvr4 = fazerPing($ipDvr4) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }

                        if (trim($ipDvr5) <> "-") {

                            $statusDvr5 = fazerPing($ipDvr5) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }

                        if (trim($ipDvr6) <> "-") {

                            $statusDvr6 = fazerPing($ipDvr6) ? '🟢 ONLINE' : '🔴 OFFLINE';
                        }


                        echo "<tr>
                            <td>" . htmlspecialchars($nome) . "</td>
                                <td>" . htmlspecialchars($ipDvr1) . "</td>
                            <td>" . htmlspecialchars($statusDvr1) . "</td>";

                        echo "
                        
                                <td>" . htmlspecialchars($ipDvr2) . "</td>
                            <td>" . htmlspecialchars($statusDvr2) . "</td>
                                <td>" . htmlspecialchars($ipDvr3) . "</td>
                            <td>" . htmlspecialchars($statusDvr3) . "</td>
                                <td>" . htmlspecialchars($ipDvr4) . "</td>
                            <td>" . htmlspecialchars($statusDvr4) . "</td>
                                <td>" . htmlspecialchars($ipDvr5) . "</td>
                            <td>" . htmlspecialchars($statusDvr5) . "</td>
                                <td>" . htmlspecialchars($ipDvr6) . "</td>
                            <td>" . htmlspecialchars($statusDvr6) . "</td>
                                

                        </tr>";
                    }

                    $_POST = array();
                    ?>
                </tbody>
            </table>

            <!-- Modal de Processando -->
            <div class="modal fade" id="modalProcessando" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <p class="mt-2">Processando, aguarde...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function mostrarProcessando() {
                var modal = new bootstrap.Modal(document.getElementById('modalProcessando'), {
                    backdrop: 'static', // Impede de fechar ao clicar fora
                    keyboard: false // Impede de fechar com ESC
                });
                modal.show();
            }
        </script>

        <!-- Link para o JavaScript do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>




</html>

<script>


</script>
