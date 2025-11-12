<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/orcamentos/';
	
	$codOrcamento = $_POST['codOrcamento'];

	function saveWebPImage($original_image, $new_image_path, $quality = 100) {
		if (imagewebp($original_image, $new_image_path, $quality)) {
			return true;
		} else {
			return false;
		}
	}
									
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		if (strpos($file_type, 'image') === false) {
			continue;
		}

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  
		if(in_array($ext, ['jpg', 'jpeg', 'png', 'svg'])){	
			
			$file_name = uniqid().'.'.$ext;							
				
			$sqlOrcamento = "INSERT INTO orcamentosAnexos VALUES(0, ".$codOrcamento.", 'F', '".$ext."')";
			$resultOrcamento = $conn->query($sqlOrcamento);	

			$sqlPegaOrcamento = "SELECT codOrcamentoAnexo FROM orcamentosAnexos ORDER BY codOrcamentoAnexo DESC LIMIT 0,1";
			$resultPegaOrcamento = $conn->query($sqlPegaOrcamento);
			$dadosPegaOrcamento = $resultPegaOrcamento->fetch_assoc();
						
			$codOrcamentoAnexo = $dadosPegaOrcamento['codOrcamentoAnexo'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-O.".$ext);
							
			chmod($pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-O.".$ext, 0755);
			
			if($ext != "svg"){
							   
				$imagemWebP = $pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-W.webp";

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					$original_image = imagecreatefromjpeg($pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-O.".$ext);
					break;
					case 'png':
					$original_image = imagecreatefrompng($pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-O.".$ext);
					break;
					case 'gif':
					$original_image = imagecreatefromgif($pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-O.".$ext);
					break;
				}

				saveWebPImage($original_image, $imagemWebP, 95);
				imagedestroy($original_image);

				chmod($pastaDestino.$codOrcamento."-".$codOrcamentoAnexo."-W.webp", 0755);								
			}

		}else{
			$erroExt = "erro";
		}
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."atendimento/orcamentos/anexos/".$codOrcamento."/'>";		
?>
