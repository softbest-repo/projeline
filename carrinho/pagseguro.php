<?php
	$input = json_decode(file_get_contents("php://input"), true);
	$card_token = $input['token'];

	// Token do sandbox
	$accessToken = "b60b9bb0-5bcf-49d6-af12-b340b8aa7da61de4e6c8445d9855d38f8f444ae0c9b9943d-7b1b-4e6c-a29c-6d64a32a2326";

	// URL da API
	$url = "https://sandbox.api.pagseguro.com/orders";

	// Dados do pagamento
	$data = [
		'reference_id' => 'PEDIDO12345',
		'description' => 'Compra de Produtos X e Y',
		'amount' => [
			'value' => 10000, // R$ 100,00 em centavos (R$ 50,00 + R$ 50,00)
			'currency' => 'BRL'
		],
		'customer' => [
			'name' => 'Cliente Teste',
			'email' => 'cliente@email.com',
			'tax_id' => '12345678909',
			'phones' => [
				[
					'country' => '55',
					'area' => '11',
					'number' => '999999999',
					'type' => 'MOBILE'
				]
			]
		],
		'items' => [
			[
				'reference_id' => '1',
				'name' => 'Produto X', // Nome do Produto
				'description' => 'Descrição do Produto X',
				'quantity' => 1,
				'unit_amount' => 5000, // R$ 50,00 em centavos
				'total_amount' => 5000  // R$ 50,00 em centavos
			],
			[
				'reference_id' => '2',
				'name' => 'Produto Y', // Nome do Produto
				'description' => 'Descrição do Produto Y',
				'quantity' => 1,
				'unit_amount' => 5000, // R$ 50,00 em centavos
				'total_amount' => 5000  // R$ 50,00 em centavos
			]
		]
	];

	// Configurar cURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $accessToken
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

	// Executar a requisição
	$response = curl_exec($ch);
	$order_result = json_decode($response, true);
	$order_id = $order_result['id'] ?? null;

	if (!$order_id) {
	  echo "Erro ao criar ordem.";
	  exit;
	}

	// 2. Criar pagamento com cartão
	$payment = [
	  'payment_method' => [
		'type' => 'CREDIT_CARD',
		'installments' => 1,
		'capture' => true,
		'card' => [
		  'token' => $card_token,
		  'holder' => [
			'name' => 'JOAO DA SILVA'
		  ]
		]
	  ]
	];

	$ch = curl_init("https://sandbox.api.pagseguro.com/orders/$order_id/payments");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	  'Content-Type: application/json',
	  'Authorization: Bearer ' . $accessToken
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment));
echo "<pre>";
echo "Enviando para: https://sandbox.api.pagseguro.com/orders/$order_id/payments\n";
echo "Payload:\n" . json_encode($payment, JSON_PRETTY_PRINT) . "\n";
echo "Token usado:\n" . $accessToken . "\n";
echo "</pre>";
	$response = curl_exec($ch);
	curl_close($ch);

	$payment_result = json_decode($response, true);
	print_r($payment_result);
?>
