<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "fichas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
				
				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Ficha <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Ficha <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Ficha <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Ficha <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Fichas</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>projetos/fichas/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Ficha" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Ficha</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
							
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php 
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlFicha = criaUrl($_POST['nome']);

					$sql = "INSERT INTO fichas VALUES(0, '".preparaNome($_POST['nome'])."', 'T', '".$urlFicha."')";
					$result = $conn->query($sql);

					$sqlFicha = "SELECT codFicha FROM fichas ORDER BY codFicha DESC LIMIT 0,1";
					$resultFicha = $conn->query($sqlFicha);
					$dadosFicha = $resultFicha->fetch_assoc();

					for($i=1; $i<=$_POST['total-opcoesFichas']; $i++){
						if($_POST['opcoesFichas'.$i] != ""){
							
							$sqlInsere = "INSERT INTO projetosFichas VALUES(0, ".$dadosFicha['codFicha'].", ".$_POST['opcoesFichas'.$i].")";
							$resultInsere = $conn->query($sqlInsere);
							
						}
					}
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/fichas/'>";
						}else{
							$erroData = "<p class='erro'>Ficha <strong>".$_POST['nome']."</strong> cadastrado com sucesso!</p>";
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
						<form action="<?php echo $configUrlGer; ?>projetos/fichas/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:300px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<div id="bloco-opcoesFichas" style="margin-top:10px; margin-bottom:20px;">
									<script type="text/javascript">
										function novaOpcaoFicha(){
											var pegaTotalOpcaoFicha = document.getElementById("total-opcoesFichas").value;
											var somaPegaTotalOpcaoFicha = parseInt(pegaTotalOpcaoFicha) + 1;
											
											var novadiv = document.createElement('div');
											novadiv.setAttribute('id', "bloco-opcoesFichas"+somaPegaTotalOpcaoFicha);							
											document.getElementById("bloco-novo").appendChild(novadiv);	
											
	<?php 
											$sqlOpcaoFicha = "SELECT nomeOpcaoFicha, codOpcaoFicha FROM opcoesFichas WHERE statusOpcaoFicha = 'T' ORDER BY nomeOpcaoFicha ASC";
											$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
	?>
																	
											document.getElementById("bloco-opcoesFichas"+somaPegaTotalOpcaoFicha).innerHTML += "<p class='bloco-campo'><label>OpcaoFicha:</label><select class='campo' name='opcoesFichas"+somaPegaTotalOpcaoFicha+"' style='width:315px;'><option value=''>Selecione</option><?php while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){?><option value='<?php echo $dadosOpcaoFicha['codOpcaoFicha'];?>'><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></option><?php } ?></select></p>";
											document.getElementById("total-opcoesFichas").value=somaPegaTotalOpcaoFicha;						
										}
									</script>
								
									<div id="bloco-novo">
										<div id="bloco-opcoesFichas1">	
											<p class="bloco-campo"><label>OpcaoFicha Técnica:<span class="obrigatorio"> </span></label>
												<select class="campo" name="opcoesFichas1" required style="width:315px;">
													<option value="">Selecione</option>
	<?php
					$sqlOpcaoFicha = "SELECT nomeOpcaoFicha, codOpcaoFicha FROM opcoesFichas WHERE statusOpcaoFicha = 'T' ORDER BY nomeOpcaoFicha ASC";
					$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
					while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){
	?>					
													<option value="<?php echo $dadosOpcaoFicha['codOpcaoFicha'];?>" <?php echo $_SESSION['opcoesFichas1'] == $dadosOpcaoFicha['codOpcaoFicha'] ? "/SELECTED/" : "";?>><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></option>
	<?php
					}
	?>
												</select>
											</p>
										</div>	
									</div>
									
									<div class="botao-consultar" onClick="novaOpcaoFicha();" style="margin-left:324px; margin-top:-45px; margin-bottom:0px; position:absolute;"><div class="esquerda-consultar"></div><div class="conteudo-consultar">+</div><div class="direita-consultar"></div></div>					
									
									<input type="hidden" value="1" name="total-opcoesFichas" id="total-opcoesFichas"/>									
								</div>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Ficha" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT * FROM fichas WHERE codFicha != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeFicha'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Imagens</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlFicha = "SELECT * FROM fichas ORDER BY statusFicha ASC, nomeFicha ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlFicha = "SELECT * FROM fichas ORDER BY statusFicha ASC, nomeFicha ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultFicha = $conn->query($sqlFicha);
					while($dadosFicha = $resultFicha->fetch_assoc()){
						$mostrando++;
						
						if($dadosFicha['statusFicha'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}				
						
						
						$sqlImagem = "SELECT * FROM fichasImagens WHERE codFicha = ".$dadosFicha['codFicha']." ORDER BY codFichaImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();	
?>

								<tr class="tr">
									<td class="noventa"><a href='<?php echo $configUrlGer; ?>projetos/fichas/alterar/<?php echo $dadosFicha['codFicha'] ?>/' title='Veja os detalhes do tamanho <?php echo $dadosFicha['nomeFicha'] ?>'><?php echo $dadosFicha['nomeFicha'];?></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/fichas/imagens/<?php echo $dadosFicha['codFicha'] ?>/' title='Deseja gerenciar imagens do banner <?php echo $dadosFicha['nomeFicha'] ?>?' ><img style="<?php echo $dadosImagem['codFichaImagem'] == "" ? 'display:none;' : 'padding-top:10px;';?>" src="<?php echo $configUrlGer.'f/fichas/'.$dadosImagem['codFicha'].'-'.$dadosImagem['codFichaImagem'].'-O.'.$dadosImagem['extFichaImagem'];?>" height="45"/><img style="<?php echo $dadosImagem['codFichaImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/fichas/ativacao/<?php echo $dadosFicha['codFicha'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tamanho <?php echo $dadosFicha['nomeFicha'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/fichas/alterar/<?php echo $dadosFicha['codFicha'] ?>/' title='Deseja alterar o tamanho <?php echo $dadosFicha['nomeFicha'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosFicha['codFicha'] ?>, "<?php echo htmlspecialchars($dadosFicha['nomeFicha']) ?>");' title='Deseja excluir o tamanho <?php echo $dadosFicha['nomeFicha'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o tamanho "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>projetos/fichas/excluir/'+cod+'/';
										}
									}
								</script>
								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "projetos/fichas";
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
