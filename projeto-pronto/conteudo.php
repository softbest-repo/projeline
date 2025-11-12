<?php 
   if (isset($_POST['limpar'])) {

        $_POST['quartos'] ='';
        $_POST['banheiros'] = '';
        $_POST['suite'] = '';
        $_POST['garagem'] = '';
        $_POST['metragem'] = '';
        $_POST['frente'] = '';
        $_POST['fundos'] = '';

    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['quartos']   = $_POST['quartos']   ?? '';
        $_SESSION['banheiros'] = $_POST['banheiros'] ?? '';
        $_SESSION['suite']     = $_POST['suite']     ?? '';
        $_SESSION['garagem']   = $_POST['garagem']   ?? '';
        $_SESSION['metragem']  = $_POST['metragem']  ?? '';
        $_SESSION['frente']    = $_POST['frente']    ?? '';
        $_SESSION['fundos']    = $_POST['fundos']    ?? '';
    }
?>
<div id="conteudo-interno">
    <div id="bloco-titulo">
        <p class="titulo">Projeto Pronto</p>
    </div>
    <form method="post" id="filtro-projetos" style="width: 1200px; margin: 0 auto;">
        <div style=" display: flex; justify-content: center;  flex-wrap: wrap; gap: 10px;">
            <input type="number" name="quartos" placeholder="Quartos" min="0" style="width:120px;"
                value="<?php echo $_SESSION['quartos'] ?? ''; ?>">

            <input type="number" name="banheiros" placeholder="Banheiros" min="0" style="width:120px;"
                value="<?php echo $_SESSION['banheiros'] ?? ''; ?>">

            <input type="number" name="suite" placeholder="Suítes" min="0" style="width:120px;"
                value="<?php echo $_SESSION['suite'] ?? ''; ?>">

            <input type="number" name="garagem" placeholder="Garagem" min="0" style="width:120px;"
                value="<?php echo $_SESSION['garagem'] ?? ''; ?>">

            <input type="number" name="metragem" placeholder="Metragem (m)²" min="0" style="width:170px;"
                value="<?php echo $_SESSION['metragem'] ?? ''; ?>">

            <input type="number" name="frente" placeholder="Frente (m)" min="0" style="width:140px;"
                value="<?php echo $_SESSION['frente'] ?? ''; ?>">

            <input type="number" name="fundos" placeholder="Fundos (m)" min="0" style="width:140px;"
                value="<?php echo $_SESSION['fundos'] ?? ''; ?>">

            <button type="submit" style="background:#001242; color:#fff; border:none; padding:8px 15px; cursor:pointer;">Filtrar</button>
            <button type="submit" name="limpar" value="1" style="background:#b07d02; color:#fff; border:none; padding:8px 15px; cursor:pointer;">Limpar</button>
        </div>
    </form>

    <div id="conteudo-projeto">
        <div id="mostra-projeto"  class="wow animate__animated animate__fadeIn">

<?php
    $where = "WHERE I.statusProjeto = 'T' AND I.destaqueProjeto = 'T'";

    if (!empty($_SESSION['quartos'])) {
        $where .= " AND I.quartosProjeto = " . intval($_SESSION['quartos']);
    }
    if (!empty($_SESSION['banheiros'])) {
        $where .= " AND I.banheirosProjeto = " . intval($_SESSION['banheiros']);
    }
    if (!empty($_SESSION['suite'])) {
        $where .= " AND I.suitesProjeto = " . intval($_SESSION['suite']);
    }
    if (!empty($_SESSION['garagem'])) {
        $where .= " AND I.garagemProjeto = " . intval($_SESSION['garagem']);
    }
    if (!empty($_SESSION['metragem'])) {
        $metragem = floatval($_SESSION['metragem']);

        $margem = max(5, $metragem * 0.10);

        $min = $metragem - $margem;
        $max = $metragem + $margem;

        $where .= " AND I.metragemProjeto BETWEEN {$min} AND {$max}";
    }
    if (!empty($_SESSION['frente'])) {
        $frente = floatval($_SESSION['frente']);
        $margem = 4; 
        $where .= " AND I.frenteProjeto BETWEEN " . ($frente - $margem) . " AND " . ($frente + $margem);
    }
    if (!empty($_SESSION['fundos'])) {
        $fundos = floatval($_SESSION['fundos']);
        $margem = 4; 
        $where .= " AND I.fundosProjeto BETWEEN " . ($fundos - $margem) . " AND " . ($fundos + $margem);
    }
    $cont = 0;
    $contfiltro = 0;

    $sqlProjetos = " SELECT DISTINCT I.* FROM projetos I  INNER JOIN projetosImagens II ON I.codProjeto = II.codProjeto  INNER JOIN tipoProjeto TP ON I.codTipoProjeto = TP.codTipoProjeto {$where} ORDER BY I.codigoProjeto DESC LIMIT 0,12";
    $resultProjetos = $conn->query($sqlProjetos);
    while ($dadosProjetos = $resultProjetos->fetch_assoc()) {
        $contfiltro ++;
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
    if( $contfiltro == 0){
?>
         <div id="result-filtro" style=" width: 330px; padding: 10px; border: 1px solid #66666678; margin: 50px auto; border-radius: 20px;">
            <p id="msg-filtro" style="text-align: center;"> Nenhum projeto encontrado com os filtros selecionados.</p>
         </div>    
<?php 
    }
?>
        </div>
    </div>
</div>

<style>
    #filtro-projetos { background-color: #f8f9fa; padding: 20px 0px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); margin-bottom: 30px !important; border: 1px solid #e9ecef; }
    #filtro-projetos > div { display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; }
    #filtro-projetos input[type="number"] { padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 16px; color: #495057; transition: border-color 0.3s, box-shadow 0.3s; width: 140px; box-sizing: border-box; }
    #filtro-projetos input[name="metragem"] { width: 160px;}
    #filtro-projetos input[name="frente"],
    #filtro-projetos input[name="fundos"] { width: 150px;}
    #filtro-projetos input[type="number"]:focus { border-color: #007bff;  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); outline: none; }
    #filtro-projetos button[type="submit"] { background-color: #007bff; color: #ffffff; border: none; padding: 10px 25px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s, transform 0.1s; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }

    #filtro-projetos button[type="submit"]:hover { background-color: #0056b3; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);}
    #filtro-projetos button[type="submit"]:active {transform: translateY(1px);}
    #bloco-titulo .titulo { font-size: 28px; font-weight: 700; color: #343a40; margin-bottom: 20px;text-align: center;}
    @media (max-width: 768px) {
        #filtro-projetos > div { gap: 10px; }
        #filtro-projetos input[type="number"],
        #filtro-projetos input[name="metragem"],
        #filtro-projetos input[name="frente"],
        #filtro-projetos input[name="fundos"] {width: calc(50% - 10px); min-width: 120px; }
        #filtro-projetos button[type="submit"] { width: 100%; }
    }
</style>