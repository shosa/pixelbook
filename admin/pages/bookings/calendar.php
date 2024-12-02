<?php
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();

// Recupera tutte le prenotazioni per il calendario
$stmt = $pdo->prepare("
    SELECT id, CONCAT(first_name, ' ', last_name) AS cliente, category_id ,service, date, time_of_day, price, confirmed, voided, note
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
    <div class="offcanvas-header bg-light">
        <h5 id="eventDetailsLabel" class="offcanvas-title text-primary">Dettagli Prenotazione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Chiudi"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h3 text-center text-gradient-custom mb-4"><b>Dettagli Cliente</b></h2>
                <div class="mb-3">
                    <h5><b>Cliente:</b></h5>
                    <p class="text-muted" id="eventCliente">--</p>
                </div>
                <div class="mb-3">
                    <h5><b>Servizio:</b></h5>
                    <p class="text-muted" id="eventServizio">--</p>
                </div>
                <div class="mb-3">
                    <h5><b>Data:</b></h5>
                    <p class="text-muted" id="eventData">--</p>
                </div>
                <div class="mb-3">
                    <h5><b>Prezzo:</b></h5>
                    <p class="h4 text-success"><b>€<span id="eventPrezzo">--</span></b></p>
                </div>
                <div class="mb-3">
                    <h5><b>Stato:</b></h5>
                    <p class="status" id="eventStato">--</p>
                </div>
                <div class="mb-3">
                    <h5><b>Note:</b></h5>
                    <p class="text-muted" id="eventNote">Nessuna nota</p>
                </div>
                <div class="text-center mt-4">
                    <a href="#" id="editBookingButton" class="btn btn-gradient-custom px-4 py-2 rounded-pill">Modifica
                        Prenotazione</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'it', // Localizzazione in italiano
            initialView: 'dayGridMonth', // Vista iniziale
            contentHeight: 700,
            themeSystem: 'standard',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridDay,listWeek'
            },
            buttonIcons: {
                prev: 'chevron-left',
                next: 'chevron-right',

            },
            buttonText: {

                today: "Oggi",
                month: "Mese",
                week: "Settimana",
                day: "Giorno",
                list: "Agenda"
            },
            events: <?= json_encode($eventi) ?>,
            eventClick: function (info) {
                var evento = info.event.extendedProps;
                document.getElementById('eventCliente').textContent = info.event.title.split(' - ')[0];
                document.getElementById('eventServizio').textContent = info.event.title.split(' - ')[1];
                document.getElementById('eventData').textContent = new Date(info.event.start).toLocaleString();
                document.getElementById('eventPrezzo').textContent = evento.price;
                document.getElementById('eventStato').textContent = evento.status;
                // Usa innerHTML per rendere l'HTML delle note
                document.getElementById('eventNote').innerHTML = evento.note || '<em>Nessuna nota</em>';
                var eventStato = document.getElementById('eventStato');
    eventStato.textContent = evento.status;
    if (evento.status === 'Confermata') {
        eventStato.className = 'status status-green';
    } else {
        eventStato.className = 'status status-orange';
    }

                // Imposta il link del pulsante Modifica
                var editButton = document.getElementById('editBookingButton');
                editButton.href = `details?token=${info.event.id}`;

                // Mostra l'off-canvas
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