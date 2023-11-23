<?php
require_once '../Config/config.php';
require_once 'App/Controller/LivroController.php';

if (isset($_FILES['imagem']) && !empty($_FILES['imagem'])) {
    $imagem = "../uploads/" . $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
} else {
    $imagem = "";
}

$livroController = new LivroController($pdo);

if (isset($_POST['nome']) && 
    isset($_POST['categoria']) &&
    isset($_POST['quantidade']) &&
    isset($_POST['categoria_id'])) 
{
    $livroController->criarLivro($_POST['nome'], $_POST['categoria'], $_POST['quantidade'], $imagem, $_POST['categoria_id']);
    header('Location: #');
}

// Atualiza Livro
if (isset($_POST['livro_id']) && isset($_POST['atualizar_nome']) && isset($_POST['atualizar_categoria']) && isset($_POST['atualizar_quantidade']) && isset($_POST['atualizar_imagem']) && isset($_POST['atualizar_categoria_id'])) {
    $livroController->atualizarLivro($_POST['livro_id'], $_POST['atualizar_nome'], $_POST['atualizar_categoria'], $_POST['atualizar_quantidade'], $_POST['atualizar_imagem'], $_POST['atualizar_categoria_id']);
}

// Excluir Livro
if (isset($_POST['excluir_livro_id'])) {
    $livroController->excluirLivro($_POST['excluir_livro_id']);
}

$livros = $livroController->listarLivros();



?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <title>CRUD com MVC e PDO</title>
</head>
<body>
    <a href="index.php">Voltar</a>
    <h1>Livros</h1>
    <form action="livro.php" method="post" enctype="multipart/form-data">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="text" name="categoria" placeholder="Categoria" required>
    <input type="number" name="quantidade" placeholder="Qntd De Livros" min="1" max="5" required>
    <input type="file" name="imagem" accept="image/*" required>
    <input type="number" name="categoria_id" required placeholder="Categoria_id">
    <button type="submit">Adicionar Livro</button>
</form>

<?php
$livroController->exibirListaLivros();
?>

<h2>Atualizar Livro</h2>
    <form method="post">
        <select name="livro_id">
        <?php foreach ($livros as $livro): ?>
                                <option value="<?php echo $livro['livro_id']; ?>"><?php echo $livro['livro_id']; ?></option>
                                <?php endforeach; ?>
        </select>
                <input type="text" name="atualizar_nome" placeholder="Novo Nome" required>
                <input type="text" name="atualizar_categoria" placeholder="Nova categoria" required>
                <input type="number" name="atualizar_quantidade" placeholder="Nova qntd De Livros" min="1" max="3" required>
                <input type="file" name="atualizar_imagem" accept="image/*" required>
                <input type="number" name="atualizar_categoria_id" required placeholder="Nova Categoria_id">
        <button type="submit">Atualizar Livro</button>
    </form>

    <h2>Excluir Livro</h2>
    <form method="post">
        <select name="excluir_livro_id">
            <?php foreach ($livros as $livro): ?>
                <option value="<?php echo $livro['livro_id']; ?>"><?php echo $livro['nome']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Excluir Livro</button>
    </form>
</body>
</html>