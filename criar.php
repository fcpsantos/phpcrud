<?php
include 'funcoes.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Testar se a variável $_POST não está vazia
if (!empty($_POST)) {
    // Se a variável $_POST não estiver vazia insere um novo registro
    // Atribuir as variáveis que serão inseridas. Devemos checar se as variáveis existem, caso não existam o valor default será vazio
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Checar se a variável "nome" existe no POST, se não existir usar o valor default vazio. Basicamente fazemos a mesma coisa para os demais campos
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
    $data_criacao = isset($_POST['data_criacao']) ? $_POST['data_criacao'] : date('Y-m-d H:i:s');
    // Insere o novo registro na tabela de contatos
	$stmt = $pdo->prepare('INSERT INTO CONTATOS VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nome, $email, $telefone, $cargo, $data_criacao]);
    // Mensagem de saída
    $msg = 'Novo contato criado com sucesso!';
}
?>

<?=template_header('Criar')?>

<div class="content update">
	<h2>Criar um contato</h2>
    <form action="criar.php" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="nome" placeholder="John Doe" id="nome">
        <label for="email">Email</label>
        <label for="telefone">Telefone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" id="email">
        <input type="text" name="telefone" placeholder="2025550143" id="telefone">
        <label for="cargo">Cargo</label>
        <label for="data_criacao">Data Criação</label>
        <input type="text" name="cargo" placeholder="Empregado" id="cargo">
        <input type="datetime-local" name="data_criacao" value="<?=date('Y-m-d\TH:i')?>" id="data_criacao">
        <input type="submit" value="Incluir">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
