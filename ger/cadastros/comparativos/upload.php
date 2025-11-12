<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/comparativos/';
	
	$codComparativo = $_POST['codComparativo'];

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
				
			$sqlComparativo = "INSERT INTO comparativosImagens VALUES(0, ".$codComparativo.", 'F', '".$ext."')";
			$resultComparativo = $conn->query($sqlComparativo);	

			$sqlPegaComparativo = "SELECT codComparativoImagem FROM comparativosImagens ORDER BY codComparativoImagem DESC LIMIT 0,1";
			$resultPegaComparativo = $conn->query($sqlPegaComparativo);
			$dadosPegaComparativo = $resultPegaComparativo->fetch_assoc();
						
			$codComparativoImagem = $dadosPegaComparativo['codComparativoImagem'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codComparativo."-".$codComparativoImagem."-O.".$ext);
							
			chmod($pastaDestino.$codComparativo."-".$codComparativoImagem."-O.".$ext, 0755);
			
			if($ext != "svg"){
							   
				$imagemWebP = $pastaDestino.$codComparativo."-".$codComparativoImagem."-W.webp";

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					$original_image = imagecreatefromjpeg($pastaDestino.$codComparativo."-".$codComparativoImagem."-O.".$ext);
					break;
					case 'png':
					$original_image = imagecreatefrompng($pastaDestino.$codComparativo."-".$codComparativoImagem."-O.".$ext);
					break;
					case 'gif':
					$original_image = imagecreatefromgif($pastaDestino.$codComparativo."-".$codComparativoImagem."-O.".$ext);
					break;
				}

				saveWebPImage($original_image, $imagemWebP, 95);
				imagedestroy($original_image);

				chmod($pastaDestino.$codComparativo."-".$codComparativoImagem."-W.webp", 0755);								
			}

		}else{
			$erroExt = "erro";
		}
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/comparativos/imagens/".$codComparativo."/'>";		
?>
