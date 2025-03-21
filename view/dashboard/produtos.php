<?php
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
require '../db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <!-- Link para o Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link para o Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js"></script>
</head>
<body>

<div class="dashboard">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Lista de Produtos</h2>
            <form class="form-inline" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <table class="table centered-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT p.id, p.nome, t.tipo, m.nomemarca, p.valor, p.descricao, p.foto FROM produto p JOIN tipo t ON p.tipo_id = t.id JOIN marca m ON p.marca_id = m.id");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($produto = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $produto['id'] . "</td>";
                    echo "<td><img src='" . $produto['foto'] . "' alt='Foto do Produto' style='width: 50px; height: 50px;'></td>";
                    echo "<td>" . $produto['nome'] . "</td>";
                    echo "<td>" . $produto['tipo'] . "</td>";
                    echo "<td>" . $produto['nomemarca'] . "</td>";
                    echo "<td>" . $produto['valor'] . "</td>";
                    echo "<td>" . $produto['descricao'] . "</td>";
                    echo "<td>
                        <a href='edit_produto.php?id=" . $produto['id'] . "' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a>
                        <a href='view_produto.php?id=" . $produto['id'] . "' class='btn btn-sm btn-primary'><i class='fas fa-eye'></i></a>
                        <a href='../services/delete_produto.php?id=" . $produto['id'] . "' class='btn btn-sm btn-danger'><i class='fas fa-trash-alt'></i></a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <button type="button" class="btn btn-primary add-btn" data-toggle="modal" data-target="#addProdutoModal">
        <i class="fas fa-plus"></i>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="addProdutoModal" tabindex="-1" aria-labelledby="addProdutoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../services/add_produto.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProdutoModalLabel"><i class="fas fa-plus"></i> Adicionar Novo Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nome"><i class="fas fa-tag"></i> Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo"><i class="fas fa-list"></i> Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <?php
                                $stmt_tipo = $conn->prepare("SELECT id, tipo FROM tipo");
                                $stmt_tipo->execute();
                                $result_tipo = $stmt_tipo->get_result();
                                while ($tipo = $result_tipo->fetch_assoc()) {
                                    echo "<option value='" . $tipo['id'] . "'>" . $tipo['tipo'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marca"><i class="fas fa-building"></i> Marca</label>
                            <select class="form-control" id="marca" name="marca" required>
                                <?php
                                $stmt_marca = $conn->prepare("SELECT id, nomemarca FROM marca");
                                $stmt_marca->execute();
                                $result_marca = $stmt_marca->get_result();
                                while ($marca = $result_marca->fetch_assoc()) {
                                    echo "<option value='" . $marca['id'] . "'>" . $marca['nomemarca'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="valor"><i class="fas fa-dollar-sign"></i> Valor</label>
                            <input type="number" class="form-control" id="valor" name="valor" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao"><i class="fas fa-align-left"></i> Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto"><i class="fas fa-image"></i> Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fechar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts do Bootstrap e do Font Awesome -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

