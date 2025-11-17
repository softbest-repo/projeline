<?php
include('../f/conf/config.php');

if ($_COOKIE['codAprovado'.$cookie] != "") {

    $codCliente = $_COOKIE['codAprovado'.$cookie];

    if (isset($_POST['complementoUnico'])) {

        $complemento = intval($_POST['complementoUnico']);
        $acao = $_POST['acao'] ?? 'add';

        $sqlProjeto = "SELECT codProjeto FROM projetosComplementos  WHERE codProjetoComplementar = $complemento LIMIT 1";
        $rProj = $conn->query($sqlProjeto);
        $dProj = $rProj->fetch_assoc();
        $codProjeto = $dProj['codProjeto'] ?? 0;

        if ($codProjeto == 0) {
            echo json_encode([
                'success' => false,
                'tipo' => 'carrinho',
                'message' => 'Complemento inválido.'
            ]);
            exit;
        }

        if ($acao === 'add') {

            $sqlCheck = "SELECT codCarrinho FROM carrinho WHERE codCliente = '$codCliente' AND codProjeto = '$codProjeto' AND codProjetoComplementar = '$complemento' LIMIT 1";
            $resCheck = $conn->query($sqlCheck);

            if ($resCheck->num_rows == 0) {
                $sqlInsert = "INSERT INTO carrinho  VALUES (0, '$codCliente', '$codProjeto', '$complemento', 1, '".date('Y-m-d H:i:s')."')";
                $conn->query($sqlInsert);
            }

            echo json_encode([
                'success' => true,
                'tipo' => 'carrinho',
                'message' => 'Complemento adicionado ao carrinho!'
            ]);
            exit;
        }

        if ($acao === 'remove') {
            $sqlDel = "DELETE FROM carrinho WHERE codCliente = '$codCliente' AND codProjeto = '$codProjeto' AND codProjetoComplementar = '$complemento' LIMIT 1";
            $conn->query($sqlDel);

            echo json_encode([
                'success' => true,
                'tipo' => 'carrinho',
                'message' => 'Item removido do carrinho!'
            ]);
            exit;
        }
    }
    if (isset($_POST['codProjeto'])) {

        $codProjeto = intval($_POST['codProjeto']);

        $sqlCheckProjeto = "SELECT codCarrinho FROM carrinho WHERE codCliente = '$codCliente' AND codProjeto = '$codProjeto' AND codProjetoComplementar = 0 LIMIT 1";
        $resProjeto = $conn->query($sqlCheckProjeto);

        if ($resProjeto->num_rows == 0) {
            $sqlInsertProjeto = "INSERT INTO carrinho  VALUES (0, '$codCliente', '$codProjeto', 0, 1, '".date('Y-m-d H:i:s')."')";
            $conn->query($sqlInsertProjeto);
        }

        echo json_encode([
            'success' => true,
            'tipo' => 'carrinho',
            'message' => 'Projeto adicionado ao carrinho!'
        ]);
        exit;
    }
} else {

    echo json_encode([
        'success' => false,
        'tipo' => 'cliente',
        'message' => 'Realize seu login para continuar.'
    ]);
    exit;
}
?>
