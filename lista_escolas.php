<?php

include './lerCsv.php';

function listarEscolas() {

    $contador =0;
    
    $dadosCsv = array();
    $resultado = "";
    
    lerCsv($dadosCsv);
    
    
    foreach ($dadosCsv as $linha){
        $contador++;
        $nome= $linha['Nome'];
        
        $resultado .= "<option value='$nome'>$nome</option>";
        
    }
    
    echo $resultado;
    
}


listarEscolas();