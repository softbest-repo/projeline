<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "opcoesFichas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codOpcaoFicha, nomeOpcaoFicha, statusOpcaoFicha FROM opcoesFichas WHERE codOpcaoFicha = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Opções da Ficha Técnica</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeOpcaoFicha'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusOpcaoFicha'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/opcoesFichas/ativacao/<?php echo $dadosNomePagamento['codOpcaoFicha'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tamanho <?php echo $dadosNomePagamento['nomeOpcaoFicha'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codOpcaoFicha'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeOpcaoFicha']) ?>");' title='Deseja excluir o tamanho <?php echo $dadosNomePagamento['nomeOpcaoFicha'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o tamanho "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/opcoesFichas/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Opções da Ficha Técnica" href="<?php echo $configUrl;?>projetos/opcoesFichas/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlOpcaoFicha = criaUrl($_POST['nome']);
																	
					$sql = "UPDATE opcoesFichas SET nomeOpcaoFicha = '".preparaNome($_POST['nome'])."', urlOpcaoFicha = '".$urlOpcaoFicha."' WHERE codOpcaoFicha = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/opcoesFichas/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar tamanho!</p>";
					}
				}else{
					$sql = "SELECT * FROM opcoesFichas WHERE codOpcaoFicha = ".$url[6];
					$result = $conn->query($sql);
					$dadosOpcaoFicha = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosOpcaoFicha['nomeOpcaoFicha'];
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
								document.getElementById("nome").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>projetos/opcoesFichas/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:400px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
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
