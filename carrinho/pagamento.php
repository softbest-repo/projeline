<?php
	if(isset($_COOKIE['codAprovado'.$cookie]) && $_COOKIE['codAprovado'.$cookie] != ""){
?>
	<div id="conteudo-interno" style="display: flex; justify-content: center; align-items: center; height: 615px;">
		<img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="100px" alt="">Aguarde... estamos confirmando seus dados...
	</div>
<?php
		$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
		$resultCliente = $conn->query($sqlCliente);
		$dadosCliente = $resultCliente->fetch_assoc();

		$quebraCelular = explode(" ", $dadosCliente['celularCliente']);
		$dddPag = str_replace("(", "", $quebraCelular[0]);
		$dddPag = str_replace(")", "", $dddPag);
		$celularPag = str_replace(" ", "", $quebraCelular[1]);
		$celularPag = str_replace("-", "", $celularPag);

		$url = 'https://sandbox.api.pagseguro.com/checkouts';

		$itens = [];
		$valorTotal = 0;
		$numeroParcela = 0;
		$numeroParcelaS = 0;
		$sqlCarrinho = "SELECT C.quantidadeCarrinho, P.*, PCL.nomeProjetoComplementar, PCL.codProjetoComplementar, PCL.precoProjetoComplementar FROM carrinho C INNER JOIN projetos P ON C.codProjeto = P.codProjeto LEFT JOIN projetosComplementos PC ON C.codProjeto = PC.codProjeto AND C.codProjetoComplementar = PC.codProjetoComplementar LEFT JOIN projetosComplementares PCL ON PC.codProjetoComplementar = PCL.codProjetoComplementar WHERE C.codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.dataCarrinho ASC";
		$resultCarrinho = $conn->query($sqlCarrinho);
		while($dadosCarrinho = $resultCarrinho->fetch_assoc()){

			if($dadosCarrinho['numeroParcelaProjeto'] > $numeroParcela){
				$numeroParcela = $dadosCarrinho['numeroParcelaProjeto'];
			}

			if($dadosCarrinho['numeroParcelaSProjeto'] > $numeroParcelaS){
				$numeroParcelaS = $dadosCarrinho['numeroParcelaSProjeto'];
			}

			if($dadosCarrinho['nomeProjetoComplementar'] == ""){
				$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosCarrinho['codProjeto']." ORDER BY codProjetoImagem ASC LIMIT 0,1";
				$resultImagem = $conn->query($sqlImagem);
				$dadosImagem = $resultImagem->fetch_assoc();

				$itens[] = [
					'reference_id' => $dadosCarrinho['codProjeto'],
					'name' => $dadosCarrinho['nomeProjeto'],
					'description' => 'Projeto pronto da Projeline',
					'quantity' => 1,
					'unit_amount' => str_replace(",", "", str_replace(".", "", $dadosCarrinho['precoProjeto'])),
					'image_url' => $configUrlGer.'f/i/projetos/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-O.'.$dadosImagem['extProjetoImagem']
				];

				$valorTotal += $dadosCarrinho['precoProjeto'];

			}else{
				$sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosCarrinho['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
				$resultImagem = $conn->query($sqlImagem);
				$dadosImagem = $resultImagem->fetch_assoc();

				$itens[] = [
					'reference_id' => $dadosCarrinho['codProjeto'],
					'name' => $dadosCarrinho['nomeProjetoComplementar'],
					'description' => 'Projeto complementar da Projeline',
					'quantity' => 1,
					'unit_amount' => str_replace(",", "", str_replace(".", "", $dadosCarrinho['precoProjetoComplementar'])),
					'image_url' => $configUrlGer."f/projetosComplementares/".$dadosImagem['codProjetoComplementar'].'-'.$dadosImagem['codProjetoComplementarImagem'].'-O.'.$dadosImagem['extProjetoComplementarImagem']
				];

				$valorTotal += $dadosCarrinho['precoProjetoComplementar'];
				
				$nomeItem = $dadosCarrinho['nomeProjetoComplementar'];
				$precoItem = $dadosCarrinho['precoProjetoComplementar'];
			}
		}

		$sqlInsereVenda = "INSERT INTO vendas VALUES (0, ".$dadosCliente['codCliente'].", NOW(), ".$valorTotal.", NOW(), 'ACTIVE', 'NOT_MADE')";
		$resultInsereVenda = $conn->query($sqlInsereVenda);

		if($resultInsereVenda){
			$codVenda = $conn->insert_id;
			$sqlVenda = "SELECT * FROM vendas WHERE codVenda = ".$codVenda."";
			$resultVenda = $conn->query($sqlVenda);
			$dadosVenda = $resultVenda->fetch_assoc();

			$sqlCarrinho = "SELECT C.quantidadeCarrinho, P.*, PCL.nomeProjetoComplementar, PCL.codProjetoComplementar, PCL.precoProjetoComplementar FROM carrinho C INNER JOIN projetos P ON C.codProjeto = P.codProjeto LEFT JOIN projetosComplementos PC ON C.codProjeto = PC.codProjeto AND C.codProjetoComplementar = PC.codProjetoComplementar LEFT JOIN projetosComplementares PCL ON PC.codProjetoComplementar = PCL.codProjetoComplementar WHERE C.codCliente = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.dataCarrinho ASC";
			$resultCarrinho = $conn->query($sqlCarrinho);
			while($dadosCarrinho = $resultCarrinho->fetch_assoc()){

				if($dadosCarrinho['codProjetoComplementar'] == 0){
					$nomeItem = $dadosCarrinho['nomeProjeto'];
					$precoItem = $dadosCarrinho['precoProjeto'];					
				}else{
					$nomeItem = $dadosCarrinho['nomeProjetoComplementar'];
					$precoItem = $dadosCarrinho['precoProjetoComplementar'];
				}
			
				$sqlCarrinhoItens = "INSERT INTO vendasItens VALUES (0, ".$dadosVenda['codVenda'].", ".$dadosCarrinho['codProjeto'].", '".$dadosCarrinho['codProjetoComplementar']."', '".$nomeItem."', 1, '".$precoItem."', NOW())";
				$resultCarrinhoItens = $conn->query($sqlCarrinhoItens);
			
			}
		}

		$payment_methods_configs = [];
		$config_options = [];

		if ($numeroParcela > 0) {
			$config_options[] = [
				"option" => "INSTALLMENTS_LIMIT",
				"value" => $numeroParcela
			];
		}
		if ($numeroParcelaS > 0) {
			$config_options[] = [
				"option" => "INTEREST_FREE_INSTALLMENTS",
				"value" => $numeroParcelaS
			];
		}
		if (!empty($config_options)) {
			$payment_methods_configs[] = [
				"type" => "CREDIT_CARD",
				"config_options" => $config_options
			];
		}
		
		$data = [
			"reference_id" => $codVenda,
			"customer" => [
				"phone" => [
					"country" => "55",
					"area" => $dddPag,
					"number" => $celularPag
				],
				"name" => $dadosCliente['nomeCliente']." ".$dadosCliente['sobrenomeCliente'],
				"email" => $dadosCliente['emailCliente'],
				"tax_id" => str_replace([".", "-"], "", $dadosCliente['cpfCliente'])
			],
			"items" => $itens,
			"additional_amount" => 0,
			"discount_amount" => 0,
			"payment_methods" => [
				["type" => 'CREDIT_CARD'],
				["type" => 'DEBIT_CARD'],
				["type" => 'BOLETO'],
				["type" => 'PIX']
			],
			"payment_methods_configs" => $payment_methods_configs,
			"return_url" => $configUrl."minha-conta/",
			"notification_urls" => [$configUrl."pagseguro/retorno-checkout.php"],
			"payment_notification_urls" => [$configUrl."pagseguro/retorno-pagamento.php"]
		];

		echo $itens;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer b60b9bb0-5bcf-49d6-af12-b340b8aa7da61de4e6c8445d9855d38f8f444ae0c9b9943d-7b1b-4e6c-a29c-6d64a32a2326'
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		curl_close($ch);

		$checkoutData = json_decode($response, true);

		$redirectUrl = (isset($checkoutData['links'][1]['href'])) ? $checkoutData['links'][1]['href'] : '#';

		$sqlVendaInfo = "INSERT INTO vendasInfo (codVenda, statusVendaInfo, jsonVendaInfo) VALUES ('".$codVenda."', 'NOT_MADE', '".$response."')";
		$resultVendaInfo = $conn->query($sqlVendaInfo);

		if($redirectUrl != '#'){
			$sqlDeleteCarrinho = "DELETE FROM carrinho WHERE codCliente = ".$_COOKIE['codAprovado'.$cookie]."";
			$resultDeleteCarrinho = $conn->query($sqlDeleteCarrinho);
		}
	}else{
		header('Location: '.$configUrl.'minha-conta/login/');
		exit;
	}
?>
			<script type="text/javascript">
				window.onload = function() {
					setTimeout(function() {
						location.href = "<?php echo $redirectUrl;?>";
					}, 2000);
				};
			</script>
