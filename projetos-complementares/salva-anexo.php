<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include('../f/conf/config.php');

     $pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/orcamentos/';

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $url = $_POST['url'];
    $quebraUrl = explode('-', $url);

    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === 0) {

        $sql = "INSERT INTO orcamentos (codProjetoComplementar, nomeOrcamento, telefoneOrcamento, respondidoOrcamento, statusOrcamento, urlOrcamento) VALUES ('".$quebraUrl[0]."','".$nome."', '".$telefone."','F' , 'T', '".$urlOrcamento."')";
        $result = $conn->query($sql);

        if($result){

            $codOrcamento = $conn->insert_id;
            $extensao = pathinfo($_FILES['anexo']['name'], PATHINFO_EXTENSION);
            $sqlAnexo = "INSERT INTO orcamentosAnexos (codOrcamentoAnexo, codOrcamento, extOrcamentoAnexo ) VALUES (0, $codOrcamento , '".$extensao."')";
            $resultAnexo = $conn->query($sqlAnexo);
            $codOrcamentoAnexo = $conn->insert_id;

            $nomeFinal = $codOrcamento . '-' . $codOrcamentoAnexo . '-O.' . $extensao;
            $destino = $pastaDestino . $nomeFinal;

            $arquivoTmp = $_FILES['anexo']['tmp_name'];
            if (move_uploaded_file($arquivoTmp, $destino)) {
                
                    $_SESSION['popup'] = "Orçamento enviado! <br> Logo entraremos em contato com você!";
                	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."projetos-complementares/".$url."/'>";

            } else {
                echo "Erro ao mover o arquivo.";
            }

        } else {
            echo "Erro ao salvar em orçamentos.";
        }

    } else {
        echo "Nenhum arquivo enviado ou erro no upload.";
    }
}else{
    echo "sem post";
}
?>
