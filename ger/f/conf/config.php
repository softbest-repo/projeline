<?php
	$configServer = "localhost";
	$configLogin = "root";
	$configSenha = "epitafio";
	$configBaseDados = "projeline";	
	
	$conn = new mysqli($configServer, $configLogin, $configSenha, $configBaseDados);

	if ($conn->connect_error) {
		die("Erro de conexão: " . $conn->connect_error);
	}

	$sqlSession = "SET SESSION sql_mode = ''";
	$resultSession = $conn->query($sqlSession);
	
	$configUrl = "http://192.168.1.200/projeline/ger/";
	$configUrlGer = "http://192.168.1.200/projeline/ger/";
	$configUrlSite = "http://192.168.1.200/projeline/";

	$cookie = "projeline";
	$configLimite = 10;
	
	$urlUpload = "/projeline/ger";

	$nomeEmpresa = "Ger | Projeline - Projetos em SC";
	$nomeEmpresaMenor = "Projeline";
	$hostEmail = "email-ssl.com.br";
	
	$cor1 = "#718b8f";
	$cor2 = "#718b8f";
	$cor3 = "#000";
?>
	
