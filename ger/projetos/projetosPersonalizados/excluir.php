<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosPersonalizados";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[5] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT nomeProjetoPersonalizado FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					$sql =  "DELETE FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeProjetoPersonalizado'];
						$_SESSION['exclusao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/projetosPersonalizados/'>";
					}

				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos/projetosPersonalizados/'>";
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
