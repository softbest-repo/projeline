<?php
	header('Content-Type: application/json');

	$data = [
		'email' => 'eliasportofermiano@gmail.com',
		'token' => 'b60b9bb0-5bcf-49d6-af12-b340b8aa7da61de4e6c8445d9855d38f8f444ae0c9b9943d-7b1b-4e6c-a29c-6d64a32a2326',
		'currency' => 'BRL',
		'itemId1' => '001',
		'itemDescription1' => 'Item 1',
		'itemAmount1' => '169.90',
		'itemQuantity1' => '1',
		'reference' => '124665c23f7896adff508377925',
		'senderName' => 'Natalie Green',
		'senderAreaCode' => '51',
		'senderPhone' => '988888888',
		'senderEmail' => 'emaildocomprador@pagseguro.com.br',
		'shippingAddressRequired' => 'true',
		'extraAmount' => '0.00'
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://ws.pagseguro.uol.com.br/v2/checkout');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		echo json_encode(['success' => false, 'message' => curl_error($ch)]);
		curl_close($ch);
		exit;
	}

	curl_close($ch);

	$xml = simplexml_load_string($response);

	if(isset($xml->code)){
		echo json_encode(['success' => true, 'code' => (string)$xml->code]);
	}else{
		echo json_encode([
		'success' => false,
		'message' => 'Erro ao gerar checkout',
		'raw_response' => $response
	]);
}
