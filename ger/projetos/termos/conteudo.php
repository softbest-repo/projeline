<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "termos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Termos e Garantias <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Termos e Garantias <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Termos e Garantias <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Termos e Garantias <strong>".$_SESSION['nome']."</strong> excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projetos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Termos e Garantias</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>projetos/termos/" method="post" />
				
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlTermo = criaUrl($_POST['nome']);

					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
					
					$sql = "INSERT INTO termos VALUES(0, '".preparaNome($_POST['nome'])."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlTermo."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/termos/'>";
						}else{
							$erroData = "<p class='erro'>Termos e Garantias <strong>".$_POST['nome']."</strong> cadastrada com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar termos e garantias!</p>";
					}
				
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
					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form action="<?php echo $configUrlGer; ?>projetos/termos/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:842px;" required value="" /></p>

							<p class="bloco-campo" style="width:855px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Termo" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
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
				
				$sqlConta = "SELECT nomeTermo FROM termos WHERE codTermo != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeTermo'] != ""){
?>
						<table class="tabela-menus">
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Nome</th>
								<th>Status</th>
								<th class="canto-dir">Alterar</th>
							</tr>	
							<tbody id="tabela-itens">																
<?php

					$sqlTermo = "SELECT * FROM termos ORDER BY statusTermo ASC, codTermo DESC";
					$resultTermo = $conn->query($sqlTermo);
					while($dadosTermo = $resultTermo->fetch_assoc()){
						
						if($dadosTermo['statusTermo'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}
							
?>
								<tr class="tr">
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>projetos/termos/alterar/<?php echo $dadosTermo['codTermo'] ?>/' title='Veja os detalhes da termos e garantias <?php echo $dadosTermo['nomeTermo'] ?>'><?php echo $dadosTermo['nomeTermo'];?></a></td> 
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/termos/ativacao/<?php echo $dadosTermo['codTermo'] ?>/' title='Deseja <?php echo $statusPergunta ?> a termos e garantias <?php echo $dadosTermo['nomeTermo'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/termos/alterar/<?php echo $dadosTermo['codTermo'] ?>/' title='Deseja alterar a termos e garantias <?php echo $dadosTermo['nomeTermo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								</tr>
<?php
					}
?>								 
							</tbody>					 
						</table>	
						<script type="text/javascript">
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a termos e garantias "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/termos/excluir/'+cod+'/';
								}
							}
						</script>	
						<p style="font-size:15px; color:#31625E; text-align:center; padding-top:20px;">Total de registros: <strong style="font-size:15px; color:#31625E;"><?php echo $registros;?></strong></p>													
<?php
				}else{		
?>							
						<p style="font-size:15px; color:#31625E; text-align:center; padding-top:20px;">Nenhum registro encontrado!</p>																				
<?php
				}
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
