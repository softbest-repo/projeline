<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "clientes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){


				if($url[5] != ""){
					$sqlCons = "SELECT * FROM clientes WHERE codCliente = ".$url[6].$filtraUsuario." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
				
					echo "<div id='filtro'>";
					
					if($dadosCons['status'] == "T"){
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Desativando...</p>";
					}else{
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Ativando...</p>";
					}
					
					echo "</div>";
					
					if($dadosCons['statusCliente'] == "T"){
						$alteraStatus = "F";
						$_SESSION['acao'] = "desativado";
					}else{
						$alteraStatus = "T";
						$_SESSION['acao'] = "ativado";
					}
					
					$sql =  "UPDATE clientes SET statusCliente = '".$alteraStatus."' WHERE codCliente = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeCliente'];
						$_SESSION['ativar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/clientes/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/clientes/'>";
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
