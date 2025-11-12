<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosPersonalizados";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codProjetoPersonalizado, nomeProjetoPersonalizado, statusProjetoPersonalizado FROM projetosPersonalizados WHERE codProjetoPersonalizado = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projetos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Projetos Personalizados</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeProjetoPersonalizado'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusProjetoPersonalizado'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/ativacao/<?php echo $dadosNomePagamento['codProjetoPersonalizado'] ?>/' title='Deseja <?php echo $statusPergunta ?>o Projeto <?php echo $dadosNomePagamento['nomeProjetoPersonalizado'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codProjetoPersonalizado'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeProjetoPersonalizado']) ?>");' title='Deseja excluir o Projeto <?php echo $dadosNomePagamento['nomeProjetoPersonalizado'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o Projeto "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Áreas de Atuação" href="<?php echo $configUrl;?>projetos/projetosPersonalizados/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlProjetoPersonalizado = criaUrl($_POST['nome']);

					$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
																						
					$sql = "UPDATE projetosPersonalizados SET nomeProjetoPersonalizado = '".preparaNome($_POST['nome'])."', descricaoProjetoPersonalizado = '".str_replace("'", "&#39;", $descricao)."', tipoProjeto = ".$_POST['tipo']." ,  urlProjetoPersonalizado = '".$urlProjetoPersonalizado."' WHERE codProjetoPersonalizado = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/projetosPersonalizados/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar Projeto!</p>";
					}
				}else{
					$sql = "SELECT * FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$url[6];
					$result = $conn->query($sql);
					$dadosProjetoPersonalizado = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosProjetoPersonalizado['nomeProjetoPersonalizado'];
					$_SESSION['descricao'] = $dadosProjetoPersonalizado['descricaoProjetoPersonalizado'];
					$_SESSION['status'] = $dadosProjetoPersonalizado['statusProjetoPersonalizado'];
					$_SESSION['tipo'] = $dadosProjetoPersonalizado['tipoProjeto'];
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
								document.getElementById("tipo").disabled = false;

								
								
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/alterar/<?php echo $url[6] ;?>/" method="post">

						<p class="bloco-campo-float"><label>Tipo do Projeto: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo" name="tipo" style="width:180px; height:32px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onChange="exibeCamposTipo(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' ORDER BY nomeTipoProjeto ASC";
				$resultTipoProjeto = $conn->query($sqlTipoProjeto);
				while($dadosTipoProjeto = $resultTipoProjeto->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoProjeto['codTipoProjeto'] ;?>" <?php echo $_SESSION['tipo'] == $dadosTipoProjeto['codTipoProjeto'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoProjeto['codTipoProjeto'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:650px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

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
