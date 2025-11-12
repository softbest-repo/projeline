<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosPersonalizados";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Projeto <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Projetos Personalizados</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>projetos/projetosPersonalizados/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Projeto Personalizado" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Projeto Personalizado </div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlProjetoPersonalizado = criaUrl($_POST['nome']);

					$sqlUltimoProjetoPersonalizado = "SELECT codOrdenacaoProjetoPersonalizado FROM projetosPersonalizados ORDER BY codOrdenacaoProjetoPersonalizado DESC LIMIT 0,1";
					$resultUltimoProjetoPersonalizado = $conn->query($sqlUltimoProjetoPersonalizado);
					$dadosUltimoProjetoPersonalizado = $resultUltimoProjetoPersonalizado->fetch_assoc();
					
					$novoOrdem = $dadosUltimoProjetoPersonalizado['codOrdenacaoProjetoPersonalizado'] + 1;	

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
					
					$sql = "INSERT INTO projetosPersonalizados VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".str_replace("'", "&#39;", $descricao)."','".$_POST['tipo']."' , 'T', '".$urlProjetoPersonalizado."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/projetosPersonalizados/'>";
						}else{
							$erroData = "<p class='erro'>Projeto <strong>".$_POST['nome']."</strong> cadastrada com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar Projeto!</p>";
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
						<form action="<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/" method="post">
							<p class="bloco-campo-float"><label>Tipo do Projeto: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo" name="tipo" style="width:180px; height:32px;" required onChange="exibeCamposTipo(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' ORDER BY nomeTipoProjeto ASC";
				$resultTipoProjeto = $conn->query($sqlTipoProjeto);
				while($dadosTipoProjeto = $resultTipoProjeto->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoProjeto['codTipoProjeto'] ;?>" <?php echo $_SESSION['tipo'] == $dadosTipoProjeto['codTipoProjeto'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoProjeto['nomeTipoProjeto'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:650px;" required value="" /></p>

							<p class="bloco-campo" style="width:855px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar ProjetoPersonalizado" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT nomeProjetoPersonalizado FROM projetosPersonalizados WHERE codProjetoPersonalizado != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeProjetoPersonalizado'] != ""){
?>
						<table class="tabela-menus">
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordenar</th>
								<th>Nome</th>
							
								<th>Ícone</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>	
							<tbody id="tabela-itens">																
<?php

					$sqlProjetoPersonalizado = "SELECT * FROM projetosPersonalizados ORDER BY statusProjetoPersonalizado ASC, codOrdenacaoProjetoPersonalizado ASC, codProjetoPersonalizado DESC";
					$resultProjetoPersonalizado = $conn->query($sqlProjetoPersonalizado);
					while($dadosProjetoPersonalizado = $resultProjetoPersonalizado->fetch_assoc()){
						
						if($dadosProjetoPersonalizado['statusProjetoPersonalizado'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}
						$sqlTipo = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' and codTipoProjeto = ".$dadosProjetoPersonalizado['tipoProjeto']." ORDER BY codTipoProjeto DESC LIMIT 0,1";
						$resultTipo = $conn->query($sqlTipo);
						$dadosTipo = $resultTipo->fetch_assoc();

						$sqlImagem = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$dadosProjetoPersonalizado['codProjetoPersonalizado']." ORDER BY codProjetoPersonalizadoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();	
												
?>
								<tr class="tr">
									<td class="dez handle" style="width:5%; text-align:center; cursor:move;"><a style="text-decoration:none; font-size:22px;" title='Arraste para ordenar'>⇅ <input type="hidden" name="codProjetoPersonalizado" value="<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'];?>"/></a></td> 
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/alterar/<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Veja os detalhes d o Projeto <?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'] ?>'><?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'];?></a></td> 
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/imagens/<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Deseja gerenciar imagens do banner <?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img style="<?php echo $dadosImagem['codProjetoPersonalizadoImagem'] == "" ? 'display:none;' : 'padding-top:10px;';?>" src="<?php echo $configUrlGer.'f/projetosPersonalizados/'.$dadosImagem['codProjetoPersonalizado'].'-'.$dadosImagem['codProjetoPersonalizadoImagem'].'-O.'.$dadosImagem['extProjetoPersonalizadoImagem'];?>" height="45"/><img style="<?php echo $dadosImagem['codProjetoPersonalizadoImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/ativacao/<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Deseja <?php echo $statusPergunta ?>  o Projeto <?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/alterar/<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Deseja alterar  o Projeto <?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosProjetoPersonalizado['codProjetoPersonalizado'] ?>, "<?php echo htmlspecialchars($dadosProjetoPersonalizado['nomeProjetoPersonalizado']) ?>");' title='Deseja excluir  o Projeto <?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>								 
							</tbody>					 
						</table>	
						<script type="text/javascript">
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir  o Projeto "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/excluir/'+cod+'/';
								}
							}
							
							$tgb = jQuery.noConflict();
							const dragArea = document.querySelector("#tabela-itens");
							new Sortable(dragArea, {
								animation: 350,
								filter: '.disabled',
								handle: '.handle',									
								onEnd: function(e) {
									var allinputs = document.querySelectorAll('input[name="codProjetoPersonalizado"]');
									var myLength = allinputs.length;
									var cont = 0;
									for (i = 0; i < myLength; i++) {
										cont++;
										$tgb.post("<?php echo $configUrlGer;?>projetos/projetosPersonalizados/ordena.php", {codProjetoPersonalizado: allinputs[i].value, codOrdenacaoProjetoPersonalizado: cont});
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
