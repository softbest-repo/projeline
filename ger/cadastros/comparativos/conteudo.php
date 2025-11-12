<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "comparativos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Comparativo <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Comparativo <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Comparativo <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Integrante da Comparativo <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
			

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Comparativo</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/comparativos/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Integrante da Comparativo" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Comparativo</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar']) || isset($_POST['cadastrarFotos'])){
					
					include ('f/conf/criaUrl.php');
					$urlComparativo = criaUrl($_POST['nome']);

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

					$sqlUltimoComparativo = "SELECT codOrdenacaoComparativo FROM comparativos ORDER BY codOrdenacaoComparativo DESC LIMIT 0,1";
					$resultUltimoComparativo = $conn->query($sqlUltimoComparativo);
					$dadosUltimoComparativo = $resultUltimoComparativo->fetch_assoc();
					
					$novoOrdem = $dadosUltimoComparativo['codOrdenacaoComparativo'] + 1;
										
					$sql = "INSERT INTO comparativos VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".preparaNome($_POST['prazo'])."','".$_POST['cifra']."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlComparativo."')";
					$result = $conn->query($sql);

					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						
						$sqlComparativo = "SELECT * FROM comparativos ORDER BY codComparativo DESC LIMIT 0,1";
						$resultComparativo = $conn->query($sqlComparativo);
						$dadosComparativo = $resultComparativo->fetch_assoc();
						
						for($i=1; $i<=$_POST['quantas']; $i++){
							if($_POST['caracteristica'.$i] != ""){
							
								echo $sqlInsere = "INSERT INTO caracteristicasComparativos VALUES(0, ".$_POST['caracteristica'.$i].",'T', ".$dadosComparativo['codComparativo'].")";
								$resultInsere = $conn->query($sqlInsere);
							}
						}
													
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/comparativos/imagens/".$dadosComparativo['codComparativo']."/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar Imóvel!</p>";
					}
									
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/comparativos/'>";
						}else{
							$sqlComparativo = "SELECT codComparativo FROM comparativos ORDER BY codComparativo DESC LIMIT 0,1";
							$resultComparativo = $conn->query($sqlComparativo);
							$dadosComparativo = $resultComparativo->fetch_assoc();
							
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/comparativos/imagens/".$dadosComparativo['codComparativo']."/'>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar integrante da comparativos!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['prazo'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['cifra'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/comparativos/" method="post">
							<p class="bloco-campo-float"><label>Título: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:500px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo-float"><label>Prazo: <span class="obrigatorio"> * </span> <span class="em" style="font-weight:normal;"> Ex: 7 dias </span></label>
							<input class="campo" type="text" name="prazo" style="width:131px;"  value="<?php echo $_SESSION['prazo']; ?>" /></p>

							<p class="bloco-campo-float"><label> Cifra(s): <span class="obrigatorio"> * <span class="em" style="font-weight:normal;"> Max 5 </span> </label>
							<input class="campo" type="number" name="cifra" style="width:131px;" value="<?php echo $_SESSION['cifra']; ?>" min="0" max="5" id="cifraValorMaximo" />

							<br class="clear"/>

							<div class="bloco-campo" style="margin-bottom:25px; width: 833px"><label>Características:<span class="obrigatorio"> </span></label><br/>
<?php
				$cont = 0;
				$contTodas = 0;
				
				$sqlCaracteristicas = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultOpcionais = $conn->query($sqlCaracteristicas);
				while($dadosOpcionais = $resultOpcionais->fetch_assoc()){
				
					$cont++;
					$contTodas++;
?>				
								<label style="font-weight:normal; float:left; width:200px; height:30px; cursor:pointer; font-size:14px;"><input type="checkbox" style="cursor:pointer;" value="<?php echo $dadosOpcionais['codCaracteristica'];?>" name="caracteristica<?php echo $contTodas;?>"/> <?php echo $dadosOpcionais['nomeCaracteristica'];?></label>

<?php
					if($cont == 5){
						$cont = 0;
?>
							
<?php
					}

				}
?>
								<input type="hidden" value="<?php echo $contTodas;?>" name="quantas"/>
								<br class="clear"/>
							</div>
														
							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="margin-right:0px;"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Comparativo" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrarFotos" title="Salvar Comparativo e Cadastrar Fotos" value="Salvar Comparativo e Cadastrar Fotos" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>	
					<script>
						const cifraValorMaximo = document.getElementById('cifraValorMaximo');
						
						cifraValorMaximo.addEventListener('input', function() {
							if (parseInt(cifraValorMaximo.value) > 5) {
								cifraValorMaximo.value = 0;
							}
						});
					</script>
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
				
				$sqlConta = "SELECT * FROM comparativos";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeComparativo'] != ""){
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
						$sqlComparativo = "SELECT * FROM comparativos ORDER BY statusComparativo ASC, codOrdenacaoComparativo ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlComparativo = "SELECT * FROM comparativos ORDER BY statusComparativo ASC, codOrdenacaoComparativo ASC LIMIT ".$paginaInicial.",30";
					}		
						
					$resultComparativo = $conn->query($sqlComparativo);
					while($dadosComparativo = $resultComparativo->fetch_assoc()){
						$mostrando++;
						
						if($dadosComparativo['statusComparativo'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}

						$sqlImagem = "SELECT * FROM comparativosImagens WHERE codComparativo = ".$dadosComparativo['codComparativo']." ORDER BY codComparativoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();
						
						if($dadosComparativo['codComparativo'] == 0){								
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;">--</td>
									<td class="setenta"><a href='<?php echo $configUrlGer; ?>cadastros/comparativos/alterar/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Veja os detalhes do integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>'><?php echo $dadosComparativo['nomeComparativo'];?></a></td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="dez" style="text-align:center;">--</td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/comparativos/alterar/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Deseja alterar o integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="dez" style="text-align:center;">--</td>
								</tr>
<?php						
						}else{
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosComparativo['codOrdenacaoComparativo'];?>" onClick="alteraCor(<?php echo $dadosComparativo['codComparativo'];?>);" onBlur="alteraOrdem(<?php echo $dadosComparativo['codComparativo'];?>, this.value);" id="codOrdena<?php echo $dadosComparativo['codComparativo'];?>"/></td>
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/comparativos/alterar/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Veja os detalhes do integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>'><?php echo $dadosComparativo['nomeComparativo'];?></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/comparativos/imagens/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Deseja gerenciar imagens do integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>?' ><img style="<?php echo $dadosImagem['codComparativoImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/comparativos/'.$dadosImagem['codComparativo'].'-'.$dadosImagem['codComparativoImagem'].'-O.'.$dadosImagem['extComparativoImagem'];?>" height="50"/><img style="<?php echo $dadosImagem['codComparativoImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/comparativos/ativacao/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/comparativos/alterar/<?php echo $dadosComparativo['codComparativo'] ?>/' title='Deseja alterar o integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosComparativo['codComparativo'] ?>, "<?php echo htmlspecialchars($dadosComparativo['nomeComparativo']) ?>");' title='Deseja excluir o integrante da comparativos <?php echo $dadosComparativo['nomeComparativo'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php							
						}
					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o integrante da comparativos "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/comparativos/excluir/'+cod+'/';
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
										$po.post("<?php echo $configUrlGer;?>cadastros/comparativos/ordem.php", {codComparativo: cod, codOrdenacaoComparativo: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script>								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "cadastros/comparativos";
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
