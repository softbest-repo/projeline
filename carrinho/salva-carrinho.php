<?php
include('../f/conf/config.php');

if ($_COOKIE['codAprovado'.$cookie] != "") {

    $codCliente = $_COOKIE['codAprovado'.$cookie];
    $codProjeto = intval($_POST['codProjeto']);
    $complementares = isset($_POST['complementares']) ? $_POST['complementares'] : [];


    $sqlCheckProjeto = " SELECT codCarrinho FROM carrinho WHERE codCliente = '$codCliente' AND codProjeto = '$codProjeto' AND codProjetoComplementar = 0 LIMIT 1 ";
    $resProjeto = $conn->query($sqlCheckProjeto);

    if ($resProjeto->num_rows == 0) {
        $sqlInsertProjeto = " INSERT INTO carrinho VALUES( 0, '$codCliente', '$codProjeto', 0, 1, '".date('Y-m-d H:i:s')."' ) ";
        $conn->query($sqlInsertProjeto);
    }

    foreach ($complementares as $comp) {

        $comp = intval($comp);
        $sqlCheckComp = "  SELECT codCarrinho FROM carrinho WHERE codCliente = '$codCliente' AND codProjeto = '$codProjeto' AND codProjetoComplementar = '$comp'LIMIT 1 ";
        $resComp = $conn->query($sqlCheckComp);

        if ($resComp->num_rows == 0) {
			$sqlInsertComp = " INSERT INTO carrinho VALUES( 0, '$codCliente', '$codProjeto', '$comp', 1, '".date('Y-m-d H:i:s')."' ) ";
            $conn->query($sqlInsertComp);
        }
    }

    echo json_encode([
        'success' => true,
        'tipo' => 'carrinho',
        'message' => 'Projeto e complementares adicionados ao carrinho!'
    ]);
    exit;

} else {

    echo json_encode([
        'success' => false,
        'tipo' => 'cliente',
        'message' => 'Realize seu login para continuar.'
    ]);
}
?>
