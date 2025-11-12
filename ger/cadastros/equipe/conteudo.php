<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "equipe";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Equipe <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Equipe <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Equipe <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Equipe <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Equipe</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/equipe/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Integrante da Equipe" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Integrante da Equipe</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar']) || isset($_POST['cadastrarFotos'])){
					
					include ('f/conf/criaUrl.php');
					$urlEquipe = criaUrl($_POST['nome']);

					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);

					$sqlUltimoEquipe = "SELECT codOrdenacaoEquipe FROM equipe ORDER BY codOrdenacaoEquipe DESC LIMIT 0,1";
					$resultUltimoEquipe = $conn->query($sqlUltimoEquipe);
					$dadosUltimoEquipe = $resultUltimoEquipe->fetch_assoc();
					
					$novoOrdem = $dadosUltimoEquipe['codOrdenacaoEquipe'] + 1;
										
					$sql = "INSERT INTO equipe VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".preparaNome($_POST['subNome'])."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlEquipe."')";
					$result = $conn->query($sql);
									
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/equipe/'>";
						}else{
							$sqlEquipe = "SELECT codEquipe FROM equipe ORDER BY codEquipe DESC LIMIT 0,1";
							$resultEquipe = $conn->query($sqlEquipe);
							$dadosEquipe = $resultEquipe->fetch_assoc();
							
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/equipe/imagens/".$dadosEquipe['codEquipe']."/'>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar integrante da equipe!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['subNome'] = "";
					$_SESSION['descricao'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/equipe/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:580px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo-float"><label>Função: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="subNome" style="width:208px;"  value="<?php echo $_SESSION['subNome']; ?>" /></p>
														
							<br class="clear"/>
														
							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="margin-right:0px;"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Equipe" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrarFotos" title="Salvar Equipe e Cadastrar Fotos" value="Salvar Equipe e Cadastrar Fotos" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT * FROM equipe";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeEquipe'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordenação</th>
								<th>Nome</th>
								<th>Imagem</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlEquipe = "SELECT * FROM equipe ORDER BY statusEquipe ASC, codOrdenacaoEquipe ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlEquipe = "SELECT * FROM equipe ORDER BY statusEquipe ASC, codOrdenacaoEquipe ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultEquipe = $conn->query($sqlEquipe);
					while($dadosEquipe = $resultEquipe->fetch_assoc()){
						$mostrando++;
						
						if($dadosEquipe['statusEquipe'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}

						$sqlImagem = "SELECT * FROM equipeImagens WHERE codEquipe = ".$dadosEquipe['codEquipe']." ORDER BY codEquipeImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();
						
						if($dadosEquipe['codEquipe'] == 0){								
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;">--</td>
									<td class="setenta"><a href='<?php echo $configUrlGer; ?>cadastros/equipe/alterar/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Veja os detalhes do integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>'><?php echo $dadosEquipe['nomeEquipe'];?></a></td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/equipe/alterar/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Deseja alterar o integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="dez" style="text-align:center;">--</td>
								</tr>
<?php						
						}else{
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosEquipe['codOrdenacaoEquipe'];?>" onClick="alteraCor(<?php echo $dadosEquipe['codEquipe'];?>);" onBlur="alteraOrdem(<?php echo $dadosEquipe['codEquipe'];?>, this.value);" id="codOrdena<?php echo $dadosEquipe['codEquipe'];?>"/></td>
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/equipe/alterar/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Veja os detalhes do integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>'><?php echo $dadosEquipe['nomeEquipe'];?></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/equipe/imagens/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Deseja gerenciar imagens do integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>?' ><img style="<?php echo $dadosImagem['codEquipeImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/equipe/'.$dadosImagem['codEquipe'].'-'.$dadosImagem['codEquipeImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codEquipeImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/equipe/ativacao/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/equipe/alterar/<?php echo $dadosEquipe['codEquipe'] ?>/' title='Deseja alterar o integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosEquipe['codEquipe'] ?>, "<?php echo htmlspecialchars($dadosEquipe['nomeEquipe']) ?>");' title='Deseja excluir o integrante da equipe <?php echo $dadosEquipe['nomeEquipe'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php							
						}
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o integrante da equipe "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/equipe/excluir/'+cod+'/';
										}
									}
								</script>
								<script type="text/javascript">
									function alteraCor(cod){
										var $po2 = jQuery.noConflict();
										$po2("#codOrdena"+cod).css("border", "1px solid #FF0000");
									}

									function alteraOrdem(cod, ordem){
										var $po = jQuery.noConflict();
										$po.post("<?php echo $configUrlGer;?>cadastros/equipe/ordem.php", {codEquipe: cod, codOrdenacaoEquipe: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script>								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "cadastros/equipe";
				include ('f/conf/paginacao.php');		
?>							
					</div>
				</div>
				<script>
					var $rf = jQuery.noConflict();
					$rf(".select2").select2();				
				</script>				
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
