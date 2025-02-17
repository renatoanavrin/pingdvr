<?php

include_once './lerCsv.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function fazerPing($ip) {
    // Comando para fazer ping (variação para Windows e Linux)
    $comando = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "ping -n 2 $ip" : "ping -c 2 $ip";
    $saida = shell_exec($comando);

    // Verifica se a resposta contém "TTL=" (Windows) ou "bytes from" (Linux/Mac)
    return (strpos($saida, "TTL=") !== false || strpos($saida, "bytes from") !== false);
}

function processarPing($nome,$numero) {

    $dadosCsv = array();
    $respostaHtml = "";

    lerCsv($dadosCsv);

    foreach ($dadosCsv as $linha) {
        if ($linha['Nome'] == $nome) {

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




            $respostaHtml .= "<tr><td>$numero</td>"
                    . "<td>" . htmlspecialchars($nome) . "</td>"
                    . "<td>$ipDvr1</td>"
                    . "<td>" . htmlspecialchars($statusDvr1) . "</td>"
                    . "<td>$ipDvr2</td>"
                    . "<td>" . htmlspecialchars($statusDvr2) . "</td>"
                    . "<td>$ipDvr3</td>"
                    . "<td>" . htmlspecialchars($statusDvr3) . "</td>"
                    . "<td>$ipDvr4</td>"
                    . "<td>" . htmlspecialchars($statusDvr4) . "</td>"
                    . "<td>$ipDvr5</td>"
                    . "<td>" . htmlspecialchars($statusDvr5) . "</td>"
                    . "<td>$ipDvr6</td>"
                    . "<td>" . htmlspecialchars($statusDvr6) . "</td></tr>";
        }
    }
    
    
    return $respostaHtml;
}

echo json_encode(processarPing($_POST['id'],$_POST['numero']));

return;