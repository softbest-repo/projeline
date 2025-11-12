<?php
	include('../f/conf/config.php');
	
	if($_COOKIE['codAprovado'.$cookie] != ""){
	
		$codProjeto = $_POST['codProjeto'];
		$codProjetoComplementar = $_POST['codProjetoComplementar'];
		
		$sqlCarrinho = "SELECT * FROM carrinho WHERE codProjeto = '".$codProjeto."' and codProjetoComplementar = '".$codProjetoComplementar."' and codCliente = '".$_COOKIE['codAprovado'.$cookie]."' ORDER BY codCarrinho DESC LIMIT 0,1";
		$resultCarrinho = $conn->query($sqlCarrinho);
		$dadosCarrinho = $resultCarrinho->fetch_assoc();
		
		if($dadosCarrinho['codCarrinho'] == ""){
			$sqlInsere = "INSERT INTO carrinho VALUES(0, '".$_COOKIE['codAprovado'.$cookie]."', '".$codProjeto."', '".$codProjetoComplementar."', 1, '".date('Y-m-d H:i:s')."')";
			$resultInsere = $conn->query($sqlInsere);
			
			if($resultInsere == 1){
				if($codProjetoComplementar != 0){
					echo json_encode(['success' => true, 'tipo' => 'carrinho', 'message' => 'Projeto Complementar inserido no carrinho com sucesso!']);
				}else{
					echo json_encode(['success' => true, 'tipo' => 'carrinho', 'message' => 'Projeto inserido no carrinho com sucesso!']);
				}
			}else{
				echo json_encode(['success' => false, 'tipo' => 'carrinho', 'message' => 'Problemas ao inserir no carrinho!']);
			}
		}else{
			if($codProjetoComplementar != 0){
				echo json_encode(['success' => false, 'tipo' => 'carrinho', 'message' => 'Projeto Complementar já se encontra no seu carrinho!']);	
			}else{
				echo json_encode(['success' => false, 'tipo' => 'carrinho', 'message' => 'Projeto já se encontra no seu carrinho!']);	
			}
		}
	}else{
		echo json_encode(['success' => false, 'tipo' => 'cliente', 'message' => 'Clique no botão abaixo e realize o seu login ou cadastre-se.']);	
	}
?>
