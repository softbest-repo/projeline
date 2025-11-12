				<div id="conteudo-interno">
					<div id="bloco-titulo">
						<p class="titulo">Depoimentos</p>	
					</div>
					<div id="conteudo-depoimentos">
						<div id="mostra-depoimentos" class="wow animate__animated animate__fadeIn">
<?php	
	$cont2 = 0; 
	$cont = 0; 
	
	$sqlDepoimento = "SELECT * FROM depoimentos WHERE statusDepoimento = 'T' ORDER BY codOrdenacaoDepoimento ASC";
	$resultDepoimento = $conn->query($sqlDepoimento);
	while($dadosDepoimento = $resultDepoimento->fetch_assoc()){
		
		$cont++;
		$cont2++;
		
		$sqlImagem = "SELECT * FROM depoimentosImagens WHERE codDepoimento = ".$dadosDepoimento['codDepoimento']." ORDER BY codDepoimentoImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();
?>							
							<div id="bloco-depoimento" style="min-height:130px;">
<?php
		if($dadosImagem['codDepoimento'] != ""){
?>							
								<div class="bloco-imagem" style="margin-top:0px;">
									<p class="imagem-blur" style="background:transparent url('<?php echo $configUrlGer.'f/depoimentos/'.$dadosImagem['codDepoimento'].'-'.$dadosImagem['codDepoimentoImagem'].'-W.webp';?>') center center no-repeat; background-size:100%;"></p>	
									<p class="imagem-depoimentos" style="background:transparent url('<?php echo $configUrlGer.'f/depoimentos/'.$dadosImagem['codDepoimento'].'-'.$dadosImagem['codDepoimentoImagem'].'-W.webp';?>') center center no-repeat; background-size:auto 100%;"></p>
								</div>
<?php
		}
?>							
								<div id="fundo-depoimento">	
									<p class="titulo-depoimento"><?php echo $dadosDepoimento['nomeDepoimento'];?></p>
									<p class="cidade-depoimento"><?php echo $dadosDepoimento['cidadeDepoimento'];?></p>
									<p class="estrelas-depoimento"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/estrelas.svg" width="100px"/></p>
									<div class="texto-depoimento"><?php echo $dadosDepoimento['descricaoDepoimento'];?></div>
								</div>
							</div>
<?php
	}	
?>
						</div>
					</div>
<?php
	if($cont2 == 0){
?>							
							<p class="embreve" style="font-size:16px; font-weight:bold; text-align:center; color:#000; padding-top:100px;">Em Breve</p>
<?php
	}
?>
				</div>
