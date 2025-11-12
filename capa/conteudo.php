                <div id="repete-conteudo">
                    <div id="repete-banners">
<?php
        include('capa/banner-capa.php');
?>

                    </div>

<?php
	$sqlProjetos = "SELECT DISTINCT I.* FROM projetos I inner join projetosImagens II on I.codProjeto = II.codProjeto inner join tipoProjeto TP on I.codTipoProjeto = TP.codTipoProjeto WHERE I.statusProjeto = 'T' AND I.destaqueProjeto = 'T'";
	$resultProjetos = $conn->query($sqlProjetos);
	$dadosProjetos = $resultProjetos->fetch_assoc();
	
	if($dadosProjetos['codProjeto'] != ""){
?>


			<div id="repete-projetos">
				<div id="conteudo-projetos">
					<div id="bloco-titulo">
						<p class="titulo">CONHEÇA NOSSOS <span> PROJETOS</span></p>
					</div>
					<div id="mostra-projeto"  class="wow animate__animated animate__fadeIn">

<?php
	$cont = 0;

	$sqlProjetos = "SELECT DISTINCT I.* FROM projetos I inner join projetosImagens II on I.codProjeto = II.codProjeto inner join tipoProjeto TP on I.codTipoProjeto = TP.codTipoProjeto WHERE I.statusProjeto = 'T' AND I.destaqueProjeto = 'T' ORDER BY I.codigoProjeto DESC LIMIT 0,12";
	$resultProjetos = $conn->query($sqlProjetos);
	while ($dadosProjetos = $resultProjetos->fetch_assoc()) {

		$cont++;
		$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE codTipoProjeto = " . $dadosProjetos['codTipoProjeto'] . " LIMIT 0,1";
		$resultTipoProjeto = $conn->query($sqlTipoProjeto);
		$dadosTipoProjeto = $resultTipoProjeto->fetch_assoc();

		$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = " . $dadosProjetos['codProjeto'] . " ORDER BY ordenacaoProjetoImagem ASC, codProjetoImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();

		if ($dadosProjetos['precoProjeto'] != "0.00") {
			$preco = "R$ " . number_format($dadosProjetos['precoProjeto'], 2, ",", ".");
		} else {
			$preco = "A consultar";
		}

		if( $dadosProjetos['frenteProjeto'] == "0" || $dadosProjetos['frenteProjeto'] == "" || $dadosProjetos['fundosProjeto'] == "0" || $dadosProjetos['fundosProjeto'] == "" ){
			$display =  "vazio";
		}else{
			$display = "valor";
		}

		if($cont == 3){
            $cont = 0;
            $margin = "margin-right:0px;";
        }else{
            $margin = "";
        }    

?>

						<div id="bloco-projeto-pronto" style="<?php echo $margin; ?>">
							<a title="<?php echo $dadosProjetos['nomeProjeto']; ?>" href="<?php echo $configUrl . 'projeto-pronto/' . $dadosProjetos['codProjeto'] . '-' . $dadosProjetos['urlProjeto'] . '/'; ?>">
								<div class="bloco-imagem">
									<div class="imagem" style="background:transparent url('<?php echo $configUrlGer . 'f/projetos/' . $dadosImagem['codProjeto'] . '-' . $dadosImagem['codProjetoImagem'] . '-W.webp'; ?>') center center no-repeat; background-size:cover, 100%;"></div>
								</div>
								<div id="conteudo-dados">
									<div id="nome-projeto-pronto">
										<p class="nome"><?php echo $dadosProjetos['nomeProjeto']; ?> - <?php echo $dadosProjetos['codigoProjeto']; ?></p>
									</div>
									<div id="tipo-projeto-pronto">
										<div class="tipo"  style=" <?php if( $dadosTipoProjeto['nomeTipoProjeto']  == 'Apartamento'){ ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/apartamento.svg) 10px center no-repeat; background-size: 22px; <?php }else if($dadosTipoProjeto['nomeTipoProjeto']  == 'Terreno' || $dadosTipoProjeto['nomeTipoProjeto']  == 'Lote' ){  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/terreno.svg) 10px center no-repeat; background-size: 22px; <?php }else {  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/casa-d.svg) 10px center no-repeat; background-size: 22px; <?php } ?> " ><?php echo $dadosTipoProjeto['nomeTipoProjeto']; ?></div>
									</div>
									<div id="icones">
										<div id="alinha-icones">
											<div id="espaco">
												<p class="frente-fundo" style=" <?php echo $display == "vazio" ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['frenteProjeto'].'x'.$dadosProjetos['fundosProjeto']; ?>m²</p>
												<p class="area" style="<?php echo $dadosProjetos['metragemProjeto'] == 0 ? 'display:none;' : '';  ?>"><?php echo $dadosProjetos['metragemProjeto']; ?>m²</p>
												<p class="quartos" style="<?php echo $dadosProjetos['quartosProjeto'] == 0 ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['quartosProjeto']; ?></p>
												<p class="banheiros" style="<?php echo $dadosProjetos['banheirosProjeto'] == 0 ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['banheirosProjeto']; ?></p>
											</div>
										</div>
									</div>
									<div style="display: flex; justify-content: space-between; margin-top:10px;">
										<p class="preco"><?php echo $preco; ?></p>
										<p class="detalhes">Vizualizar Projeto!</p>
									</div>
								</div>
							</a>
						</div>
<?php
	}
?>
					</div>
					<div id="mais">
						<p class="mais">VER MAIS</p>
					</div>
				</div>
			</div>

<?php
	}
?> 		

<?php
	$sqlServico = "SELECT count(DISTINCT N.codServico) total FROM servicos N inner join servicosImagens NI on N.codServico = NI.codServico WHERE N.statusServico = 'T'";
	$resultServico = $conn->query($sqlServico);
	$dadosServico = $resultServico->fetch_assoc();

	if ($dadosServico['total'] >= 1) {
?>
								<div title="<?php echo $dadosServico['nomeServico']; ?>" id="repete-servicos">
									<div id="conteudo-servicos"  class="wow animate__animated animate__fadeInLeft">
										<div id="bloco-titulo">
											<p class="titulo">SERVIÇOS</p>
										</div>
										<div id="mostra-servicos" >
<?php
		$cont = 0;

		$sqlServico = "SELECT DISTINCT N.* FROM servicos N inner join servicosImagens NI on N.codServico = NI.codServico WHERE N.statusServico = 'T' ORDER BY codOrdenacaoServico ASC LIMIT 0,12 ";
		$resultServico = $conn->query($sqlServico);
		
		while ($dadosServico = $resultServico->fetch_assoc()) {
			$sqlImagem = "SELECT * FROM servicosImagens WHERE codServico = " . $dadosServico['codServico'] . " ORDER BY codServicoImagem ASC LIMIT 0,1";
			$resultImagem  = $conn->query($sqlImagem);
			$dadosImagem = $resultImagem->fetch_assoc();

			$cont++;
			if($cont == 2){
				$cor = "background-color: #c27e01;";
				$cont = 0;
			}else{
				$cor = "background-color: #001242;";
			}
			if($dadosServico['urlServico'] == 'projeto-pronto' || $dadosServico['urlServico'] == 'projetos-complementares' || $dadosServico['urlServico'] == 'projetos-personalizados'){
				$linkUrl = $dadosServico['urlServico'];
			}else{
				$linkUrl = "";
			}
?>
												<div id="bloco-servicos" style="<?php echo $cor; ?>">
													<a title="<?php echo $dadosServico['nomeServico']; ?>" href="<?php echo $configUrl.$linkUrl.'/'; ?>">
															<div id="bloco-imagem">
																<img src="<?php echo $configUrlGer . 'f/servicos/' . $dadosImagem['codServico'] . '-' . $dadosImagem['codServicoImagem'] . '-O.'.$dadosImagem['extServicoImagem']; ?>" height="180" alt="">
															</div>
															<div id="fundo">
																<div class="bloco-nome">
																	<p class="nome"><?php echo $dadosServico['nomeServico']; ?></p>
																</div>
																<div class="bloco-descricao">
																	<p class="descricao"><?php echo strip_tags($dadosServico['descricaoServico']); ?></p>
																</div>
																<div id="fundo-confira" <?php echo $linkUrl == "" ? 'style="display: none;"' : ''; ?>>
																	<p class="confira">Saiba mais</p>
																</div>
															</div>
														</p>
													</a>
												</div>
<?php
		}
?>
											</div>
										</div>
									</div>
<?php
	}
?>           

					<div id="repete-por-que">
						<div id="conteudo-por-que" class="wow animate__animated animate__fadeInRight">
							<div id="bloco-titulo">
								<p class="titulo">POR QUE A PROJELINE É A <strong> SOLUÇÃO IDEAL </strong> PARA VOCê?</p>
							</div>
								<div id="mostra-por-que">
<?php 
		$cont = 0;
		$contCor = 0;

		$sqlPorque = "SELECT * FROM porque WHERE statusPorque = 'T' ORDER BY codOrdenacaoPorque ASC";
		$resultPorque  = $conn->query($sqlPorque);
		while($dadosPorque = $resultPorque->fetch_assoc()){
			$cont++;
			$contCor++;
			$sqlImagem = "SELECT * FROM porqueImagens WHERE codPorque = " . $dadosPorque['codPorque'] . "";
			$resultImagem  = $conn->query($sqlImagem);
			$dadosImagem = $resultImagem->fetch_assoc();
			
			if ($cont == 4) {
				$cont = 0;
				$margin = "margin-right:0px;";
			} else {
				$margin = "";
			}
			

			if($contCor == 2){
				$cor = "background-color: #001242;";
				$contCor = 0;
			}else{
				$cor = "background-color: #b07c02;";
			}

?>							
								<div title="<?php echo $dadosPorque['nomePorque']; ?>" id="fundo" style="<?php echo $cor.$margin; ?> cursor:pointer;">
									<div id="imagem">
										<img src="<?php echo $configUrlGer.'f/porque/'.$dadosImagem['codPorque'].'-'.$dadosImagem['codPorqueImagem'].'-O.'.$dadosImagem['extPorqueImagem']; ?>"  height="70" alt="">
									</div>
									<div id="descricao">
										<p class="nome"> <?php echo $dadosPorque['nomePorque']; ?> </p>
									</div>
								</div>
<?php 
		}
?>
							</div>
						</div>
					</div>
				<div id="repete-comparativo">
					<div id="conteudo-comparativo" class="wow animate__animated animate__fadeIn">
						<div id="bloco-titulo">
							<p class="titulo">FAÇA UM COMPARATIVO E <strong>ESCOLHA</strong></p>
						</div>







						<div id="mostra-comparativo">
<?php 
	$cont = 0;
	$sqlComparativos = "SELECT * FROM comparativos WHERE statusComparativo = 'T' ORDER BY codOrdenacaoComparativo ASC";			
	$resultComparativos = $conn->query($sqlComparativos);		

	while ($dadosComparativos = $resultComparativos->fetch_assoc()) {		
		$sqlImagem = "SELECT * FROM comparativosImagens WHERE codComparativo = " . $dadosComparativos['codComparativo'];
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();

		$cont++;
		$margin = ($cont == 3) ? "margin-right:0px;" : "";
		if ($cont == 3) $cont = 0;
?>	
							<div title="Plano <?php echo $dadosComparativos['nomeComparativo']; ?>. " id="fundo" style="<?php echo $margin ?>">
								<div id="titulo">
									<p class="titulo" style="background: transparent url('<?php echo $configUrlGer . 'f/comparativos/' . $dadosImagem['codComparativo'] . '-' . $dadosImagem['codComparativoImagem'] . '-O.' . $dadosImagem['extComparativoImagem']; ?>') left center no-repeat; background-size: 50px;">
										<?php echo $dadosComparativos['nomeComparativo']; ?>
									</p>
								</div>
								<div id="descricao"><?php echo $dadosComparativos['descricaoComparativo']; ?></div>
								<div id="prazo">
									<p class="prazo">Prazo Médio: <?php echo $dadosComparativos['prazoComparativo']; ?></p>
									<p class="cifra"> <?php echo str_repeat('$', $dadosComparativos['cifraoComparativo']); ?></p>
								</div>
<?php 	
			$caracteristicaCheck = [];
			$caracteristicaX = [];
			
			$sqlCaracteristicas = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";			
			$resultCaracteristicas = $conn->query($sqlCaracteristicas);		

			while ($dadosCaracteristicas = $resultCaracteristicas->fetch_assoc()) {
				$sqlCaracteristicasComparativos = "SELECT * FROM caracteristicasComparativos WHERE codComparativo = " . $dadosComparativos['codComparativo'];
				$resultCaracteristicasComparativos = $conn->query($sqlCaracteristicasComparativos);		
				$estaNoComparativo = false;

				while ($dadosCaracteristicasComparativos = $resultCaracteristicasComparativos->fetch_assoc()) {
					if ($dadosCaracteristicas['codCaracteristica'] == $dadosCaracteristicasComparativos['codCaracteristica']) {
						$estaNoComparativo = true;
						break;
					}
				}

				if ($estaNoComparativo) {
					if (!in_array($dadosCaracteristicas['nomeCaracteristica'], $caracteristicaCheck)) {
						$caracteristicaCheck[] = $dadosCaracteristicas['nomeCaracteristica'];
					}
				} else {
					if (!in_array($dadosCaracteristicas['nomeCaracteristica'], $caracteristicaX)) {
						$caracteristicaX[] = $dadosCaracteristicas['nomeCaracteristica'];
					}
				}
			}
			
			for ($i = 0; $i < count($caracteristicaCheck); $i++){
?>
								<div id="caracteristicas">
									<p class="itens" style="background: transparent url('<?php echo $configUrl . 'f/i/quebrado/check.svg'; ?>') left center no-repeat; background-size: 25px;">
										<?php echo $caracteristicaCheck[$i]; ?>
									</p>
								</div>
<?php 
			}
?>
<?php 
			for ($i = 0; $i < count($caracteristicaX); $i++){
?>
								<div id="caracteristicas">
									<p class="itens" style="background: transparent url('<?php echo $configUrl . 'f/i/quebrado/x.svg'; ?>') left center no-repeat; background-size: 25px;">
										<?php echo $caracteristicaX[$i]; ?>
									</p>
								</div>
<?php 
			} 
			
?>
							</div>
<?php 
	}
?>
						</div>
						<div id="compre">
							<a href="<?php echo $configUrl.'projeto-pronto';?>"><p class="compre">Compre agora!</p></a>
						</div>
					</div>
				</div>
				<div id="repete-banner-desconto"  onClick="abrirAcesso();" style="cursor: pointer;">
<?php
        include('capa/banner-promocao.php');
?>
				</div>
				
<?php
	$sqlDepoimento = "SELECT count(codDepoimento) total FROM depoimentos WHERE statusDepoimento = 'T'";
	$resultDepoimento = $conn->query($sqlDepoimento);
	$dadosDepoimento = $resultDepoimento->fetch_assoc();

	if ($dadosDepoimento['total'] >= 1 && $url[2] != "depoimentos") {
?>
					<div id="repete-depoimentos">
						<div id="conteudo-depoimentos">
							<div id="bloco-titulo">
								<p class="titulo">DEPOIMENTOS</p>
							</div>
							<div id="mostra-depoimentos" class="wow animate__animated animate__fadeIn">
								<div class="owl-carrossel">
									<div class="row">
										<div class="large-12 columns">
											<div class="loop owl-carousel depoimentosCarrossel owl-loaded owl-drag">
<?php
	$cont2 = 0;
	$sqlDepoimento = "SELECT * FROM depoimentos WHERE statusDepoimento = 'T' ORDER BY codOrdenacaoDepoimento ASC";
	$resultDepoimento = $conn->query($sqlDepoimento);
	while ($dadosDepoimento = $resultDepoimento->fetch_assoc()) {

		$cont2++;

		$sqlImagem = "SELECT * FROM depoimentosImagens WHERE codDepoimento = " . $dadosDepoimento['codDepoimento'] . " ORDER BY codDepoimentoImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();
?>
												<li class="carrosel-depoimento">
													<a title="<?php echo $dadosDepoimento['nomeDepoimento']; ?>" href="<?php echo $configUrl; ?>depoimentos/">
														<div class="bloco-imagem">
															<div class="moldura">
																<p class="imagem-blur" style="background:transparent url('<?php echo $configUrlGer . 'f/depoimentos/' . $dadosImagem['codDepoimento'] . '-' . $dadosImagem['codDepoimentoImagem'] . '-O.' . $dadosImagem['extDepoimentoImagem']; ?>') center center no-repeat; background-size:100%;"></p>
<?php 
	if($dadosImagem['codDepoimento'] != "" &&  $dadosImagem['codDepoimento'] == $dadosImagem['codDepoimento'] ){
?>
																<p class="imagem-depoimentos" style="background:transparent url('<?php echo $configUrlGer . 'f/depoimentos/' . $dadosImagem['codDepoimento'] . '-' . $dadosImagem['codDepoimentoImagem'] . '-O.' . $dadosImagem['extDepoimentoImagem']; ?>') center center no-repeat; background-size:auto 100%; "></p>
<?php 
	}else{		
?> 																<p class="imagem-depoimentos" style="background:transparent url('<?php echo $configUrl . 'f/i/quebrado/sem-foto.png'; ?>') center center no-repeat; background-size:auto 100%; "></p>
<?php
	}
?>
															</div>
														</div>
														<div id="fundo-depoimento">
															<div id="nome-cidade">
																<p class="nome-depoimento"><?php echo $dadosDepoimento['nomeDepoimento']; ?> - </p>
																<p class="cidade-depoimento"> <?php echo $dadosDepoimento['cidadeDepoimento']; ?></p>
															</div>
															<p class="estrelas-depoimento"><img style="display:block; margin-left: 168px; margin-top: 5px;" src="<?php echo $configUrl; ?>f/i/quebrado/estrelas.svg" width="85px" /></p>
															<div id="alinha-depoimento">
																<div class="texto-depoimento"><?php echo strip_tags($dadosDepoimento['descricaoDepoimento']); ?></div>
															</div>
														</div>
														<br class="clear" />
													</a>
												</li>
<?php
	}
?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<script>
								var $rfgs = jQuery.noConflict();
								$rfgs(document).ready(function() {
									var owlProdutos = $rfgs('.depoimentosCarrossel');
									owlProdutos.owlCarousel({
										autoplay: false,
										autoplayTimeout: 20000,
										smartSpeed: 1000,
										fluidSpeed: 10000,
										items: 2,
										loop: true,
										autoWidth: false,
										margin: 25,
										nav: true,
										dots: true,
										dotsEach: true
									});
								});
							</script>
						</div>
					</div>
<?php
	}
?>		

				<div id="repete-fundo">
					<div id="repete-quemSomos">
						<div id="conteudo-quemSomos" class="wow animate__animated animate__fadeInLeft">
							<a title="<?php echo $nomeEmpresaMenor ?>" href="<?php echo $configUrl.'projeline/'; ?>">
								<div id="mostra-quemSomos">
									<div id="bloco-titulo">
										<p class="titulo">PROJELINE</p>
									</div>
<?php 
	$sqlQuemSomos = "SELECT * FROM quemSomos  LIMIT 0,1";
	$resultQuemSomos = $conn->query($sqlQuemSomos);
	$dadosQuemSomos = $resultQuemSomos->fetch_assoc();
?>
									<div style="display: flex;">
										<div class="descricao"><?php echo $dadosQuemSomos['descricaoCQuemSomos']; ?></div>
										<div id="imagem"><img src="<?php echo $configUrl.'f/i/quebrado/logo-b.png' ?>" width="90%" alt=""></div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div id="repete-equipe">
						<div id="conteudo-equipe" class="wow animate__animated animate__fadeInRight">
							<div id="bloco-titulo">
								<p class="titulo">EQUIPE</p>
							</div>
							<div id="mostra-equipe">
<?php 
	$sqlEquipes = "SELECT * FROM equipe WHERE codOrdenacaoEquipe !=  0 AND statusEquipe = 'T' ORDER BY codOrdenacaoEquipe ASC  LIMIT 0,4";
	$resultEquipes = $conn->query($sqlEquipes);
	while ($dadosEquipe = $resultEquipes->fetch_assoc()) {

		$cont++;

		$sqlImagem = "SELECT * FROM equipeImagens WHERE codEquipe = " . $dadosEquipe['codEquipe'] . " ORDER BY capaEquipeImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();
?>
								<a title="<?php echo $dadosEquipe['nomeEquipe']; ?>"style="margin-top: 15px; cursor:pointer;" >
									<div id="fundo" >
										<div id="imagem" style="background:transparent url('<?php echo $configUrlGer . 'f/equipe/' . $dadosImagem['codEquipe'] . '-' . $dadosImagem['codEquipeImagem'] . '-W.webp'; ?>') center top no-repeat; background-size:cover, 100%; width:220px; height:340px; display:block;"></div>
										<div id="nome-descricao">
											<p class="nome"> <?php echo $dadosEquipe['nomeEquipe']; ?></p>
											<div class="descricao"><?php echo $dadosEquipe['descricaoEquipe']; ?></div>
										</div>
									</div>
								</a>
<?php 
	}
?>
							</div>
						</div>
					</div>
				</div>
				<div id="repete-duvidas">
					<div id="conteudo-duvidas" class="wow animate__animated animate__fadeIn">
						<div id="bloco-titulo">
							<p class="titulo">DÚVIDAS FREQUENTES</p>
						</div>
						<div id="mostra-duvidas">
<?php 
		$sqlDuvidas = "SELECT * FROM duvidas WHERE statusDuvida = 'T' ORDER BY codOrdenacaoDuvida ASC LIMIT 0,8";
		$resultDuvidas = $conn->query($sqlDuvidas);
		while ($dadosDuvidas = $resultDuvidas->fetch_assoc()) {
?>
							<div class="bloco-duvidas">
								<p class="titulo">
									<?php echo $dadosDuvidas['nomeDuvida']; ?> 
									<img  class="icone" src="<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>" width="15" alt="mais">
								</p>
								<div class="descricao"><?php echo $dadosDuvidas['descricaoDuvida']; ?></div>
							</div>
<?php 
		}                            
?>
						</div>
						<div id="mais">
							<a href="<?php echo $configUrl.'duvidas/' ?>"><p class="mais">VER MAIS</p></a>
						</div>
					</div>
				</div>
				<script>
					document.addEventListener('DOMContentLoaded', function () {
						const blocos = document.querySelectorAll('#repete-duvidas #conteudo-duvidas #mostra-duvidas .bloco-duvidas');

						blocos.forEach(bloco => {
							bloco.addEventListener('click', function () {
								const descricao = this.querySelector('.descricao');
								const icone = this.querySelector('.icone');

								blocos.forEach(outroBloco => {
									const outraDescricao = outroBloco.querySelector('.descricao');
									const outroIcone = outroBloco.querySelector('.icone');
									if (outraDescricao !== descricao) {
										outraDescricao.classList.remove('show');
										outroIcone.src = "<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>";
										outroIcone.style.width = '';
										outroIcone.style.height = '';
									}
								});

								descricao.classList.toggle('show');
								
								if (descricao.classList.contains('show')) {
									icone.src = "<?php echo $configUrl.'f/i/quebrado/seta.svg' ?>";
									icone.style.width = '10px';
								} else {
									icone.src = "<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>";
									icone.style.width = '';
									icone.style.height = '';
								}
							});
						});
					});
				</script>
				<div id="repete-banner-escolha">
					<img src="<?php echo $configUrl.'f/i/quebrado/banner-rodape-projeline.jpg' ?>" width="100%" alt="IMAGEM escolha">
					<div id="botoes">
						<div id="escolher">
							<a href="<?php echo $configUrl.'projeto-pronto/'  ?>"><p class="escolher">ESCOLHER O MEU PROJETO</p></a>
						</div>
						<div id="duvidas" onClick="abrirAcesso();">
							<p class="duvidas">QUERO TIRAR ALGUMAS DUVIDAS</p>
						</div>
					</div>
				</div>
            </div>
