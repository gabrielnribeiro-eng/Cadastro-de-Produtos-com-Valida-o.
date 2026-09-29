
<?php

// Conexão com o banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "Senai@118";
$banco = "exercicio";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$mensagem = "";

// Quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $preco = $_POST["preco"];

    // Validação do nome
    if (empty($nome)) {
        $mensagem = "Erro: O nome do produto não pode estar vazio.";
    }

    // Validação do preço
    elseif (!is_numeric($preco) || $preco <= 0) {
        $mensagem = "Erro: O preço deve ser um número positivo.";
    }

    // Se estiver tudo correto
    else {
        $sql = "INSERT INTO produtos (nome, preco) VALUES (?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sd", $nome, $preco);

        if ($stmt->execute()) {
            $mensagem = "Produto cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o produto.";
        }

        $stmt->close();
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
</head>
<body>

    <h1>Cadastro de Produtos</h1>

    <?php
    if (!empty($mensagem)) {
        echo "<p>$mensagem</p>";
    }
    ?>

    <form method="POST">

        <label for="nome">Nome do Produto:</label><br>
        <input type="text" name="nome" id="nome"><br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" name="preco" id="preco" step="0.01"><br><br>

        <button type="submit">Cadastrar Produto</button>

    </form>

</body>
</html>
