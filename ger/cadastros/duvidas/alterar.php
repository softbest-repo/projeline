<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "duvidas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codDuvida, nomeDuvida, statusDuvida FROM duvidas WHERE codDuvida = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Dúvida</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeDuvida'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusDuvida'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/duvidas/ativacao/<?php echo $dadosNomePagamento['codDuvida'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da duvidas <?php echo $dadosNomePagamento['nomeDuvida'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codDuvida'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeDuvida']) ?>");' title='Deseja excluir o integrante da duvidas <?php echo $dadosNomePagamento['nomeDuvida'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o integrante da duvidas "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/duvidas/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Duvida" href="<?php echo $configUrl;?>cadastros/duvidas/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
						<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
						<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>						
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlDuvida = criaUrl($_POST['nome']);

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
																						
					$sql = "UPDATE duvidas SET nomeDuvida = '".preparaNome($_POST['nome'])."', descricaoDuvida = '".str_replace("'", "&#39;", $descricao)."', urlDuvida = '".$urlDuvida."' WHERE codDuvida = '".$url[6]."'";
					$result = $conn->query($sql); 
															
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/duvidas/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar integrante da duvidas!</p>";
					}
				}else{
					$sql = "SELECT * FROM duvidas WHERE codDuvida = ".$url[6];
					$result = $conn->query($sql);
					$dadosDuvida = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosDuvida['nomeDuvida'];
					$_SESSION['descricao'] = $dadosDuvida['descricaoDuvida'];
					$_SESSION['status'] = $dadosDuvida['statusDuvida'];
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
						<form action="<?php echo $configUrlGer; ?>cadastros/duvidas/alterar/<?php echo $url[6] ;?>/" method="post">

							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width: 813px;" value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<br class="clear"/>

							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>

						</form>
					</div>
				</div>
				<script>
					var $rf = jQuery.noConflict();
					$rf(".select2").select2();				
				</script>				
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['descricao'] = "";
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
