<div id="conteudo-interno">
	<div id="bloco-titulo">	
		<p class="titulo galeria">Projetos Complementares</p>
	</div>

	<div id="conteudo-projetosComplementares" class="wow animate__animated animate__fadeInUp">
		<div id="mostra-complementares">
			<table id="tabela-complementares">
				<tr class="titulo">
					<td style="border-radius:5px 0 0 5px; text-align:center;">Imagem</td>
					<td>Projeto</td>
					<td style="text-align:center;">Preço</td>
					<td style="border-radius:0 5px 5px 0; text-align:center;">Ver Projeto</td>
				</tr>

				<?php
				$sqlConta = "SELECT COUNT(*) AS registros FROM projetosComplementares WHERE statusProjetoComplementar = 'T'";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];

				if($url[3] == 1 || $url[3] == ""){
					$pagina = 1;
					$sqlProjetoComplementar = "SELECT * FROM projetosComplementares WHERE statusProjetoComplementar = 'T' ORDER BY codOrdenacaoProjetoComplementar ASC, codProjetoComplementar DESC LIMIT 0,12";
				}else{
					$pagina = $url[3];
					$paginaFinal = $pagina * 12;
					$paginaInicial = $paginaFinal - 12;
					$sqlProjetoComplementar = "SELECT * FROM projetosComplementares WHERE statusProjetoComplementar = 'T' ORDER BY codOrdenacaoProjetoComplementar ASC, codProjetoComplementar DESC LIMIT ".$paginaInicial.",12";
				}
				
				$cont = 0;
				$mostrando = 0;
				$resultProjetoComplementar = $conn->query($sqlProjetoComplementar);
				while($dadosProjetoComplementar = $resultProjetoComplementar->fetch_assoc()){
					$mostrando++;
					$cont++;
					$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosProjetoComplementar['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
					$resultImagem = $conn->query($sqlImagem);
					$dadosImagem = $resultImagem->fetch_assoc();

					$background = ($cont % 2 == 0) ? 'background-color:#f5f5f5;' : 'background-color:#f5e6e6;';
				?>
				<tr class="item" style="<?php echo $background; ?> cursor:pointer;"  onclick="window.location.href='<?php echo $configUrl . 'projetos-complementares/' . $dadosProjetoComplementar['codProjetoComplementar'] . '-' . $dadosProjetoComplementar['urlProjetoComplementar'] . '/'; ?>'">

					<td style="width:130px;">
						<img src="<?php echo $configUrlGer . 'f/projetosComplementares/' . $dadosImagem['codProjetoComplementar'] . '-' . $dadosImagem['codProjetoComplementarImagem'] . '-O.'. $dadosImagem['extProjetoComplementarImagem']; ?>" alt="<?php echo $dadosProjetoComplementar['nomeProjetoComplementar']; ?>" width="150">
					</td>
					<td>
						<strong><?php echo $dadosProjetoComplementar['nomeProjetoComplementar']; ?></strong>
					</td>
					<td style="text-align:center; width:150px;">
						<strong>R$ <?php echo number_format($dadosProjetoComplementar['precoProjetoComplementar'], 2, ',', '.'); ?></strong>
					</td>
					<td style="width:160px; text-align:center;">
						<a href="<?php echo $configUrl . 'projetos-complementares/' . $dadosProjetoComplementar['codProjetoComplementar'] . '-' . $dadosProjetoComplementar['urlProjetoComplementar'] . '/'; ?>">
							<button class="botao-vermais">Ver mais</button>
						</a>
					</td>
				</tr>
<?php
 	} 
?>
			</table>
		</div>
	</div>
<?php
	$regPorPagina = 12;
	$area = "projetosComplementares";
	include ('f/conf/paginacao.php');
?>
</div>
