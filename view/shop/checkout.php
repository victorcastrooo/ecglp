<?php
session_start();
include '../../db_connect.php';

// Inicialize variáveis
$total = 0;
$cart = [];

// Verifique se há dados enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receba os dados do carrinho
    $total = isset($_POST['total']) ? $_POST['total'] : 0;
    $cart = isset($_POST['cart']) ? $_POST['cart'] : [];

    // Se os dados do carrinho e do pedido estiverem presentes, prossiga para salvar no banco de dados
    if (!empty($cart) && isset($_POST['nome'], $_POST['email'], $_POST['endereco'], $_POST['telefone'])) {
        // Salve os dados do usuário e do pedido no banco de dados
        $nome = $conn->real_escape_string($_POST['nome']);
        $email = $conn->real_escape_string($_POST['email']);
        $endereco = $conn->real_escape_string($_POST['endereco']);
        $telefone = $conn->real_escape_string($_POST['telefone']);

        // Prepare a query para o pedido
        $stmt_pedido = $conn->prepare("INSERT INTO pedidos (nome, email, endereco, telefone, total) VALUES (?, ?, ?, ?, ?)");
        $stmt_pedido->bind_param("ssssd", $nome, $email, $endereco, $telefone, $total);

        if ($stmt_pedido->execute()) {
            $pedido_id = $stmt_pedido->insert_id; // Obtém o ID do pedido inserido

            // Prepare a query para os itens do pedido
            $stmt_itens = $conn->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)");
            foreach ($cart as $product_id => $quantity) {
                $stmt_itens->bind_param("iii", $pedido_id, $product_id, $quantity);
                
                // Verifique se o produto_id existe na tabela produto
                $result = $conn->query("SELECT id FROM produto WHERE id = $product_id");
                if ($result->num_rows > 0) {
                    // Se existe, insere o item
                    $stmt_itens->execute();
                } else {
                    echo "Erro: Produto ID $product_id não existe.";
                    exit();
                }
            }

            // Redirecione para a página de confirmação de pedido
            header('Location: confirmacao.php');
            exit();
        } else {
            echo "Erro ao salvar pedido: " . $stmt_pedido->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="../../css/style.css">
<script src="../js/script.js"></script>
</head>
<body>
    <h1>Checkout</h1>
    <form action="checkout.php" method="post">
        <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">
        <?php foreach ($cart as $product_id => $quantity): ?>
            <input type="hidden" name="cart[<?= htmlspecialchars($product_id) ?>]" value="<?= htmlspecialchars($quantity) ?>">
        <?php endforeach; ?>
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
        </div>
        <div>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>
        </div>
        <button type="submit">Finalizar Compra</button>
    </form>
</body>
</html>
