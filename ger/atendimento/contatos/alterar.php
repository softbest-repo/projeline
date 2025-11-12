<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "contatos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeContato = "SELECT codContato, nomeContato, statusContato FROM contatos WHERE codContato = '".$url[6]."' LIMIT 0,1";
				$resultNomeContato = $conn->query($sqlNomeContato);
				$dadosNomeContato = $resultNomeContato->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contatos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeContato['nomeContato'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeContato['statusContato'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>atendimento/contatos/ativacao/<?php echo $dadosNomeContato['codContato'] ?>/' title='Deseja <?php echo $statusPergunta ?> o contato <?php echo $dadosNomeContato['nomeContato'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeContato['codContato'] ?>, "<?php echo htmlspecialchars($dadosNomeContato['nomeContato']) ?>");' title='Deseja excluir o contato <?php echo $dadosNomeContato['nomeContato'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o contato "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>atendimento/contatos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a href="<?php echo $configUrl;?>atendimento/contatos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['nome'] != ""){
					
					$sql = "UPDATE contatos SET codUsuario = ".$_POST['usuario'].", nomeContato = '".$_POST['nome']."', emailContato = '".$_POST['email']."', cidadeContato = '".$_POST['cidade']."', estadoContato = '".$_POST['estado']."', celularContato = '".$_POST['celular']."', descricaoContato = '".$_POST['descricao']."' WHERE codContato = ".$url[6]."";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alterars'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."atendimento/contatos/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar contato!</p>";
					}

				}else{
					$sql = "SELECT * FROM contatos WHERE codContato = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosContato = $result->fetch_assoc();
					$_SESSION['usuario'] = $dadosContato['codUsuario'];
					$_SESSION['nome'] = $dadosContato['nomeContato'];
					$_SESSION['email'] = $dadosContato['emailContato'];
					$_SESSION['cidade'] = $dadosContato['cidadeContato'];
					$_SESSION['estado'] = $dadosContato['estadoContato'];
					$_SESSION['celular'] = $dadosContato['celularContato'];
					$_SESSION['telefone'] = $dadosContato['telefoneContato'];
					$_SESSION['descricao'] = $dadosContato['descricaoContato'];
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
								document.getElementById("usuario").disabled = false;
								document.getElementById("nome").disabled = false;
								document.getElementById("email").disabled = false;        
								document.getElementById("cidade").disabled = false;        
								document.getElementById("estado").disabled = false;        
								document.getElementById("celular").disabled = false;
								document.getElementById("descricao").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						 </script>

						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>		
						<form name="formContato" action="<?php echo $configUrlGer; ?>atendimento/contatos/alterar/<?php echo $url[6] ;?>/" method="post">
						
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:190px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
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
							<input class="campo-nomes" type="text" style="width:230px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<br class="clear"/>						

							<p class="bloco-campo-float"><label>E-mail:</label>
							<input class="campo-7" type="email" style="width:433px;" name="email" id="email" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['email']; ?>"/></p>

							<br class="clear"/>						

							<p class="bloco-campo-float"><label>Cidade:</label>
							<input class="campo-7" type="text" style="width:260px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cidade" id="cidade" value="<?php echo $_SESSION['cidade']; ?>"/></p>

							<p class="bloco-campo-float"><label>Estado:</label>
								<select class="campo" id="estado" name="estado" style="width:162px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
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

							<p class="bloco-campo-float"><label>Celular: </label>
							<input class="campo-6" type="text" style="width:432px;" name="celular" required id="celular" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear" />						

							<p class="bloco-campo"><label>Mensagem:<span class="obrigatorio"> </span></label>
							<textarea class="desabilita campo" id="descricao" name="descricao"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:431px; height:150px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar"/><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['usuario'] = "";
					$_SESSION['email'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['telefone'] = "";
					$_SESSION['descricao'] = "";
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
