<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/equipe/';
	
	$codEquipe = $_POST['codEquipe'];

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
				
			$sqlEquipe = "INSERT INTO equipeImagens VALUES(0, ".$codEquipe.", 'F', '".$ext."')";
			$resultEquipe = $conn->query($sqlEquipe);	

			$sqlPegaEquipe = "SELECT codEquipeImagem FROM equipeImagens ORDER BY codEquipeImagem DESC LIMIT 0,1";
			$resultPegaEquipe = $conn->query($sqlPegaEquipe);
			$dadosPegaEquipe = $resultPegaEquipe->fetch_assoc();
						
			$codEquipeImagem = $dadosPegaEquipe['codEquipeImagem'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codEquipe."-".$codEquipeImagem."-O.".$ext);
							
			chmod($pastaDestino.$codEquipe."-".$codEquipeImagem."-O.".$ext, 0755);
			
			if($ext != "svg"){
							   
				$imagemWebP = $pastaDestino.$codEquipe."-".$codEquipeImagem."-W.webp";

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					$original_image = imagecreatefromjpeg($pastaDestino.$codEquipe."-".$codEquipeImagem."-O.".$ext);
					break;
					case 'png':
					$original_image = imagecreatefrompng($pastaDestino.$codEquipe."-".$codEquipeImagem."-O.".$ext);
					break;
					case 'gif':
					$original_image = imagecreatefromgif($pastaDestino.$codEquipe."-".$codEquipeImagem."-O.".$ext);
					break;
				}

				saveWebPImage($original_image, $imagemWebP, 95);
				imagedestroy($original_image);

				chmod($pastaDestino.$codEquipe."-".$codEquipeImagem."-W.webp", 0755);								
			}

		}else{
			$erroExt = "erro";
		}
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/equipe/imagens/".$codEquipe."/'>";		
?>
