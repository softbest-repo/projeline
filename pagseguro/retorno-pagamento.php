<?php
    include('../f/conf/config.php');

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['reference_id']) || !isset($data['charges'][0]['status'])) {
        http_response_code(400);
        exit("Dados inválidos");
    }

    $codVenda = $data['reference_id'];
    $statusVenda = $data['charges'][0]['status']; // exemplo: PAID, DECLINED, CANCELED, etc.

    $sql = "UPDATE vendas SET statusVenda = '".$statusVenda."' WHERE codVenda = '".$codVenda."'";
    $result = $conn->query($sql);

    if ($result){
        http_response_code(200);
        $sqlVendaInfo = "INSERT INTO vendasInfo (codVenda, statusVendaInfo, jsonVendaInfo) VALUES ('".$codVenda."', '".$statusVenda."', '".$input."')";
        $resultVendaInfo = $conn->query($sqlVendaInfo);
    }else{
        http_response_code(500);
    }