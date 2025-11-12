                        
<?php
	if (!empty($_SESSION['popup'])) {
		$mensagem = $_SESSION['popup'];
		$_SESSION['popup'] = ""; 
	}
?>
						<div id="conteudo-interno" style="padding-bottom: 20px;">
							<div id="bloco-titulo">	
								<p class="titulo">Projetos Complementares</p>
							</div>
<?php
	$quebraUrl = explode("-", $url[3]);
	$sqlProjetoComplementar = "SELECT * FROM projetosComplementares WHERE statusProjetoComplementar = 'T' and codProjetoComplementar = '".$quebraUrl[0]."' LIMIT 0,1";
	$resultProjetoComplementar = $conn->query($sqlProjetoComplementar);
	$dadosProjetoComplementar = $resultProjetoComplementar->fetch_assoc();

	$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosProjetoComplementar['codProjetoComplementar']." ORDER BY codProjetoComplementar ASC, codProjetoComplementarImagem ASC LIMIT 0,1";
	$resultImagem = $conn->query($sqlImagem);
	$dadosImagem = $resultImagem->fetch_assoc();

?>
							<div id="conteudo-projetosComplementares-detalhes" class="wow animate__animated animate__fadeIn">
								<div id="mostra-detalhes">
									<p class="botao-topo"><a href="<?php echo $configUrl;?>projetos-complementares/">Voltar</a></p>
										<div id="imagem-detalhes">
											<p class="imagem-projetosComplementares"><a rel="lightbox[roadtrip]" title="<?php echo $dadosProjetoComplementar['nomeProjetoComplementar'];?>" href="<?php echo $configUrlGer.'f/projetosComplementares/'.$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];?>"><img style="display:block;" src="<?php echo $configUrlGer.'f/projetosComplementares/'.$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];?>" width="100%"/></a></p>															
										</div>
										
										<div id="dados-detalhes">
											<p class="nome-projetosComplementares"><?php echo $dadosProjetoComplementar['nomeProjetoComplementar'];?></p>
												<div class="descricao-projetosComplementares"><?php echo $dadosProjetoComplementar['descricaoProjetoComplementar'];?></div>
											<p class="fonte-projetosComplementares"><?php echo $dadosProjetoComplementar['fonteProjetoComplementar'];?></p>
										</div>

									<br class="clear"/>
								</div>
								<div style="background: #f9f9f9;">
								<div style=" width: 1200px; margin: 0 auto; padding: 30px 0px; margin-top: 20px; margin-bottom: 20px;  display: flex; gap:30px; justify-content: space-between; ">
	<?php
	$sqlConta1 = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = '".$dadosProjetoComplementar['codProjetoComplementar']."' and codProjetoComplementarImagem != ".$dadosImagem['codProjetoComplementarImagem'];
	$resultConta1 = $conn->query($sqlConta1);
	$registros1 = mysqli_num_rows($resultConta1);
	
	if($registros1 > 0){
?>
									<div id="outras">
										<div id="bloco-titulo" style=" padding-top: 0px; margin-bottom: 25px; margin-top: 0px;">	
											<p class="titulo projetosComplementares" style="width:600px; margin: 0; font-size: 22px; ">Mais Imagens</p>
										</div>

										<div class="swiper carrossel-imagens">
											<div class="swiper-wrapper">
<?php
		$sqlImagens = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = '".$dadosProjetoComplementar['codProjetoComplementar']."' and codProjetoComplementarImagem != '".$dadosImagem['codProjetoComplementarImagem']."' ORDER BY codProjetoComplementar ASC, codProjetoComplementarImagem ASC";
		$resultImagens = $conn->query($sqlImagens);
		
		$imagens = array();
		while($dadosImagens = $resultImagens->fetch_assoc()){
			$imagens[] = $dadosImagens;
		}
		
		for($i = 0; $i < count($imagens); $i += 2){
?>
												<div class="swiper-slide">
													<div class="slide-container">
<?php
			$img1 = $imagens[$i];
			$urlImg1 = $configUrlGer.'f/projetosComplementares/'.$img1['codProjetoComplementar'].'-'.$img1['codProjetoComplementarImagem'].'-O.'.$img1['extProjetoComplementarImagem'];
?>
														<div class="slide-item">
															<a rel="lightbox[roadtrip]" title="<?php echo $dadosProjetoComplementar['nomeProjetoComplementar'];?>" href="<?php echo $urlImg1;?>" class="slide-image" style="background-image: url('<?php echo $urlImg1;?>')"></a>
														</div>
<?php
			if(isset($imagens[$i + 1])){
				$img2 = $imagens[$i + 1];
				$urlImg2 = $configUrlGer.'f/projetosComplementares/'.$img2['codProjetoComplementar'].'-'.$img2['codProjetoComplementarImagem'].'-O.'.$img2['extProjetoComplementarImagem'];
?>
														<div class="slide-item">
															<a rel="lightbox[roadtrip]" title="<?php echo $dadosProjetoComplementar['nomeProjetoComplementar'];?>" href="<?php echo $urlImg2;?>" class="slide-image" style="background-image: url('<?php echo $urlImg2;?>')"></a>
														</div>
<?php
			}
?>
													</div>
												</div>
<?php
		}
?>
											</div>

											<div class="swiper-button-next"></div>
											<div class="swiper-button-prev"></div>
											<div class="swiper-pagination"></div>
										</div>
									</div>
<?php
	}
?>
									<script>
										document.addEventListener('DOMContentLoaded', function() {
											const swiper = new Swiper('.carrossel-imagens', {
												slidesPerView: 1,      
												spaceBetween: 0,            
												loop: true,              
												autoplay: {
													delay: 5000,         
													disableOnInteraction: true
												},
												pagination: {
													el: '.carrossel-imagens .swiper-pagination',
													clickable: true, 
													dynamicBullets: false
												},
												navigation: {
													nextEl: '.carrossel-imagens .swiper-button-next',
													prevEl: '.carrossel-imagens .swiper-button-prev'
												},
											
												effect: 'slide',
												speed: 500, 
												grabCursor: true,          
												breakpoints: {
													320: {
														slidesPerView: 1
													},
													768: {
														slidesPerView: 1
													},
													1024: {
														slidesPerView: 1
													}
												}
											});
										});
									</script> 
									<form action="<?php echo $configUrl;?>projetos-complementares/salva-anexo.php"  method="post" enctype="multipart/form-data" class="form-projetos wow animate__animated animate__fadeInRight">
										<h2>Projetos Complementares</h2>
										<label for="nome">Nome:</label>
										<div style="display: flex;">
											<input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
										</div>

										<label for="telefone">Telefone (DDD + número):</label>
										<div style="display: flex;">
											<input type="tel" id="telefone" name="telefone" placeholder="(DDD) 99999-9999" required  onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" >
										</div>

										<label for="anexo">Selecionar anexo:</label>
										<div style="display: flex;">
											<input type="file" id="anexo" name="anexo" required>
										</div>

										<input type="hidden" name="url" value="<?php echo $url[3]; ?>">
										<button type="submit">Enviar</button>
									</form>
								</div>
								</div>
							</div>
							<p class="botao-bottom" style="text-align: center; heigth: 0px;" ><a href="<?php echo $configUrl;?>projetos-complementares/">Voltar</a></p>
						</div>
<?php 
	if($mensagem != ''){
?>
   						<div id="popup-mensagem"><?php echo $mensagem; ?></div>
<?php
	}
?>
						<script>
							document.addEventListener("DOMContentLoaded", function() {
								const popup = document.getElementById("popup-mensagem");
								if (popup) {
									setTimeout(() => {
										popup.style.opacity = "0";
										setTimeout(() => popup.remove(), 1000); 
									}, 4000); 
								}
							});
						</script>
