<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

// Recupera tutte le prenotazioni
$stmt = $pdo->prepare("
    SELECT p.*, c.nome AS categoria_nome 
    FROM prenotazioni p 
    LEFT JOIN categorie c ON p.category_id = c.id
    ORDER BY p.id DESC
");
$stmt->execute();
$prenotazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="../../index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="index">Prenotazioni</a></li>

                        </ol>
                    </div>
                    <h2 class="page-title">Gestione Prenotazioni</h2>
                    <p class="text-muted">Visualizza e gestisci tutte le prenotazioni effettuate.</p>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?php echo BASE_URL ?>/pages/bookings/calendar" class="btn rounded-pill shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-brand-whatsapp text-info" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Calendario
                        </a>
                    </div>
                </div>
            </div>
            <?php include(BASE_PATH . "/components/alerts.php"); ?>
        </div>

    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista Prenotazioni</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servizio</th>
                                <th>Data Prenotazione</th>
                                <th>Data Evento</th>
                                <th>Prezzo</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prenotazioni as $prenotazione): ?>
                                <tr>
                                    <td><?= sprintf('%06d', $prenotazione['id']); ?></td>
                                    <td><?= htmlspecialchars($prenotazione['first_name']) . ' ' . htmlspecialchars($prenotazione['last_name']); ?>
                                    </td>
                                    <td><?= htmlspecialchars($prenotazione['service']); ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date_of_submit']))); ?>
                                    </td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($prenotazione['date']))); ?> -
                                        <?= htmlspecialchars($prenotazione['time_of_day']); ?>
                                    </td>
                                    <td>AED <?= number_format($prenotazione['price'], 2); ?></td>
                                    <td>
                                        <?php
                                        if ($prenotazione['voided']) {
                                            echo '<span class="status status-red">Annullata</span>';
                                        } elseif ($prenotazione['confirmed']) {
                                            echo '<span class="status status-green">Confermata</span>';
                                        } else {
                                            echo '<span class="status status-orange"><span class="status-dot status-dot-animated"></span>Incompleta</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="details?token=<?= $prenotazione['id']; ?>"
                                            class="btn btn-icon btn-primary rounded-pill">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(BASE_PATH . "/components/footer.php"); ?>