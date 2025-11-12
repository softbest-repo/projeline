<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario() == "tem usuario"){
			
			$area = "vendas";
			if(validaAcesso($area) == "ok"){

				if($url[6] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			
					
					$sqlCons = "SELECT codVenda FROM vendas WHERE codVenda = ".$url[6]." LIMIT 0,1";
					$resultCons = mysql_query($sqlCons);
					$dadosCons = mysql_fetch_array($resultCons);

					$sqlCons2 = "SELECT * FROM vendasItens WHERE codVenda = ".$url[6]." LIMIT 0,1";
					$resultCons2 = mysql_query($sqlCons2);
					while($dadosCons2 = mysql_fetch_array($resultCons2)){
					
						$sql =  "DELETE FROM vendasPartes WHERE CodItem = ".$dadosCons2['CodItem'];
						$result = mysql_query($sql);						
					
					}
					
					$sql =  "DELETE FROM vendasItens WHERE codVenda = ".$url[6];
					$result = mysql_query($sql);

					$sql =  "DELETE FROM vendas WHERE codVenda = ".$url[6];
					$result = mysql_query($sql);
					if($result == 1){
						$_SESSION['nome'] = "";
						$_SESSION['excluir'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."atendimento/vendas/'>";
					}
									
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."atendimento/vendas/'>";
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
