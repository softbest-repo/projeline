<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "duvidas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Duvida <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Duvida <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Duvida <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Duvida <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Dúvida</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/duvidas/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Integrante da Duvida" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Dúvida</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar']) || isset($_POST['cadastrarFotos'])){
					
					include ('f/conf/criaUrl.php');
					$urlDuvida = criaUrl($_POST['nome']);

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

					$sqlUltimoDuvida = "SELECT codOrdenacaoDuvida FROM duvidas ORDER BY codOrdenacaoDuvida DESC LIMIT 0,1";
					$resultUltimoDuvida = $conn->query($sqlUltimoDuvida);
					$dadosUltimoDuvida = $resultUltimoDuvida->fetch_assoc();
					
					$novoOrdem = $dadosUltimoDuvida['codOrdenacaoDuvida'] + 1;
										
					$sql = "INSERT INTO duvidas VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."','".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlDuvida."')";
					$result = $conn->query($sql);
									
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/duvidas/'>";
						}else{
							$sqlDuvida = "SELECT codDuvida FROM duvidas ORDER BY codDuvida DESC LIMIT 0,1";
							$resultDuvida = $conn->query($sqlDuvida);
							$dadosDuvida = $resultDuvida->fetch_assoc();
							
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/duvidas/imagens/".$dadosDuvida['codDuvida']."/'>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar dúvidas!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/duvidas/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width: 813px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
														
							<br class="clear"/>
														
							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="margin-right:0px;"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Duvida" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT * FROM duvidas";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeDuvida'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordenação</th>
								<th>Nome</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlDuvida = "SELECT * FROM duvidas ORDER BY statusDuvida ASC, codOrdenacaoDuvida ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlDuvida = "SELECT * FROM duvidas ORDER BY statusDuvida ASC, codOrdenacaoDuvida ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultDuvida = $conn->query($sqlDuvida);
					while($dadosDuvida = $resultDuvida->fetch_assoc()){
						$mostrando++;
						
						if($dadosDuvida['statusDuvida'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}
					
						if($dadosDuvida['codDuvida'] == 0){								
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;">--</td>
									<td class="setenta"><a href='<?php echo $configUrlGer; ?>cadastros/duvidas/alterar/<?php echo $dadosDuvida['codDuvida'] ?>/' title='Veja os detalhes de "duvidas" <?php echo $dadosDuvida['nomeDuvida'] ?>'><?php echo $dadosDuvida['nomeDuvida'];?></a></td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/duvidas/alterar/<?php echo $dadosDuvida['codDuvida'] ?>/' title='Deseja alterar a "duvidas" <?php echo $dadosDuvida['nomeDuvida'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="dez" style="text-align:center;">--</td>
								</tr>
<?php						
						}else{
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosDuvida['codOrdenacaoDuvida'];?>" onClick="alteraCor(<?php echo $dadosDuvida['codDuvida'];?>);" onBlur="alteraOrdem(<?php echo $dadosDuvida['codDuvida'];?>, this.value);" id="codOrdena<?php echo $dadosDuvida['codDuvida'];?>"/></td>
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/duvidas/alterar/<?php echo $dadosDuvida['codDuvida'] ?>/' title='Veja os detalhes de "duvidas" <?php echo $dadosDuvida['nomeDuvida'] ?>'><?php echo $dadosDuvida['nomeDuvida'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/duvidas/ativacao/<?php echo $dadosDuvida['codDuvida'] ?>/' title='Deseja <?php echo $statusPergunta ?> a duvidas <?php echo $dadosDuvida['nomeDuvida'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/duvidas/alterar/<?php echo $dadosDuvida['codDuvida'] ?>/' title='Deseja alterar "duvidas" <?php echo $dadosDuvida['nomeDuvida'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosDuvida['codDuvida'] ?>, "<?php echo htmlspecialchars($dadosDuvida['nomeDuvida']) ?>");' title='Deseja excluir as "duvidas" <?php echo $dadosDuvida['nomeDuvida'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php							
						}
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o  duvidas "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/duvidas/excluir/'+cod+'/';
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
										$po.post("<?php echo $configUrlGer;?>cadastros/duvidas/ordem.php", {codDuvida: cod, codOrdenacaoDuvida: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script>								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "cadastros/duvidas";
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
