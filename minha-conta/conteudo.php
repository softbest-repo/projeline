<?php
// ERRO ENCONTRADO: A variável $erro é usada mas nunca definida neste arquivo.
// Isso pode causar um aviso de "undefined variable" em: if($erro != ""){ ... }

	if($_COOKIE['codAprovado'.$cookie] == ""){ 
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "minha-conta/login/'>";
	}else{
?>
				<div id="conteudo-interno">
                    <div id="bloco-titulo">
                        <p class="titulo">MINHA CONTA</p>
                    </div>
<?php     
  		$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
		$resultCliente = $conn->query($sqlCliente);
		$dadosCliente = $resultCliente->fetch_assoc();
		
		$_SESSION['nomeCompleto'] = $dadosCliente['nomeCliente'] . ' ' . $dadosCliente['sobrenomeCliente'];
		if($dadosCliente['cpfCliente'] != ""){
			$quebraCpf = explode(".", $dadosCliente['cpfCliente']);
			$quebraDois = explode("-", $dadosCliente['cpfCliente']);
			$monta = $quebraCpf[0].".***.***-".$quebraDois[1];
			$_SESSION['cpf'] = $monta;
			$label = "CPF";
		}
		$_SESSION['email'] = $dadosCliente['emailCliente'];
		$_SESSION['cidade'] = $dadosCliente['cidadeCliente'];
		$_SESSION['estado'] = $dadosCliente['estadoCliente'];		
?>	
					<div id="conteudo-minha-conta">
						<div id="col-esq-conta">
							<div id="barra-inicio">
								<div class="bloco-nome"><p class="nome">Olá, <span class="bold"><?php echo  $_SESSION['nomeCompleto'] ?></span></p></div>
								<br class="clear"/>
							</div>							
							<div id="menu">
								<p class="<?php echo $url[3] == "meus-pedidos" || $url[3] == "" ? 'ativo' : 'item';?>"><a style="background:transparent url('<?php echo $configUrl;?>f/i/quebrado/checkout.svg') left center no-repeat; background-size:24px;" href="<?php echo $configUrl;?>minha-conta/meus-pedidos/#menu-geral">Meus Pedidos</a></p>
								<p class="<?php echo $url[3] == "dados-pessoais" || $url[3] == "alterar-senha" ? 'ativo' : 'item';?>"><a style="background:transparent url('<?php echo $configUrl;?>f/i/quebrado/user2.svg') left center no-repeat; background-size:24px;" href="<?php echo $configUrl;?>minha-conta/dados-pessoais/#menu-geral">Meus Dados</a></p>
                                <p class="<?php echo $url[3] == "sair" ? 'ativo' : 'item';?>" style="border-bottom:none;"><a style="background:transparent url('<?php echo $configUrl;?>f/i/quebrado/logout.svg') left center no-repeat; background-size:24px;" href="#" onclick="document.getElementById('logout-form').submit();">Sair</a></p>
                                <form id="logout-form" action="<?php echo $configUrl;?>minha-conta/sair/" method="POST" style="display: none;"><input type="hidden" name="logout" value="true"></form>
							</div>
						</div>
						<div id="col-dir-conta" style="<?php echo $min;?>">
<?php
		if($url[3] == "dados-pessoais"){
			           
			
			if(isset($_POST['alterar'])){
				$sqlUpdate = "UPDATE clientes SET nomeCliente = '".$_POST['nomeCliente']."', sobrenomeCliente = '".$_POST['sobrenomeCliente']."', celularCliente = '".$_POST['celularCliente']."', celular2Cliente = '".$_POST['celular2Cliente']."', cidadeCliente = '".$_POST['cidadeCliente']."', estadoCliente = '".$_POST['estadoCliente']."' WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
				$resultUpdate = $conn->query($sqlUpdate);
				
				if($resultUpdate == 1){
                    $_SESSION['msg-dados-pessoais'] = '<p class="wow animate__animated animate__fadeIn" style="color: #ffffff;margin-bottom: 0px;left: 50%;transform: translateX(-50%);font-size: 12px;position: absolute;top: -37px;background-color: green; padding: 6px 15px; border-radius: 8px;">Seus dados foram alterados com sucesso!</p>';
				}else{
                    $_SESSION['msg-dados-pessoais'] = '<p style="color: #ffffff;margin-bottom: 0px;left: 50%;transform: translateX(-50%);font-size: 12px;position: absolute;top: -37px;background-color: #f52200; padding: 6px 15px; border-radius: 8px;">Problemas ao alterar dados</p>';
				}
			}

			$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
			$resultCliente = $conn->query($sqlCliente);
			$dadosCliente = $resultCliente->fetch_assoc();			
?>							
							<div id="bloco-dados">
								<?php if(isset($_SESSION['msg-dados-pessoais'])){ echo $_SESSION['msg-dados-pessoais']; } ?>
								<p class="titulo-dados">Meus Dados</p>
								<form action="<?php echo $configUrl;?>minha-conta/dados-pessoais/#menu-geral" method="post">
									<p class="campo-padrao"><label class="label" id="label-nome">Nome: </label><span class="obrigatorio"> *</span><br/>
									<input class="input" type="text" required name="nomeCliente" value="<?php echo $dadosCliente['nomeCliente'];?>" /></p>
									
									<p class="campo-padrao" style="float:right;"><label class="label">Sobrenome: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="text" required name="sobrenomeCliente" value="<?php echo $dadosCliente['sobrenomeCliente'];?>" /></p>
									
									<p class="campo-padrao"><label class="label">CPF: <span class="obrigatorio">*</span><span style="display:none; margin-left:325px; font-weight:bold; font-size:15px; color:#FF0000;" id="erroCpf">CPF inválido</span></label><br/>
									<input class="input" type="text" name="cpfCliente" disabled id="validaCpf" value="<?php echo $dadosCliente['cpfCliente'];?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf), consistenciaCPF(cpf.value);" maxlength="14" /></p>
									
                                    <p class="campo-padrao" style="float:right;"><label class="label">E-mail: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="email" name="emailCliente" disabled="disabled" value="<?php echo $dadosCliente['emailCliente'];?>" style="text-transform:lowercase;"/></p>	

                                    <br class="clear"/>

									<p class="campo-padrao"><label class="label">Celular 1: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="text" name="celularCliente" required value="<?php echo $dadosCliente['celularCliente'];?>" /></p>
									
									<p class="campo-padrao" style="float:right;"><label class="label">Celular 2: <span class="obrigatorio"> </span></label><br/>
									<input class="input" type="text" name="celular2Cliente" value="<?php echo $dadosCliente['celular2Cliente'];?>" /></p>
									
									<br class="clear"/>

									<p class="campo-padrao"><label class="label">Cidade: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="text" name="cidadeCliente" required value="<?php echo $dadosCliente['cidadeCliente'];?>" /></p>
									
									<p class="campo-padrao" style="float:right;"><label class="label">Estado: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="text" name="estadoCliente" required value="<?php echo $dadosCliente['estadoCliente'];?>" /></p>
									
									<br class="clear"/>
									
									<p class="campo-padrao" style="width:fit-content; margin:0 auto; float:none;">
									<a class="link-alt" href="<?php echo $configUrl;?>minha-conta/alterar-senha/#menu-geral">Alterar Senha</a>
									<input class="botao" type="submit" value="Alterar Dados" name="alterar" /></p>				
									
									<br class="clear"/>
								</form>
							</div>
                            
<?php
            $_SESSION['msg-dados-pessoais'] = "";
		}else
		if($url[3] == "alterar-senha"){			
		
			if(isset($_POST['alterarSenha'])){
				$sqlSenhaAntiga = "SELECT senhaCliente FROM clientes WHERE statusCliente = 'T' and senhaCliente = '".$_POST['senha-antiga']."' and codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
				$resultSenhaAntiga = $conn->query($sqlSenhaAntiga);
				$dadosSenhaAntiga = $resultSenhaAntiga->fetch_assoc();
				
				if($dadosSenhaAntiga['senhaCliente'] != ""){ 
					$sqlUpdate = "UPDATE clientes SET senhaCliente = '".$_POST['senha']."' WHERE codCliente = '".$_COOKIE['codAprovado'.$cookie]."'";
					$resultUpdate = $conn->query($sqlUpdate);
                    $_SESSION['msg-alterar-senha'] = '<p  class="wow animate__animated animate__fadeIn" style="color: #ffffff;margin-bottom: 0px;left: 50%;transform: translateX(-50%);font-size: 12px;position: absolute;top: -37px;background-color: green; padding: 6px 15px; border-radius: 8px;webkit-animation-name: fadeIn; animation-name: fadeIn;">Senha alterada com sucesso!</p>';
                    echo  $_SESSION['msg-alterar-senha'];

				}else{
                    $_SESSION['msg-alterar-senha'] = '<p  class="wow animate__animated animate__fadeIn" style="color: #ffffff;margin-bottom: 0px;left: 50%;transform: translateX(-50%);font-size: 12px;position: absolute;top: -37px;background-color: #f52200; padding: 6px 15px; border-radius: 8px;">A Senha Atual está incorreta!</p>';
				
				}
			}
            
?> 
							<div id="bloco-senha">
								<p class="botao-topo" style="margin-top:0px; margin-right:20px; top: -1px;"><a href="<?php echo $configUrl;?>minha-conta/dados-pessoais/#menu-geral"> Voltar</a></p>
								<p class="titulo-senha">Alterar Senha</p>
								<script type="text/javascript">
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

									function confereDadosCadastra(nomeForm){
										if(nomeForm.confereSenhass.value=="false"){
											nomeForm.confirmaSenha.focus();										 
											return false;
										}else{
											nomeForm.alterarSenha.setAttribute('readonly',true);
											this.location = "#menu-geral";
											return true;
										}
									}
								</script>
                                <?php if(isset($_SESSION['msg-alterar-senha'])){ echo $_SESSION['msg-alterar-senha']; } ?>
								<form style="width:350px; margin:0 auto;" action="<?php echo $configUrl;?>minha-conta/alterar-senha/#menu-geral" method="post" onSubmit="return confereDadosCadastra(this);">
									<p class="campo-padrao"><label class="label">Senha Atual: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="password" name="senha-antiga" required id="senha-antiga" value="<?php echo $_SESSION['senha-antiga'];?>" /></p>
									
									<p class="campo-padrao"><label class="label">Nova Senha: <span class="obrigatorio">*</span></label><br/>
									<input class="input" type="password" name="senha" required id="senha" onKeyUp="confereSenhas();" value="<?php echo $_SESSION['senha'];?>" /></p>
									
									<p class="campo-padrao"><label class="label">Confirma Senha: <span class="obrigatorio">*</span><span id="erro-senhas" style="display:none; margin-left:30px; font-family:Arial; font-weight:bold; font-size:13px; color:#FF0000;" id="erroCpf">Senhas não conferem</span></label><br/>
										<input class="input" type="password" name="confirmaSenha" required id="confirmaSenha" onKeyup="confereSenhas();" value="<?php echo $_SESSION['confirmaSenha'];?>" />
										<input type="hidden" value="<?php echo $_SESSION['confereSenhass'];?>" id="confereSenhass" name="confereSenhass"/>
									</p>								

									<p class="campo-padrao"><input class="botao" type="submit" value="Alterar Senha" name="alterarSenha" /></p>					

									<br class="clear"/>
								</form>
							</div>
                            
<?php
            $_SESSION['msg-alterar-senha'] = "";
		}else
		if($url[3] == "meus-pedidos" || $url[3] == ""){
?>
							<div id="meus-pedidos">
								<script type="text/javascript">
									function abreMenu(id){
										var $slide = jQuery.noConflict();
										$slide(".cor-botao").css("background-color", "#fbfbfb");
										$slide(".cor-botao").css("font-weight", "normal");
										if(document.getElementById("detalhes-pedido"+id).style.display=="none"){	
											$slide(".cor-botao"+id).css("background-color", "#ccc");
											$slide(".cor-botao"+id).css("font-weight", "bold");
										}
										$slide(".detalhes-pedido").slideUp(500);
										$slide("#detalhes-pedido"+id).stop().slideToggle(500);
									}
								</script>
								<p class="titulo-pedidos">Meus Pedidos</p>
								<div id="conteudo-pedidos">
<?php
			$sqlTotal = "SELECT * FROM vendas WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY dataVenda DESC LIMIT 0,1";
			$resultTotal = $conn->query($sqlTotal);
			$dadosTotal = $resultTotal->fetch_assoc();
			
			if($dadosTotal['codVenda'] != ""){
?>
									<div id="tabela">
										<div id="titulos-tabela">
											<p class="data" style="width:10%;">Nº Pedido</p>
											<p class="data">Data</p>
											<p class="valor">Total</p>
											<p class="status">Status</p>
											<p class="mais">Detalhes</p>
											<br class="clear" />
										</div>
<?php
				$cont = 0;
				$sqlUltimos = "SELECT * FROM vendas WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY dataVenda DESC";
				$resultUltimos = $conn->query($sqlUltimos);
				while($dadosUltimos = $resultUltimos->fetch_assoc()){

					$cont++;
					
					$dataCompra = explode(" ", $dadosUltimos['dataVenda']);	

					if($dadosUltimos['statusVenda'] == "NOT_MADE"){

						$sqlVendaInfo = "SELECT jsonVendaInfo FROM vendasInfo WHERE codVenda = ".$dadosUltimos['codVenda'];
						$resultVendaInfo = $conn->query($sqlVendaInfo);
						$dadosVendaInfo = $resultVendaInfo->fetch_assoc();

						$checkoutData = json_decode($dadosVendaInfo['jsonVendaInfo'], true);
						$redirectUrl = (isset($checkoutData['links'][1]['href'])) ? $checkoutData['links'][1]['href'] : '#';
						
						$dataVenda = strtotime($dadosUltimos['dataVenda']);
						$dataAtual = time();
						$diferencaHoras = ($dataAtual - $dataVenda) / 3600;
						
						if ($diferencaHoras < 2) {
							$status = "Pagamento não Efetuado";
							$backgroundColor = "#ff0000";
							$color = "#FFF";	
						}else{
							$status = "Checkout Cancelado";
							$backgroundColor = "#bf0000";
							$color = "#FFF";
						}
					}else
					if($dadosUltimos['statusVenda'] == "CANCELLED"){
						$status = "Pagamento Cancelado";
						$backgroundColor = "#bf0000";
						$color = "#FFF";
					}else
					if($dadosUltimos['statusVenda'] == "DECLINED"){
						$status = "Pagamento Negado";
						$backgroundColor = "#ff4d4d";
						$color = "#FFF";
					}else
					if($dadosUltimos['statusVenda'] == "REFUNDED"){
						$status = "Pagamento Devolvido";
						$backgroundColor = "#ff8080";
						$color = "#FFF";
					}else						
					if($dadosUltimos['statusVenda'] == "CHARGEDBACK"){
						$status = "Pagamento Estornado";
						$backgroundColor = "#ffb3b3";
						$color = "#333";						
					}else						
					if($dadosUltimos['statusVenda'] == "WAITING"){
						$status = "Aguardando Pagamento";					
						$backgroundColor = "#fbaa14";
						$color = "#333";					
					}else
					if($dadosUltimos['statusVenda'] == "IN_ANALYSIS"){
						$status = "Em Análise";					
						$backgroundColor = "#ffc966";
						$color = "#333";					
					}else
					if($dadosUltimos['statusVenda'] == "AUTHORIZED"){
						$status = "Pagamento Autorizado";
						$backgroundColor = "#c7e4f6";
						$color = "#333";																
					}else
					if($dadosUltimos['statusVenda'] == "PAID"){
						$status = "Pagamento Aprovado";
						$backgroundColor = "#99d6ff";
						$color = "#333";																
					}			
?>			
										<div id="pedido">
											<div class="informacoes-pedido">
												<p class="data-pedido cor-preta cor-preta<?php echo $cont;?>" id="verifica<?php echo $cont;?>" style="width:10%;"><?php echo $dadosUltimos['codVenda'];?></p>
												<p class="data-pedido cor-preta cor-preta<?php echo $cont;?>" id="verifica<?php echo $cont;?>" style="color:#808080;"><?php echo data($dataCompra[0]);?></p>
												<p class="valor-pedido cor-preta cor-preta<?php echo $cont;?>">R$ <?php echo number_format($dadosUltimos['valorVenda'], 2, ",", ".");?></p>
												<p class="status-pedido cor-preta cor-preta<?php echo $cont;?>" style="font-size:15px; background-color:<?php echo $backgroundColor;?>; color:<?php echo $color;?>;"><?php echo $status;?></p>
												<p class="mais"><a class="cor-preta cor-preta<?php echo $cont;?> cor-botao cor-botao<?php echo $cont;?>" href="javascript:abreMenu(<?php echo $cont;?>);">Detalhes</a></p>
												<br class="clear" />
											</div>		
											<div class="detalhes-pedido" id="detalhes-pedido<?php echo $cont;?>" style="display:none;">
<?php
					if($dadosUltimos['statusVenda'] == "NOT_MADE"){
						$sqlVendaInfo = "SELECT jsonVendaInfo FROM vendasInfo WHERE codVenda = ".$dadosUltimos['codVenda'];
						$resultVendaInfo = $conn->query($sqlVendaInfo);
						$dadosVendaInfo = $resultVendaInfo->fetch_assoc();

						$checkoutData = json_decode($dadosVendaInfo['jsonVendaInfo'], true);
						$redirectUrl = (isset($checkoutData['links'][1]['href'])) ? $checkoutData['links'][1]['href'] : '#';
						
						$dataVenda = strtotime($dadosUltimos['dataVenda']);
						$dataAtual = time();
						$diferencaHoras = ($dataAtual - $dataVenda) / 3600;
						
						if ($diferencaHoras < 2) {
?>
												<p class="botao-pagamento"><a target="_blank" href="<?php echo $redirectUrl;?>">Realizar Pagamento</a></p>
<?php
						}
					}
?>
												<div class="infos-produtos">
													<div class="tituto-infos">
														<p class="itens">Itens do Pedido</p>
														<p class="quanti">Quant</p>
														<p class="valor-uni">Valor</p>
														<p class="sub">Download</p>
														<br class="clear" />
													</div>
													<table class="produtos-compra">
<?php
					$cont = 0;

					$sqlVendasItens = "SELECT * FROM vendasItens WHERE codVenda = ".$dadosUltimos['codVenda']." ORDER BY codVendaItem ASC";
					$resultVendasItens = $conn->query($sqlVendasItens);
					while($dadosVendasItens = $resultVendasItens->fetch_assoc()){
						
						$cont++;

						if($dadosVendasItens['codProjeto'] != 0 && $dadosVendasItens['codProjetoComplementar'] == 0){

							$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosVendasItens['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC LIMIT 0,1";
							$resultImagem = $conn->query($sqlImagem);
							$dadosImagem = $resultImagem->fetch_assoc();	

							$imagem = $configUrlGer.'f/projetos/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-O.'.$dadosImagem['extProjetoImagem'];

							if($cont == 2){
								$cont = 0;
								$background = "background-color:#f5f5f5;";
							}else{
								$background = "background-color:#f5f5f5;";
							}
							
							$codigo = $dadosVendasItens['codProjeto'];  // ou algo como $dadosVendasItens['codProjeto']
							$letra = "P";
						}else{
							$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosVendasItens['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
							$resultImagem = $conn->query($sqlImagem);
							$dadosImagem = $resultImagem->fetch_assoc();	

							$imagem = $configUrlGer.'f/projetosComplementares/'.$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];

							if($cont == 2){
								$cont = 0;
								$background = "background-color:#f5f5f5;";
							}else{
								$background = "background-color:#f5f5f5;";
							}
							
							$codigo = $dadosVendasItens['codProjetoComplementar'];  // ou algo como $dadosVendasItens['codProjeto']
							$letra = "PC";							
						}										   					

						$senha = "proje2025line22";
						$mensagem = $senha . "|" . $codigo . "|" . $letra;
						$hash = hash_hmac('sha256', $mensagem, 'df2455vd@202522');
						$tokenBruto = $hash . "|" . $codigo . "|" . $letra;
						$tokenCodificado = base64_encode($tokenBruto);	
?>
														<tr style="<?php echo $background;?>">
															<td class="itens"><span><img style="padding-right:15px;" src="<?php echo $imagem;?>" width="100px"/></span><span><?php echo $dadosVendasItens['nomeItemVenda']; ?></span></td>
															<td class="quanti"><?php echo $dadosVendasItens['quantidadeItemVenda']; ?></td>
															<td class="valor-uni">R$ <?php echo number_format($dadosVendasItens['valorItemVenda'], 2, ",", "."); ?></td>
<?php
						if($dadosUltimos['statusVenda'] == "PAID"){
?>
															<td class="baixar"><a href="<?php echo $configUrl.'projeto-pronto/download.php?token='.urlencode($tokenCodificado);?>">Baixar Projeto</a></td>
<?php
						}else{
?>
															<td class="baixar" style="text-decoration:none;"><a>--</a></td>
<?php
						}
?>
														</tr>
<?php
					}
?>
													</table>
												</div>
											</div>	
										</div>
<?php
					$cont++;
				}
?>			
									</div>
<?php
			}else{
?>
									<p class="msg">Nenhum pedido realizado!</p>
									<p class="encontre"><a href="<?php echo $configUrl;?>projeto-pronto/">Acesse a área de Projeto Pronto e confira nossas opções</a></p>
<?php				
			}
?>											
								</div>
							</div>
<?php
		}else
		if($url[3] == "trocas-e-devolucoes"){
?>	
							<div id="bloco-devolucoes">
								<p class="titulo-devolucoes">Trocas e Devoluções</p>								
								<p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce molestie augue tincidunt arcu mattis ullamcorper. Nunc nec dolor venenatis, tincidunt enim non, elementum nisi. Nam pellentesque tortor eu accumsan elementum. Curabitur in arcu orci. Aliquam ultrices eros eget nisi varius, nec placerat tortor tempor. Sed hendrerit ultricies justo id feugiat. Morbi ut risus velit. Fusce in placerat lorem. Fusce vel sapien at orci lobortis tincidunt et non libero. Duis ac vulputate est.</p>
								<p class="entre-em-contato"><a href="<?php echo $configUrl;?>contato/">Entre em contato conosco</a></p>
							</div>
<?php
		}
?>
						</div>
						<br class="clear"/>
 					</div>
<?php
        if(isset($erro) && $erro != ""){
?>	
					<script type="text/javascript">
						function someErro(){
							var $t = jQuery.noConflict();
							$t("#erro").fadeOut("slow");
						}

						setTimeout("someErro()", 10000);
					</script>
<?php
		}
?>
				</div>

<?php	 
	}
?>
