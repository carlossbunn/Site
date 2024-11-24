<?php
$servername = "localhost";
$username = "--";
$password = "--";
$dbname = "galeria_fotos";

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checando conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

