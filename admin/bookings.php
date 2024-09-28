<?php
require '../config/db.php';
require '../components/headerAdmin.php';

$pdo = Database::getInstance();

// Recupera tutte le prenotazioni
$stmt = $pdo->query("SELECT * FROM prenotazioni");
$prenotazioni = $stmt->fetchAll();
?>

<div class="container">
    <h1>Gestisci Prenotazioni</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Data Prenotazione</th>
                <th>Categoria</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prenotazioni as $prenotazione): ?>
                <tr>
                    <td><?php echo $prenotazione['id']; ?></td>
                    <td><?php echo $prenotazione['nome']; ?></td>
                    <td><?php echo $prenotazione['email']; ?></td>
                    <td><?php echo $prenotazione['telefono']; ?></td>
                    <td><?php echo $prenotazione['data_prenotazione']; ?></td>
                    <td>
                        <?php
                        $stmt = $pdo->prepare("SELECT nome FROM categorie WHERE id = ?");
                        $stmt->execute([$prenotazione['categoria_id']]);
                        $categoria = $stmt->fetch();
                        echo $categoria['nome'];
                        ?>
                    </td>
                    <td>
                        <!-- Azioni come visualizzare dettagli o cancellare prenotazione possono essere aggiunte qui -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../components/footer.php'; ?>