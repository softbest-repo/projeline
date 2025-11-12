<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "clientes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[6] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			
					
					$sqlCons = "SELECT * FROM clientes WHERE codCliente = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sql =  "DELETE FROM clientes WHERE codCliente = ".$url[6];
					$result = $conn->query($sql);

					$sqlVenda = "SELECT * FROM vendas WHERE codCliente = ".$url[6]." ORDER BY codVenda ASC";
					$resultVenda = $conn->query($sqlVenda);
					while($dadosVenda = $resultVenda->fetch_assoc()){
					
						$sql =  "DELETE FROM vendasItens WHERE codVenda = ".$dadosVenda['codVenda'];
						$result = $conn->query($sql);						

					}
					
					$sql =  "DELETE FROM vendas WHERE codCliente = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeCliente'];
						$_SESSION['excluir'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."atendimento/clientes/'>";
					}
									
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."atendimento/clientes/'>";
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
