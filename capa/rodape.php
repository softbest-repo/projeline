			<script type="text/javascript">	
				var $th = jQuery.noConflict();
				var didScroll;
				var lastScrollTop = 0;
				var delta = 5;
				var navbarHeight = 150;

				$th(window).scroll(function(event) {
					didScroll = true;
				});

				setInterval(function() {
					if (didScroll) {
						hasScrolled();
						didScroll = false;
					}
				}, 250);

				function hasScrolled() {

					var st = $th(this).scrollTop();

					// Make sure they scroll more than delta
					if (Math.abs(lastScrollTop - st) <= delta)
						return;

					// If they scrolled down and are past the navbar, add class .nav-up.
					// This is necessary so you never see what is "behind" the navbar.
					if (st > lastScrollTop && st > navbarHeight) {
						// Scroll Down
						$th('.botao-whatsapp').css("right", "");
					} else {
						// Scroll Up
						if (st + $th(window).height() < $th(document).height()) {
							$th('.botao-whatsapp').css("right", "0px");
						}
					}
					lastScrollTop = st;
				}
			</script>

			<p class="botao-whatsapp"><a class="one" target="_blank"   title="Converse com a gente através do WhatsApp!" onClick="abrirAcesso();">Entre em contato!<br /><?php echo $celular; ?></a></p>

<?php		
	if(isset($_COOKIE['politica'.$cookie]) == ""){
?>
				<script>
					function salvaPolitica(){
						var $pol = jQuery.noConflict();															
						$pol("#politica-privacidade").fadeOut(200);
						$pol.post("<?php echo $configUrl;?>salva-politica.php", {cod: 1},function(data){
							$pol("#politica-privacidade").fadeOut(200);							
						});  																						
					}	
					
					function fadeInPolitica(){
						var $polF = jQuery.noConflict();															
						$polF("#politica-privacidade").fadeIn(200);						
					}			
				</script>
				<div id="politica-privacidade" style="display:none;" class="animate__animated animate__pulse animate__slow animate__infinite">
					<p class="texto">Ao navegar este site você concorda com as <a target="_blank" class="texto" href="<?php echo $configUrl;?>politica-de-privacidade/">políticas de privacidade</a>. <a class="botao-ok" onClick="salvaPolitica();">Ok</a> </p>
				</div>
<?php
	}
	$celularWhats = str_replace("(", "", $celular); 
	$celularWhats = str_replace(")", "", $celularWhats); 
	$celularWhats = str_replace(" ", "", $celularWhats); 
	$celularWhats = str_replace("-", "", $celularWhats); 
	
?>				
					<div id="repete-rodape">
						<div id="conteudo-rodape">
							<div id="lado-esq-rodape">
								<div id="acesso-rapido">
									<p class="titulo">ACESSO RÁPIDO</p>
									<div id="mostra-acesso">
										<li class="<?php echo $url[2] == "" ? 'ativo' : 'p';?>"><a href="<?php echo $configUrl;?>">Home</a></li>
										<li class="<?php echo $url[2] == "projeline" ? 'ativo' : 'p';?>"><a href="<?php echo $configUrl;?>projeline/">Projeline</a></li>
										<li class="<?php echo $url[2] == "contato" ? 'ativo' : 'p';?>"><a href="<?php echo $configUrl;?>contato/">Contato</a></li>
									</div>
								</div>
								<div id="projetos">
									<p class="titulo">PROJETOS</p>
									<div id="mostra-projetos">
<?php 
		$sqlTipo = "SELECT * FROM tipoProjeto LIMIT 0,4";
		$resultTipo = $conn->query($sqlTipo);
		while($dadosTipo = $resultTipo->fetch_assoc()){
?>							
									<a href="">
										<p class="tipos"><?php echo $dadosTipo['nomeTipoProjeto']; ?></p>
									</a>
<?php
		}
?>				
									</div>
								</div>
								<div id="cliente">
									<div id="ld-esq-cliente">
										<p class="titulo">ÁREA DO CLIENTE</p>
										<div id="mostra-compras">
<?php
	if(isset($_COOKIE['codAprovado'.$cookie])){
?>
											<div id="repete-login" style=" margin-right: 16px;">
												<a title="Minha conta." href="<?php echo $configUrl.'minha-conta/'?>">
													<div id="login" style="padding: 8px 20px 8px 35px; background: #001242 url(<?php echo  $configUrl;?>f/i/quebrado/user.svg) 4px  center no-repeat; background-size: 25px; color:white;">Minha Conta</div>
												</a>
												<p title="Sair." style="margin-top:6px; font-size: 12px; color: #001242; font-weight: 700; text-decoration: underline;" id="cadastro" ><a href="#" onclick="document.getElementById('logout-form').submit();">Sair</a></p>
													<form id="logout-form" action="<?php echo $configUrl;?>minha-conta/sair/" method="POST" style="display: none;"><input type="hidden" name="logout" value="true"></form>
												</p>
											</div>
<?php 
	}else{
?>
											<a href="<?php echo $configUrl.'minha-conta/login/'?>"><p class="login">Login</p></a>
<?php 
	}
?>
											
											<a href=""><p class="carrinho">Carrinho</p></a>
											<a href=""><p class="compras">Minhas Compras</p></a>
										</div>
										<a <?php if(isset($_COOKIE['codAprovado'.$cookie])){ echo ' style = " display:none;"';} ?>  href="<?php echo $configUrl.'minha-conta/cadastre-se/' ?>"><p class="esquece-senha">Esqueci minha senha</p></a>
									</div>
									<div id="ld-dir-cliente" <?php if(isset($_COOKIE['codAprovado'.$cookie])){ echo ' style = " width: 39%;"';} ?>>
										<img src="<?php echo $configUrl.'f/i/quebrado/bancos.png' ?>"width =  "80%"; alt="bancos">
									</div>
								</div>
							</div>
							<div id="lado-dir-rodape">
								<div id="logo" style="display: flex;justify-content: center;">
									<img <?php echo $nomeEmpresa;?> src="<?php echo $configUrl.'f/i/quebrado/logo.png' ?>" width="350px" alt="">
								</div>
								<div id="redes">
									<p class="whatsapp" onClick="abrirAcesso();" style="<?php if($celular == ""){ ?>  display:none; <?php } ?> "><a target="_blank" title="Chame-nos no WhatsApp!"><?php echo $celular;?></a></p><br class="clear" />
									<p class="email"><a target="_blank" title="Nosso E-mail" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
									<p class="facebook" style="<?php if($facebook == ""){ ?>   display:none; <?php } ?>"><a target="_blank" title="Curta nossa página no Facebook" href="https://www.facebook.com/<?php echo $facebook; ?>"></a></p>
									<p class="instagram" style="<?php if($instagram == ""){ ?>  display:none; <?php } ?> "><a target="_blank" title="Siga-nos no Instagram" href="https://www.instagram.com/<?php echo $instagram; ?>"></a></p><br class="clear" />
								</div>
							</div>
						</div>
					</div>
					<div id="repete-copy">
						<div id="conteudo-copy">
							<p class="politica"><a href="<?php echo $configUrl; ?>politica-de-privacidade/">Política de Privacidade</a></p>
							<p class="copy">Copyright 2025 - Todos os direitos reservados - <?php echo $nomeEmpresaMenor; ?></p>
							<p class="softbest"><a target="_blank" title="Desenvolvido por: www.softbest.com.br" href="http://www.softbest.com.br"><img style="display:block;" src="<?php echo $configUrl;?>f/i/logo-softbest.svg" width="40"/></a></p>
							<br class="clear" />
						</div>
					</div>	
					<script type="text/javascript">
						function retiraCaptcha(){
							var $gt = jQuery.noConflict();
							$gt(".grecaptcha-badge").fadeOut("slow");
						}
						
						setTimeout("retiraCaptcha();", 2000);
					</script>