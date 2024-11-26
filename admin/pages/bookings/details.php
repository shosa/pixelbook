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
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Dettagli Prenotazione</h2>
                    <p class="text-muted">Visualizza e modifica i dettagli della prenotazione.</p>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7l9 6l9 -6l-9 -6z" />
                                <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2 -2v-10" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            Email
                        </a>
                        <a href="https://wa.me/<?= htmlspecialchars($prenotazione['phone']); ?>" class="btn btn-success"
                            target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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
        <div class="row row-cards">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
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
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
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
                        <p><strong>Servizio:</strong> <?= htmlspecialchars($prenotazione['service']); ?></p>
                        <p><strong>Data Evento:</strong>
                            <?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date']))); ?></p>
                        <p><strong>Orario:</strong> <?= htmlspecialchars($prenotazione['time_of_day']); ?></p>
                        <p><strong>Durata:</strong> <?= htmlspecialchars($prenotazione['duration']) . ' ore'; ?></p>
                        <p><strong>Prezzo:</strong> €<?= number_format($prenotazione['price'], 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <svg class="icon icon-tabler icon-tabler-currency-euro" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17.2 7a6 7 0 1 0 0 10" />
                                <path d="M7 10h8m-8 4h8" />
                            </svg> Stato Prenotazione
                        </h3>
                        <p><strong>Creata in data:</strong>
                            <?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date_of_submit']))); ?></p>
                        <p><strong>Stato:</strong>
                            <?= $prenotazione['confirmed'] ? '<span class="status status-green">Confermata</span>' : '<span class="status status-orange">
  <span class="status-dot status-dot-animated"></span>Non Conclusa</span>'; ?>
                        </p>

                    </div>
                </div>
            </div>
        </div>


        <!-- Note amministratore -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Note Amministratore</h3>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Componi Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm">
                <div class="modal-body">
                    <input type="text" class="form-control" id="id" name="id" value="<?= htmlspecialchars($id) ?>"
                        hidden>
                    <div class="mb-3">
                        <label for="to" class="form-label">Destinatario</label>
                        <input type="email" class="form-control" id="to" name="to"
                            value="<?= htmlspecialchars($prenotazione['mail']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Oggetto</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="Don't tell anyone" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo da mostrare</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-primary">Invia Email</button>
                </div>
            </form>
            <div id="responseMessage" class="p-3"></div>
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

        // Gestione invio form con AJAX
        emailForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(emailForm);

            fetch("send_email.php", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    // Mostra il messaggio di risposta
                    responseMessage.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'}">${data.message}</div>`;
                })
                .catch(error => {
                    responseMessage.innerHTML = `<div class="alert alert-danger">Errore durante l'invio: ${error.message}</div>`;
                });
        });
    });
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>