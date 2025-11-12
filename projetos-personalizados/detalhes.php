<div id="conteudo-interno" style="padding-bottom: 0px;">
    <div id="repete-projetosPersonalizados">
        <div id="bloco-titulo">
            <p class="titulo">Projetos Personalizados</p>
        </div>	
        <p class="botao-topo"><a href="<?php echo $configUrl;?>projetos-personalizados/">Voltar</a></p>	
        <div id="detalhes-projetosPersonalizados" class="wow animate__animated animate__fadeIn">
            <div id="bloco-imagem">
                <div class="owl-estampas">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="loop owl-carousel projetosPersonalizados owl-loaded owl-drag">	

<?php 
    $quebraUrl = explode("-", $url[3]); 
    $sqlProjetoPersonalizado = "SELECT * FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$quebraUrl[0];
    $resultProjetoPersonalizado = $conn->query($sqlProjetoPersonalizado);
    $dadosProjetoPersonalizado = $resultProjetoPersonalizado->fetch_assoc();
    
    $sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE codTipoProjeto = " . $dadosProjetoPersonalizado['tipoProjeto'] . " LIMIT 0,1";
    $resultTipoProjeto = $conn->query($sqlTipoProjeto);
    $dadosTipoProjeto = $resultTipoProjeto->fetch_assoc();

    $mostrando = $mostrando + 1;
    $cont++;
    $sqlImagem = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$dadosProjetoPersonalizado['codProjetoPersonalizado']." ORDER BY codProjetoPersonalizadoImagem ASC";
    $resultImagem = $conn->query($sqlImagem);
    while($dadosImagem = $resultImagem->fetch_assoc()){
        $numImagens = $resultImagem->num_rows;


		if($dadosImagem['extProjetoPersonalizadoImagem'] == "mp4"){
			
?>
                              <li style="width:226px; height:400px; position:relative; background-color:#b17d4a;"><span><video id="video" class="vid" disablePictureInPicture controlsList="nodownload" constrols style="max-height:100%; position:absolute; left:50%; transform:translateX(-50%);" src="<?php echo $configUrlGer.'f/projetosPersonalizados/'.$dadosImagem['codProjetoPersonalizado'].'-'.$dadosImagem['codProjetoPersonalizadoImagem'].'-O.'.$dadosImagem['extProjetoPersonalizadoImagem'];?>" type="video/mp4" controls="true"></video></span></li>
<?php
		}else{
?>
                             <li><a rel="lightbox[roadtrip]" href="<?php echo $configUrlGer.'f/projetosPersonalizados/'.$dadosImagem['codProjetoPersonalizado'].'-'.$dadosImagem['codProjetoPersonalizadoImagem'].'-O.'.$dadosImagem['extProjetoPersonalizadoImagem'];?>" style="width: 390px; height:350px; display:block; background:transparent url('<?php echo $configUrlGer.'f/projetosPersonalizados/'.$dadosImagem['codProjetoPersonalizado'].'-'.$dadosImagem['codProjetoPersonalizadoImagem'].'-O.'.$dadosImagem['extProjetoPersonalizadoImagem'];?>') center center no-repeat; background-size:cover, 100%; border-radius: 15px;"></a></li>
<?php		
		}
    }
?>	
                           </div>
                        </div>
                    </div>
                </div>
<?php 
		if($numImagens < 3 ){ ?>
                                <style> .owl-carousel .owl-stage-outer {display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: center;}</style>
                                <script>
                                    var $gt = jQuery.noConflict();
                                    var owl = $gt('.projetosPersonalizados');
                                        owl.owlCarousel({
                                            center: false,
                                            items:3,
                                            loop: false,
                                            autoWidth:false,
                                            margin:15,
                                            nav: true,
                                            dots: true
                                        });
                                </script>	
<?php
	}else{
?>
                                <script>
                                    var $gt = jQuery.noConflict();
                                    var owl = $gt('.projetosPersonalizados');
                                        owl.owlCarousel({
                                            center: true,
                                            items:3,
                                            loop: true,
                                            autoWidth:false,
                                            margin:15,
                                            nav: true,
                                            dots: true
                                        });
                                </script>	
<?php 
	}
?>												
                </div>
                <div id="nome-projeto">
                    <p class="nome-projeto"><?php echo $dadosProjetoPersonalizado['nomeProjetoPersonalizado']; ?></p>
                </div>
                <div id="tipo-projeto">
                    <p class="tipo-projeto">Tipo de projeto: <span> <?php echo $dadosTipoProjeto['nomeTipoProjeto'];?> </span> </p>
                </div>
                <div id="descricao-projeto">
                    <div class="descricao-projeto"> <?php echo $dadosProjetoPersonalizado['descricaoProjetoPersonalizado']; ?> </div>
                </div>
            </div>
        </div>
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