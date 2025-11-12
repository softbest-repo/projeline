<div id="repete-bannersPromocoes">
		<div id="conteudo-banner">
			<div id="bloco-banner">
				<div class="owl-carrossel">
					<div class="row">
						<div class="large-12 columns">
							<div class="loop owl-carousel bannerCapa owl-loaded owl-drag">
								<?php
								$cont = 0;

								$sqlBannerPromocao = "SELECT * FROM bannersPromocoes WHERE statusBannerPromocao = 'T' ORDER BY codOrdenacaoBannerPromocao ASC";
								$resultBannerPromocao = $conn->query($sqlBannerPromocao);
								while ($dadosBannerPromocao = $resultBannerPromocao->fetch_assoc()) {
									$sqlImagem = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = '" . $dadosBannerPromocao['codBannerPromocao'] . "' ORDER BY codBannerPromocaoImagem ASC LIMIT 0,1";
									$resultImagem = $conn->query($sqlImagem);
									$dadosImagem = $resultImagem->fetch_assoc();

									if ($dadosImagem['extBannerPromocaoImagem'] != "") {

										$cont++;

										if ($dadosImagem['extBannerPromocaoImagem'] != "mp4" && $dadosImagem['extBannerPromocaoImagem'] != "MP4") {

											if ($dadosBannerPromocao['linkBannerPromocao'] != "") {

												if ($dadosBannerPromocao['novaAbaBannerPromocao'] == "S") {
													$target = "target='_blank'";
												} else {
													$target = "";
												}
?>
											<li class="imagem"><a class="imagem-banner" <?php echo $target; ?> title="<?php echo $dadosBannerPromocao['nomeBannerPromocao']; ?>" href="<?php echo $dadosBannerPromocao['linkBannerPromocao']; ?>"><img style="display:block;" src="<?php echo $configUrlGer . 'f/banners-promocoes/' . $dadosImagem['codBannerPromocao'] . '-' . $dadosImagem['codBannerPromocaoImagem'] . '-W.webp'; ?>" width="100%"/></a></li>
<?php
											} else {
?>
												<li class="imagem-banner"  title="<?php echo $dadosBannerPromocao['nomeBannerPromocao']; ?>"><img style="display:block;" src="<?php echo $configUrlGer . 'f/banners-promocoes/' . $dadosImagem['codBannerPromocao'] . '-' . $dadosImagem['codBannerPromocaoImagem'] . '-W.webp'; ?>" width="100%"/></li>
<?php
											}
										} else {
?>
											<li class="imagem-banner"  title="<?php echo $dadosBannerPromocao['nomeBannerPromocao']; ?>">
												<video id="video" class="vid" disablePictureInPicture controlsList="nodownload" style="min-width: 100%; min-height: 100%; width: 100%; display:block;" src="<?php echo $configUrlGer . 'f/banners-promocoes/' . $dadosImagem['codBannerPromocao'] . '-' . $dadosImagem['codBannerPromocaoImagem'] . '-O.' . $dadosImagem['extBannerPromocaoImagem']; ?>" type="video/mp4" loop muted autoplay></video>
											</li>
<?php
										}
									}
								}
?>
							</div>
						</div>
					</div>
				</div>
				<script>
					var $rfg = jQuery.noConflict();
					var owl = $rfg('.bannerCapa');
					owl.owlCarousel({
						autoplay: true,
						speed: 1500,
						autoplayTimeout: 10000,
						smartSpeed: 1000,
						fluidSpeed: 1000,
						items: 1,
						loop: true,
						videoHeight: 930,
						video: true,
						lazyLoad: true,
						lazyLoad: true,
						autoWidth: false,
						autoplayHoverPause: false,
						margin: 0,
						nav: false,
						dots: true
					});
				</script>
			</div>
		</div>
	</div>