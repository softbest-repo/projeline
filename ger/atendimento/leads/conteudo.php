<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "leads";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Lead <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Lead <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Leads</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script>
								function abreCadastrar(){
									var $rf = jQuery.noConflict();
									if(document.getElementById("cadastrar").style.display=="none"){
										document.getElementById("botaoFechar").style.display="block";
										$rf("#cadastrar").slideDown(250);
									}else{
										document.getElementById("botaoFechar").style.display="none";
										$rf("#cadastrar").slideUp(250);
									}
								}
							</script>
							<form name="filtro" action="<?php echo $configUrl;?>atendimento/leads/" method="post" />
							</form>
						</div>
					</div>				
				</div>
				<div id="dados-conteudo">

					<div id="consultas">				
<?php	
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
<?php
				}
				
				$sqlConta = "SELECT COUNT(codLead) AS registros, nomeLead FROM leads WHERE localLead = 'S' 	GROUP BY nomeLead";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				if($dadosConta['nomeLead'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Nome</th>
								<th>WhatsApp</th>
								<th>Data / Hora</th>
								<th>Status</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlLead = "SELECT * FROM leads WHERE localLead = 'S' ORDER BY statusLead ASC, dataLead DESC, codLead DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlLead = "SELECT * FROM leads WHERE localLead = 'S' ORDER BY statusLead ASC, dataLead DESC, codLead DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultLead = $conn->query($sqlLead);
					while($dadosLead = $resultLead->fetch_assoc()){
						$mostrando++;
						
						if($dadosLead['statusLead'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	
						
						$dataLead = explode(" ", $dadosLead['dataLead']);
?>
								<tr class="tr">
									<td class="trinta"><a><?php echo $dadosLead['nomeLead'];?></a></td>
									<td class="trinta" style="text-align:center;"><a><?php echo $dadosLead['celularLead'];?></a></td>
									<td class="trinta" style="text-align:center;"><a><?php echo data($dataLead[0]);?> ás <?php echo $dataLead[1];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/leads/ativacao/<?php echo $dadosLead['codLead'] ?>/' title='Deseja <?php echo $statusPergunta ?> o lead <?php echo $dadosLead['nomeLead'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosLead['codLead'] ?>, "<?php echo htmlspecialchars($dadosLead['nomeLead']) ?>");' title='Deseja excluir o lead <?php echo $dadosLead['nomeLead'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o lead "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/leads/excluir/'+cod+'/';
										}
									}
								</script>
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "atendimento/leads";
				include ('f/conf/paginacao.php');		
?>							
					</div>
				</div>
<?php
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
