<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners-promocoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Promoção <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Promoção <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nomeAlt'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Promoção <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Promoção <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Banner Promoção</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/banners-promocoes/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Banner Promoção" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Banner Promoção</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlBannerPromocao = criaUrl($_POST['nome']);

					$sqlUltimoBannerPromocao = "SELECT codOrdenacaoBannerPromocao FROM bannersPromocoes ORDER BY codOrdenacaoBannerPromocao DESC LIMIT 0,1";
					$resultUltimoBannerPromocao = $conn->query($sqlUltimoBannerPromocao);
					$dadosUltimoBannerPromocao = $resultUltimoBannerPromocao->fetch_assoc();
					
					$novoOrdem = $dadosUltimoBannerPromocao['codOrdenacaoBannerPromocao'] + 1;	

					$sql = "INSERT INTO bannersPromocoes VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".$_POST['titulo']."', '".$_POST['frase']."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['link']))."', '".$_POST['novaAba']."', 'T', '".$urlBannerPromocao."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/banners-promocoes/'>";
						}else{
							$erroData = "<p class='erro'>BannerPromocao Capa <strong>".$_POST['nome']."</strong> cadastrado com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar banner capa!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['titulo'] = "";
					$_SESSION['frase'] = "";
					$_SESSION['link'] = "";
					$_SESSION['novaAba'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/banners-promocoes/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:400px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo"><label>Link: <span class="em" style="font-weight:normal;"> Ex: http://www.softbest.com.br</span></label>
							<input class="campo" type="text" name="link" style="width:400px;" value="<?php echo $_SESSION['link']; ?>" /></p>

							<p class="bloco-campo"><label>Abrir link em nova aba:</label>
							<label style="float:left; font-weight:normal; margin-right:20px;"><input class="campo" type="radio" name="novaAba" value="N" <?php echo $_SESSION['novaAba'] == "N" || $_SESSION['novaAba'] == "" ? 'checked' : '';?>/> Não</label>
							<label style="float:left; font-weight:normal;"><input class="campo" type="radio" name="novaAba" value="S" <?php echo $_SESSION['novaAba'] == "S" ? 'checked' : '';?>/> Sim</label></p>							 
							<br class="clear"/>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar BannerPromocao Capa" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT nomeBannerPromocao FROM bannersPromocoes WHERE codBannerPromocao != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeBannerPromocao'] != ""){
?>	
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordena</th>
								<th>Nome</th>
								<th>Imagens</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>
							<tbody id="tabela-itens">		
<?php
					$sqlBannerPromocao = "SELECT * FROM bannersPromocoes ORDER BY statusBannerPromocao ASC, codOrdenacaoBannerPromocao ASC, codBannerPromocao DESC";
					$resultBannerPromocao = $conn->query($sqlBannerPromocao);
					while($dadosBannerPromocao = $resultBannerPromocao->fetch_assoc()){
						
						if($dadosBannerPromocao['statusBannerPromocao'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	

						$sqlImagem = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$dadosBannerPromocao['codBannerPromocao']." ORDER BY codBannerPromocaoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();								
?>
								<tr class="tr">
									<td class="dez handle" style="width:5%; text-align:center; cursor:move;"><a style="text-decoration:none; font-size:22px;" title='Arraste para ordenar'>⇅ <input type="hidden" name="codBannerPromocao" value="<?php echo $dadosBannerPromocao['codBannerPromocao'];?>"/></a></td> 
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/banners-promocoes/alterar/<?php echo $dadosBannerPromocao['codBannerPromocao'] ?>/' title='Veja os detalhes do banner <?php echo $dadosBannerPromocao['nomeBannerPromocao'] ?>'><?php echo $dadosBannerPromocao['nomeBannerPromocao'];?></a></td> 
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/banners-promocoes/imagens/<?php echo $dadosBannerPromocao['codBannerPromocao'] ?>/' title='Deseja gerenciar imagens do banner <?php echo $dadosBannerPromocao['nomeBannerPromocao'] ?>?' ><img style="<?php echo $dadosImagem['codBannerPromocaoImagem'] == "" ? 'display:none;' : 'padding-top:18px;';?>" src="<?php echo $configUrlGer.'f/banners-promocoes/'.$dadosImagem['codBannerPromocao'].'-'.$dadosImagem['codBannerPromocaoImagem'].'-W.webp';?>" height="30"/><img style="<?php echo $dadosImagem['codBannerPromocaoImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/banners-promocoes/ativacao/<?php echo $dadosBannerPromocao['codBannerPromocao'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banner <?php echo $dadosBannerPromocao['nomeBannerPromocao'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/banners-promocoes/alterar/<?php echo $dadosBannerPromocao['codBannerPromocao'] ?>/' title='Deseja alterar o banner <?php echo $dadosBannerPromocao['nomeBannerPromocao'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosBannerPromocao['codBannerPromocao'] ?>, "<?php echo htmlspecialchars($dadosBannerPromocao['nomeBannerPromocao']) ?>");' title='Deseja excluir o banner capa <?php echo $dadosBannerPromocao['nomeBannerPromocao'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>								 
							</tbody>					 
						</table>	
						<script type="text/javascript">
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o banner capa "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/banners-promocoes/excluir/'+cod+'/';
								}
							}
																
							$tgb = jQuery.noConflict();
							const dragArea = document.querySelector("#tabela-itens");
							new Sortable(dragArea, {
								animation: 350,
								filter: '.disabled',
								handle: '.handle',
								onEnd: function(e) {
									var allinputs = document.querySelectorAll('input[name="codBannerPromocao"]');
									var myLength = allinputs.length;
									var cont = 0;
									for (i = 0; i < myLength; i++) {
										cont++;
										$tgb.post("<?php echo $configUrlGer;?>cadastros/banners-promocoes/ordena.php", {codBannerPromocao: allinputs[i].value, codOrdenacaoBannerPromocao: cont});
									}
								}
							});						
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
