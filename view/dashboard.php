<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['username'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <ul>
                <li>
                    <img class="logo" src="../img/logo.png" alt="Logo">
                </li>
                <li class="nav-item <?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>">
                    <a href="?page=home">
                        <i class="fa-solid fa-house"></i>
                        <span class="nav-text">Início</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'marcas') ? 'active' : ''; ?>">
                    <a href="?page=marcas">
                        <i class="fa-sharp fa-solid fa-copyright"></i>
                        <span class="nav-text">Marcas</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'produtos') ? 'active' : ''; ?>">
                    <a href="?page=produtos">
                        <i class="fa-solid fa-box-open"></i>
                        <span class="nav-text">Produtos</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'pedidos') ? 'active' : ''; ?>">
                    <a href="?page=pedidos">
                        <i class="fa-solid fa-list"></i>
                        <span class="nav-text">Pedidos</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'motoboys') ? 'active' : ''; ?>">
                    <a href="?page=motoboys">
                        <i class="fa-solid fa-motorcycle"></i>
                        <span class="nav-text">Motoboys</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'clientes') ? 'active' : ''; ?>">
                    <a href="?page=clientes">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-text">Clientes</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'vendas') ? 'active' : ''; ?>">
                    <a href="?page=vendas">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="nav-text">Vendas</span>
                    </a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'parceiros') ? 'parceiros' : ''; ?>">
                    <a href="?page=parceiros">
                        <i class="fa-solid fa-users-gear"></i>
                        <span class="nav-text">parceiros</span>
                    </a>
                </li>
                <h1 class="copy">
  Version 1.2 | Developed by: 
  <a href="https://www.ovictorcastro.com.br" target="_blank">
    <img src="../img/logo_vc.png" alt="Logo Victor Castro" height="19px">
  </a> 
  <br><br>
  Copyright (C) 2024 Distribuidora Trad – All rights reserved
</h1>
            </ul>
        </nav>
        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'home':
                        include '../view/dashboard/home.php';
                        break;
                    case 'marcas':
                        include '../view/dashboard/marcas.php';
                        break;
                    case 'produtos':
                        include '../view/dashboard/produtos.php';
                        break;
                    case 'pedidos':
                        include '../view/dashboard/pedidos.php';
                        break;
                    case 'settings':
                        include 'settings.php';
                        break;
                    case 'parceiros':
                        include 'parceiros.php';
                        break;
                    default:
                        include '../view/dashboard/home.php';
                        break;
                }
            } else {
                include '../view/dashboard/home.php';
            }
            ?>
        </div>
    </div>
</body>
</html>
