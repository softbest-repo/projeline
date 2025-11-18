<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "orcamentos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Orçamentos <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Orçamentos <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Orçamentos <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Orçamentos <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Orcamentos</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>atendimento/orcamentos/" method="post" />
								<!-- <div class="botao-novo" style="margin-left:0px;"><a title="Novo Orçamentos" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Orçamentos</div><div class="direita-novo"></div></a></div> -->
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar']) || isset($_POST['cadastrarFotos'])){
					
					include ('f/conf/criaUrl.php');
					$urlOrcamento = criaUrl($_POST['nome']);

					$sql = "INSERT INTO orcamentos VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".$_POST['telefone']."' 'T', '".$urlOrcamento."')";
					$result = $conn->query($sql);
									
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/orcamentos/'>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar integrante da orcamentos!</p>";
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
						<form action="<?php echo $configUrlGer; ?>atendimento/orcamentos/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:580px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo-float"><label>Função: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="subNome" style="width:208px;"  value="<?php echo $_SESSION['subNome']; ?>" /></p>
														
							<br class="clear"/>
														
							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="margin-right:0px;"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Orcamento" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrarFotos" title="Salvar Orcamento e Cadastrar Fotos" value="Salvar Orcamento e Cadastrar Fotos" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT * FROM orcamentos";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeOrcamento'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Nome</th>
								<th >Projeto</th>
								<th>Telefone</th>
								<th style=" line-height: 97%;">Orçamento <br> respondido?</th>
								<th>Anexo</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlOrcamento = "SELECT * FROM orcamentos ORDER BY statusOrcamento ASC, respondidoOrcamento DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlOrcamento = "SELECT * FROM orcamentos ORDER BY statusOrcamento ASC respondidoOrcamento DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultOrcamento = $conn->query($sqlOrcamento);
					while($dadosOrcamento = $resultOrcamento->fetch_assoc()){
						$mostrando++;
						
						if($dadosOrcamento['statusOrcamento'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}

						$sqlProjeto =  "SELECT * FROM projetosComplementares WHERE codProjetoComplementar = ".$dadosOrcamento['codProjetoComplementar'];
						$resultProjeto =  $conn->query($sqlProjeto);
						$dadosProjeto = $resultProjeto->fetch_assoc();


						if($dadosProjeto['nomeProjetoComplementar'] == ''){
							$nomeProjeto = '--';
						}else{
							$nomeProjeto = $dadosProjeto['nomeProjetoComplementar'];
						}

						$sqlImagem = "SELECT * FROM orcamentosAnexos WHERE codOrcamento = ".$dadosOrcamento['codOrcamento']." ORDER BY codOrcamentoAnexo ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();

?>
								<tr class="tr">
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>atendimento/orcamentos/alterar/<?php echo $dadosOrcamento['codOrcamento'] ?>/' title='Veja os detalhes do integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>'><?php echo $dadosOrcamento['nomeOrcamento'];?></a></td>
									<td class="oitenta"  style=" text-align: center;"><a href='<?php echo $configUrlGer; ?>atendimento/orcamentos/alterar/<?php echo $dadosOrcamento['codOrcamento'] ?>/' title='Veja os detalhes do integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>'><?php echo $nomeProjeto;?></a></td>
									<td class="oitenta" style=" text-align: center;"><a style="width: 120px; display: block;" href='<?php echo $configUrlGer; ?>atendimento/orcamentos/alterar/<?php echo $dadosOrcamento['codOrcamento'] ?>/' title='Veja os detalhes do integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>'><?php echo $dadosOrcamento['telefoneOrcamento'];?></a></td>
									<td class="vinte" style="text-align: center;">
										<label><input type="radio"  class="radio-respondido"  name="respondido_<?php echo $dadosOrcamento['codOrcamento']; ?>"  value="T"  data-cod-orcamento="<?php echo $dadosOrcamento['codOrcamento']; ?>" <?php echo ($dadosOrcamento['respondidoOrcamento'] == 'T') ? 'checked' : ''; ?>> Sim </label>
										<label> <input type="radio"  class="radio-respondido" name="respondido_<?php echo $dadosOrcamento['codOrcamento']; ?>"  value="F"  data-cod-orcamento="<?php echo $dadosOrcamento['codOrcamento']; ?>" <?php echo ($dadosOrcamento['respondidoOrcamento'] == 'F') ? 'checked' : ''; ?>> Não </label>
									</td>						
									<td class="botoes" style="width:5%; display:flex; jusify"> <a style="padding:0px; display:block" href="<?php echo $configUrl; ?>atendimento/orcamentos/anexos/<?php echo $dadosOrcamento['codOrcamento']; ?>/" title="Gerenciar PDF do orçamento <?php echo $dadosOrcamento['nomeOrcamento']; ?>"> <img style=" margin-top: 10px;" src="<?php echo $configUrl; ?>f/i/icone-pdf.png"  alt="ícone PDF"  height="40"> </a> </td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/orcamentos/ativacao/<?php echo $dadosOrcamento['codOrcamento'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/orcamentos/alterar/<?php echo $dadosOrcamento['codOrcamento'] ?>/' title='Deseja alterar o integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosOrcamento['codOrcamento'] ?>, "<?php echo htmlspecialchars($dadosOrcamento['nomeOrcamento']) ?>");' title='Deseja excluir o integrante da orcamentos <?php echo $dadosOrcamento['nomeOrcamento'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php							

					}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o integrante da orcamentos "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/orcamentos/excluir/'+cod+'/';
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
										$po.post("<?php echo $configUrlGer;?>atendimento/orcamentos/ordem.php", {codOrcamento: cod, codOrdenacaoOrcamento: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script>
								<script>
									var $tg = jQuery.noConflict();

									$tg(document).ready(function() {
										$tg(document).on('change', '.radio-respondido', function() {
											var codOrcamento = $tg(this).data('cod-orcamento');
											var valorRespondido = $tg(this).val();
											
											console.log('Atualizando orçamento:', codOrcamento, 'para:', valorRespondido);
											
											$tg.ajax({
												url: '<?php echo $configUrlGer; ?>atendimento/orcamentos/atualizar-respondido.php',
												type: 'POST',
												data: {
													codOrcamento: codOrcamento,
													respondido: valorRespondido
												},
												dataType: 'json',
												success: function(response) {
													if (response.success) {
														console.log('✓ Atualizado com sucesso!');
													} else {
														console.error('Erro:', response.message);
														alert('Erro ao atualizar: ' + response.message);
													}
												},
												error: function(xhr, status, error) {
													console.error('Erro AJAX:', error);
													alert('Erro ao conectar com o servidor.');
												}
											});
										});
									});
								</script>
								 
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "atendimento/orcamentos";
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
