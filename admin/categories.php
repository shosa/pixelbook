<?php
require '../config/db.php';
require 'components/header.php';

$pdo = Database::getInstance();
$categoriaToEdit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        // Aggiungi categoria
        $nome = $_POST['nome'];
        $descrizione = $_POST['descrizione'];
        $banner = $_FILES['banner']['name'];

        move_uploaded_file($_FILES['banner']['tmp_name'], '../images/categories/' . $banner);

        $stmt = $pdo->prepare("INSERT INTO categorie (nome, descrizione, banner) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $descrizione, $banner]);

        echo "<p class='alert alert-success'>Categoria aggiunta con successo!</p>";
    } elseif (isset($_POST['update_category'])) {
        // Aggiorna categoria
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descrizione = $_POST['descrizione'];
        $banner = $_FILES['banner']['name'];

        if ($banner) {
            move_uploaded_file($_FILES['banner']['tmp_name'], '../images/categories/' . $banner);
            $stmt = $pdo->prepare("UPDATE categorie SET nome = ?, descrizione = ?, banner = ? WHERE id = ?");
            $stmt->execute([$nome, $descrizione, $banner, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE categorie SET nome = ?, descrizione = ? WHERE id = ?");
            $stmt->execute([$nome, $descrizione, $id]);
        }

        echo "<p class='alert alert-success'>Categoria aggiornata con successo!</p>";
    } elseif (isset($_POST['delete_category'])) {
        // Elimina categoria
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id = ?");
        $stmt->execute([$id]);

        echo "<p class='alert alert-success'>Categoria eliminata con successo!</p>";
    }
}

// Recupera tutte le categorie
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();

// Se è stata richiesta una modifica
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
    $stmt->execute([$id]);
    $categoriaToEdit = $stmt->fetch();
}
?>
<div class="container admin-container">
    <h1 class="admin-title">Gestisci Categorie</h1>

    <button class="btn btn-primary mb-3" id="toggleForm">Aggiungi Categoria</button>
    <div id="addCategoryForm" style="display:none;">
        <form action="categories.php" method="post" enctype="multipart/form-data" class="admin-form">
            <h2><?php echo $categoriaToEdit ? "Modifica Categoria" : "Aggiungi Categoria"; ?></h2>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required
                    value="<?php echo $categoriaToEdit['nome'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <textarea name="descrizione" id="descrizione" class="form-control" rows="3"
                    required><?php echo $categoriaToEdit['descrizione'] ?? ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="banner">Banner (Immagine)</label>
                <input type="file" name="banner" id="banner" class="form-control-file">
            </div>
            <?php if ($categoriaToEdit): ?>
                <input type="hidden" name="id" value="<?php echo $categoriaToEdit['id']; ?>">
                <button type="submit" name="update_category" class="btn btn-warning">Aggiorna Categoria</button>
            <?php else: ?>
                <button type="submit" name="add_category" class="btn btn-primary">Aggiungi Categoria</button>
            <?php endif; ?>
        </form>
    </div>

    <h2 class="mt-5">Categorie Esistenti</h2>
    <table class="table table-striped ">
        <thead>
            <tr>

                <th>Nome</th>

                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorie as $categoria): ?>
                <tr>

                    <td><?php echo $categoria['nome']; ?></td>

                    <td>
                        <a href="categories.php?edit=<?php echo $categoria['id']; ?>" class="btn text-warning"><i
                                class="fa fa-pen"></i></a>
                        <form action="categories.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">
                            <button type="submit" name="delete_category" class="btn text-danger"><i
                                    class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('toggleForm').addEventListener('click', function () {
        var form = document.getElementById('addCategoryForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>

<?php require '../components/footer.php'; ?>