<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosComplementares";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto Complementar <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto Complementar <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto Complementar <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto Complementar <strong>".$_SESSION['nome']."</strong> excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Projetos Complementares</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>projetos/projetosComplementares/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Projeto Complementar" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Projeto Complementar </div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlProjetoComplementar = criaUrl($_POST['nome']);

					$sqlUltimoProjetoComplementar = "SELECT codOrdenacaoProjetoComplementar FROM projetosComplementares ORDER BY codOrdenacaoProjetoComplementar DESC LIMIT 0,1";
					$resultUltimoProjetoComplementar = $conn->query($sqlUltimoProjetoComplementar);
					$dadosUltimoProjetoComplementar = $resultUltimoProjetoComplementar->fetch_assoc();
					
					$novoOrdem = $dadosUltimoProjetoComplementar['codOrdenacaoProjetoComplementar'] + 1;	

					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);

					$precoComplementar = str_replace(".", "", $_POST['preco']);
					$precoComplementar = str_replace(",", ".", $precoComplementar);
					
					$sql = "INSERT INTO projetosComplementares VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".$precoComplementar."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlProjetoComplementar."')";
					echo $sql;
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/projetosComplementares/'>";
						}else{
							$erroData = "<p class='erro'>Área de Atuação <strong>".$_POST['nome']."</strong> cadastrada com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar área de atuação!</p>";
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
						<form action="<?php echo $configUrlGer; ?>projetos/projetosComplementares/" method="post">
							<script>
								function moeda(z){  
									v = z.value;
									v=v.replace(/\D/g,"") 
								v=v.replace(/[0-9]{12}/,"inválido") 
								v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") 
								v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  
								v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	
									z.value = v;
								}
							</script>

							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:635px;" required value="" /></p>

							<p class="bloco-campo-float"><label>Preço: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="preco" style="width:180px;" required value="" onkeyup="moeda(this)" /></p>

							<p class="bloco-campo" style="width:855px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar ProjetoComplementar" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT nomeProjetoComplementar FROM projetosComplementares WHERE codProjetoComplementar != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeProjetoComplementar'] != ""){
?>
						<table class="tabela-menus">
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordenar</th>
								<th>Nome</th>
								<th>Preço</th>
								<th>Ícone</th>
								<th>Anexos</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>	
							<tbody id="tabela-itens">																
<?php

					$sqlProjetoComplementar = "SELECT * FROM projetosComplementares ORDER BY statusProjetoComplementar ASC, codOrdenacaoProjetoComplementar ASC, codProjetoComplementar DESC";
					$resultProjetoComplementar = $conn->query($sqlProjetoComplementar);
					while($dadosProjetoComplementar = $resultProjetoComplementar->fetch_assoc()){
						
						if($dadosProjetoComplementar['statusProjetoComplementar'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}

						$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosProjetoComplementar['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();							
?>
								<tr class="tr">
									<td class="dez handle" style="width:5%; text-align:center; cursor:move;"><a style="text-decoration:none; font-size:22px;" title='Arraste para ordenar'>⇅ <input type="hidden" name="codProjetoComplementar" value="<?php echo $dadosProjetoComplementar['codProjetoComplementar'];?>"/></a></td> 
									<td class="setenta"><a href='<?php echo $configUrlGer; ?>projetos/projetosComplementares/alterar/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Veja os detalhes da área de atuação <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>'><?php echo $dadosProjetoComplementar['nomeProjetoComplementar'];?></a></td> 
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>projetos/projetosComplementares/alterar/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Veja os detalhes da área de atuação <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>'>R$ <?php echo number_format($dadosProjetoComplementar['precoProjetoComplementar'], 2, ",", ".");?></a></td> 
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/projetosComplementares/imagens/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Deseja gerenciar imagens do banner <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>?' ><img style="<?php echo $dadosImagem['codProjetoComplementarImagem'] == "" ? 'display:none;' : 'padding-top:10px;';?>" src="<?php echo $configUrlGer.'f/projetosComplementares/'.$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];?>" height="45"/><img style="<?php echo $dadosImagem['codProjetoComplementarImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/projetosComplementares/anexos/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Deseja cadastrar anexos para o projeto complementar <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/projetosComplementares/ativacao/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Deseja <?php echo $statusPergunta ?> a área de atuação <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/projetosComplementares/alterar/<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>/' title='Deseja alterar a área de atuação <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosProjetoComplementar['codProjetoComplementar'] ?>, "<?php echo htmlspecialchars($dadosProjetoComplementar['nomeProjetoComplementar']) ?>");' title='Deseja excluir a área de atuação <?php echo $dadosProjetoComplementar['nomeProjetoComplementar'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>								 
							</tbody>					 
						</table>	
						<script type="text/javascript">
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a área de atuação "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/projetosComplementares/excluir/'+cod+'/';
								}
							}
							
							$tgb = jQuery.noConflict();
							const dragArea = document.querySelector("#tabela-itens");
							new Sortable(dragArea, {
								animation: 350,
								filter: '.disabled',
								handle: '.handle',									
								onEnd: function(e) {
									var allinputs = document.querySelectorAll('input[name="codProjetoComplementar"]');
									var myLength = allinputs.length;
									var cont = 0;
									for (i = 0; i < myLength; i++) {
										cont++;
										$tgb.post("<?php echo $configUrlGer;?>projetos/projetosComplementares/ordena.php", {codProjetoComplementar: allinputs[i].value, codOrdenacaoProjetoComplementar: cont});
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
