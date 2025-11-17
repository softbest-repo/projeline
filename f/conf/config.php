<?php


	error_reporting(0);
	ini_set('display_errors', 0);

	$configServer = "50.116.87.98";
	$configLogin = "servidor_projeline";
	$configSenha = "epitafio2025*";
	$configBaseDados = "servidor_projeline";	

	$configUrl = "http://".$_SERVER['HTTP_HOST']."/projeline/";
	$configUrlSeg = "http://".$_SERVER['HTTP_HOST']."/projeline_m/";
	$configUrlGer = "http://".$_SERVER['HTTP_HOST']."/projeline/ger/";

	$conn = new mysqli($configServer, $configLogin, $configSenha, $configBaseDados);
	$conn->set_charset("utf8mb4");

	if ($conn->connect_error) {
		die("Erro de conexão: " . $conn->connect_error);
	}

	$sqlSession = "SET SESSION sql_mode = ''";
	$resultSession = $conn->query($sqlSession);
	
	$nomeEmpresa = "Projeline - Projetos em SC";
	$nomeEmpresaMenor = "Projeline";
	
	$cookie = "projelineSite";
	
	$aux = "";
	
	$urlUpload = "/projeline/ger";

	$politicaNome = "Projeline";
	$politicaNomeA = "a Projeline";

	$linguagem = "Portuguese";
	$pais = "Brazil";
	$estado = "Santa Catarina";
	$cidade = "";

	$sqlInformacao = "SELECT * FROM informacoes WHERE codInformacao = 1";
	$resultInformacao = $conn->query($sqlInformacao);
	$dadosInformacao = $resultInformacao->fetch_assoc();
	
	$celularWhats = $dadosInformacao['celularInformacao'];
	$endereco = $dadosInformacao['enderecoInformacao'];
	$atendimento = $dadosInformacao['atendimentoInformacao'];
	$rota = $dadosInformacao['rotaInformacao'];
	$telefone = $dadosInformacao['telefoneInformacao'];
	$celular = $dadosInformacao['celularInformacao'];
	$email = $dadosInformacao['emailInformacao'];	
	$creci = $dadosInformacao['creciInformacao'];	
	$facebook = $dadosInformacao['facebookInformacao'];
	$instagram = $dadosInformacao['instagramInformacao'];	
	$mapa = $dadosInformacao['mapaInformacao'];
	$tagsHead = $dadosInformacao['tagsHeadInformacao'];
	$tagsBody = $dadosInformacao['tagsBodyInformacao'];
	$tagsConversao = $dadosInformacao['tagsConversaoInformacao'];
	
	$keywordsConfig = "";

	$hostEmail = "email-ssl.com.br";
	$dominio = "https://projeline.com.br";
	$dominioSem = "projeline.com.br";
	$chaveSite = "6LdI-IsqAAAAACqb0x50bev3kVa-H3PbeFSTv9II";
	$chaveSecreta = "6LdI-IsqAAAAAGzMsbRkUdxyFxjuJ4xU6fLjKF_u";
	
	$cor1 = "#ae7d02";
	$cor2 = "#021245";
	
