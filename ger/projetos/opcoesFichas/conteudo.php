<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "opcoesFichas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
				
				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>OpcaoFicha <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>OpcaoFicha <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>OpcaoFicha <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>OpcaoFicha <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Opções da Ficha Técnica</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>projetos/opcoesFichas/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Opção" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Opção</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php 
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlOpcaoFicha = criaUrl($_POST['nome']);

				 	$sql = "INSERT INTO opcoesFichas VALUES(0, '".preparaNome($_POST['nome'])."', 'T', '".$urlOpcaoFicha."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/opcoesFichas/'>";
						}else{
							$erroData = "<p class='erro'>OpcaoFicha <strong>".$_POST['nome']."</strong> cadastrado com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar tamanho!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
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
						<form action="<?php echo $configUrlGer; ?>projetos/opcoesFichas/" method="post">

								<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="nome" style="width:400px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar OpcaoFicha" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT * FROM opcoesFichas WHERE codOpcaoFicha != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeOpcaoFicha'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlOpcaoFicha = "SELECT * FROM opcoesFichas ORDER BY statusOpcaoFicha ASC, nomeOpcaoFicha ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlOpcaoFicha = "SELECT * FROM opcoesFichas ORDER BY statusOpcaoFicha ASC, nomeOpcaoFicha ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
					while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){
						$mostrando++;
						
						if($dadosOpcaoFicha['statusOpcaoFicha'] == "T"){
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
									<td class="noventa"><a href='<?php echo $configUrlGer; ?>projetos/opcoesFichas/alterar/<?php echo $dadosOpcaoFicha['codOpcaoFicha'] ?>/' title='Veja os detalhes do tamanho <?php echo $dadosOpcaoFicha['nomeOpcaoFicha'] ?>'><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/opcoesFichas/ativacao/<?php echo $dadosOpcaoFicha['codOpcaoFicha'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tamanho <?php echo $dadosOpcaoFicha['nomeOpcaoFicha'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/opcoesFichas/alterar/<?php echo $dadosOpcaoFicha['codOpcaoFicha'] ?>/' title='Deseja alterar o tamanho <?php echo $dadosOpcaoFicha['nomeOpcaoFicha'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosOpcaoFicha['codOpcaoFicha'] ?>, "<?php echo htmlspecialchars($dadosOpcaoFicha['nomeOpcaoFicha']) ?>");' title='Deseja excluir o tamanho <?php echo $dadosOpcaoFicha['nomeOpcaoFicha'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o tamanho "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>projetos/opcoesFichas/excluir/'+cod+'/';
										}
									}
								</script>
								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "projetos/opcoesFichas";
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
