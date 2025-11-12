                        <div id="conteudo-interno" style="padding-bottom: 0px;">
							<div id="bloco-titulo">	
								<p class="titulo galeria">Projetos Personalizados</p>
							</div>
							<div id="conteudo-projetosPersonalizados" class="wow animate__animated animate__fadeInUp">
<?php
	$sqlProjeto = "SELECT * FROM projetosPersonalizados WHERE statusProjetoPersonalizado = 'T'";
	$resultProjeto = $conn->query($sqlProjeto);
	$dadosProjeto = $resultProjeto->fetch_assoc();
	$registros = $resultProjeto->num_rows; 
	
	if($url[3] == 1 || $url[3] == ""){
        $pagina = 1;
        $sqlProjetoPersonalizado = "SELECT * FROM projetosPersonalizados WHERE statusProjetoPersonalizado = 'T' ORDER BY codOrdenacaoProjetoPersonalizado ASC, codProjetoPersonalizado DESC LIMIT 0,12";
    }else{
        $pagina = $url[3];
        $paginaFinal = $pagina * 12;
        $paginaInicial = $paginaFinal - 12;
        $sqlProjetoPersonalizado = "SELECT * FROM projetosPersonalizados WHERE statusProjetoPersonalizado = 'T' ORDER BY codOrdenacaoProjetoPersonalizado ASC, codProjetoPersonalizado DESC LIMIT ".$paginaInicial.",12";
    }
    
    $cont = 0;
    
    $resultProjetoPersonalizado = $conn->query($sqlProjetoPersonalizado);
    while($dadosProjetoPersonalizado = $resultProjetoPersonalizado->fetch_assoc()){
    
        $mostrando = $mostrando + 1;
        $cont++;
        $sqlImagem = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$dadosProjetoPersonalizado['codProjetoPersonalizado']." ORDER BY codProjetoPersonalizadoImagem ASC LIMIT 0,1";
        $resultImagem = $conn->query($sqlImagem);
        $dadosImagem = $resultImagem->fetch_assoc();

		$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE codTipoProjeto = " . $dadosProjetoPersonalizado['tipoProjeto'] . " LIMIT 0,1";
		$resultTipoProjeto = $conn->query($sqlTipoProjeto);
		$dadosTipoProjeto = $resultTipoProjeto->fetch_assoc();  
		
		if($cont == 3){
            $cont = 0;
            $margin = "margin-right:0px;";
        }else{
            $margin = "";
        }    
?>
						<div id="bloco-projetosPersonalizados" style="<?php echo $margin; ?>">
							<a title="<?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado']; ?>" href="<?php echo $configUrl . 'projetos-personalizados/' . $dadosProjetoPersonalizado['codProjetoPersonalizado'] . '-' . $dadosProjetoPersonalizado['urlProjetoPersonalizado'] . '/'; ?>">
								<div class="bloco-imagem">
									<div class="imagem" style="background:transparent url('<?php echo $configUrlGer . 'f/projetosPersonalizados/' . $dadosImagem['codProjetoPersonalizado'] . '-' . $dadosImagem['codProjetoPersonalizadoImagem'] . '-O.'. $dadosImagem['extProjetoPersonalizadoImagem']; ?>') center center no-repeat; background-size:cover, 100%;"></div>
								</div>
								<div id="conteudo-dados">
									<div id="nome-projetosPersonalizados">
										<p class="nome"><?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado']; ?></p>
									</div>
									<div id="tipo-projetosPersonalizados">
										<div class="tipo"  style=" <?php if( $dadosTipoProjeto['nomeTipoProjeto']  == 'Apartamento'){ ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/apartamento.svg) 0px center no-repeat; background-size: 22px; <?php }else if($dadosTipoProjeto['nomeTipoProjeto']  == 'Sala Comercial'){  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/sala.svg) 0px center no-repeat; background-size: 22px; <?php }else {  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/casa.svg) 0px center no-repeat; background-size: 22px; <?php } ?> " ><?php echo $dadosTipoProjeto['nomeTipoProjeto']; ?> </div>
									</div>
									<div id="detalhes">
										<p class="detalhes">Vizualizar Projeto!</p>
									</div>
								</div>
							</a>
						</div>
<?php
    }
?>
					</div>
<?php
	$regPorPagina = 12;
	$area = "projetosPersonalizados";
	include ('f/conf/paginacao.php');
?>	
						<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
						<div id="chamada-acao">
							<p id="titulo">Desenvolvemos projetos exclusivos, planejados nos mínimos detalhes para atender às suas necessidades</p>

							<div class="blocos">
								<div class="bloco">
									<i class="fa-solid fa-puzzle-piece"></i>
									<p id="descricso">Projetos totalmente personalizados</p>
								</div>

								<div class="bloco">
									<i class="fa-solid fa-headset"></i>
									<p id="descricso">Atendimento especializado</p>
								</div>

								<div class="bloco">
									<i class="fa-solid fa-scale-balanced"></i>
									<p id="descricso">Custo-benefício real</p>
								</div>

								<div class="bloco">
									<i class="fa-solid fa-bolt"></i>
									<p id="descricso">Agilidade no desenvolvimento</p>
								</div>

								<div class="bloco">
									<i class="fa-solid fa-eye"></i>
									<p id="descricso">Visualização completa do projeto</p>
								</div>

								<div class="bloco">
									<i class="fa-solid fa-life-ring"></i>
									<p id="descricso">Suporte contínuo</p>
								</div>
							</div>
							<form id="targetFormBaixo" action="<?php echo $configUrl;?>" method="post" onSubmit="return false, leadWhatsApp('P', 'S');">
								<div id="form-contato">
									<p class="campo-nome">
										<input type="text" id="nomeContatoP" value="" placeholder="Nome" required />
									</p>
									<p class="campo-whats">
										<input type="text" id="celularContatoP" value="" placeholder="WhatsApp / Celular" required onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" />
									</p>
									<p class="botao-envia">
										<button type="submit">Enviar</button>
									</p>
								</div>
							</form>
						</div>
					</div>
