<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/projetosComplementaresAnexo/';
	
	$codProjetoComplementar = $_POST['codProjetoComplementar'];
								
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  						
		$sqlProjetoComplementar = "INSERT INTO projetosComplementaresAnexos VALUES(0, ".$codProjetoComplementar.", '".$file_name."', '".$ext."')";
		$resultProjetoComplementar = $conn->query(query: $sqlProjetoComplementar);	

		$sqlPegaProjetoComplementar = "SELECT codProjetoComplementarAnexo FROM projetosComplementaresAnexos ORDER BY codProjetoComplementarAnexo DESC LIMIT 0,1";
		$resultPegaProjetoComplementar = $conn->query($sqlPegaProjetoComplementar);
		$dadosPegaProjetoComplementar = $resultPegaProjetoComplementar->fetch_assoc();
					
		$codProjetoComplementarAnexo = $dadosPegaProjetoComplementar['codProjetoComplementarAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codProjetoComplementar."-".$codProjetoComplementarAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codProjetoComplementar."-".$codProjetoComplementarAnexo."-O.".$ext, 0755);					   
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/projetosComplementares/anexos/".$codProjetoComplementar."/'>";		
?>
