<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/projetosAnexo/';
	
	$codProjeto = $_POST['codProjeto'];
								
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  						
		$sqlProjeto = "INSERT INTO projetosAnexos VALUES(0, ".$codProjeto.", '".$file_name."', '".$ext."')";
		$resultProjeto = $conn->query($sqlProjeto);	

		$sqlPegaProjeto = "SELECT codProjetoAnexo FROM projetosAnexos ORDER BY codProjetoAnexo DESC LIMIT 0,1";
		$resultPegaProjeto = $conn->query($sqlPegaProjeto);
		$dadosPegaProjeto = $resultPegaProjeto->fetch_assoc();
					
		$codProjetoAnexo = $dadosPegaProjeto['codProjetoAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codProjeto."-".$codProjetoAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codProjeto."-".$codProjetoAnexo."-O.".$ext, 0755);					   
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/pronto/anexos/".$codProjeto."/'>";		
?>
