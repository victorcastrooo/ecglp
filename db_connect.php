<?php
//$servername = 'localhost';
//$username = 'root';
//$password = '';
//$dbname = 'trad';
$servername = '127.0.0.1:3306';
$username = 'u799406689_victorcastro';
$password = 'Mkt..2023..';
$dbname = 'u799406689_users';

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);
    
// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
