<?php	
	$sqlVerifica = "SELECT * FROM controleAcesso WHERE codUsuario = '".$_COOKIE['codAprovado'.$cookie]."' and dataControle = '".date("Y-m-d")."'";
	$resultVerifica = $conn->query($sqlVerifica);
	$dadosVerifica = $resultVerifica->fetch_assoc();
	
	if($dadosVerifica['codControle'] == $_COOKIE['controleAprovado'.$cookie]){
		$controleUsuario = "tem usuario";
	}else{
		$retornoControle = "";
	}
	
	$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$_COOKIE['codAprovado'.$cookie]."' LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();
	
	if($dadosUsuario['tipoUsuario'] == "C"){
		$filtraUsuario = " and codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioI = " and CO.codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioIM = " and I.codUsuario = ".$dadosUsuario['codUsuario']."";
		$usuario = "C";
	}else{
		$filtraUsuario = "";
		$filtraUsuarioI = "";
		$filtraUsuarioIM = "";
		$usuario = "A";
	}
?>
	
