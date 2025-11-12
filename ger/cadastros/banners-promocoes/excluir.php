<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners-promocoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[5] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT nomeBannerPromocao FROM bannersPromocoes WHERE codBannerPromocao = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sql =  "DELETE FROM bannersPromocoes WHERE codBannerPromocao = ".$url[6];
					$result = $conn->query($sql);

					$sqlExcluiImagens = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$url[6]." ORDER BY codBannerPromocaoImagem ASC";
					$resultExcluiImagens = $conn->query($sqlExcluiImagens);
					while($dadosExcluiImagens = $resultExcluiImagens->fetch_assoc()){
						
						if(file_exists("f/banners-promocoes/".$dadosExcluiImagens['codBannerPromocao']."-".$dadosExcluiImagens['codBannerPromocaoImagem']."-O.".$dadosExcluiImagens['extBannerPromocaoImagem'])){
							unlink("f/banners-promocoes/".$dadosExcluiImagens['codBannerPromocao']."-".$dadosExcluiImagens['codBannerPromocaoImagem']."-O.".$dadosExcluiImagens['extBannerPromocaoImagem']);
							unlink("f/banners-promocoes/".$dadosExcluiImagens['codBannerPromocao']."-".$dadosExcluiImagens['codBannerPromocaoImagem']."-P.".$dadosExcluiImagens['extBannerPromocaoImagem']);
							unlink("f/banners-promocoes/".$dadosExcluiImagens['codBannerPromocao']."-".$dadosExcluiImagens['codBannerPromocaoImagem']."-G.".$dadosExcluiImagens['extBannerPromocaoImagem']);
						}
							
					}

					$sql =  "DELETE FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$url[6];
					$result = $conn->query($sql);
										
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeBannerPromocao'];
						$_SESSION['exclusao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/banners-promocoes/'>";
					}

				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/banners-promocoes/'>";
				}

			}else{
?>	
			<div id="filtro">
				<div id="erro-permicao">	
<?php
				echo "<p><strong>Você não tem permissão para acessar essa área!</strong></p>";
				echo "<p>Para mais informações entre em contato com o administrador!</p>";
?>	
				</div>
			</div>
<?php
			}

		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
