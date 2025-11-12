				<script type="text/javascript">
					function leadWhatsApp(cod, area){
						var $FL = jQuery.noConflict();
						var nomeLead = document.getElementById("nomeContato"+cod).value;
						var celularLead = document.getElementById("celularContato"+cod).value;
						var siteLocal = area;
					
						$FL("#loading-fundo").fadeIn(250);
						$FL("#loading-icone").fadeIn(250);								
						grecaptcha.execute('<?php echo $chaveSite;?>', {action: 'action_form'}).then(function(token) {
						
							$FL.post("<?php echo $configUrl;?>salvaLead.php", {nomeLead: nomeLead, celularLead: celularLead, siteLocal: siteLocal, token: token, action: "action_form"}, function(data){
								if(data.trim() == "ok"){
									$FL("#nomeContato"+cod).val("");									
									$FL("#celularContato"+cod).val("");	
									$FL("#loading-fundo").fadeOut(250);
									$FL("#loading-icone").fadeOut(250);
									$FL(".blackout").fadeOut(250);
									$FL("#popup").fadeOut(250);
									window.open("<?php echo $configUrl;?>contato-whatsapp-enviado/?numero=<?php echo $celularWhats;?>&msg=<?php echo $whatsAppMsg;?>", "_blank");					
								}else
								if(data.trim() == "erro sql lead"){
									alert("Houve um erro ao iniciar conversa no WhatsApp. Erro: #100");
								}else
								if(data.trim() == "erro captcha"){
									alert("Houve um erro ao iniciar conversa no WhatsApp. Erro: #200");
								}else{
									alert("Houve um erro ao iniciar conversa no WhatsApp. Erro: desconhecido");
								}
								
								return false										
							});
						});
						
						return false;
						
						//Erro #100: Erro ao inserir Lead;
						//Erro #200: Erro ao Captcha;
					}	

					function fechaAcesso(){
						var $FLs = jQuery.noConflict();
						$FLs(".blackout").fadeOut(250);
						$FLs("#popup").fadeOut(250);
					}														

					function abrirAcesso(){
						var $FLgs = jQuery.noConflict();
						$FLgs(".blackout").fadeIn(250);
						$FLgs("#popup").fadeIn(250);
					}														
				</script> 
				<p class="blackout" style="display:none;" onClick="fechaAcesso();"></p>
				<div id="popup" style="display:none;">
					<p class="x" onClick="fechaAcesso();">X</p>
					<p class="logo"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/logo-whats-2.svg" width="220"/></p>
					<p class="titulo">Chame no WhatsApp!</p>
					<p class="titulo2">Fale com um de nossos atendentes agora mesmo.</p>
					<form id="targetFormTopo" action="<?php echo $configUrl;?>" method="post" onSubmit="return false, leadWhatsApp('P', 'S');">
						<p class="campo-nome"><input type="text" id="nomeContatoP" value="" placeholder="Nome" required /></p>
						<p class="campo-whats"><input type="text" id="celularContatoP" value="" placeholder="WhatsApp" required onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" /></p>
						<p class="botao-envia"><input type="submit" value="Iniciar Atendimento"/></p>
					</form>
				</div>



				<div id="repete-topo">
					<div id="linha-sup"></div>
						<div id="conteudo-topo">
							<a title="<?php echo $nomeEmpresa ?>" href=" <?php echo  $configUrl; ?>">
								<div id="logo">
									<img id="logo-img" src="<?php echo $configUrl.'f/i/quebrado/logo.png'; ?>" alt="img-logo">
								</div>
							</a>
							<div id="menu">
								<div id="mostra-menu">
									<p class="<?php echo $url[2] == "" ? 'ativo' : ''; ?>"><a style="margin-left: 30px;" href="<?php echo $configUrl; ?>">Home</a></p>
									<p class="<?php echo $url[2] == "projeline" ? 'ativo' : ''; ?>"><a  href="<?php echo $configUrl; ?>projeline">Projeline</a></p>
									<p class="<?php echo $url[2] == "projeto-pronto" ? 'ativo' : ''; ?>"><a  href="<?php echo $configUrl; ?>projeto-pronto/">Projeto Pronto</a></p>
									<p class="<?php echo $url[2] == "projetos-personalizados" ? 'ativo' : ''; ?>"><a href="<?php echo $configUrl; ?>projetos-personalizados/">Projetos Personalizados</a></p>
									<p class="<?php echo $url[2] == "projetos-complementares" ? 'ativo' : ''; ?>"><a href="<?php echo $configUrl; ?>projetos-complementares/">Projetos Complementares</a></p>
									<p class="<?php echo $url[2] == "contato" ? 'ativo' : ''; ?>"><a href="<?php echo $configUrl; ?>contato/">Contato</a></p>
									<br class="clear" />
								</div>
							</div>
							<div id="carrinho">
								<a title="Confira seu carrinho." href="<?php echo $configUrl.'carrinho/' ?>"><img src="<?php echo $configUrl.'f/i/quebrado/carrinho.svg'; ?>" width="40px" alt=""></a>
							</div>
<?php
	if(isset($_COOKIE['codAprovado'.$cookie])){
?>
							<div id="repete-login" style=" width: 13%;">
								<a title="Minha conta." href="<?php echo $configUrl.'minha-conta/'?>">
									<div id="login" style="padding: 7px  8px 7px  30px; background: #001242 url(<?php echo  $configUrl;?>f/i/quebrado/user.svg) 4px  center no-repeat; background-size: 25px;">MINHA CONTA</div>
								</a>
								<p title="Sair." style="margin-top:6px" id="cadastro" ><a href="#" onclick="document.getElementById('logout-form').submit();">Sair</a></p>
									<form id="logout-form" action="<?php echo $configUrl;?>minha-conta/sair/" method="POST" style="display: none;"><input type="hidden" name="logout" value="true"></form>
								</p>
							</div>
<?php 
	}else{
?>

							<div id="repete-login">
								<a title="Faça o seu login." href="<?php echo $configUrl.'minha-conta/login/'?>">
									<div id="login">LOGIN</div>
								</a>
								<p title="Cadastre-se." id="cadastro">Não tem cadastro? <br><a href="<?php echo $configUrl.'minha-conta/cadastre-se/' ?>">Cadastre-se</a></p>
							</div>
<?php 
	}
?>
					</div>
					<div id="linha-inf"></div>
                </div>
