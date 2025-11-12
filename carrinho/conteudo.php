<?php
	if($_COOKIE['codAprovado'.$cookie] != ""){
		$_SESSION['salvaLocal'] = $arquivoRetornar;
		
		if($url[3] == "excluir" && $url[4] != ""){
			
			$sqlDelete = "DELETE FROM carrinho WHERE codCarrinho = ".$url[4]." and codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
			$resultDelete = $conn->query($sqlDelete);
?>
				<div id="conteudo-interno" style="display: flex; justify-content: center; align-items: center; height: 615px;">
					<img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="100px" alt="">Excluindo projeto do carrinho...
				</div>
<?php
			if($resultDelete == 1){
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."carrinho/'>";
			}
		}else{
?>
	<div id="conteudo-interno">
		<div id="bloco-titulo">
			<p class="titulo">Carrinho</p>
		</div>
		<div id="conteudo-carrinho">
			<div id="col-esq-carrinho">
				<p class="imagem"><img src="<?php echo $configUrl;?>f/i/quebrado/carrinho-esq.jpg" width="100%"/></p>
			</div>
			<div id="col-dir-carrinho">
<?php
			$sqlCarrinho = "SELECT * FROM carrinho C inner join projetos P on C.codProjeto = P.codProjeto WHERE C.codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.dataCarrinho ASC LIMIT 0,1";
			$resultCarrinho = $conn->query($sqlCarrinho);
			$dadosCarrinho = $resultCarrinho->fetch_assoc();
			
			if($dadosCarrinho['codCarrinho'] != ""){
?>				
				<div id="mostra-carrinho">
					<table id="tabela-carrinho">
						<tr class="tr-titulo">
							<th class="um" colspan="2">Projeto</th>
							<th class="dois">Preço</th>
							<th class="tres">Quantidade</th>
							<th class="quatro">Remover</th>
						</tr>
<?php
				$quantiCarrinho = 0;
				$totalCarrinho = 0;
				
				$sqlCarrinho = "SELECT C.codCarrinho, C.quantidadeCarrinho, P.nomeProjeto, P.codProjeto, P.precoProjeto, PCL.nomeProjetoComplementar, PCL.codProjetoComplementar, PCL.precoProjetoComplementar FROM carrinho C INNER JOIN projetos P ON C.codProjeto = P.codProjeto LEFT JOIN projetosComplementos PC ON C.codProjeto = PC.codProjeto AND C.codProjetoComplementar = PC.codProjetoComplementar LEFT JOIN projetosComplementares PCL ON PC.codProjetoComplementar = PCL.codProjetoComplementar WHERE C.codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.dataCarrinho ASC";
				$resultCarrinho = $conn->query($sqlCarrinho);
				while($dadosCarrinho = $resultCarrinho->fetch_assoc()){
					
					$quantiCarrinho++;
					
					if($dadosCarrinho['nomeProjetoComplementar'] == ""){

						$totalCarrinho = $totalCarrinho + $dadosCarrinho['precoProjeto'];

						$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosCarrinho['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();
?>					
						<tr class="tr-while">
							<td class="zero"><a rel="lightbox[roadtrip]" href="<?php echo $configUrlGer."f/projetos/".$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-W.webp';?>"><img style="display:table; margin:0 auto; border-radius:5px;" src="<?php echo $configUrlGer."f/projetos/".$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-W.webp';?>" width="100"/></a></td>
							<td class="um"><?php echo $dadosCarrinho['nomeProjeto'];?></td>
							<td class="dois">R$ <?php echo number_format($dadosCarrinho['precoProjeto'], 2, ",", ".");?></td>
							<td class="tres"><?php echo $dadosCarrinho['quantidadeCarrinho'];?></td>
							<td class="quatro"><a onClick="confirmaExclusao(<?php echo $dadosCarrinho['codCarrinho'];?>, '<?php echo $dadosCarrinho['nomeProjeto'];?>');"><img style="display:table; margin:0 auto;" src="<?php echo $configUrl;?>f/i/quebrado/excluir-2.svg" width="25"/></a></td>
						</tr>
<?php
					}else{

						$totalCarrinho = $totalCarrinho + $dadosCarrinho['precoProjetoComplementar'];

						$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosCarrinho['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();
?>
						<tr class="tr-while">
							<td class="zero"><a rel="lightbox[roadtrip]" href="<?php echo $configUrlGer."f/projetosComplementares/".$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];?>"><img style="display:table; margin:0 auto; border-radius:5px;" src="<?php echo $configUrlGer."f/projetosComplementares/".$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem'];?>" width="100"/></a></td>
							<td class="um"><?php echo $dadosCarrinho['nomeProjetoComplementar'];?></td>
							<td class="dois">R$ <?php echo number_format($dadosCarrinho['precoProjetoComplementar'], 2, ",", ".");?></td>
							<td class="tres"><?php echo $dadosCarrinho['quantidadeCarrinho'];?></td>
							<td class="quatro"><a onClick="confirmaExclusao(<?php echo $dadosCarrinho['codCarrinho'];?>, '<?php echo $dadosCarrinho['nomeProjetoComplementar'];?>');"><img style="display:table; margin:0 auto;" src="<?php echo $configUrl;?>f/i/quebrado/excluir-2.svg" width="25"/></a></td>
						</tr>
<?php
					}
				}
?>					
					</table>
				</div>
				<script type="text/javascript">
					function confirmaExclusao(cod, nome){
						if(confirm("Deseja excluir o projeto "+nome+" do carrinho de compras?")){
							window.location='<?php echo $configUrl;?>carrinho/excluir/'+cod+'/';
						}
					}	
				</script>				
				<div id="bloco-total">
					<div id="total-esq">
						<p class="titulo-total">Pagamento será realizado através do:</p>
						<p class="pagseguro"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/logo-pagseguro.png" width="150"/></p>
					</div>	
					<div id="total-dir">					
						<p class="titulo-total">Total</p>
						<p class="total">R$ <?php echo number_format($totalCarrinho, 2, ",", ".");?></p>
					</div>	
					<br class="clear"/>
				</div>			
				<p class="continuar"><a href="<?php echo $configUrl;?>carrinho/confirmar/">Continuar</a></p>	
<?php
			}else{
?>
				<p class="msg-carrinho">Você precisa adicionar um projeto ao seu carrinho!</p>
				<p class="continuar-projetos"><a href="<?php echo $configUrl;?>projeto-pronto/">Ir para Projetos</a></p>
<?php				
			}
?>				
			</div>
			<br class="clear"/>
		</div>
	</div>
<?php
		}
	}else{
		$_SESSION['salvaLocal'] = $arquivoRetornar;
?>
	<div id="conteudo-interno" style="display: flex; justify-content: center; align-items: center; height: 615px;">
		<img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="100px" alt="">
	</div>
<?php
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/login/'>";		
	}
?>
