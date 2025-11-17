<?php
include('../../f/conf/config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $codOrcamento = intval($_POST['codOrcamento']);
    $respondido = $_POST['respondido']; 

    if (!in_array($respondido, ['T', 'F'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Valor inválido. Use "sim" ou "nao".'
        ]);
        exit;
    }
    
    $sql = "UPDATE orcamentos SET respondidoOrcamento = ? WHERE codOrcamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $respondido, $codOrcamento);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'codOrcamento' => $codOrcamento,
            'respondido' => $respondido
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao atualizar no banco de dados.'
        ]);
    }
    
    $stmt->close();
    $conn->close();
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método não permitido.'
    ]);
}
?>
