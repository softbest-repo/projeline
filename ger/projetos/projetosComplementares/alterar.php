<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosComplementares";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codProjetoComplementar, nomeProjetoComplementar, statusProjetoComplementar FROM projetosComplementares WHERE codProjetoComplementar = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Projetos Complementares</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeProjetoComplementar'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusProjetoComplementar'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/projetosComplementares/ativacao/<?php echo $dadosNomePagamento['codProjetoComplementar'] ?>/' title='Deseja <?php echo $statusPergunta ?> a área de atuação <?php echo $dadosNomePagamento['nomeProjetoComplementar'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codProjetoComplementar'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeProjetoComplementar']) ?>");' title='Deseja excluir a área de atuação <?php echo $dadosNomePagamento['nomeProjetoComplementar'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir a área de atuação "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/projetosComplementares/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Áreas de Atuação" href="<?php echo $configUrl;?>projetos/projetosComplementares/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlProjetoComplementar = criaUrl($_POST['nome']);

					$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);

					$preco = str_replace(".", "", $_POST['preco']);
					$preco = str_replace(",", ".", $preco);
																						
					$sql = "UPDATE projetosComplementares SET nomeProjetoComplementar = '".preparaNome($_POST['nome'])."', precoProjetoComplementar = '".$preco."', descricaoProjetoComplementar = '".str_replace("'", "&#39;", $descricao)."', urlProjetoComplementar = '".$urlProjetoComplementar."' WHERE codProjetoComplementar = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/projetosComplementares/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar área de atuação!</p>";
					}
				}else{
					$sql = "SELECT * FROM projetosComplementares WHERE codProjetoComplementar = ".$url[6];
					$result = $conn->query($sql);
					$dadosProjetoComplementar = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosProjetoComplementar['nomeProjetoComplementar'];
					$_SESSION['preco'] = number_format($dadosProjetoComplementar['precoProjetoComplementar'], 2, ",", ".");
					$_SESSION['descricao'] = $dadosProjetoComplementar['descricaoProjetoComplementar'];
					$_SESSION['status'] = $dadosProjetoComplementar['statusProjetoComplementar'];
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
								document.getElementById("preco").disabled = false;
								tinymce.get("descricao").setMode("design");
								
								
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>projetos/projetosComplementares/alterar/<?php echo $url[6] ;?>/" method="post">
							<script>
								function moeda(z){  
									v = z.value;
									v=v.replace(/\D/g,"") 
								v=v.replace(/[0-9]{12}/,"inválido") 
								v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") 
								v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  
								v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	
									z.value = v;
								}
							</script>

							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:635px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Preço: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="preco" id="preco" style="width:180px;" required value="" onkeyup="moeda(this)" /></p>
							
							<br class="clear"/>

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
