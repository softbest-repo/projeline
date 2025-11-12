<?php

	session_start();
	if($_COOKIE['codAprovado'.$cookie] == ""){
	$_SESSION['nome'] = "";
	$_SESSION['sobrenome'] = "";
	$_SESSION['confereCpf'] = "";
	$_SESSION['cpf'] = "";
	$_SESSION['email'] = "";
	$_SESSION['celular'] = "";
	$_SESSION['celular2'] = "";
	$_SESSION['cidade'] = "";
	$_SESSION['estado'] = "";
	$_SESSION['senha'] = "";
?>
			<p id="cadastrando" style="display:none; padding-bottom:30px;"></p>	

				<div id="conteudo-interno">					
					<div id="conteudo-cadastre-se">						
						<div id="conteudo-cadastro">
							<p class="botao-topo" style="top: 50px; left: -25px;"><a href="<?php echo $configUrl;?>minha-conta/login/"> Voltar</a></p>
							<div id="bloco-titulo">
								<p class="titulo">CADASTRE-SE</p>
							</div>				
							<div id= "bloco-cadastre-se">
								<div class="imagem">
									<img src="<?php echo  $configUrl.'f/i/quebrado/rb_1660.png'; ?>" alt="img">
								</div>
								
								<form id="form-cadastro" style=" width: 50%; position: relative; z-index: 20; height:400px; background-color: #b5b5b52b; padding: 30px 0px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" action="<?php echo $configUrl;?>minha-conta/sendEmail-cadastre-se.php" method="post" onSubmit="cadastrarCliente(); return false">		
									<?php if(isset($_SESSION['msg-cadastro'])){ echo $_SESSION['msg-cadastro']; } ?>	
									<p class="loading" id="loading" style="display:none; text-align:center; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);"><img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="80px" alt=""/><br/>Aguarde...</p>							
									<div id="dados-pessoais" style="display:flex;">				
										
										<p class="campo-padrao"><label class="label" id="label-nome">Nome: </label><span class="obrigatorio"> *</span><br/>
										<input class="input" type="name" required name="nome" value="<?php echo $_SESSION['nome'];?>"/ placeholder="Nome"></p>
										
										<p class="campo-padrao"><label class="label" id="label-responsavel">Sobrenome: </label><span class="obrigatorio">*</span><br/>
										<input class="input" type="text" required name="sobrenome" placeholder="Sobrenome" value="<?php echo $_SESSION['sobrenome'];?>"/></p>
										
										<p class="campo-padrao" id="campo-cpf"><label class="label">CPF: <span class="obrigatorio">*</span><span style="display:none; margin-left:325px; font-weight:bold; font-family:Arial; font-size:13px; color:#FF0000;" id="erroCpf">CPF inválido</span></label><br/>
										<input class="input" type="text" name="cpf" required id="validaCpf" placeholder="xxx.xxx.xxx-xx" value="<?php echo $_SESSION['cpf'];?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf), consistenciaCPF(cpf.value);" maxlength="14" /></p>
										<input type="hidden" name="confereCpf" id="confereCpf" value="<?php echo $_SESSION['confereCpf'];?>">			

										<p class="campo-padrao"><label class="label">E-mail: <span class="obrigatorio">*</span></label><br/>
										<input class="input" type="email" name="email" required  placeholder="exemplo@dominio.com" value="<?php echo $_SESSION['email'];?>" style="text-transform:lowercase;"/></p>
				
										<p class="campo-padrao"><label class="label">Celular 1: <span class="obrigatorio">*</span></label><br/>
										<input class="input" type="text" name="celular" required  placeholder="(48) 98765-4321" value="<?php echo $_SESSION['celular'];?>" style="text-transform:lowercase;" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>
				
										<p class="campo-padrao"><label class="label">Celular 2: <span class="obrigatorio"></span></label><br/>
										<input class="input" type="text" name="celular2"  placeholder="(48) 98765-4321" value="<?php echo $_SESSION['celular2'];?>" style="text-transform:lowercase;" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>
				
										<p class="campo-padrao"><label class="label">Cidade<span class="obrigatorio"> * </span></label><br/>
										<input class="input" type="text" required name="cidade" placeholder="Cidade" value="<?php echo $_SESSION['cidade']; ?>" /></p>
																																	
										<p class="campo-padrao"><label class="label">Estado<span class="obrigatorio"> * </span></label><br/>
											<select class="select" name="estado" required>
												<option value="">Selecione...</option>
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


										<script type="text/javascript">
											function cadastrarCliente(){
												document.getElementById("loading").style.display="block";
												document.getElementById("dados-pessoais").style.display="none";
												document.getElementById("form-cadastro").submit();
											}
											
											function confereSenhas(){
												var pegaSenha = document.getElementById("senha").value;
												var pegaConfirmaSenha = document.getElementById("confirmaSenha").value
												
												if(pegaConfirmaSenha != ""){
													if(pegaSenha != pegaConfirmaSenha){
														document.getElementById("erro-senhas").style.display="inline";
														document.getElementById("confereSenhass").value="false";
													}else{
														document.getElementById("erro-senhas").style.display="none";
														document.getElementById("confereSenhass").value="true";
													}
												}else{
													document.getElementById("erro-senhas").style.display="none";
													document.getElementById("confereSenhass").value="false";
												}
											}
										</script>
										<p class="campo-padrao"><label class="label">Senha: <span class="obrigatorio">*</span></label><br/>
										<input class="input" type="password" name="senha" required id="senha" placeholder="******" onKeyUp="confereSenhas();" value="<?php echo $_SESSION['senha'];?>" /></p>
										
										<p class="campo-padrao"><label class="label">Confirma Senha: <span class="obrigatorio">*</span><span id="erro-senhas" style="display:none; font-weight:bold; font-size:12px; color:#FF0000;" id="erroCpf">Senhas não conferem</span></label><br/>
											<input class="input" type="password" name="confirmaSenha" required id="confirmaSenha" placeholder="******" onKeyup="confereSenhas();" value="" />
											<input type="hidden" value="" id="confereSenhass" name="confereSenhass"/>
										</p>
									
										<p class="botao-completo">	
											<input class="botao" type="submit" value="Cadastre-se" name="cadastro" />					
										</p>	
									</div>
								</form>
							</div>

						</div>
						<br class="clear"/>
					</div>
				</div>
				
<?php
		$_SESSION['msg-cadastro'] = "";
	}else{
		header("Location: " . $configUrl);
	}
?>
