<?php
include 'funcoes.php';
// Conectar ao banco de dados MySQL
$pdo = pdo_connect_mysql();
// Obter o número da página via requisição GET (parâmetro URL: page), se não existir o default será página 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros a serem apresentados por página
$records_per_page = 5;
// Prepara o comando SQL e obter os registros a partir da tabela de contatos
$stmt = $pdo->prepare('SELECT * FROM CONTATOS ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Buscar os registros para serem exibidos no nosso template
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Obter o número total de contatos, para determinarmos a necessidade dos botões anterior e próximo
$num_contacts = $pdo->query('SELECT COUNT(*) FROM CONTATOS')->fetchColumn();
?>
<?=template_header('Ler')?>

<div class="content read">
	<h2>Contatos Cadastrados</h2>
	<a href="criar.php" class="create-contact">Criar Contato</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nome</td>
                <td>Email</td>
                <td>Telefone</td>
                <td>Cargo</td>
                <td>Data Criação</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id']?></td>
                <td><?=$contact['nome']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['telefone']?></td>
                <td><?=$contact['cargo']?></td>
                <td><?=$contact['data_criacao']?></td>
                <td class="actions">
                    <a href="atualizar.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deletar.php?id=<?=$contact['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="ler.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="ler.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
