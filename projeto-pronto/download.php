<?php
    if (ob_get_level()) {
        ob_end_clean();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include('../f/conf/config.php');

    $tokenCodificado = $_GET['token'] ?? '';
    $tokenBruto = base64_decode($tokenCodificado, true);
    if ($tokenBruto === false) {
        die();
    }

    $partes = explode("|", $tokenBruto);
    if (count($partes) !== 3) {
        die();
    }

    list($hashRecebido, $codigo, $letra) = $partes;

    $senha = "proje2025line22";
    $dados = $codigo . "|" . $letra;
    $mensagem = $senha . "|" . $dados;
    $hashEsperado = hash_hmac('sha256', $mensagem, 'df2455vd@202522');

    if (!hash_equals($hashEsperado, $hashRecebido)) {
        die();
    }

    if ($letra === "P") {
        $sqlProjeto = "SELECT codProjeto FROM projetos WHERE codProjeto = $codigo ORDER BY codProjeto ASC LIMIT 1";
        $resultProjeto = $conn->query($sqlProjeto);
        $dadosProjeto = $resultProjeto->fetch_assoc();

        $zip = new ZipArchive();
        $nomeZip = 'projeto_' . $dadosProjeto['codProjeto'] . '.zip';
        $caminhoZip = $nomeZip;

        if ($zip->open($caminhoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $sqlAnexo = "SELECT * FROM projetosAnexos WHERE codProjeto = " . $dadosProjeto['codProjeto'] . " ORDER BY codProjetoAnexo ASC";
            $resultAnexo = $conn->query($sqlAnexo);

            while ($dadosAnexo = $resultAnexo->fetch_assoc()) {
                $nomeArquivoInterno = $dadosAnexo['codProjeto'] . '-' . $dadosAnexo['codProjetoAnexo'] . '-O.' . $dadosAnexo['extProjetoAnexo'];
                $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/projetosAnexo/' . $nomeArquivoInterno;

                if (file_exists($caminhoArquivo)) {
                    $zip->addFile($caminhoArquivo, $nomeArquivoInterno);
                }
            }

            $zip->close();

            if (!file_exists($caminhoZip) || filesize($caminhoZip) === 0) {
                die("Erro ao gerar ZIP.");
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $nomeZip . '"');
            header('Content-Length: ' . filesize($caminhoZip));
            readfile($caminhoZip);
            unlink($caminhoZip);
            exit;
        } else {
            die("Erro ao criar o ZIP.");
        }
    }else{
        $sqlProjeto = "SELECT codProjetoComplementar FROM projetosComplementares WHERE codProjetoComplementar = $codigo ORDER BY codProjetoComplementar ASC LIMIT 1";
        $resultProjeto = $conn->query($sqlProjeto);
        $dadosProjeto = $resultProjeto->fetch_assoc();

        $zip = new ZipArchive();
        $nomeZip = 'projeto-complementar_' . $dadosProjeto['codProjetoComplementar'] . '.zip';
        $caminhoZip = $nomeZip;

        if ($zip->open($caminhoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $sqlAnexo = "SELECT * FROM projetosComplementaresAnexos WHERE codProjetoComplementar = " . $dadosProjeto['codProjetoComplementar'] . " ORDER BY codProjetoComplementarAnexo ASC";
            $resultAnexo = $conn->query($sqlAnexo);

            while ($dadosAnexo = $resultAnexo->fetch_assoc()) {
                $nomeArquivoInterno = $dadosAnexo['codProjetoComplementar'] . '-' . $dadosAnexo['codProjetoComplementarAnexo'] . '-O.' . $dadosAnexo['extProjetoComplementarAnexo'];
                $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/projetosComplementaresAnexo/' . $nomeArquivoInterno;

                if (file_exists($caminhoArquivo)) {
                    $zip->addFile($caminhoArquivo, $nomeArquivoInterno);
                }
            }

            $zip->close();

            if (!file_exists($caminhoZip) || filesize($caminhoZip) === 0) {
                die("Erro ao gerar ZIP.");
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $nomeZip . '"');
            header('Content-Length: ' . filesize($caminhoZip));
            readfile($caminhoZip);
            unlink($caminhoZip);
            exit;
        } else {
            die("Erro ao criar o ZIP.");
        }        
    }