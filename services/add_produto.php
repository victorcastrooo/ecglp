<?php

require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $tipo_id = $_POST['tipo'];
    $marca_id = $_POST['marca'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];
    
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto'];
        $foto_nome = $foto['name'];
        $foto_tmp = $foto['tmp_name'];
        $foto_tamanho = $foto['size'];
        $foto_tipo = $foto['type'];

        // Diretório onde a imagem será salva
        $diretorio_upload = '../uploads/';
        if (!is_dir($diretorio_upload)) {
            mkdir($diretorio_upload, 0777, true);
        }
        $foto_destino = $diretorio_upload . basename($foto_nome);

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($foto_tmp, $foto_destino)) {
            // Insere os dados no banco de dados
            $stmt = $conn->prepare("INSERT INTO produto (nome, tipo_id, marca_id, valor, descricao, foto) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siidss", $nome, $tipo_id, $marca_id, $valor, $descricao, $foto_destino);

            if ($stmt->execute()) {
                header("Location: ../view/dashboard.php?page=produtos");
            } else {
                echo "Erro ao adicionar produto: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Erro no envio do arquivo.";
    }
} else {
    header("Location: ../view/dashboard.php?page=produtos");
}

$conn->close();
?>
