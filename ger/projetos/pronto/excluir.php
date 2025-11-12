<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[5] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT nomeProjeto FROM projetos WHERE codProjeto = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sqlExcluiImagens = "SELECT * FROM projetosImagens WHERE codProjeto = ".$url[6]." ORDER BY codProjetoImagem ASC";
					$resultExcluiImagens = $conn->query($sqlExcluiImagens);
					while($dadosExcluiImagens = $resultExcluiImagens->fetch_assoc()){
						
						if(file_exists("f/projetos/".$dadosExcluiImagens['codProjeto']."-".$dadosExcluiImagens['codProjetoImagem']."-O.".$dadosExcluiImagens['extProjetoImagem'])){
							unlink("f/projetos/".$dadosExcluiImagens['codProjeto']."-".$dadosExcluiImagens['codProjetoImagem']."-O.".$dadosExcluiImagens['extProjetoImagem']);
							unlink("f/projetos/".$dadosExcluiImagens['codProjeto']."-".$dadosExcluiImagens['codProjetoImagem']."-MD.".$dadosExcluiImagens['extProjetoImagem']);
							unlink("f/projetos/".$dadosExcluiImagens['codProjeto']."-".$dadosExcluiImagens['codProjetoImagem']."-W.webp");
						}
							
					}

					$sql =  "DELETE FROM projetosImagens WHERE codProjeto = ".$url[6];
					$result = $conn->query($sql);
										
					$sql =  "DELETE FROM projetos WHERE codProjeto = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeProjeto'];
						$_SESSION['exclusaos'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/pronto/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/pronto/'>";
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
