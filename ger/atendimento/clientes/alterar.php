<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "clientes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeCliente = "SELECT * FROM clientes WHERE codCliente = '".$url[6]."' LIMIT 0,1";
				$resultNomeCliente = $conn->query($sqlNomeCliente);
				$dadosNomeCliente = $resultNomeCliente->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Clientes</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeCliente['nomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeCliente['statusCliente'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	

						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>atendimento/clientes/ativacao/<?php echo $dadosNomeCliente['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeCliente['codCliente'] ?>, "<?php echo htmlspecialchars($dadosNomeCliente['nomeCliente']) ?>");' title='Deseja excluir o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o cliente "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>atendimento/clientes/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar" style="float:left;"><a href="<?php echo $configUrl;?>atendimento/clientes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear"/>
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['alterar'] != ""){

					$sql = "UPDATE clientes SET nomeCliente = '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['nome']))."', cpfCliente = '".$_POST['cpf']."', celularCliente = '".$_POST['celular']."', celular2Cliente = '".$_POST['celular2']."', cidadeCliente = '".$_POST['cidade']."', estadoCliente = '".$_POST['estado']."', emailCliente = '".$_POST['email']."', senhaCliente = '".$_POST['senha']."' WHERE codCliente = ".$url[6]."";
					$result = $conn->query($sql);
					
					if($result == 1){

						$cont = 0;
						
						$_SESSION['nome'] = $_POST['nomeCompleto'];
						$_SESSION['alterar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/clientes/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar cliente!</p>";
					}

				}else{
					$sql = "SELECT * FROM clientes WHERE codCliente = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosCliente = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosCliente['nomeCliente'];
					$_SESSION['sobrenome'] = $dadosCliente['sobrenomeCliente'];
					$_SESSION['cpf'] = $dadosCliente['cpfCliente'];
					$_SESSION['email'] = $dadosCliente['emailCliente'];
					$_SESSION['celular'] = $dadosCliente['celularCliente'];
					$_SESSION['celular2'] = $dadosCliente['celular2Cliente'];
					$_SESSION['senha'] = $dadosCliente['senhaCliente'];					
					$_SESSION['cidade'] = $dadosCliente['cidadeCliente'];
					$_SESSION['estado'] = $dadosCliente['estadoCliente'];
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
 					<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;							
								document.getElementById("sobrenome").disabled = false;							
								document.getElementById("cpf").disabled = false;
								document.getElementById("email").disabled = false;
								document.getElementById("celular").disabled = false;
								document.getElementById("celular2").disabled = false;
								document.getElementById("cidade").disabled = false;
								document.getElementById("estado").disabled = false;
								document.getElementById("senha").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
	
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>		
						<form name="formCliente" action="<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $url[6] ;?>/" method="post">

						<p class="bloco-campo-float"><label id="label-nome">Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:170px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-chamado">Sobrenome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:250px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="sobrenome" required name="sobrenome" value="<?php echo $_SESSION['sobrenome']; ?>" /></p>

							<p class="bloco-campo-float" id="campo-cpf"><label>CPF: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:170px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required id="cpf" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>E-mail: <span class="obrigatorio"> * </span></label>
							<input class="campo-7" type="email" style="width:370px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="email" id="email" required value="<?php echo $_SESSION['email']; ?>"/></p>

							<p class="bloco-campo-float"><label>Celular 1: <span class="obrigatorio"> * </span></label>
							<input class="campo-6" type="text" style="width:110px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="celular" id="celular" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular 2: </label>
							<input class="campo-6" type="text" style="width:110px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="celular2" id="celular2" value="<?php echo $_SESSION['celular2']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Cidade: <span class="obrigatorio"> * </span></label>
							<input class="campo-3" type="text" style="width:250px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="cidade" id="cidade" value="<?php echo $_SESSION['cidade']; ?>"/></p>
							
							<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required style="width:250px; padding:6px;">
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
							<input class="campo-7" type="senha" style="width:105px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="senha" id="senha" required value="<?php echo $_SESSION['senha']; ?>"/></p>

							<br class="clear"/>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar"/><p class="direita-botao"></p></div></p>						

						</form>
														
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['emissor'] = "";
					$_SESSION['escola'] = "";
					$_SESSION['lotacao'] = "";
					$_SESSION['cargo'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['contratacao'] = "";
					$_SESSION['civil'] = "";
					$_SESSION['situacao'] = "";
					$_SESSION['nascimento'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";	
					$_SESSION['senha'] = "";	
				}

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
