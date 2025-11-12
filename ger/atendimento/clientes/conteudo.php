<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "clientes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
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
					$filtraStatus = " and status = '".$_SESSION['statusFiltro']."'";
				}					
?>
				<script>
					function mascaraMutuario(o,f){
						v_obj=o
						v_fun=f
						setTimeout('execmascara()',1)
					}
					 
					function execmascara(){
						v_obj.value=v_fun(v_obj.value)
					}
					 
					function cpfCnpj(v){
					 
						//Remove tudo o que não é dígito
						v=v.replace(/\D/g,"")
					 
						if (v.length <= 13) { //CPF
					 
							//Coloca um ponto entre o terceiro e o quarto dígitos
							v=v.replace(/(\d{3})(\d)/,"$1.$2")
					 
							//Coloca um ponto entre o terceiro e o quarto dígitos
							//de novo (para o segundo bloco de números)
							v=v.replace(/(\d{3})(\d)/,"$1.$2")
					 
							//Coloca um hífen entre o terceiro e o quarto dígitos
							v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
					 
						} else { //CNPJ
					 
							//Coloca ponto entre o segundo e o terceiro dígitos
							v=v.replace(/^(\d{2})(\d)/,"$1.$2")
					 
							//Coloca ponto entre o quinto e o sexto dígitos
							v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
					 
							//Coloca uma barra entre o oitavo e o nono dígitos
							v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
					 
							//Coloca um hífen depois do bloco de quatro dígitos
							v=v.replace(/(\d{4})(\d)/,"$1-$2")
					 
						}
					 
						return v
					 
					}
				</script>	
				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Clientes</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<script type="text/javascript">
							function alteraStatus(status){
								document.getElementById("filtroStatus").submit();
							}
						</script>
						<div id="formulario-filtro">
							<form id="filtroStatus" action="<?php echo $configUrl;?>atendimento/clientes/" method="post">

								<p class="nome-clientes-filtro" style="width:220px;"><label class="label">Filtrar Nome:</label>
								<input type="text" style="width:200px;" name="clientes" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-clientes-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="nome-clientes-filtro" style="width:220px;"><label class="label">Filtrar CPF:</label>
								<input type="text" style="width:200px;" name="cpfCpnj" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj); buscaAvancada();" id="cpfCpnj" autocomplete="off" value="" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />
								
								<p class="bloco-campo-float"><label>Filtrar Status: <span class="obrigatorio"> </span></label>
									<select class="campo" name="statusFiltro" style="width:155px; padding:6px;" required onChange="alteraStatus(this.value);">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['statusFiltro'] == "T" ? '/SELECTED/' : '';?>>Ativo</option>
										<option value="F" <?php echo $_SESSION['statusFiltro'] == "F" ? '/SELECTED/' : '';?>>Inativo</option>
									</select>
								</p>									

								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo Cliente" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo Cliente</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:16px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								
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
																		
					$sql = "INSERT INTO clientes VALUES(0, '".date("Y-m-d")."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['nome']))."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['sobrenome']))."', '".$_POST['cpf']."', '".$_POST['cidade']."', '".$_POST['estado']."', '".$_POST['celular']."', '".$_POST['celular2']."', '".$_POST['email']."', '".$_POST['senha']."', 'T')";
					$result = $conn->query($sql);

					$sqlCodCliete = "SELECT * FROM clientes ORDER BY codCliente DESC LIMIT 0,1";
					$resultCodCliente = $conn->query($sqlCodCliete);
					$dadosCodCliente = $resultCodCliente->fetch_assoc();
					
					if($result == 1){				

						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['sobrenome'] = "";
						$_SESSION['cpf'] = "";
						$_SESSION['celular'] = "";
						$_SESSION['celular2'] = "";
						$_SESSION['email'] = "";
						$_SESSION['senha'] = "";
						$_SESSION['cidade'] = "";
						$_SESSION['estado'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/clientes/'>";					
						$block = "none";		
					}else{
						$erroConteudo = "<p class='erro'>Prbolemas ao cadastrar cliente!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['sobrenome'] = "";
						$_SESSION['cpf'] = "";
						$_SESSION['celular'] = "";
						$_SESSION['celular2'] = "";
						$_SESSION['email'] = "";
						$_SESSION['senha'] = "";
						$_SESSION['cidade'] = "";
						$_SESSION['estado'] = "";
					}

				}else{
					$_SESSION['nome'] = "";
					$_SESSION['sobrenome'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['celular2'] = "";
					$_SESSION['email'] = "";
					$_SESSION['senha'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['estado'] = "";
					$block = "none";		
				}
?>						 
					<div id="cadastrar" style="display:<?php echo $block;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">			
						<form name="formCliente" action="<?php echo $configUrlGer; ?>atendimento/clientes/" method="post">

							<p class="bloco-campo-float"><label id="label-nome">Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:170px;" id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-chamado">Sobrenome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:250px;" id="sobrenome" required name="sobrenome" value="<?php echo $_SESSION['sobrenome']; ?>" /></p>

							<p class="bloco-campo-float" id="campo-cpf"><label>CPF: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:170px;" required id="cpf" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>E-mail: <span class="obrigatorio"> * </span></label>
							<input class="campo-7" type="email" style="width:370px;" required name="email" required value="<?php echo $_SESSION['email']; ?>"/></p>

							<p class="bloco-campo-float"><label>Celular 1: <span class="obrigatorio"> * </span></label>
							<input class="campo-6" type="text" style="width:110px;" required name="celular" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular 2: </label>
							<input class="campo-6" type="text" style="width:110px;" name="celular2" value="<?php echo $_SESSION['celular2']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Cidade: <span class="obrigatorio"> * </span></label>
							<input class="campo-3" type="text" style="width:250px;" required name="cidade" value="<?php echo $_SESSION['cidade']; ?>"/></p>
							
							<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" required style="width:250px; padding:6px;">
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

								
							<p class="bloco-campo-float"><label>Senha: <span class="obrigatorio"> * </span></label>
							<input class="campo-7" type="senha" style="width:105px;" name="senha" required value="<?php echo $_SESSION['senha']; ?>"/></p>
								
							<br class="clear" />
					
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
								var cpfCpnj = $AGD("#cpfCpnj").val();
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>atendimento/clientes/busca-clientes.php?busca="+busca+"&cpfCpnj="+cpfCpnj);
								if(busca == "" && cpfCpnj == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT count(codCliente) registros, nomeCliente, codCliente FROM clientes WHERE codCliente != ''".$filtraStatus."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeCliente'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>CPF</th>
									<th>Celular</th>
									<th>Cidade / Estado</th>
									<th>Cadastro</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
				}
				
				if($url[5] == 1 || $url[5] == ""){
					$pagina = 1;
					$sqlClientes = "SELECT * FROM clientes WHERE codCliente != ''".$filtraStatus." ORDER BY statusCliente ASC, dataCliente DESC, codCliente DESC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlClientes = "SELECT * FROM clientes WHERE codCliente != ''".$filtraStatus." ORDER BY statusCliente ASC, dataCliente DESC, codCliente DESC LIMIT ".$paginaInicial.",30";				
				}		

				$resultClientes = $conn->query($sqlClientes);
				while($dadosClientes = $resultClientes->fetch_assoc()){
					$mostrando++;
					
					if($dadosClientes['statusCliente'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}	
					
					$aniversario = explode("-", $dadosClientes['nascimento']);
					$novaData = $aniversario[2]."/".$aniversario[1];

					$celularWhats = str_replace("(", "", $dadosClientes['fone1']); 
					$celularWhats = str_replace(")", "", $celularWhats); 
					$celularWhats = str_replace(" ", "", $celularWhats); 
					$celularWhats = str_replace("-", "", $celularWhats); 
?>
								<tr class="tr">
									<td class="vinte"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['nomeCliente'];?> <?php echo $dadosClientes['sobrenomeCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosClientes['cpfCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" target="_blank" href='https://api.whatsapp.com/send?1=pt_BR&amp;phone=55<?php echo $celularWhats;?>' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosClientes['celularCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCompleto'] ?>'><?php echo $dadosClientes['cidadeCliente'];?> / <?php echo $dadosClientes['estadoCliente'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCompleto'] ?>'><?php echo data($dadosClientes['dataCliente']);?></a></td>
									<td class="botoes"><a style="padding:0px;" href='<?php echo $configUrl; ?>atendimento/clientes/ativacao/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosClientes['nomeCompleto'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a style="padding:0px;" href='<?php echo $configUrl; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja alterar o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosClientes['codCliente'] ?>, "<?php echo htmlspecialchars($dadosClientes['nomeCompleto']) ?>");' title='Deseja excluir o cliente <?php echo $dadosClientes['nomeCompleto'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
				}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o cliente "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/clientes/excluir/'+cod+'/';
										}
									}
									
									function resetarSenha(cod, nome){
										$tg = jQuery.noConflict();
										if(confirm("Deseja resetar a senha do cliente "+nome+"?")){
											$tg("#html"+cod).html("<img src='<?php echo $configUrlGer;?>f/i/loading.svg' width='50'/>");
											$tg.post("<?php echo $configUrlGer;?>atendimento/clientes/reseta-senha.php", {codCliente: cod},function(data){
												$tg("#html"+cod).html("Senha Padrão");											
											});
										}
									}
								 </script>	 
							</table>							
						</div>
<?php
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "atendimento/clientes";
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
