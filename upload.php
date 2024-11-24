<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $uploadDir = 'uploads/';

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $nomeArquivo = uniqid() . '-' . basename($_FILES['foto']['name']);
        $caminhoArquivo = $nomeArquivo;

        // Criar o diretório de uploads, se não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Mover o arquivo para o diretório de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $caminhoArquivo)) {
            // Inserir os dados no banco de dados
            $stmt = $conn->prepare("INSERT INTO fotos (titulo, descricao, caminho_arquivo) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sss', $titulo, $descricao, $caminhoArquivo);
                if ($stmt->execute()) {
                    echo "<p>Foto enviada com sucesso!</p>";
                    echo "<a href='index.php'>Voltar para a página principal</a>";
                } else {
                    echo "<p>Erro ao executar a consulta: " . htmlspecialchars($stmt->error) . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Erro ao preparar a consulta: " . htmlspecialchars($conn->error) . "</p>";
            }
        } else {
            echo "<p>Erro ao mover o arquivo.</p>";
        }
    } else {
        echo "<p>Erro no envio do arquivo. Erro: " . $_FILES['foto']['error'] . "</p>";
    }
}

$conn->close();
?>

