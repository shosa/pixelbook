<?php
require '../config/db.php';
require 'components/header.php';

$pdo = Database::getInstance();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_photo'])) {
        // Aggiungi più foto alla galleria
        $categoria_id = $_POST['categoria_id'];

        // Verifica che ci siano file caricati
        if (!empty($_FILES['files']['name'][0])) {
            $files = $_FILES['files'];

            // Cicla attraverso i file caricati
            for ($i = 0; $i < count($files['name']); $i++) {
                $file_name = $files['name'][$i];
                $tmp_name = $files['tmp_name'][$i];

                // Sposta il file caricato nella cartella di destinazione
                if (move_uploaded_file($tmp_name, '../images/gallery/' . $file_name)) {
                    // Inserisci l'immagine nel database
                    $stmt = $pdo->prepare("INSERT INTO galleria (categoria_id, file) VALUES (?, ?)");
                    $stmt->execute([$categoria_id, $file_name]);
                }
            }

            echo "<p class='alert alert-success'>Foto aggiunte con successo!</p>";
        } else {
            echo "<p class='alert alert-danger'>Nessun file selezionato.</p>";
        }
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
            <label for="file">Immagini</label>
            <input type="file" name="files[]" id="file" class="form-control-file" multiple required>
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

                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fotografie as $foto): ?>
                    <tr>
                        <td><?php echo $foto['id']; ?></td>
                        <td><img src="../images/gallery/<?php echo $foto['file']; ?>" alt="<?php echo $foto['descrizione']; ?>"
                                style="width: 100px;"></td>
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