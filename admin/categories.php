<?php
require '../config/db.php';
require '../components/headerAdmin.php';

$pdo = Database::getInstance();

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
?>
<div class="container admin-container">
    <h1 class="admin-title">Gestisci Categorie</h1>

    <form action="categories.php" method="post" enctype="multipart/form-data" class="admin-form">
        <h2>Aggiungi Categoria</h2>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea name="descrizione" id="descrizione" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="banner">Banner (Immagine)</label>
            <input type="file" name="banner" id="banner" class="form-control-file" required>
        </div>
        <button type="submit" name="add_category" class="btn btn-primary">Aggiungi Categoria</button>
    </form>

    <h2 class="mt-5">Categorie Esistenti</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Banner</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorie as $categoria): ?>
                <tr>
                    <td><?php echo $categoria['id']; ?></td>
                    <td><?php echo $categoria['nome']; ?></td>
                    <td><?php echo $categoria['descrizione']; ?></td>
                    <td><img src="../images/categories/<?php echo $categoria['banner']; ?>"
                            alt="<?php echo $categoria['nome']; ?>" class="img-thumbnail" style="width: 100px;"></td>
                    <td>
                        <a href="categories.php?edit=<?php echo $categoria['id']; ?>"
                            class="btn btn-warning btn-sm">Modifica</a>
                        <form action="categories.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../components/footer.php'; ?>