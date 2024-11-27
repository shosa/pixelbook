<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

if (!isset($_GET['token'])) {
    header("Location: index");
    exit();
}

$id = $_GET['token'];

// Recupera i dettagli della prenotazione
$stmt = $pdo->prepare("SELECT p.*, c.nome AS categoria_nome FROM prenotazioni p LEFT JOIN categorie c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$prenotazione = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prenotazione) {
    echo "<p>Errore: Prenotazione non trovata.</p>";
    exit();
}
?>

<div class="page-wrapper">
    <div class="container-xl">
        <!-- Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center ">
                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="../../index">Home</a></li>
                            <li class="breadcrumb-item"><a href="index">Prenotazioni</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Dettagli</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title">Dettagli Prenotazione</h2>
                    <p class="text-muted">Visualizza e modifica i dettagli della prenotazione.</p>
                </div>

                <div class="col-auto ms-auto d-print-none">

                    <div class="btn-list">

                        <a href="https://wa.me/<?= htmlspecialchars($prenotazione['phone']); ?>"
                            class="btn rounded-pill shadow-sm" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-brand-whatsapp text-green" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path
                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                            </svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informazioni principali -->
        <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title badge subheader bg-instagram-lt">
                            <svg class="icon icon-tabler icon-tabler-user" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg> Cliente
                        </h3>
                        <a class="h2"><strong>
                                <?= htmlspecialchars($prenotazione['first_name'] . ' ' . $prenotazione['last_name']); ?>
                        </a></strong><br>
                        <a class="text-muted"
                            href="mailto:<?= htmlspecialchars($prenotazione['mail']); ?>"><?= htmlspecialchars($prenotazione['mail']); ?></a><br>
                        <a></strong> <?= htmlspecialchars($prenotazione['phone']); ?></a>
                        <p><strong>Creata in data:</strong>
                            <?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date_of_submit']))); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title badge subheader bg-info-lt">
                            <svg class="icon icon-tabler icon-tabler-calendar" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <rect x="4" y="5" width="16" height="16" rx="2" />
                                <line x1="16" y1="3" x2="16" y2="7" />
                                <line x1="8" y1="3" x2="8" y2="7" />
                                <line x1="4" y1="11" x2="20" y2="11" />
                                <line x1="11" y1="15" x2="12" y2="15" />
                                <line x1="12" y1="15" x2="12" y2="18" />
                            </svg> Dettagli Evento
                        </h3>
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Servizio:</strong><br><?= htmlspecialchars($prenotazione['service']); ?></p>
                                <p><strong>Data
                                        Evento:</strong><br><?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date']))); ?>
                                </p>
                                <p><strong>Orario:</strong><br><?= htmlspecialchars($prenotazione['time_of_day']); ?>
                                </p>
                            </div>
                            <div class="col-6">
                                <p><strong>Durata:</strong><br><?= htmlspecialchars($prenotazione['duration']) . ' ore'; ?>
                                </p>
                                <p><strong>Prezzo:</strong><br>€<?= number_format($prenotazione['price'], 2); ?></p>

                                <!-- Pulsante Elimina -->
                                <button class="btn btn-light btn-outline-red rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7h16" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3h6v3" />
                                    </svg> Elimina
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title badge subheader bg-rss-lt">
                            <svg class="icon icon-tabler icon-tabler-currency-euro" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17.2 7a6 7 0 1 0 0 10" />
                                <path d="M7 10h8m-8 4h8" />
                            </svg> Stato Prenotazione
                        </h3>

                        <!-- Stato Prenotazione -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Stato:</strong><br>
                                <?php
                                if ($prenotazione['voided']) {
                                    echo '<span class="status status-red">Annullata</span>';
                                } elseif ($prenotazione['confirmed']) {
                                    echo '<span class="status status-green">Confermata</span>';
                                } else {
                                    echo '<span class="status status-orange"><span class="status-dot status-dot-animated"></span>Non Conclusa</span>';
                                }
                                ?>
                            </p>
                            <button class="btn rounded-pill shadow-sm  text-dark" data-bs-toggle="modal"
                                data-bs-target="#updateStatusModal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M19 8v5a5 5 0 0 1 -5 5h-3l3 -3m0 6l-3 -3" />
                                    <path d="M5 16v-5a5 5 0 0 1 5 -5h3l-3 -3m0 6l3 -3" />
                                </svg>
                                Cambia
                            </button>
                        </div>

                        <!-- Prezzo Prenotazione -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <p><strong>Prezzo:</strong><br>
                                <?php if (!empty($prenotazione['offer_price'])): ?>
                                    <span
                                        style="text-decoration: line-through;">€<?= number_format($prenotazione['price'], 2); ?></span>
                                    <span
                                        class="text-success ms-2">€<?= number_format($prenotazione['offer_price'], 2); ?></span>
                                <?php else: ?>
                                    €<?= number_format($prenotazione['price'], 2); ?>
                                <?php endif; ?>
                            </p>
                            <?php if (!$prenotazione['confirmed']): ?>
                                <button class="btn text-instagram shadow-sm rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#emailModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13.5 19h-8.5a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v3.5" />
                                        <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                        <path d="M19 21v1m0 -8v1" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                    CallBack
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Log del callback -->
                        <?php if (!empty($prenotazione['date_of_offer'])): ?>
                            <p class="text-center subheader mt-2 badge bg-success-lt text-success">Offerta inviata il:
                                <?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date_of_offer']))); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>
        <?php include(BASE_PATH . "/components/alerts.php"); ?>

        <!-- Note amministratore -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Annotazioni</h3>
                    </div>
                    <div class="card-body">
                        <form action="update_notes" method="post">
                            <input type="hidden" name="id" value="<?= $prenotazione['id']; ?>">
                            <textarea id="adminNote" name="adminNote"
                                class="form-control"><?= htmlspecialchars($prenotazione['note']); ?></textarea>
                            <button type="submit" class="btn btn-outline-primary mt-3 w-100">Salva Note</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale per la composizione dell'email -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Offerta di CallBack</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm">
                <div class="modal-body">
                    <input type="text" class="form-control" id="id" name="id" value="<?= htmlspecialchars($id) ?>" hidden>
                    <div class="mb-3">
                        <label for="to" class="form-label">Destinatario</label>
                        <input type="email" class="form-control" id="to" name="to"
                            value="<?= htmlspecialchars($prenotazione['mail']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Oggetto</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="Offerta speciale"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">
                            Nuovo Prezzo 
                            <span class="text-muted">(Prezzo originale: AED <?= number_format($prenotazione['price'], 2); ?> 
                            <span class="text-rss"> -> 10%:</span> AED <?= number_format($prenotazione['price'] * 0.9, 2); ?>)</span>
                        </label>
                        <input type="text" class="form-control" id="price" name="price" 
                            value="<?= number_format($prenotazione['price'] * 0.9, 2); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded-pill" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-outline-success rounded-pill">Invia Email</button>
                </div>
            </form>
            <div id="responseMessage" class="p-3"></div>
        </div>
    </div>
</div>
<!-- Modale cambia stato -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Modifica Stato Prenotazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $prenotazione['id']; ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Seleziona Stato</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="confirmed" <?= $prenotazione['confirmed'] ? 'selected' : ''; ?>>Confermata
                            </option>
                            <option value="not_confirmed" <?= !$prenotazione['confirmed'] && !$prenotazione['voided'] ? 'selected' : ''; ?>>Non Conclusa</option>
                            <option value="voided" <?= $prenotazione['voided'] ? 'selected' : ''; ?>>Annullata</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded-pill" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-outline-primary rounded-pill">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modale di conferma eliminazione -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare questa prenotazione? L'azione è irreversibile.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Elimina</button>
            </div>
        </div>
    </div>
</div>

<!-- TinyMCE per l'editor -->

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/tinymce/tinymce.min.js" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let options = {
            selector: '#adminNote',
            height: 300,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'print | undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
        }
        if (localStorage.getItem("tablerTheme") === 'dark') {
            options.skin = 'oxide-dark';
            options.content_css = 'dark';
        }
        tinyMCE.init(options);
    })
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const emailForm = document.getElementById("emailForm");
        const responseMessage = document.getElementById("responseMessage");

        emailForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(emailForm);
            const offerPrice = formData.get('price');
            const prenotazioneId = formData.get('id');

            fetch("send_email.php", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Salva l'offer_price nel database
                        fetch("update_offer_price.php", {
                            method: "POST",
                            body: JSON.stringify({
                                id: prenotazioneId,
                                offer_price: offerPrice,
                            }),
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                            .then(updateResponse => updateResponse.json())
                            .then(updateData => {
                                if (updateData.success) {
                                    responseMessage.innerHTML = `<div class="alert alert-success">Email inviata e offerta salvata!</div>`;
                                    location.reload(); // Ricarica la pagina per aggiornare i dati
                                } else {
                                    responseMessage.innerHTML = `<div class="alert alert-danger">Errore durante il salvataggio dell'offerta.</div>`;
                                }
                            });
                    } else {
                        responseMessage.innerHTML = `<div class="alert alert-danger">Errore durante l'invio: ${data.message}</div>`;
                    }
                })
                .catch(error => {
                    responseMessage.innerHTML = `<div class="alert alert-danger">Errore: ${error.message}</div>`;
                });
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const updateStatusForm = document.getElementById("updateStatusForm");

        updateStatusForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(updateStatusForm);
            const prenotazioneId = formData.get("id");
            const newStatus = formData.get("status");

            fetch("update_status.php", {
                method: "POST",
                body: JSON.stringify({
                    id: prenotazioneId,
                    status: newStatus,
                }),
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        location.reload(); // Ricarica la pagina per aggiornare lo stato
                    } else {

                    }
                })
                .catch(error => {
                    alert("Errore: " + error.message);
                });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const confirmDeleteButton = document.getElementById("confirmDeleteButton");

        confirmDeleteButton.addEventListener("click", function () {
            fetch("delete_prenotazione.php", {
                method: "POST",
                body: JSON.stringify({ id: <?= json_encode($prenotazione['id']); ?> }),
                headers: { "Content-Type": "application/json" }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        window.location.href = "index"; // Redirigi alla lista prenotazioni
                    } else {
                        alert("Errore durante l'eliminazione: " + data.message);
                    }
                })
                .catch(error => {
                    alert("Errore: " + error.message);
                });
        });
    });
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>