<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "contatos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Contato <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['alterars'] == "ok"){
					$erroConteudo = "<p class='erro'>Contato <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterars'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Contato <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Contato <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['nome'] = "";
				}

				if(isset($_POST['statusFiltro'])){
					if($_POST['statusFiltro'] != ""){
						$_SESSION['statusFiltro'] = $_POST['statusFiltro'];
					}else{
						$_SESSION['statusFiltro'] = "";
					}
				}
				
				if($_SESSION['statusFiltro'] != ""){
					$filtraStatus = " and statusContato = '".$_SESSION['statusFiltro']."'";
				}	
				
				if(isset($_POST['usuarioFiltro'])){
					if($_POST['usuarioFiltro'] != ""){
						$_SESSION['usuarioFiltro'] = $_POST['usuarioFiltro'];
					}else{
						$_SESSION['usuarioFiltro'] = "";
					}
				}
				
				if($_SESSION['usuarioFiltro'] != ""){
					$filtraUsuarioF = " and codUsuario = '".$_SESSION['usuarioFiltro']."'";
				}	
?>

				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contatos</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script>
								function enviar(){
									document.filtro.submit(); 
								}
							</script>
							<script type="text/javascript">
								function alteraStatus(status){
									document.getElementById("filtroStatus").submit();
								}
							</script>
							<form id="filtroStatus" action="<?php echo $configUrl;?>atendimento/contatos/" method="post" >

								<p class="nome-clientes-filtro" style="width:218px;"><label class="label">Filtrar Nome:</label>
								<input type="text" style="width:200px;" name="contatos" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-contatos-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="bloco-campo-float"><label>Filtrar Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="usuarioFiltro" name="usuarioFiltro" style="width:190px; padding:6px; margin-right:0px;" onChange="alteraStatus();">
										<option value="">Todos</option>
										<option value="0" <?php echo $_SESSION['usuarioFiltro'] == "0" ? '/SELECTED/' : '';?>>Atendimento</option>
<?php
				$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4".$filtraUsuario." ORDER BY nomeUsuario ASC";
				$resultUsuarios = $conn->query($sqlUsuarios);
				while($dadosUsuarios = $resultUsuarios->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuarios['codUsuario'] ;?>" <?php echo $_SESSION['usuarioFiltro'] == $dadosUsuarios['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuarios['nomeUsuario'] ;?></option>
<?php
}
?>					
									</select>
									<br class="clear"/>
								</p>

								<p class="bloco-campo-float"><label>Filtrar Status: <span class="obrigatorio"> </span></label>
									<select class="campo" name="statusFiltro" style="width:155px; padding:6px;" required onChange="alteraStatus(this.value);">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['statusFiltro'] == "T" ? '/SELECTED/' : '';?>>Ativo</option>
										<option value="F" <?php echo $_SESSION['statusFiltro'] == "F" ? '/SELECTED/' : '';?>>Inativo</option>
									</select>
								</p>	
								
								<div class="botao-novo" style="margin-left:0px; margin-top:17px;"><a onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo Contato</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:17px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>
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
<?php
				if($_POST['nome'] != ""){												
					
					$sql = "INSERT INTO contatos VALUES(0, ".$_POST['usuario'].", 0, 'Contato Ger', '".date('Y-m-d')."', '".$_POST['nome']."', '".$_POST['email']."', '".$_POST['cidade']."', '".$_POST['estado']."', '".$_POST['celular']."', '".$_POST['descricao']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastrar'] = "ok";
						$_SESSION['usuario'] = "";
						$_SESSION['email'] = "";	
						$_SESSION['cidade'] = "";	
						$_SESSION['estado'] = "";	
						$_SESSION['celular'] = "";
						$_SESSION['descricao'] = "";		
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/contatos/'>";					
						$block = "none";		
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar contato!</p>";
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['cidade'] = $_POST['cidade'];
						$_SESSION['estado'] = $_POST['estado'];
						$_SESSION['celular'] = $_POST['celular'];
						$_SESSION['telefone'] = $_POST['telefone'];
						$_SESSION['descricao'] = $_POST['descricao'];
					}

				}else{
					$_SESSION['usuario'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['email'] = "";	
					$_SESSION['cidade'] = "";	
					$_SESSION['estado'] = "";	
					$_SESSION['celular'] = "";
					$_SESSION['telefone'] = "";
					$_SESSION['descricao'] = "";	
					$block = "none";		
				}
?>						 
					<div id="cadastrar" style="display:<?php echo $block;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">			
						<form name="formContato" action="<?php echo $configUrlGer; ?>atendimento/contatos/" method="post">

							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:190px;" required>
									<option value="">Selecione</option>
<?php
				$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4".$filtraUsuario." ORDER BY nomeUsuario ASC";
				$resultUsuarios = $conn->query($sqlUsuarios);
				while($dadosUsuarios = $resultUsuarios->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuarios['codUsuario'] ;?>" <?php echo $_SESSION['usuario'] == $dadosUsuario['codUsuario'] || $_COOKIE['codAprovado'.$cookie] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuarios['nomeUsuario'] ;?></option>
<?php
}
?>					
								</select>
								<br class="clear"/>
							</p>


							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:230px;" id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<br class="clear"/>

							<p class="bloco-campo-float"><label>E-mail:</label>
							<input class="campo-7" type="email" style="width:433px;" name="email" id="email" value="<?php echo $_SESSION['email']; ?>"/></p>

							<br class="clear"/>
						
							<p class="bloco-campo-float"><label>Cidade:</label>
							<input class="campo-7" type="text" style="width:260px;" name="cidade" id="cidade" value="<?php echo $_SESSION['cidade']; ?>"/></p>

							<p class="bloco-campo-float"><label>Estado:</label>
								<select class="campo" name="estado" style="width:162px;">
									<option value="">Selecione</option>
									<option value="AC" <?php echo $_SESSION['estado'] == 'AC' ? '/SELECTED/' : ''; ?>>AC</option>
									<option value="AL" <?php echo $_SESSION['estado'] == 'AL' ? '/SELECTED/' : ''; ?>>AL</option>
									<option value="AP" <?php echo $_SESSION['estado'] == 'AP' ? '/SELECTED/' : ''; ?>>AP</option>
									<option value="AM" <?php echo $_SESSION['estado'] == 'AM' ? '/SELECTED/' : ''; ?>>AM</option>
									<option value="BA" <?php echo $_SESSION['estado'] == 'BA' ? '/SELECTED/' : ''; ?>>BA</option>
									<option value="CE" <?php echo $_SESSION['estado'] == 'CE' ? '/SELECTED/' : ''; ?>>CE</option>
									<option value="DF" <?php echo $_SESSION['estado'] == 'DF' ? '/SELECTED/' : ''; ?>>DF</option>
									<option value="ES" <?php echo $_SESSION['estado'] == 'ES' ? '/SELECTED/' : ''; ?>>ES</option>
									<option value="GO" <?php echo $_SESSION['estado'] == 'GO' ? '/SELECTED/' : ''; ?>>GO</option>
									<option value="MA" <?php echo $_SESSION['estado'] == 'MA' ? '/SELECTED/' : ''; ?>>MA</option>
									<option value="MT" <?php echo $_SESSION['estado'] == 'MT' ? '/SELECTED/' : ''; ?>>MT</option>
									<option value="MS" <?php echo $_SESSION['estado'] == 'MS' ? '/SELECTED/' : ''; ?>>MS</option>
									<option value="MG" <?php echo $_SESSION['estado'] == 'MG' ? '/SELECTED/' : ''; ?>>MG</option>
									<option value="PR" <?php echo $_SESSION['estado'] == 'PR' ? '/SELECTED/' : ''; ?>>PR</option>
									<option value="PB" <?php echo $_SESSION['estado'] == 'PB' ? '/SELECTED/' : ''; ?>>PB</option>
									<option value="PA" <?php echo $_SESSION['estado'] == 'PA' ? '/SELECTED/' : ''; ?>>PA</option>
									<option value="PE" <?php echo $_SESSION['estado'] == 'PE' ? '/SELECTED/' : ''; ?>>PE</option>
									<option value="PI" <?php echo $_SESSION['estado'] == 'PI' ? '/SELECTED/' : ''; ?>>PI</option>
									<option value="RN" <?php echo $_SESSION['estado'] == 'RN' ? '/SELECTED/' : ''; ?>>RN</option>
									<option value="RS" <?php echo $_SESSION['estado'] == 'RS' ? '/SELECTED/' : ''; ?>>RS</option>
									<option value="RJ" <?php echo $_SESSION['estado'] == 'RJ' ? '/SELECTED/' : ''; ?>>RJ</option>
									<option value="RO" <?php echo $_SESSION['estado'] == 'RO' ? '/SELECTED/' : ''; ?>>RO</option>
									<option value="RR" <?php echo $_SESSION['estado'] == 'RR' ? '/SELECTED/' : ''; ?>>RR</option>
									<option value="SC" <?php echo $_SESSION['estado'] == 'SC' ? '/SELECTED/' : ''; ?>>SC</option>
									<option value="SE" <?php echo $_SESSION['estado'] == 'SE' ? '/SELECTED/' : ''; ?>>SE</option>
									<option value="SP" <?php echo $_SESSION['estado'] == 'SP' ? '/SELECTED/' : ''; ?>>SP</option>
									<option value="TO" <?php echo $_SESSION['estado'] == 'TO' ? '/SELECTED/' : ''; ?>>TO</option>
							   </select>							
							</p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Celular: <span class="obrigatorio"> * </span></label>
							<input class="campo-6" type="text" style="width:432px;" name="celular" required id="telefone" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear" />						

							<p class="bloco-campo"><label>Mensagem:<span class="obrigatorio"> </span></label>
							<textarea class="campo" id="descricao" name="descricao" type="text" style="width:431px; height:150px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Paciente" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
?>
						<script type="text/javascript">
							function buscaAvancada(){
								var $AGD = jQuery.noConflict();
								var busca = $AGD("#busca").val();
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>atendimento/contatos/busca-contato.php?busca="+busca);
								if(busca == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT nomeContato, codContato FROM contatos WHERE codContato != ''".$filtraUsuario.$filtraUsuarioF.$filtraStatus."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeContato'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Nome</th>
									<th>Celular</th>
									<th>Corretor</th>
									<th>Data</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
				}
				
				if($url[5] == 1 || $url[5] == ""){
					$pagina = 1;
					$sqlContatos = "SELECT * FROM contatos WHERE codContato != ''".$filtraUsuario.$filtraUsuarioF.$filtraStatus." ORDER BY statusContato ASC, dataContato DESC, codContato DESC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlContatos = "SELECT * FROM contatos WHERE codContato != ''".$filtraUsuario.$filtraUsuarioF.$filtraStatus." ORDER BY statusContato ASC, dataContato DESC, codContato DESC LIMIT ".$paginaInicial.",30";
				}		

				$resultContatos = $conn->query($sqlContatos);
				while($dadosContatos = $resultContatos->fetch_assoc()){
					$mostrando++;
					
					if($dadosContatos['statusContato'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}
					
					if($dadosContatos['codUsuario'] == 0){
						$corretor = "Site";
					}else{					
						$sqlUsuario = "SELECT nomeUsuario FROM usuarios WHERE codUsuario = ".$dadosContatos['codUsuario']." LIMIT 0,1";
						$resultUsuario = $conn->query($sqlUsuario);
						$dadosUsuario = $resultUsuario->fetch_assoc();
						
						$corretor = $dadosUsuario['nomeUsuario'];
					}
?>

								<tr class="tr">
									<td class="sessenta"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $dadosContatos['nomeContato'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $dadosContatos['celularContato'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $corretor;?></a></td>
									<td class="dez" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo data($dadosContatos['dataContato']);?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/contatos/ativacao/<?php echo $dadosContatos['codContato'] ?>/' title='Deseja <?php echo $statusPergunta ?> o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/contatos/alterar/<?php echo $dadosContatos['codContato'] ?>/' title='Deseja alterar o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosContatos['codContato'] ?>, "<?php echo htmlspecialchars($dadosContatos['nomeContato']) ?>");' title='Deseja excluir o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
				}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o contato "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/contatos/excluir/'+cod+'/';
										}
									  }
								 </script>
								 
							</table>							
						</div>
<?php
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "atendimento/contatos";
					include ('f/conf/paginacao.php');
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
				echo "<p><strong>Vocês não tem permissão para acessar essa área!</strong></p>";
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
