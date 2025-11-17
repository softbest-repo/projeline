<?php

	$configServer = "50.116.87.98";
	$configLogin = "servidor_projeline";
	$configSenha = "epitafio2025*";
	$configBaseDados = "servidor_projeline";	
	
	$conn = new mysqli($configServer, $configLogin, $configSenha, $configBaseDados);

	if ($conn->connect_error) {
		die("Erro de conexão: " . $conn->connect_error);
	}

	$sqlSession = "SET SESSION sql_mode = ''";
	$resultSession = $conn->query($sqlSession);

	$configUrl = "http://".$_SERVER['HTTP_HOST']."/projeline/ger/";
	$configUrlGer = "http://".$_SERVER['HTTP_HOST']."/projeline/ger/";
	$configUrlSeg = "http://".$_SERVER['HTTP_HOST']."/projeline/";

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
	
