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
                    <h2 class="page-title">Gestione Prenotazioni</h2>
                    <p class="text-muted">Visualizza e gestisci tutte le prenotazioni effettuate.</p>
                </div>
            </div>
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
                                    <td>&euro;<?= number_format($prenotazione['price'], 2); ?></td>
                                    <td>
                                        <?= $prenotazione['confirmed'] ? '<span class="status status-green">Confermata</span>' : '<span class="status status-orange">
  <span class="status-dot status-dot-animated"></span>Non Conclusa</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="details?token=<?= $prenotazione['id']; ?>"
                                            class="btn btn-icon btn-outline-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
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