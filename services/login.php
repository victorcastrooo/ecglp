<?php
session_start();

// Incluir arquivo de conexão
include '../db_connect.php';

// Pegar dados do formulário
$user = $_POST['username'];
$pass = $_POST['password'];

// Proteger contra SQL Injection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);

// Verificar se o usuário existe
$sql = "SELECT * FROM usuarios WHERE email = '$user' AND senha = '$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login bem-sucedido
    $_SESSION['username'] = $user;
    echo "Login successful!";
    // Redirecionar para uma página protegida
    header("Location: ../view/dashboard.php");
    exit();
} else {
    // Login falhou
    echo "Invalid username or password.";
}

$conn->close();
?>
