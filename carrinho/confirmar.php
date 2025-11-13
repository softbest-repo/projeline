<?php
	if(isset($_COOKIE['codAprovado'.$cookie]) && $_COOKIE['codAprovado'.$cookie] != ""){

		$sqlCarrinho = "SELECT * FROM carrinho WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
		$resultCarrinho = $conn->query($sqlCarrinho);
		$dadosCarrinho = $resultCarrinho->fetch_assoc();

		if($dadosCarrinho['codCarrinho'] != ""){
		
			$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codCliente DESC LIMIT 0,1";
			$resultCliente = $conn->query($sqlCliente);
			$dadosCliente = $resultCliente->fetch_assoc();
?>
	<div id="conteudo-interno">
		<div id="bloco-titulo">
			<p class="titulo">Confirmação para Pagamento</p>
		</div>
		<div id="conteudo-confirmar">
			<div id="cliente">
				<div id="mostra-cliente">
					<p class="titulo-itens">Dados para Faturamento</p>		
					<p class="item"><strong>Nome</strong><br/><?php echo $dadosCliente['nomeCliente'];?> <?php echo $dadosCliente['sobrenomeCliente'];?> </p>	
					<p class="item"><strong>CPF</strong><br/><?php echo $dadosCliente['cpfCliente'];?></p>	
					<br class="clear"/>
					<p class="item"><strong>WhatsApp</strong><br/><?php echo $dadosCliente['celularCliente'];?></p>	
					<p class="item"><strong>E-mail</strong><br/><?php echo $dadosCliente['emailCliente'];?></p>	
					<br class="clear"/>
					<p class="alterar-dados"><a href="<?php echo $configUrl;?>minha-conta/dados-pessoais/">Alterar meus dados</a></p>
				</div>
			</div>
			<div id="valores">
				<div id="mostra-itens">
					<p class="titulo-itens">Seus Itens</p>			
					<div id="mostra-confirmar">
						<table id="tabela-confirmar">
							<tr class="tr-titulo">
								<th class="um" colspan="2">Projeto</th>
								<th class="dois">Preço</th>
								<th class="tres">Quantidade</th>
								<th class="tres">Excluir</th>
							</tr>
<?php
				$quantiCarrinho = 0;
				$totalCarrinho = 0;
				
				$sqlCarrinho = "SELECT C.quantidadeCarrinho, P.nomeProjeto, P.codProjeto, P.precoProjeto, PCL.nomeProjetoComplementar, PCL.codProjetoComplementar, PCL.precoProjetoComplementar FROM carrinho C INNER JOIN projetos P ON C.codProjeto = P.codProjeto LEFT JOIN projetosComplementos PC ON C.codProjeto = PC.codProjeto AND C.codProjetoComplementar = PC.codProjetoComplementar LEFT JOIN projetosComplementares PCL ON PC.codProjetoComplementar = PCL.codProjetoComplementar WHERE C.codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.dataCarrinho ASC";
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
					<div id="total-dir">					
						<p class="total">R$ <?php echo number_format($totalCarrinho, 2, ",", ".");?></p>
						<p class="titulo-total">Total</p>
						<br class="clear"/>
					</div>	
				</div>			
			</div>
			<br class="clear"/>
			<p class="bandeiras">
				<img style="padding-bottom:10px; padding-right:20px;" src="<?php echo $configUrl;?>f/i/quebrado/logo-pagseguro.png" alt="Bandeiras" width="150"/>
				<img src="<?php echo $configUrl;?>f/i/quebrado/bancos.png" alt="Bandeiras" width="200"/>
			</p>


		<div class="termos-container">
			<div id="termos">
<?php
				$sqlTermos = "SELECT * FROM termos LIMIT 1";
				$resultTermo = $conn->query($sqlTermos);

				if ($resultTermo && $resultTermo->num_rows > 0) {
					$dadosTermo = $resultTermo->fetch_assoc();
?>
					<h3><?php echo $dadosTermo['nomeTermo']; ?></h3>
					<p><?php echo nl2br($dadosTermo['descricaoTermo']); ?></p>
<?php
				} else {
					echo "<p>Nenhum termo encontrado.</p>";
				}
?>
			</div>

			<div style="margin-top:15px; text-align: center;">
				<input type="checkbox" id="aceitoTermos">
				<label for="aceitoTermos">Ao continuar, você declara estar de acordo com os
					<a href="#" target="_blank">termos e condições de garantia</a>.
				</label>
			</div>
		</div>

		<p class="msg-confirmar">Ao continuar, você será redirecionado para o PagSeguro para finalizar o pagamento.</p>
		<p class="continuar">
			<a id="botaoContinuar" href="<?php echo $configUrl; ?>carrinho/pagamento/" style="pointer-events:none; opacity:0.5;">Continuar para Pagamento</a>
		</p>
  		<p id="msgAviso" style="text-align: center;" class="msg-aviso">⚠️ Você deve aceitar os termos antes de continuar.</p>
		<script>
			const checkbox = document.getElementById('aceitoTermos');
			const botao = document.getElementById('botaoContinuar');
			const msgAviso = document.getElementById('msgAviso');

			checkbox.addEventListener('change', () => {
				if (checkbox.checked) {
				botao.style.pointerEvents = 'auto';
				botao.style.opacity = '1';
				msgAviso.style.display = 'none';
				} else {
				botao.style.pointerEvents = 'none';
				botao.style.opacity = '0.5';
				}
			});

			botao.addEventListener('click', (e) => {
				if (!checkbox.checked) {
				e.preventDefault();
				msgAviso.style.display = 'block';
				}
			});
		</script>


		</div>
	</div>
<?php
		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projeto-pronto/'>";		
		}
	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/login/'>";		
	}
?>

<style>
	.termos-container { background: #f8f8f8; border: 1px solid #ddd; padding: 20px; border-radius: 10px; margin: 20px 0; color: #333;}
	.termos-container h3 { color: #b07d02; margin-bottom: 10px; text-align: center; }
	.termos-container p { line-height: 1.6; font-size: 14px; text-align: justify; }
	.termos-container a { color: #b07d02; text-decoration: none; font-weight: 600; }
	.termos-container a:hover { text-decoration: underline; } 
	.termos-container input[type="checkbox"] {accent-color: #001242; transform: scale(1.2); margin-right: 8px;  vertical-align: middle;}
</style>