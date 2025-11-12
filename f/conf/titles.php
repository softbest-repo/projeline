<?php
	if($url[2] == ""){
		$sqlQuemSomos = "SELECT * FROM quemSomos LIMIT 0,1";
		$resultQuemSomos = $conn->query($sqlQuemSomos);
		$dadosQuemSomos = $resultQuemSomos->fetch_assoc();
	
		$title = $nomeEmpresa;
		$description = strip_tags($dadosQuemSomos['descricaoQuemSomos']);
	}else
	if($url[2] == "projeline"){
		$sqlQuemSomos = "SELECT * FROM quemSomos  LIMIT 0,1";
		$resultQuemSomos = $conn->query($sqlQuemSomos);
		$dadosQuemSomos = $resultQuemSomos->fetch_assoc();
	
		$title = $nomeEmpresa;
		$description = strip_tags($dadosQuemSomos['descricaoQuemSomos']);
	}else
	if($url[2] == "duvidas"){
		$sqlDuvida = "SELECT * FROM duvidas WHERE codOrdenacaoDuvida = 2 LIMIT 0,1";
		$resultDuvida = $conn->query($sqlDuvida);
		$dadosDuvida = $resultDuvida->fetch_assoc();
	
		$title = "Dúvidas | ".$nomeEmpresa;
		$description = strip_tags($dadosDuvida['descricaoDuvida']);
	}else
	if($url[2] == "depoimentos"){
		$sqlDepoimento = "SELECT * FROM depoimentos WHERE codOrdenacaoDepoimento = 2 LIMIT 0,1";
		$resultDepoimento = $conn->query($sqlDepoimento);
		$dadosDepoimento = $resultDepoimento->fetch_assoc();
	
		$title = "Depoimentos | ".$nomeEmpresa;
		$description = strip_tags($dadosDepoimento['descricaoDepoimento']);
	}else
	if($url[2] == "projeto-pronto"){
		
		$sqlProjeto = "SELECT * FROM projetos LIMIT 0,1";
		$resultProjeto = $conn->query($sqlProjeto);
		$dadosProjeto = $resultProjeto->fetch_assoc();

		$title = "Projeto Pronto | ".$nomeEmpresa;
		$description = strip_tags($dadosProjeto['descricaoProjeto']);

		if($url[2] == "projeto-pronto" && $url[3] != ''){

			$quebraUrl = explode("-", $url[3]);
			$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto = ".$quebraUrl[0];
			$resultProjeto = $conn->query($sqlProjeto);
			$dadosProjeto = $resultProjeto->fetch_assoc();

			$title = $dadosProjeto['nomeProjeto']." - Projeto Pronto | ".$nomeEmpresa;
			$description = strip_tags($dadosProjeto['descricaoProjetos']);
		}
	}else
	if($url[2] == "projetos-personalizados"){
		
		$sqlProjeto = "SELECT * FROM projetosPersonalizados LIMIT 0,1";
		$resultProjeto = $conn->query($sqlProjeto);
		$dadosProjeto = $resultProjeto->fetch_assoc();

		$title = "Projetos Personalizados | ".$nomeEmpresa;
		$description = strip_tags($dadosProjeto['descricaoProjetos']);

		if($url[2] == "projetos-personalizados" && $url[3] != ''){

			$quebraUrl = explode("-", $url[3]);
			$sqlProjeto = "SELECT * FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$quebraUrl[0];
			$resultProjeto = $conn->query($sqlProjeto);
			$dadosProjeto = $resultProjeto->fetch_assoc();

			$title = $dadosProjeto['nomeProjetoPersonalizado']." - Projetos Personalizados | ".$nomeEmpresa;
			$description = strip_tags($dadosProjeto['descricaoProjetos']);
		}
	}else
	if($url[2] == "projetos-complementares"){
		$sqlProjetos = "SELECT * FROM projetosComplementares LIMIT 0,1";
		$resultProjetos = $conn->query($sqlProjetos);
		$dadosProjetos = $resultProjetos->fetch_assoc();
	
		$title = "Projetos Complementares | ".$nomeEmpresa;
		$description = strip_tags($dadosProjetos['descricaoProjetos']);
		
		if($url[2] == "projetos-complementares" && $url[3] != ''){

			$quebraUrl = explode("-", $url[3]);
			$sqlProjetos = "SELECT * FROM projetosComplementares WHERE codProjetoComplementar = ".$quebraUrl[0];
			$resultProjetos = $conn->query($sqlProjetos);
		 	$dadosProjetos = $resultProjetos->fetch_assoc();

			$title = $dadosProjetos['nomeProjetoComplementar']." - Projetos Complementares | ".$nomeEmpresa;
			$description = strip_tags($dadosProjetos['descricaoProjetos']);
		}
	}else
	if($url[2] == "carrinho"){
		$title = "Carrinho | ".$nomeEmpresa;
		$description = "";

		if($url[3] == "confirmar"){
			$title = "Confirmação para Pagamento | ".$nomeEmpresa;
			$description = "";
		}else
		if($url[3] == "pagamento"){
			$title = "Aguarde... Estamos confirmando seus dados | ".$nomeEmpresa;
			$description = "";
		}
	}else

	if($url[2] == "contato"){
		$title = "Contato | ".$nomeEmpresa;
		$description = "";
	}else
	if($url[2] == 'minha-conta'){
		$title = "Minha Conta | ".$nomeEmpresa;
		$description = "";
		if($url[3] == 'login'){
			$title = "Login | ".$nomeEmpresa;
			$description = "";
		}elseif($url[3] == 'esqueci-minha-senha'){
			$title = "Esqueci Minha Senha | ".$nomeEmpresa;
			$description = "";
		}elseif($url[3] == 'cadastre-se'){
			$title = "Cadastre-se | ".$nomeEmpresa;
			$description = "";
		}
	}
	else
	if($url[2] == "contato-whatsapp-enviado"){
		$title = "Contato WhatsApp Enviado | ".$nomeEmpresa;
		$description = "";
	}else{
		$title = "Página não encontrada | ".$nomeEmpresa;
		$description = "Utilize os menu acima para navegar pelo site";
	}if($url[2] == "balneario-gaivota"){
		$title = "Conheça Balneário Gaivota | ".$nomeEmpresa;
		$description = "Localizada no extremo sul de Santa Catarina, Balneário Gaivota é atualmente uma das cidades que mais se destaca em seu desenvolvimento estrutural";
		
		if($url[3] != ""){
			$title = "Contato enviado com sucessso - Contato | ".$nomeEmpresa;			
		}
	}
	
	$keywords = $keywordsConfig; 
?>
