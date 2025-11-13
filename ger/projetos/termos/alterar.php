<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "termos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codTermo, nomeTermo, statusTermo FROM termos WHERE codTermo = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projetos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Termos e Garantias</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeTermo'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusTermo'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
			
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir a termos e garantias "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/termos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlTermo = criaUrl($_POST['nome']);

					$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
																						
				 	$sql = "UPDATE termos SET nomeTermo = '".preparaNome($_POST['nome'])."', descricaoTermo = '".str_replace("'", "&#39;", $descricao)."', urlTermo = '".$urlTermo."' WHERE codTermo = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						$sql = "SELECT * FROM termos WHERE codTermo = ".$url[6];
						$result = $conn->query($sql);
						$dadosTermo = $result->fetch_assoc();
						$_SESSION['nome'] = $dadosTermo['nomeTermo'];
						$_SESSION['descricao'] = $dadosTermo['descricaoTermo'];
						$_SESSION['status'] = $dadosTermo['statusTermo'];
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar termos e garantias!</p>";
					}
				}else{
					$sql = "SELECT * FROM termos WHERE codTermo = ".$url[6];
					$result = $conn->query($sql);
					$dadosTermo = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosTermo['nomeTermo'];
					$_SESSION['descricao'] = $dadosTermo['descricaoTermo'];
					$_SESSION['status'] = $dadosTermo['statusTermo'];
				}

				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
						<div class="area-erro">
<?php
					echo $erroData;
					if($erro == "sim" || $erro == "ok"){
						include('f/conf/mostraErro.php');
					}
?>
						</div>
<?php
				}
?>				
					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("alterar").disabled = false;
								document.getElementById("nome").disabled = false;
								tinymce.get("descricao").setMode("design");
								
								
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>projetos/termos/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:842px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo" style="width:855px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['status'] = "";
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
