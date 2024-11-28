<?php
require '../../config/db.php';

// Verifica se l'ID della categoria è presente
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo = Database::getInstance();

    // Recupera i dettagli della categoria dal database
    $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
    $stmt->execute([$id]);
    $categoria = $stmt->fetch();

    if ($categoria) {
        // Genera il form pre-compilato con i dati della categoria
        ?>
        <form action="index" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoria['id']); ?>">
            <input type="hidden" name="update_category" value="1">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($categoria['nome']); ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">AED Base</label>
                <input type="number" name="price" class="form-control"
                    value="<?php echo htmlspecialchars($categoria['base_price']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo</label>
                <select name="type" class="form-select" required>
                    <option value="PERSONAL" <?php echo ($categoria['type'] == 'PERSONAL') ? 'selected' : ''; ?>>PERSONAL</option>
                    <option value="BUSINESS" <?php echo ($categoria['type'] == 'BUSINESS') ? 'selected' : ''; ?>>BUSINESS</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrizione</label>
                <textarea name="descrizione" class="form-control" rows="3"
                    required><?php echo htmlspecialchars($categoria['descrizione']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Banner (Immagine)</label>
                <input type="file" name="banner" class="form-control">
                <?php if (!empty($categoria['banner'])): ?>
                    <p class="mt-2 text-center">Banner attuale: <br>
                        <img src="../../../images/categories/<?php echo htmlspecialchars($categoria['banner']); ?>" alt="Banner"
                            style="max-width: 200px; border-radius: 5px;" class="border shadow-sm">
                    </p>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-primary rounded-pill">Salva Modifiche</button>
            </div>
        </form>
        <?php
    } else {
        $_SESSION['warning'] = "Categoria non trovata.";
    }
} else {
    $_SESSION['danger'] = "ID Categoria non specificato.";
}
?>