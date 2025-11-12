<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "duvidas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
				
				if($url[5] != ""){
				
					$sqlCons = "SELECT nomeDuvida, statusDuvida FROM duvidas WHERE codDuvida = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					echo "<div id='filtro'>";
				
					if($dadosCons['statusDuvida'] == "T"){
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Desativando...</p>";
					}else{
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Ativando...</p>";
					}
					
					echo "</div>";
					
					if($dadosCons['statusDuvida'] == "T"){
						$alteraStatus = "F";
						$_SESSION['acao'] = "desativado";
					}else{
						$alteraStatus = "T";
						$_SESSION['acao'] = "ativado";
					}
					
					$sql =  "UPDATE duvidas SET statusDuvida = '".$alteraStatus."' WHERE codDuvida = ".$url[6];
					$result = $conn->query($sql);
				
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeDuvida'];
						$_SESSION['ativacao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/duvidas/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/duvidas/'>";
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
