<?php
include 'funcoes.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $title = isset($_POST['cargo']) ? $_POST['cargo'] : '';
        $created = isset($_POST['data_criacao']) ? $_POST['data_criacao'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE CONTATOS SET id = ?, nome = ?, email = ?, telefone = ?, cargo = ?, data_criacao = ? WHERE id = ?');
        $stmt->execute([$id, $nome, $email, $telefone, $cargo, $data_criacao, $_GET['id']]);
        $msg = 'Atualizado com sucesso!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM CONTATOS WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Não existe contato com este ID!');
    }
} else {
    exit('Nenhum ID foi especificado!');
}
?>

<?=template_header('Alterar')?>

<div class="content update">
	<h2>Alterar Contato #<?=$contact['id']?></h2>
    <form action="atualizar.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['email']?>" id="email">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone">
        <label for="title">Title</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" value="<?=$contact['title']?>" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>


<?=template_footer()?>
