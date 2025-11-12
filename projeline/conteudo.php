<?php
	$sqlQuemSomos = "SELECT * FROM quemSomos  LIMIT 0,1";
	$resultQuemSomos = $conn->query($sqlQuemSomos);
	$dadosQuemSomos = $resultQuemSomos->fetch_assoc();
	
	$sqlImagemP = "SELECT * FROM quemSomosImagens WHERE capaQuemSomosImagem = 'T' AND codQuemSomos =  ".$dadosQuemSomos['codQuemSomos']." ORDER BY codQuemSomosImagem ASC LIMIT 1;";
	$resultImagemP = $conn->query($sqlImagemP);
	$dadosImagemP = $resultImagemP->fetch_assoc();
	
	$sqlImagemS = "SELECT * FROM quemSomosImagens WHERE codQuemSomos = ".$dadosQuemSomos['codQuemSomos']." ORDER BY capaQuemSomosImagem ASC, codQuemSomosImagem ASC LIMIT 1,1";
	
	$resultImagemS = $conn->query($sqlImagemS);
	$dadosImagemS = $resultImagemS->fetch_assoc();
?>	
					<div id="conteudo-interno">
						<div id="bloco-titulo">
							<p class="titulo">PROJELINE</p>
						</div>	
						<div id="conteudo-quemSomos">
<?php
	if($dadosImagemP['codQuemSomosImagem'] != ""){
?>
							<p class="imagem-quemSomos wow animate__animated animate__fadeIn"><a title="<?php echo $nomeEmpresaMenor; ?>" rel="lightbox[roadtrip]" href="<?php echo $configUrlGer.'f/quemSomos/'.$dadosImagemP['codQuemSomos'].'-'.$dadosImagemP['codQuemSomosImagem'].'-W.webp'?>"><img style="height:315px; display:block;"src="<?php echo $configUrlGer.'f/quemSomos/'.$dadosImagemP['codQuemSomos'].'-'.$dadosImagemP['codQuemSomosImagem'].'-W.webp';?>" alt=""></a></p>
<?php
	}
?>
							<div class="descricao"><?php echo $dadosQuemSomos['descricaoQuemSomos'];?></div>
							<br class="clear"/>
<?php
	$cont = 0;
	
	$sqlImagemConta = "SELECT * FROM quemSomosImagens WHERE codQuemSomos = ".$dadosQuemSomos['codQuemSomos']." and codQuemSomosImagem != ".$dadosImagemP['codQuemSomosImagem']."";
	$resultImagemConta = $conn->query($sqlImagemConta);
	$dadosImagemConta = $resultImagemConta->fetch_assoc();
	
	if($dadosImagemConta){
?>
							<div id="mais-imagens">
<?php
		$sqlImagem = "SELECT * FROM quemSomosImagens WHERE codQuemSomos = ".$dadosQuemSomos['codQuemSomos']." and codQuemSomosImagem != ".$dadosImagemP['codQuemSomosImagem']." ORDER BY capaQuemSomosImagem ASC, codQuemSomosImagem ASC";
		$resultImagem = $conn->query($sqlImagem);
		while($dadosImagems = $resultImagem->fetch_assoc()){
			$cont++;
			
			if($cont == 3){
				$cont = 0;
				$margin = "margin-right:0px;";
			}else{
				$margin = "";
			}			
?>								
								<p class="imagem" style="<?php echo $margin;?>"><a rel="lightbox[roadtrip]" href="<?php echo $configUrlGer.'f/quemSomos/'.$dadosImagems['codQuemSomos'].'-'.$dadosImagems['codQuemSomosImagem'].'-W.webp';?>" style="width:100%; height:250px; display:block; background:transparent url('<?php echo $configUrlGer.'f/quemSomos/'.$dadosImagems['codQuemSomos'].'-'.$dadosImagems['codQuemSomosImagem'].'-W.webp';?>') center center no-repeat; background-size:cover, 100%;"></a></p>
<?php
		}
?>
								<br class="clear"/>
							</div>
<?php
	}
?>
						</div>
						
					</div>
