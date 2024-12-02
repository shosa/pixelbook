<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

// Recupera tutte le prenotazioni per il calendario
$stmt = $pdo->prepare("
    SELECT id, CONCAT(first_name, ' ', last_name) AS cliente, service, date, time_of_day, price, confirmed, voided, note
    FROM prenotazioni
    WHERE voided = 0
");
$stmt->execute();
$prenotazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepara i dati per il calendario in formato JSON
$eventi = array_map(function ($prenotazione) {
    return [
        'id' => $prenotazione['id'],
        'title' => $prenotazione['cliente'] . ' - ' . $prenotazione['service'],
        'start' => $prenotazione['date'] . 'T' . date('H:i:s', strtotime($prenotazione['time_of_day'])),
        'price' => $prenotazione['price'],
        'status' => $prenotazione['confirmed'] ? 'Confermata' : 'Incompleta',
        'note' => $prenotazione['note'],
        'color' => $prenotazione['confirmed'] ? '#4CAF50' : '#FFC107', // Colore dello sfondo
        'textColor' => '#ffffff' // Colore del testo
    ];
}, $prenotazioni);
?>

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Calendario Prenotazioni</h2>
                    <p class="text-muted">Visualizza tutte le prenotazioni in formato calendario.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendario</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Off-Canvas per i dettagli dell'evento -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="eventDetails" aria-labelledby="eventDetailsLabel">
    <div class="offcanvas-header">
        <h5 id="eventDetailsLabel" class="offcanvas-title">Dettagli Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p><strong>Cliente:</strong> <span id="eventCliente"></span></p>
        <p><strong>Servizio:</strong> <span id="eventServizio"></span></p>
        <p><strong>Data:</strong> <span id="eventData"></span></p>
        <p><strong>Prezzo:</strong> €<span id="eventPrezzo"></span></p>
        <p><strong>Stato:</strong> <span id="eventStato"></span></p>
        <p><strong>Note:</strong> <span id="eventNote"></span></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'it', // Localizzazione in italiano
            initialView: 'dayGridMonth', // Vista iniziale
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            buttonText: {
                prev: "Prec",
                next: "Succ",
                today: "Oggi",
                month: "Mese",
                week: "Settimana",
                day: "Giorno",
                list: "Agenda"
            },
            events: <?= json_encode($eventi) ?>,
            eventClick: function (info) {
                // Mostra i dettagli nell'off-canvas
                var evento = info.event.extendedProps;
                document.getElementById('eventCliente').textContent = info.event.title.split(' - ')[0];
                document.getElementById('eventServizio').textContent = info.event.title.split(' - ')[1];
                document.getElementById('eventData').textContent = info.event.start.toLocaleString();
                document.getElementById('eventPrezzo').textContent = evento.price;
                document.getElementById('eventStato').textContent = evento.status;
                document.getElementById('eventNote').textContent = evento.note || 'Nessuna nota';
                var offcanvas = new bootstrap.Offcanvas(document.getElementById('eventDetails'));
                offcanvas.show();
            },
            selectable: true,
            select: function (info) {
                var start = info.startStr;
                var end = info.endStr;
                alert('Selezionato intervallo: ' + start + ' - ' + end);
            }
        });

        calendar.render();
    });
</script>

<?php include(BASE_PATH . "/components/footer.php"); ?>
