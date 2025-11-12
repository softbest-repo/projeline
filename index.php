<?php

	ob_start();
	session_start();
	include ('f/conf/config.php');
	include ('f/conf/functions.php');

	$url = explode("/", $aux.$_SERVER['REQUEST_URI']);

	$quebraUrl2 = explode("=", $url[2]);
	$quebraUrl3 = explode("=", $url[3]);
	$quebraUrl4 = explode("=", $url[4]);

	if($quebraUrl2[0] == "?fbclid" || $quebraUrl2[0] == "?gclid"){
		$url[2] = "";
	}
	if($quebraUrl3[0] == "?fbclid" || $quebraUrl3[0] == "?gclid" || $quebraUrl3[0] == "?numero"){
		$url[3] = "";
	}
	if($quebraUrl4[0] == "?fbclid" || $quebraUrl4[0] == "?gclid"){
		$url[4] = "";
	}
 
	if($url[4] != ""){
		$arquivoRetornar = $url[2].'/'.$url[3].'/'.$url[4].'/';
			if(file_exists($url[2].'/detalhes.php') && $url[2] == 'projeto-pronto' ){   
				$arquivo = $url[2].'/detalhes.php';												
			}else 
			if(is_numeric($url[4])){
				if(file_exists($url[2].'/'.$url[3].'/conteudo.php')){
					$arquivo = $url[2].'/'.$url[3].'/conteudo.php';
				}else
					if(file_exists($url[2].'/'.$url[3].'/detalhes.php')){
						$arquivo = $url[2].'/'.$url[3].'/detalhes.php';
					}else
						if(file_exists($url[2].'/'.$url[3].'.php')){
							$arquivo = $url[2].'/'.$url[3].'.php';
						}else
							if(file_exists($url[2].'/conteudo.php')){
								$arquivo = $url[2].'/conteudo.php';
							}else{
								$arquivo = '404/conteudo.php';
							}
					
			}else
				if(file_exists($url[2].'/detalhes.php') && $url[2] == "imoveis"){
					$arquivo = $url[2].'/detalhes.php';
				}else
					if(file_exists($url[2].'/conteudo.php')){
						$arquivo = $url[2].'/conteudo.php';
					}else
						if(file_exists($url[2].'/'.$url[3].'/'.$url[4].'.php')){
							$arquivo = $url[2].'/'.$url[3].'/'.$url[4].'.php';
						}else{
							$arquivo = '404/conteudo.php';
						}
	}else
		if($url[3] != ""){    
			$arquivoRetornar = $url[2].'/'.$url[3].'/';
			$arquivo = $url[2].'/conteudo.php';

			if(is_numeric($url[3])){ 
				if(file_exists($url[2].'/conteudo.php')){  
					$arquivo = $url[2].'/conteudo.php';
				}else										
					if(file_exists($url[2].'/conteudo.php')){  
						$arquivo = $url[2].'/conteudo.php';
					}
			}else	 
				if(!is_numeric($url[3])){  
 
					if(file_exists($url[2].'/detalhes.php')){    
						$arquivo = $url[2].'/detalhes.php';												
					}else
						if($url[3] == "cadastre-se"){   
							$arquivo = 'minha-conta/cadastre-se.php';
						}else
							if($url[3] == "login"){    
								$arquivo = 'minha-conta/login.php';
							}else
								if($url[3] == "esqueci-minha-senha"){  
									$arquivo = 'minha-conta/esqueci-minha-senha.php';
								}else
									if(file_exists($url[2].'/'.$url[3].'.php')){  
										$arquivo = $url[2].'/'.$url[3].'.php';
									}										
								}else 
								if($url[3] == "contato-whatsapp-enviado"){ 
									$arquivo = 'contato-whatsapp-enviado.php';
									}else															
									if(file_exists($url[2].'/'.$url[3].'/conteudo.php')){  
										$arquivo = $url[2].'/'.$url[3].'/conteudo.php';																						
									}else
										if(file_exists($url[2].'/detalhes.php')){ 
											$arquivo = $url[2].'/detalhes.php';		 										
										}else								
											if(file_exists($url[2].'/'.$url[3].'.php')){ 
												$arquivo = $url[2].'/'.$url[3].'.php';
											}else
												if(file_exists($url[2].'/conteudo.php')){ 
													$arquivo = $url[2].'/conteudo.php';
												}else
													if($url[2] == "busca"){
														$arquivo = $url[2].'/conteudo.php';
													}else{
														$arquivo = '404/conteudo.php';
													}
				
		}else
			if($url[2] != ""){  
				$arquivoRetornar = $url[2].'/';
				if($url[2] == "contato-whatsapp-enviado"){
						$arquivo = 'contato-whatsapp-enviado.php';
					}else
						if(file_exists($url[2].'/conteudo.php')){
							$arquivo = $url[2].'/conteudo.php';
						}else
							if(file_exists($url[2].'.php')){
								$arquivo = $url[2].'.php';
							}else{
								$arquivo = '404/conteudo.php';
							}	
			}else
				if($url[2] == ""){ 
					$arquivoRetornar = "";
					
					$arquivo = 'capa/conteudo.php';
				}else{
					$arquivo = '404/conteudo.php';
				}	
					
	include ('f/conf/titles.php');	
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
	<head>
		<title><?php echo $title;?></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="author" content="SoftBest" />
		<meta name="description" content="<?php echo $description;?>" />
		<meta name="keywords" content="<?php echo $keywords;?>" />
		<meta name="language" content="<?php echo $linguagem;?>"/>
		<meta name="city" content="<?php echo $cidade;?>"/>
		<meta name="state" content="<?php echo $estado;?>"/>
		<meta name="country" content="<?php echo $pais;?>"/>
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">		 -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="theme-color" content="<?php echo $cor1;?>">
		<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $cor1;?>">
		<meta name="msapplication-navbutton-color" content="<?php echo $cor1;?>">	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		

<?php

	if($arquivo != "404/conteudo.php"){
?>
		<meta name="robots" content="index,follow"/>	
<?php
	}else{
?>
		<meta name="robots" content="noindex">
<?php
	}
?>
		
		<link rel="canonical" href="<?php echo $dominio;?>/<?php echo $arquivoRetornar;?>" />	
		<link rel="shortcut icon" href="<?php echo $configUrl;?>f/i/icon.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo $configUrl;?>f/c/estilo.css" media="all" title="Layout padrão" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
		<link rel="stylesheet" href="caminho/para/carrossel-swiper.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sora:wght@100..800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $chaveSite;?>"></script>
		<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/jquery.js"></script>			
		<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/mascaras.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


		<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
		<link rel="stylesheet" href="https://use.typekit.net/sav3tbo.css">
		<script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>

				
<?php
	if($configUrlSeg != ""){
?>		

		 <script>
		  var ua = navigator.userAgent.toLowerCase();

		  var uMobile = '';

		  //Lista de dispositivos que Ã© possÃ­vel acessar
		  uMobile = '';
		  uMobile += 'iphone;ipod;ipad;windows phone;android;iemobile 8';

		  //Separa os itens em arrays
		  v_uMobile = uMobile.split(';');

		  //verifica se vocÃª estÃ¡ acessando pelo celular
		  var boolMovel = false;
		  for (i=0;i<=v_uMobile.length;i++)
		  {
		  if (ua.indexOf(v_uMobile[i]) != -1)
		  {
		  boolMovel = true;
		  }
		  }

		  if (boolMovel == true)
		  {
		   location.href="<?php echo $configUrlSeg.$arquivoRetornar.$ancora;?>";	  			  
		  }else{
		  }
		 </script>		
					
<?php
	}
	
		
	if($url[2] != "" ||  $url['2'] == 'projetos-complementares' ){
?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" />
		<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
		<script>
		lightbox.option({
		  'resizeDuration': 200,
		  'wrapAround': true
		  })
		</script>

		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.theme.default.min.css">
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/jquery.min.js"></script>
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/owl.carousel.js"></script>	
<?php	
	}

	
	if($url[2] == "terrenos" && $url[3] != "" || $url[2] == "casas" && $url[3] != "" || $url[2] == "loteamentos" && $url[3] != "" || $url[2] == "residenciais" && $url[3] != ""){
?>		
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.theme.default.min.css">
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/jquery.min.js"></script>
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/owl.carousel.js"></script>	
<?php
	}else
	if($url[2] == "" || $url[2] == "balneario-gaivota"){	
?>
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.theme.default.min.css">
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/jquery.min.js"></script>
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/owl.carousel.js"></script>					
<?php
	}
?>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>	
<?php
	if($url[2] != "projeto-pronto"){
		
?>
		<meta property="og:title" content="<?php echo $title;?>"/>
		<meta property="og:image" content="<?php echo $configUrl;?>f/i/comp.png"/>
		<meta property="og:description" content="<?php echo $description;?>"/>
		<meta property="og:url" content="<?php echo $configUrl.$arquivoRetornar;?>"/>
		<link href="<?php echo $configUrl;?>f/i/comp.png" rel="image_src" />
<?php
	}
	$dominio = "http://".$_SERVER['SERVER_NAME']."/projeline/";	
?>
		<style type="text/css">

			@font-face {font-family: 'uni';
				src: url('<?php echo $dominio; ?>f/i/fonte/uni.otf') format('opentype');
			}	
			@font-face {font-family: 'UniSans';
				src: url('<?php echo $dominio; ?>f/i/fonte/uni-sans-regular.ttf') format('truetype');
			}
			* {font-family: 'UniSans', sans-serif;}
			.swiper { width: 100%; height: 100%;}
			.swiper-slide { text-align: center; font-size: 18px; background: #fff; display: flex; justify-content: center; align-items: center;}
			.swiper { width: 100%; height: -webkit-fill-available; margin-left: auto; margin-right: auto;}
			.swiper-slide { background-size: cover; background-position: center;}
			.mySwiper2 { height: 883px; width: 100%;}
			.mySwiper { box-sizing: border-box;}.mySwiper 
			.swiper-slide {cursor:pointer; width: 100%; height: 100%; opacity: 0.5;}
			.mySwiper .swiper-slide-thumb-active { opacity: 1;}
			.swiper-slide img { display: block; width: 100%; height: 100%; object-fit: cover;}

		</style>
<?php
	$tagsHead = str_replace("&#39;", "'", $tagsHead);
	echo html_entity_decode($tagsHead);
?>				  
	</head>
<?php
	if(isset($_COOKIE['politica'.$cookie]) == ""){
		$load = "onLoad='fadeInPolitica();'";
	}
?>	
	<body <?php echo $load;?>>
<?php
	$tagsBody = str_replace("&#39;", "'", $tagsBody);
	echo html_entity_decode($tagsBody);
?>

		<div id="tudo">
<?php
	if($url[2] == ""){
?>							
			<script type="text/javascript">
				var $gh2 = jQuery.noConflict();
				$gh2(document).ready(function(){
					$gh2(window).scroll(function(){
						if($gh2(this).scrollTop() >= 80){
							$gh2("#topo").removeClass("normal").addClass("scroll");
							document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/logo.png";
						}else{
							$gh2("#topo").removeClass("scroll").addClass("normal");
							document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/logo.png";
						}
					});
				});

			</script>
			<div id="topo" class="normal"> 
<?php
	}else{
?>				
			<script type="text/javascript">
				var $gh2 = jQuery.noConflict();
				$gh2(document).ready(function(){
					$gh2(window).scroll(function(){
						if($gh2(this).scrollTop() >= 50){
							$gh2("#topo").removeClass("interno").addClass("scroll");
							document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/scroll.png";								
						}else{
							$gh2("#topo").removeClass("scroll").addClass("interno");
							document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/normal.png";
						}
					});
				});

				$gh2(window).scroll(function(){
					if($gh2(this).scrollTop() >= 100){
						$gh2("#topo").removeClass("interno").addClass("scroll");
						document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/scroll.png";														
					}else{
						$gh2("#topo").removeClass("scroll").addClass("interno");
						document.getElementById("logo-img").src="<?php echo $configUrl;?>f/i/quebrado/normal.png";
					}
				});					
			</script>
		<div id="topo" class="interno">
<?php
	}
?>
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
<?php 

$quebraUrl = explode("-", $url[3]);
if($url[2] == "projeto-pronto" && is_numeric($quebraUrl[0]) && !is_numeric($url[3])){

	$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto = ".$quebraUrl[0]." LIMIT 0,1";
	$resultProjeto = $conn->query($sqlProjeto);
	$dadosProjeto = $resultProjeto->fetch_assoc();
	
	$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE codTipoProjeto = " . $dadosProjeto['codTipoProjeto'] . " LIMIT 0,1";
	$resultTipoProjeto = $conn->query($sqlTipoProjeto);
	$dadosTipoProjeto = $resultTipoProjeto->fetch_assoc();  
	
	$whatsAppNumero = $celularWhats;
	$whatsAppMsg = "Olá, gostaria de mais informações sobre o *Projeto Pronto:* ".$dadosProjeto['nomeProjeto']." [ Tipo Projeto :".$dadosTipoProjeto['nomeTipoProjeto']."], Link :".$configUrl.$arquivoRetornar."";
	$whatsAppRetornar = $configUrl.$arquivoRetornar;

}else{
	$whatsAppNumero = $currentWhatsAppNumero;

	$whatsAppMsg = "Olá, vim através do site e gostaria mais informações sosbre os *projetos*.";
	$whatsAppRetornar = $configUrl.$arquivoRetornar;
}
?>

<?php
    $celularWhats = str_replace("(", "", $celular);
    $celularWhats = str_replace(")", "", $celularWhats);
    $celularWhats = str_replace(" ", "", $celularWhats);
    $celularWhats = str_replace("-", "", $celularWhats);

	$telefoneWhats = str_replace("(", "", $telefone);
    $telefoneWhats = str_replace(")", "", $telefoneWhats);
    $telefoneWhats = str_replace(" ", "", $telefoneWhats);
    $telefoneWhats = str_replace("-", "", $telefoneWhats);																								
?>
				<script type="text/javascript">
				    function enviaContatoWhatsApp(numero, msg, retornar) {
				        window.open("<?php echo $configUrl; ?>contato-whatsapp-enviado/?numero=" + numero + "&msg=" + msg + "&retornar=" + retornar, "_blank");
				    }
				</script>
<?php
	include('capa/topo.php');
?>
			</div>	
			<div id="conteudo">
<?php
	include($arquivo);
?>	
			</div>
			<div id="rodape">
<?php 
	include('capa/rodape.php');
?>
			</div>	
			<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/wow.min.js"></script>			
			<script>
				new WOW().init();
			</script>			
		</div>
		<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
		<script src="caminho/para/carrossel-swiper.js"></script>
	</body>
</html>
<?php
	$conn->close();
?>
