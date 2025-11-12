<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "equipe";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codEquipe, nomeEquipe, statusEquipe FROM equipe WHERE codEquipe = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Equipe</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeEquipe'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusEquipe'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/equipe/ativacao/<?php echo $dadosNomePagamento['codEquipe'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da equipe <?php echo $dadosNomePagamento['nomeEquipe'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codEquipe'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeEquipe']) ?>");' title='Deseja excluir o integrante da equipe <?php echo $dadosNomePagamento['nomeEquipe'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o integrante da equipe "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/equipe/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Equipe" href="<?php echo $configUrl;?>cadastros/equipe/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
						<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
						<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>						
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlEquipe = criaUrl($_POST['nome']);

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
																						
					$sql = "UPDATE equipe SET nomeEquipe = '".preparaNome($_POST['nome'])."', subNomeEquipe = '".preparaNome($_POST['subNome'])."', descricaoEquipe = '".str_replace("'", "&#39;", $descricao)."', urlEquipe = '".$urlEquipe."' WHERE codEquipe = '".$url[6]."'";
					$result = $conn->query($sql); 
															
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/equipe/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar integrante da equipe!</p>";
					}
				}else{
					$sql = "SELECT * FROM equipe WHERE codEquipe = ".$url[6];
					$result = $conn->query($sql);
					$dadosEquipe = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosEquipe['nomeEquipe'];
					$_SESSION['subNome'] = $dadosEquipe['subNomeEquipe'];
					$_SESSION['descricao'] = $dadosEquipe['descricaoEquipe'];
					$_SESSION['status'] = $dadosEquipe['statusEquipe'];
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
<?php
				if($url[6] != 0){
?>
								document.getElementById("subNome").disabled = false;
<?php
				}
?>
								document.getElementById("alterar").disabled = false;
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>cadastros/equipe/alterar/<?php echo $url[6] ;?>/" method="post">

<?php
				if($url[6] == 0){
?>
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:815px;" value="<?php echo $_SESSION['nome']; ?>" /></p>
<?php
				}else{
?>
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:580px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Função: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="subNome" name="subNome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:208px;" 
							 value="<?php echo $_SESSION['subNome']; ?>" /></p>
							
							<br class="clear"/>

<?php
				}
?>
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
