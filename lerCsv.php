<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function lerCsv(&$dadosCsv) {

    // Caminho do arquivo CSV
    $arquivo = 'ips.csv';
    
// Verifica se o arquivo existe
    if (!file_exists($arquivo) || !is_readable($arquivo)) {
        die("Arquivo CSV não encontrado ou não pode ser lido.");
    }
    
    

    if (($handle = fopen($arquivo, 'r')) !== FALSE) {
        // Lê a primeira linha para capturar os cabeçalhos (colunas)
        $cabecalhos = fgetcsv($handle, 1000, ',');
        

        // Lê as linhas seguintes e armazena os dados
        while (($linha = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $dadosCsv[] = array_combine($cabecalhos, $linha);
        }
        
        
        fclose($handle);
    }
}
