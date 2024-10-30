<?php
ob_start(); // Inizia il buffer di output
session_start(); // Inizia la sessione per gestire i messaggi di errore/successo
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

// Recupera i dati attuali del tariffario
$stmt = $pdo->query("SELECT * FROM tariffario WHERE id = 1"); // Presumendo che ci sia solo una riga
$tariffario = $stmt->fetch(PDO::FETCH_ASSOC);

// Gestione del form POST per aggiornare i dati del tariffario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("
            UPDATE tariffario 
            SET 
                Photo = :photo, 
                Video = :video, 
                `Photo & Video` = :photo_video, 
                `1` = :duration_1, 
                `2` = :duration_2, 
                `3` = :duration_3, 
                Custom = :custom 
            WHERE id = 1");

        $stmt->execute([
            'photo' => $_POST['photo'],
            'video' => $_POST['video'],
            'photo_video' => $_POST['photo_video'],
            'duration_1' => $_POST['duration_1'],
            'duration_2' => $_POST['duration_2'],
            'duration_3' => $_POST['duration_3'],
            'custom' => $_POST['custom']
        ]);

        $_SESSION["success"] = "Tariffario aggiornato con successo!";
    } catch (Exception $e) {
        $_SESSION["danger"] = "Errore durante l'aggiornamento: " . $e->getMessage();
    }

    // Reindirizza per evitare la sottomissione multipla
    header('Location: index.php');
    exit;
}
?>

<div class="page-wrapper">
    <!-- Visualizzazione dei messaggi di errore/successo -->
    <div class="container-xl">
        <?php if (isset($_SESSION["danger"])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION["danger"];
                unset($_SESSION["danger"]); ?>
            </div>
        <?php elseif (isset($_SESSION["success"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["success"];
                unset($_SESSION["success"]); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Gestione Tariffario</h2>
                    <p class="text-muted">Gestisci i moltiplicatori di prezzo per vari servizi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="" id="tariffarioForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">
                                    <strong>Photo Multiplier</strong>
                                </label>
                                <input type="number" step="0.01" name="photo" class="form-control" id="photo"
                                    value="<?php echo htmlspecialchars($tariffario['Photo']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="video" class="form-label"><strong>Video Multiplier</strong></label>
                                <input type="number" step="0.01" name="video" class="form-control" id="video"
                                    value="<?php echo htmlspecialchars($tariffario['Video']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="photo_video" class="form-label"><strong>Photo & Video
                                        Multiplier</strong></label>
                                <input type="number" step="0.01" name="photo_video" class="form-control"
                                    id="photo_video"
                                    value="<?php echo htmlspecialchars($tariffario['Photo & Video']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="custom" class="form-label"><strong>Custom Duration
                                        Multiplier</strong></label>
                                <input type="number" step="0.01" name="custom" class="form-control" id="custom"
                                    value="<?php echo htmlspecialchars($tariffario['Custom']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="duration_1" class="form-label"><strong>1 Hour Multiplier</strong></label>
                                <input type="number" step="0.01" name="duration_1" class="form-control" id="duration_1"
                                    value="<?php echo htmlspecialchars($tariffario['1']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration_2" class="form-label"><strong>2 Hours Multiplier</strong></label>
                                <input type="number" step="0.01" name="duration_2" class="form-control" id="duration_2"
                                    value="<?php echo htmlspecialchars($tariffario['2']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration_3" class="form-label"><strong>3 Hours Multiplier</strong></label>
                                <input type="number" step="0.01" name="duration_3" class="form-control" id="duration_3"
                                    value="<?php echo htmlspecialchars($tariffario['3']); ?>" required>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">Salva Modifica</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">Ripristina
                                valori precedenti</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Esempi aggiornati in tempo reale -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Esempi di Prezzi Calcolati (Ex: Servizio Base 1000 AED)</h5>
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="icon icon-tabler icon-tabler-camera mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0"><strong>Photo 1 Ora</strong></p>
                                    <p id="examplePhoto1" class="text-primary fw-bold">0 AED</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="icon icon-tabler icon-tabler-video mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0"><strong>Video 2 Ore</strong></p>
                                    <p id="exampleVideo2" class="text-primary fw-bold">0 AED</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="icon icon-tabler icon-tabler-camera-plus mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0"><strong>Photo & Video 3 Ore</strong></p>
                                    <p id="examplePhotoVideo3" class="text-primary fw-bold">0 AED</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="icon icon-tabler icon-tabler-camera mb-2" style="font-size: 24px;"></i>
                                    <i class="icon icon-tabler icon-tabler-video mb-2" style="font-size: 24px;"></i>
                                    <p class="mb-0"><strong>Photo & Video 8 Ore</strong></p>
                                    <p id="examplePhotoVideo8" class="text-primary fw-bold">0 AED</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale di conferma -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conferma Modifiche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler salvare queste modifiche al tariffario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Conferma</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Funzione per resettare il form
    function resetForm() {
        document.getElementById('tariffarioForm').reset();
        updateExamples();
    }

    // Funzione per sottomettere il form
    function submitForm() {
        document.getElementById('tariffarioForm').submit();
    }

    // Funzione per aggiornare gli esempi in tempo reale
    function updateExamples() {
        const photoMultiplier = parseFloat(document.getElementById('photo').value) || 0;
        const videoMultiplier = parseFloat(document.getElementById('video').value) || 0;
        const photoVideoMultiplier = parseFloat(document.getElementById('photo_video').value) || 0;

        const duration1 = parseFloat(document.getElementById('duration_1').value) || 0;
        const duration2 = parseFloat(document.getElementById('duration_2').value) || 0;
        const duration3 = parseFloat(document.getElementById('duration_3').value) || 0;
        const custom8 = parseFloat(document.getElementById('custom').value) * 8 || 0;

        // Calcoli per gli esempi
        document.getElementById('examplePhoto1').innerText = (1000 * (photoMultiplier * duration1)).toFixed(2) + " AED";
        document.getElementById('exampleVideo2').innerText = (1000 * (videoMultiplier * duration2)).toFixed(2) + " AED";
        document.getElementById('examplePhotoVideo3').innerText = (1000 * (photoVideoMultiplier * duration3)).toFixed(2) + " AED";
        document.getElementById('examplePhotoVideo8').innerText = (1000 * (photoVideoMultiplier * custom8)).toFixed(2) + " AED";
    }

    // Attivazione dei tooltip
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Aggiungi event listener per aggiornare gli esempi
        document.querySelectorAll('#tariffarioForm input').forEach(input => {
            input.addEventListener('input', updateExamples);
        });

        // Esegui update una volta per inizializzare
        updateExamples();
    });
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>
