<?php
require '../config/db.php';
require '../components/headerAdmin.php';

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_photo'])) {
        // Aggiungi foto alla galleria
        $categoria_id = $_POST['categoria_id'];
        $descrizione = $_POST['descrizione'];
        $file = $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], '../images/gallery/' . $file);

        $stmt = $pdo->prepare("INSERT INTO galleria (categoria_id, file, descrizione) VALUES (?, ?, ?)");
        $stmt->execute([$categoria_id, $file, $descrizione]);

        echo "<p class='alert alert-success'>Foto aggiunta con successo!</p>";
    } elseif (isset($_POST['delete_photo'])) {
        // Elimina foto dalla galleria
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM galleria WHERE id = ?");
        $stmt->execute([$id]);

        echo "<p class='alert alert-success'>Foto eliminata con successo!</p>";
    }
}

// Recupera le categorie
$stmt = $pdo->query("SELECT * FROM categorie");
$categorie = $stmt->fetchAll();

// Recupera le foto dalla galleria
$categoria_id = $_GET['id'] ?? null;
if ($categoria_id) {
    $stmt = $pdo->prepare("SELECT * FROM galleria WHERE categoria_id = ?");
    $stmt->execute([$categoria_id]);
    $fotografie = $stmt->fetchAll();
}
?>

<div class="container">
    <h1>Gestisci Galleria</h1>

    <form action="gallery.php" method="post" enctype="multipart/form-data">
        <h2>Aggiungi Foto</h2>
        <div class="form-group">
            <label for="categoria_id">Categoria</label>
            <select name="categoria_id" id="categoria_id" class="form-control" required>
                <?php foreach ($categorie as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria_id == $categoria['id']) ? 'selected' : ''; ?>><?php echo $categoria['nome']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group p-2">
            <label for="file">Immagine</label>
            <input type="file" name="file" id="file" class="form-control-file" required>
        </div>
        <div class="form-group p-2">
            <label for="descrizione">Descrizione</label>
            <textarea name="descrizione" id="descrizione" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_photo" class="btn btn-primary btn-block p-2">Aggiungi Foto</button>
    </form>

    <h2 class="mt-5">Galleria per Categoria</h2>
    <?php if ($categoria_id): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Immagine</th>
                    <th>Descrizione</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fotografie as $foto): ?>
                    <tr>
                        <td><?php echo $foto['id']; ?></td>
                        <td><img src="../images/gallery/<?php echo $foto['file']; ?>" alt="<?php echo $foto['descrizione']; ?>"
                                style="width: 100px;"></td>
                        <td><?php echo $foto['descrizione']; ?></td>
                        <td>
                            <form action="gallery.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">
                                <button type="submit" name="delete_photo" class="btn btn-danger btn-sm">Elimina</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Seleziona una categoria per visualizzare le foto.</p>
    <?php endif; ?>
</div>

<?php require '../components/footer.php'; ?>