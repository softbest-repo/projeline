<?php
	session_start();

	include('../../f/conf/config.php');
	
	require '../../../vendor/autoload.php';
	
	use Intervention\Image\ImageManagerStatic as Image;

	 $pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/projetos/';
	
	 $codProjeto = $_POST['codProjeto'];
	
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

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  
		if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'mp4'])){	
			
			$file_name = uniqid().'.'.$ext;							

			$sqlCont = "SELECT * FROM projetosImagens WHERE codProjeto = ".$codProjeto." ORDER BY ordenacaoProjetoImagem DESC LIMIT 0,1";
			$resultCont = $conn->query($sqlCont);
			$dadosCont = $resultCont->fetch_assoc();
			
			if($dadosCont['codProjetoImagem'] == ""){
				$cont = 1;
			}else{
				$cont = $dadosCont['ordenacaoProjetoImagem'] + 1;
			}
							
			$sqlProjeto = "INSERT INTO projetosImagens VALUES(0, ".$codProjeto.", ".$cont.", '".$ext."')";
			$resultProjeto = $conn->query($sqlProjeto);	

			$sqlPegaProjeto = "SELECT codProjetoImagem FROM projetosImagens ORDER BY codProjetoImagem DESC LIMIT 0,1";
			$resultPegaProjeto = $conn->query($sqlPegaProjeto);
			$dadosPegaProjeto = $resultPegaProjeto->fetch_assoc();
						
			$codProjetoImagem = $dadosPegaProjeto['codProjetoImagem'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codProjeto."-".$codProjetoImagem."-O.".$ext);
							
			chmod($pastaDestino.$codProjeto."-".$codProjetoImagem."-O.".$ext, 0755);
			
			if($ext != "mp4"){
			
				$imagem_original = $pastaDestino.$codProjeto."-".$codProjetoImagem."-O.".$ext;
				
				$imagemPreparada = Image::make($imagem_original);
				
				$width = $imagemPreparada->width();
				$height = $imagemPreparada->height();
				
				if($width >= 1920 && $height >= 1080) {
					$imagemPreparada->fit(1920, 1080)->save($imagem_original);	
					$liberado = "ok";
				}else			
				if($width >= 1600 && $height >= 900) {
					$imagemPreparada->fit(1600, 900)->save($imagem_original);	
					$liberado = "ok";
				}else			
				if($width >= 1200 && $height >= 675) {
					$imagemPreparada->fit(1200, 675)->save($imagem_original);	
					$liberado = "ok";
				}else			
				if($width >= 800 && $height >= 450){
					$imagemPreparada->fit(800, 450)->save($imagem_original);					
					$liberado = "ok";
				}else
				if($width >= 600 && $height >= 338){
					$imagemPreparada->fit(600, 338)->save($imagem_original);								
					$liberado = "ok";
				}else{
					$liberado = "nao";
				}
				
				if($liberado == "ok"){
					list($width, $height) = getimagesize($imagem_original);

					$imagemWebP = $pastaDestino.$codProjeto."-".$codProjetoImagem."-W.webp";

					$new_image = imagecreatetruecolor($width, $height);

					switch ($ext) {
						case 'jpg':
						case 'jpeg':
						$original_image = imagecreatefromjpeg($imagem_original);
						break;
						case 'png':
						$original_image = imagecreatefrompng($imagem_original);
						break;
						case 'gif':
						$original_image = imagecreatefromgif($imagem_original);
						break;
					}

					imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $width, $height, $width, $height);

					$watermark_path = "marca.png";

					$watermark = imagecreatefrompng($watermark_path);
					imagealphablending($watermark, true);
					imagesavealpha($watermark, true);

					$resized_width = imagesx($new_image);
					$resized_height = imagesy($new_image);

					$watermark_ratio = 0.13;

					$original_watermark_width = imagesx($watermark);
					$original_watermark_height = imagesy($watermark);

					if ($original_watermark_width > $original_watermark_height) {
						$watermark_width = $resized_width * $watermark_ratio;
						$watermark_height = $watermark_width * ($original_watermark_height / $original_watermark_width);
					} else {
						$watermark_height = $resized_height * $watermark_ratio;
						$watermark_width = $watermark_height * ($original_watermark_width / $original_watermark_height);
					}

					$watermark_resized = imagecreatetruecolor($watermark_width, $watermark_height);
					imagealphablending($watermark_resized, false);
					imagesavealpha($watermark_resized, true);
					imagecopyresampled($watermark_resized, $watermark, 0, 0, 0, 0, $watermark_width, $watermark_height, $original_watermark_width, $original_watermark_height);

					$dest_x = $resized_width - $watermark_width - 20; // 30 pixels de margem à direita
					$dest_y = $resized_height - $watermark_height - 20; // 30 pixels de margem na parte inferior

					imagecopy($new_image, $watermark_resized, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

					switch ($ext) {
						case 'jpg':
						case 'jpeg':
						imagejpeg($new_image, $pastaDestino.$codProjeto."-".$codProjetoImagem."-MD.".$ext, 100);
						break;
						case 'png':
						imagepng($new_image, $pastaDestino.$codProjeto."-".$codProjetoImagem."-MD.".$ext);
						break;
						case 'gif':
						imagegif($new_image, $pastaDestino.$codProjeto."-".$codProjetoImagem."-MD.".$ext);
						break;
					}

					saveWebPImage($new_image, $imagemWebP, 98);

					chmod($pastaDestino.$codProjeto."-".$codProjetoImagem."-MD.".$ext, 0755);
					chmod($pastaDestino.$codProjeto."-".$codProjetoImagem."-W.webp", 0755);

					imagedestroy($new_image);
					imagedestroy($watermark);
				}else{							   
					$sqlDelete = "DELETE FROM projetosImagens WHERE codProjetoImagem = ".$codProjetoImagem;
					$resultDelete = $conn->query($sqlDelete);
					
					unlink($imagem_original);
					
					$erroTamanho = "sim";
				}
			}
			
		}else{
			$erroExtensao = "sim";
		}
	}
	
	if($erroTamanho == "sim"){
		$_SESSION['erroTamanho'] = "<p class='erro'>Uma ou mais imagens são muito pequenas e por isso não foram cadastradas!</p>";
	}
	
	if($erroExtensao == "sim"){
		$_SESSION['erroExtensao'] = "<p class='erro'>Uma ou mais imagens não possuem extensão permitida para cadastro!</p>";
	}
	
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/pronto/imagens/".$codProjeto."/'>";				
?>
