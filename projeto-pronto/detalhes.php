<?php
	$_SESSION['salvaLocal'] = $arquivoRetornar;
?>

<div id="conteudo-interno">
    <div id="conteudo-projeto-pronto-detalhes">
        <div id="bloco-titulo">
            <p class="titulo">Projeto Pronto</p>
        </div>
        <div id="mostra-projeto-pronto">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $('a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            const alvo = $($(this).attr('href'));
            if (alvo.length) {
            $('html, body').animate({
                scrollTop: alvo.offset().top
            }, 600); 
            }
        });
        </script>         
<?php
    $sqlProjeto = "SELECT * FROM projetos WHERE codProjeto = '" . $quebraUrl[0] . "'";
    $resultProjeto = $conn->query($sqlProjeto);
    $dadosProjetos = $resultProjeto->fetch_assoc();
?>
            <div id="cabecalho">
                <p class="nome"><?php echo $dadosProjetos['nomeProjeto']; ?></p>
                <div id="linha"></div>
                <div id="descricao"><?php echo $dadosProjetos['descricaoProjeto']; ?></div>
            </div>
            <p class="botao-topo"><a href="<?php echo $configUrl;?>projeto-pronto/">Voltar</a></p>	
            <div id="bloco-imagem">
                <div id="carrossel">
                    <div class="swiper gallery-top">
                        <div class="swiper-wrapper">
<?php 
    $sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosProjetos['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC"; 
    $resultImagem = $conn->query($sqlImagem);
    while ($dadosImagem = $resultImagem->fetch_assoc()) {
?>

                            <div class="swiper-slide"><a rel="lightbox[roadtrip]" title="<?php echo $dadosProjetos['nomeProjeto'];?>" href="<?php echo $configUrlGer . "f/projetos/" . $dadosImagem['codProjeto'] . "-" .  $dadosImagem['codProjetoImagem'] . "-W.webp";?>" style="width:100%; height:100%; display:block; background-image: url(' <?php echo $configUrlGer . "f/projetos/" . $dadosImagem['codProjeto'] . "-" .  $dadosImagem['codProjetoImagem'] . "-W.webp";?>'); background-position: center center; background-repeat: no-repeat; background-size: cover, 100%;"></a></div>
<?php 
    }
?>
                        </div>
                      
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                    <div class="swiper gallery-thumbs">
                        <div class="swiper-wrapper">
<?php 
    $sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosProjetos['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC"; 
    $resultImagem = $conn->query($sqlImagem);
    while ($dadosImagem = $resultImagem->fetch_assoc()) {
?>

                            <div class="swiper-slide" style="background-image: url(' <?php echo $configUrlGer . "f/projetos/" . $dadosImagem['codProjeto'] . "-" .  $dadosImagem['codProjetoImagem']."-W.webp";?>'); background-position: center center; background-repeat: no-repeat; background-size: cover,100%; width: 180px; height:110px;"></div>
<?php 
    }
    $numero = $dadosProjetos['precoProjeto'];
    $numeroFormatado = number_format($numero, 2, ',', '.');

    if($dadosProjetos['numeroParcelaProjeto'] > 0){
        if($dadosProjetos['numeroParcelaSProjeto'] > 0){
            $valorParcela = $numero / $dadosProjetos['numeroParcelaSProjeto'];
            $parcelamento = "Ou em até ".$dadosProjetos['numeroParcelaSProjeto']."x de <span>R$ ".number_format($valorParcela, 2, ',', '.')." <br> </span> sem juros no cartão";
        }else{
            $parcelamento = "Ou em até ".$dadosProjetos['numeroParcelaProjeto']."x no cartão";
        }
    }else{
        $parcelamento =  "á vista";
    }
?>

                        </div>
                    </div>
                </div>
				<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>     
                <div id="lado-dir">
                    <div id="bloco-dir">
                        <div id="preco"> <span>R$:</span> <?php echo $numeroFormatado; ?> </div>
                        <div id="parcelado"><?php echo $parcelamento; ?></div>
						<button type="submit" id="comprar-btn" onclick="adicionarAoCarrinho(<?php echo $dadosProjetos['codProjeto'];?>, 0)" name="comprar">COMPRAR PROJETO</button>
                        <div id="bloco-cod">
                            <p class="cod">
                                COD:  <?php echo $dadosProjetos['codigoProjeto']; ?>
                            </p>
                        </div>     
<?php
    $sqlComplementos = "SELECT * FROM projetosComplementares PC inner join projetosComplementos PC2 on PC.codProjetoComplementar = PC2.codProjetoComplementar WHERE PC2.codProjeto = ".$dadosProjetos['codProjeto']." ORDER BY PC2.codProjetoComplementar ASC LIMIT 0,1";
    $resultComplementos = $conn->query($sqlComplementos);
    $dadosComplementos = $resultComplementos->fetch_assoc();

    if($dadosComplementos['codProjetoComplementar'] != ""){
?>
                        <div id="botao-complemento">
                            <p class="botao"><a href="#projetos-complementares"><i class="fa-regular fa-square-plus"></i> Projeto Complementar</a></p>
                        </div>
<?php
    }else{
        $margin1 = "margin-top:80px;";
        $margin2 = "margin-top:85px;";
    }
?>                                         
                        <p class="descricao" style="<?php echo $margin1;?>">Tem dúvidas? Fale agora mesmo com a gente pelo WhatsApp!</p>
                        <div id="botao-whats">
                            <p class="botao">WhatsApp</p>
                        </div>
                        <div id="compra-segura" style="<?php echo $margin2;?>">
                            <p class="titulo">Compra Segura.</p>
                            <img src="<?php echo $configUrl.'f/i/quebrado/bancos.png' ?>"width =  "100%"; alt="bancos">
                        </div>
                    </div>
                </div>
            </div>
			<script>
			function adicionarAoCarrinho(codProjeto, codProjetoComplementar) {
				var $tg = jQuery.noConflict();
				Swal.fire({
					title: 'Adicionando ao carrinho...',
					text: 'Aguarde enquanto processamos seu pedido.',
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
						
						$tg.ajax({
							url: '<?php echo $configUrl;?>carrinho/salva-carrinho.php',
							type: 'POST',
							data: { codProjeto: codProjeto, codProjetoComplementar: codProjetoComplementar },
							dataType: 'json',
							success: function(response) {
								if(response.tipo == "carrinho"){
									if (response.success) {
										Swal.fire({
											title: 'Sucesso!',
											text: response.message,
											icon: 'success',
											showCancelButton: true,
											confirmButtonText: 'Ir para o Carrinho',
											cancelButtonText: 'Adicionar mais projetos'
										}).then((result) => {
											if (result.isConfirmed) {
												window.location.href = '<?php echo $configUrl;?>carrinho/';
											}
										});
									} else {
										Swal.fire({
											title: 'Ops!',
											text: response.message,
											icon: 'info',
											showCancelButton: true,
											confirmButtonText: 'Ir para o Carrinho',
											cancelButtonText: 'Fechar'
										}).then((result) => {
											if (result.isConfirmed) {
												window.location.href = '<?php echo $configUrl;?>carrinho/';
											}
										});
									}
								}else{
									Swal.fire({
										title: 'Opa, você precisa estar logado!',
										text: response.message,
										icon: 'warning',
										showCancelButton: true,
										confirmButtonText: 'Realizar Login',
										cancelButtonText: 'Cancelar'
									}).then((result) => {
										if (result.isConfirmed) {
											window.location.href = '<?php echo $configUrl;?>minha-conta/login/';
										}
									});									
								}
							},
							error: function() {
								Swal.fire('Erro!', 'Não foi possível conectar ao servidor.', 'error');
							}
						});
					}
				});
			}
			</script>
<?php
    $sqlComplementos = "SELECT * FROM projetosComplementares PC inner join projetosComplementos PC2 on PC.codProjetoComplementar = PC2.codProjetoComplementar WHERE PC2.codProjeto = ".$dadosProjetos['codProjeto']." ORDER BY PC2.codProjetoComplementar ASC LIMIT 0,1";
    $resultComplementos = $conn->query($sqlComplementos);
    $dadosComplementos = $resultComplementos->fetch_assoc();

    if($dadosComplementos['codProjetoComplementar'] != ""){
?>
            <div id="complementos-projeto">
                <div id="bloco-titulo">
                    <p class="titulo">Projetos Complementares</p>
                    <p class="sub-titulo">Selecione os projetos complementares que deseja adicionar ao seu projeto.</p>
                </div>
                <p id="projetos-complementares" style="position:absolute; margin-top:-230px;"></p>
                <div id="conteudo-complementos">
                    <div id="mostra-complementos">
                        <table id="tabela">
                            <tr class="titulo">
                                <td style="border-radius:5px 0px 0px 5px;">Projeto</td>
                                <td>Preço</td>
                                <td style="border-radius:0px 5px 5px 0px;">Carrinho</td>
                            </tr>
<?php
        $cont = 0;

        $sqlComplementos = "SELECT * FROM projetosComplementares PC inner join projetosComplementos PC2 on PC.codProjetoComplementar = PC2.codProjetoComplementar WHERE PC2.codProjeto = ".$dadosProjetos['codProjeto']." ORDER BY PC2.codProjetoComplementar ASC";
        $resultComplementos = $conn->query($sqlComplementos);
        while($dadosComplementos = $resultComplementos->fetch_assoc()){

            $sqlImagem = "SELECT * FROM projetosComplementaresImagens WHERE codProjetoComplementar = ".$dadosComplementos['codProjetoComplementar']." ORDER BY codProjetoComplementarImagem ASC LIMIT 0,1";
            $resultImagem = $conn->query($sqlImagem);
            $dadosImagem = $resultImagem->fetch_assoc();
            
            $cont++;

            if($cont == 2){
                $cont = 0;
                $background = "background-color:#f5e6e6;";
            }else{
                $background = "background-color:#f5f5f5;";
            }  
?>
                            <tr class="item" style="<?php echo $background;?>">
                                <td><span><img src="<?php echo $configUrlGer . 'f/projetosComplementares/' . $dadosImagem['codProjetoComplementar'] . '-' . $dadosImagem['codProjetoComplementarImagem'] . '-O.'.$dadosImagem['extProjetoComplementarImagem']; ?>" alt="" width="100px"></span><span><?php echo $dadosComplementos['nomeProjetoComplementar']; ?></span></td>
                                <td class="preco">R$ <?php echo number_format($dadosComplementos['precoProjetoComplementar'], 2, ',', '.'); ?></td>
                                <td class="botao" style="border-right:0;"><button class="botao" onclick="adicionarAoCarrinho(<?php echo $dadosProjetos['codProjeto'];?>, <?php echo $dadosComplementos['codProjetoComplementar'];?>)">Adicionar</button></td>
                            </tr>
<?php
      }
?>
                        </table>
                    </div>
                </div>
            </div>
<?php
    }
?>            
            <div id="repete-caracteristicas" <?php if (($dadosProjetos['metragemCProjeto'] == 0 || $dadosProjetos['metragemCProjeto'] == "") && ($dadosProjetos['frenteProjeto'] == 0 || $dadosProjetos['frenteProjeto'] == "") && ($dadosProjetos['fundosProjeto'] == 0 || $dadosProjetos['fundosProjeto'] == "") && ($dadosProjetos['metragemProjeto'] == 0 || $dadosProjetos['metragemProjeto'] == "") && ($dadosProjetos['quartosProjeto'] == 0 || $dadosProjetos['quartosProjeto'] == "") && ($dadosProjetos['suiteProjeto'] == 0 || $dadosProjetos['suiteProjeto'] == "") && ($dadosProjetos['banheirosProjeto'] == 0 || $dadosProjetos['banheirosProjeto'] == "") && ($dadosProjetos['garagemProjeto'] == 0 || $dadosProjetos['garagemProjeto'] == "") ) { echo 'style="display:none;"'; } ?>>
                <div id="bloco-titulo">
                    <p class="titulo">Características do projeto</p>
                    <p class="sub-titulo">Conheça as Principais Características do Projeto.</p>
                </div>
                <div id="conteudo-caracteristicas">
                    <div id="mostra-caracteristicas">
                        <div id="areaC" <?php if($dadosProjetos['metragemCProjeto'] == 0 || $dadosProjetos['metragemCProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Área Construída</p>
                            <div id="valor"><?php echo $dadosProjetos['metragemCProjeto'];?>m²</div>
                        </div>
                        <div id="frente" <?php if($dadosProjetos['frenteProjeto'] == 0 || $dadosProjetos['frenteProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Frente</p>
                            <div id="valor"><?php echo $dadosProjetos['frenteProjeto'];?>m</div>
                        </div>
                        <div id="fundos" <?php if($dadosProjetos['fundosProjeto'] == 0 || $dadosProjetos['fundosProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Fundos</p>
                            <div id="valor"><?php echo $dadosProjetos['fundosProjeto']; ?>m</div>
                        </div>
                        <div id="areaT"  <?php if($dadosProjetos['metragemProjeto'] == 0 || $dadosProjetos['metragemProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Área do Terreno</p>
                            <div id="valor"><?php echo $dadosProjetos['metragemProjeto'];?>m²</div>
                        </div>
                        <div id="quartos" <?php if($dadosProjetos['quartosProjeto'] == 0 || $dadosProjetos['quartosProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Quartos</p>
                            <div id="valor"><?php echo $dadosProjetos['quartosProjeto']; ?></div>
                        </div>
                        <div id="suites" <?php if($dadosProjetos['suiteProjeto'] == 0 || $dadosProjetos['suiteProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Suítes</p>
                            <div id="valor"><?php echo $dadosProjetos['suiteProjeto']; ?></div>
                        </div>
                        <div id="banheiros" <?php if($dadosProjetos['banheirosProjeto'] == 0 || $dadosProjetos['banheirosProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Banheiros</p>
                            <div id="valor"><?php echo $dadosProjetos['banheirosProjeto']; ?></div>
                        </div>
                        <div id="garagem" <?php if($dadosProjetos['garagemProjeto'] == 0 || $dadosProjetos['garagemProjeto'] == "" ){ echo 'style = "display:none;"'; } ?>>
                            <p class="titulo">Garagem</p>
                            <div id="valor"><?php echo $dadosProjetos['garagemProjeto']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
            $sqlImagem = "SELECT * FROM plantasImagens WHERE codProjeto = ".$dadosProjetos['codProjeto'];
            $resultImagem = $conn->query($sqlImagem);
            $dadosImagem =  $resultImagem->fetch_assoc();
?>
                
                <div id="mostra-planta" style="<?php if(!isset($dadosImagem['codPlantaImagem'])){ echo 'display:none;'; } ?>">
                    <div id="bloco-titulo">
                        <p class="titulo">Planta baixa</p>
                        <p class="sub-titulo">Distribuição Inteligente dos Espaços.</p>
                    </div>
                    <div id="bloco-planta">
                        <a href="<?php echo $configUrlGer.'f/plantas/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codPlantaImagem'].'-O.'.$dadosImagem['extPlantaImagem']; ?>" data-lightbox="planta">
                            <img src="<?php echo $configUrlGer.'f/plantas/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codPlantaImagem'].'-O.'.$dadosImagem['extPlantaImagem']; ?>" alt="">
                        </a>
                    </div>
                </div>
                <div id="repete-ficha">
                    <div id="conteudo-ficha">
                        <div id="bloco-titulo">
                            <p class="titulo">Ficha Técnica</p>
                        </div>
                        <div id="mostra-ficha">
<?php 
        $cont = 0;
        $sqlFichas = "SELECT * FROM fichas WHERE statusFicha = 'T' ORDER BY nomeFicha ASC";	
        $resultFichas = $conn->query($sqlFichas);
        while($dadosFichas = $resultFichas->fetch_assoc()){

            $sqlImagem = "SELECT * FROM fichasImagens WHERE codFicha = ". $dadosFichas['codFicha'];
            $resultImagem = $conn->query($sqlImagem);
            $dadosImagem =  $resultImagem->fetch_assoc();

            if($cont == 3){
                $cont = 0;
                $margin = "margin-right:0px;";
            }else{
                $margin = "";
            }  
            $cont++;
?>
                        <div id="bloco-ficha" style="<?php echo $margin; ?>">
                            <p class="nome-ficha" style="background: url('<?php echo $configUrlGer.'f/fichas/'.$dadosImagem['codFicha'].'-'.$dadosImagem['codFichaImagem'].'-O.'.$dadosImagem['extFichaImagem']; ?>') center 5px no-repeat; background-size: 85px;" ><?php echo  $dadosFichas['nomeFicha']; ?></p>
<?php 
            

            $sqlProjetosFichas = "SELECT * FROM projetosFichas WHERE codFicha = ".$dadosFichas['codFicha']."";
            $resultProjetosFichas = $conn->query($sqlProjetosFichas);
            while($dadosProjetosFichas = $resultProjetosFichas->fetch_assoc()){
               
                $sqlOpcoesFichas = "SELECT * FROM opcoesFichas WHERE codOpcaoFicha = ".$dadosProjetosFichas['codOpcaoFicha']." ORDER BY codOpcaoFicha ASC";
                $resultOpcoesFichas = $conn->query($sqlOpcoesFichas);
                $dadosOpcoesFichas = $resultOpcoesFichas->fetch_assoc();

                $sqlProjetoOpcoes = "SELECT * FROM projetoOpcoesFichas WHERE codProjeto = '" . $quebraUrl[0] . "' AND codOpcao =  ".$dadosOpcoesFichas['codOpcaoFicha']."";
                $resultProjetoOpcoes = $conn->query($sqlProjetoOpcoes);
                $dadosProjetoOpcoes = $resultProjetoOpcoes->fetch_assoc();  


                
?>

                            <p class="descricao"><?php echo $dadosOpcoesFichas['nomeOpcaoFicha']; ?></p>
                            <div id="fundo"><p class="valor"> <?php if(isset($dadosProjetoOpcoes['dadoProjetoOpcao'])){ echo $dadosProjetoOpcoes['dadoProjetoOpcao']; }else{ echo '-------'; } ?> </p></div>
                            
<?php 
            }
?>
                        </div> 
<?php 
        }
?>
                        </div>
                    </div>
                </div>
                <div id="repete-descricao">
                    <div id="bloco-titulo">
                        <p class="titulo">Descrição Geral</p>
                        <p class="sub-titulo">Saiba mais sobre os detalhes deste projeto.</p>
                    </div>
                    <div id="descricao-geral">
                        <?php echo $dadosProjetos['descricaoGrandeProjeto']; ?> 
                    </div>
                </div>
                <div id="repete-redes">
                    <div id="bloco-titulo" style="margin-bottom: 15px;">
                        <p class="titulo">Acompanhe nossas redes</p>
                        <p class="sub-titulo">conheça mais sobre a <span><?php echo $nomeEmpresaMenor ?></span></p>
                    </div>
                    <div id="redes">
                        <a href="https://instagram.com/<?php echo $instagram ?>" target="_blank" class="instagram">Instagram</a>
                        <a href="https://facebook.com/<?php echo $facebook ?>" target="_blank" class="facebook">Facebook</a>
                        <a onClick="abrirAcesso();" target="_blank" class="wtz">WhatsApp</a>
                    </div>
                </div>
                <p class="botao-bottom" style="margin-top: 60px;"><a href="<?php echo $configUrl;?>projeto-pronto/">Voltar</a></p>	
                <div id="repete-outros">
                   <div id="bloco-titulo">
                        <p class="titulo">Outros Projetos</p>
                    </div>
                    <div id="conteudo-projeto">
                        <div id="mostra-projeto"  class="wow animate__animated animate__fadeIn">

<?php
    $cont = 0;

    $sqlProjetos = "SELECT DISTINCT I.* FROM projetos I inner join projetosImagens II on I.codProjeto = II.codProjeto inner join tipoProjeto TP on I.codTipoProjeto = TP.codTipoProjeto WHERE I.statusProjeto = 'T' AND I.destaqueProjeto = 'T'  ORDER BY RAND() DESC LIMIT 0,3";
    $resultProjetos = $conn->query($sqlProjetos);
    while ($dadosProjetos = $resultProjetos->fetch_assoc()) {

        $cont++;
        $sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE codTipoProjeto = " . $dadosProjetos['codTipoProjeto'] . " LIMIT 0,1";
        $resultTipoProjeto = $conn->query($sqlTipoProjeto);
        $dadosTipoProjeto = $resultTipoProjeto->fetch_assoc();

        $sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = " . $dadosProjetos['codProjeto'] . " ORDER BY ordenacaoProjetoImagem ASC, codProjetoImagem ASC LIMIT 0,1";
        $resultImagem = $conn->query($sqlImagem);
        $dadosImagem = $resultImagem->fetch_assoc();

        if ($dadosProjetos['precoProjeto'] != "0.00") {
            $preco = "R$ " . number_format($dadosProjetos['precoProjeto'], 2, ",", ".");
        } else {
            $preco = "A consultar";
        }

        if( $dadosProjetos['frenteProjeto'] == "0" || $dadosProjetos['frenteProjeto'] == "" || $dadosProjetos['fundosProjeto'] == "0" || $dadosProjetos['fundosProjeto'] == "" ){
            $display =  "vazio";
        }else{
            $display = "valor";
        }

        if($cont == 3){
            $cont = 0;
            $margin = "margin-right:0px;";
        }else{
            $margin = "";
        }    

?>

                                <div id="bloco-projeto-pronto" style="<?php echo $margin; ?>">
                                    <a title="<?php echo $dadosProjetos['nomeProjeto']; ?>" href="<?php echo $configUrl . 'projeto-pronto/' . $dadosProjetos['codProjeto'] . '-' . $dadosProjetos['urlProjeto'] . '/'; ?>">
                                        <div class="bloco-imagem">
                                            <div class="imagem" style="background:transparent url('<?php echo $configUrlGer . 'f/projetos/' . $dadosImagem['codProjeto'] . '-' . $dadosImagem['codProjetoImagem'] . '-W.webp'; ?>') center center no-repeat; background-size:cover, 100%;"></div>
                                        </div>
                                        <div id="conteudo-dados">
                                            <div id="nome-projeto-pronto">
                                                <p class="nome"><?php echo $dadosProjetos['nomeProjeto']; ?> - <?php echo $dadosProjetos['codigoProjeto']; ?></p>
                                            </div>
                                            <div id="tipo-projeto-pronto">
                                                <div class="tipo"  style=" <?php if( $dadosTipoProjeto['nomeTipoProjeto']  == 'Apartamento'){ ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/apartamento.svg) 10px center no-repeat; background-size: 22px; <?php }else if($dadosTipoProjeto['nomeTipoProjeto']  == 'Terreno' || $dadosTipoProjeto['nomeTipoProjeto']  == 'Lote' ){  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/terreno.svg) 10px center no-repeat; background-size: 22px; <?php }else {  ?> background: transparent url(<?php echo $configUrl; ?>f/i/quebrado/casa-d.svg) 10px center no-repeat; background-size: 22px; <?php } ?> " ><?php echo $dadosTipoProjeto['nomeTipoProjeto']; ?></div>
                                            </div>
                                            <div id="icones">
                                                <div id="alinha-icones">
                                                    <div id="espaco">
                                                        <p class="frente-fundo" style=" <?php echo $display == "vazio" ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['frenteProjeto'].'x'.$dadosProjetos['fundosProjeto']; ?>m²</p>
                                                        <p class="area" style="<?php echo $dadosProjetos['metragemProjeto'] == 0 ? 'display:none;' : '';  ?>"><?php echo $dadosProjetos['metragemProjeto']; ?>m²</p>
                                                        <p class="quartos" style="<?php echo $dadosProjetos['quartosProjeto'] == 0 ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['quartosProjeto']; ?></p>
                                                        <p class="banheiros" style="<?php echo $dadosProjetos['banheirosProjeto'] == 0 ? 'display:none;' : ''; ?>"><?php echo $dadosProjetos['banheirosProjeto']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; margin-top:10px;">
                                                <p class="preco"><?php echo $preco; ?></p>
                                                <p class="detalhes">Vizualizar Projeto!</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
<?php
    }
?>
    <?php 
     $_SESSION['link'] = '';
    ?>
                        </div>
                    </div>
                </div>
   
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 5,
        slidesPerView: 4,
        loop: false, 
        freeMode: true,
        watchSlidesProgress: true,
        watchOverflow: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        slidesPerView: 1,
        loop: false,
        navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev',},
        thumbs: {
            swiper: galleryThumbs,
        },
        watchOverflow: true,
    });
</script>
<!-- Estilo CARROSSEL -->
<style>
    #bloco-imagem { display: flex; position: relative; height: 100%; width: 1200px; margin: 0 auto; } 
    .swiper { width: 890px; margin-left: initial !important; margin-right: initial !important; } 
    .swiper-slide { background-size: cover; background-position: center; } 
    .gallery-top { width: 890px; height: 500px; border-radius: 20px; } 
    .gallery-thumbs { box-sizing: border-box; padding: 10px 0; } 
    .gallery-thumbs .swiper-slide { opacity: 0.4; border-radius: 5px; } 
    .gallery-thumbs .swiper-slide-thumb-active { opacity: 1; } 
    .swiper-button-next, .swiper-button-prev { color: #ffffff; background: #b07d02a3; padding: 10px; border-radius: 12px; background-size: 10px; font-size: 10px; }
</style>
