<?php
require 'config/db.php';
require 'components/header.php';
$servizio = isset($_GET['service']) ? htmlspecialchars($_GET['service']) : '';
?>
<style>
    /* Avanzamento del form */
    .progress-bar-container {
        margin-bottom: 30px;
    }

    .progress-bar-step {
        width: 20%;
        text-align: center;
        position: relative;
    }

    .progress-bar-step.active .step-number {
        background-color: var(--success);
        color: #fff;
    }

    .progress-bar-step .step-number {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #ddd;
        border-radius: 50%;
        margin: 0 auto;
        font-weight: bold;
    }

    .progress-bar-step .step-label {
        margin-top: 5px;
    }

    .custom-duration {
        display: none;
    }

    .flexible-date-label {
        display: inline-block;
        margin-left: 10px;
    }

    .btn-group {
        width: 100%;
    }

    .btn-group .btn {
        width: 100%;
        margin-bottom: 10px; /* Spazio tra i pulsanti */
    }

    /* Nasconde i radio button */
    input[type="radio"] {
        display: none;
    }
</style>

<div class="container mt-5">
    <h2 class="text-center text-dark font-weight-bold mb-4">Booking</h2>

    <!-- Barra di avanzamento -->
    <div class="progress-bar-container d-flex justify-content-between mb-4">
        <div class="progress-bar-step active" id="step1">
            <div class="step-number">1</div>
        </div>
        <div class="progress-bar-step" id="step2">
            <div class="step-number">2</div>
        </div>
        <div class="progress-bar-step" id="step3">
            <div class="step-number">3</div>
        </div>
        <div class="progress-bar-step" id="step4">
            <div class="step-number">4</div>
        </div>
        <div class="progress-bar-step" id="step5">
            <div class="step-number">5</div>
        </div>
    </div>

    <!-- Form a step -->
    <form id="multiStepForm">

        <!-- Step 1: Scelta del servizio -->
        <div class="step" id="step-1">
            <h4>Scegli il tipo di servizio</h4>

            <input type="radio" class="btn-check" name="service" id="photo" value="Photo" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(2)" for="photo">PHOTO</label>

            <input type="radio" class="btn-check" name="service" id="video" value="Video" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(2)" for="video">VIDEO</label>

            <input type="radio" class="btn-check" name="service" id="photo_video" value="Photo & Video" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(2)" for="photo_video">PHOTO & VIDEO</label>

        </div>

        <!-- Step 2: Scelta del momento del giorno -->
        <div class="step d-none" id="step-2">
            <h4>Quando desideri prenotare?</h4>

            <input type="radio" class="btn-check" name="time_of_day" id="morning" value="Mattina" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(3)" for="morning">Mattina</label>

            <input type="radio" class="btn-check" name="time_of_day" id="afternoon" value="Pomeriggio" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(3)" for="afternoon">Pomeriggio</label>

            <input type="radio" class="btn-check" name="time_of_day" id="evening" value="Sera" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(3)" for="evening">Sera</label>

            <button type="button" class="btn btn-secondary btn-circle mb-4" onclick="prevStep(1)"><i class="fa fa-chevron-left"></i></button>
        </div>

        <!-- Step 3: Scelta della durata -->
        <div class="step d-none" id="step-3">
            <h4>Durata del servizio</h4>

            <input type="radio" class="btn-check" name="duration" id="one_hour" value="1 Ora" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(4)" for="one_hour">1 Ora</label>

            <input type="radio" class="btn-check" name="duration" id="two_hours" value="2 Ore" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(4)" for="two_hours">2 Ore</label>

            <input type="radio" class="btn-check" name="duration" id="three_hours" value="3 Ore" required>
            <label class="btn btn-outline-success btn-block" onclick="nextStep(4)" for="three_hours">3 Ore</label>

            <div class="form-group custom-duration">
                <label for="custom_duration">Inserisci la durata personalizzata (ore):</label>
                <input type="number" id="custom_duration" name="custom_duration" class="form-control" placeholder="Es. 5">
            </div>

            <button type="button" class="btn btn-secondary btn-circle mb-4" onclick="prevStep(2)"><i class="fa fa-chevron-left"></i></button>
        </div>

        <!-- Step 4: Scelta della data -->
        <div class="step d-none" id="step-4">
            <h4>Seleziona una data</h4>
            <input type="date" class="form-control" name="date" required>

            <div class="form-check form-switch my-3">
                <input class="form-check-input" type="checkbox" id="flexibleDateSwitch" name="flexible_date">
                <label class="form-check-label flexible-date-label" for="flexibleDateSwitch">Data flessibile?</label>
            </div>

            <button type="button" class="btn btn-secondary btn-circle mb-4" onclick="prevStep(3)"><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="btn btn-success btn-block" onclick="nextStep(5)">RIVEDI</button>
        </div>

        <!-- Step 5: Riepilogo -->
        <div class="step d-none" id="step-5">
            <h4>Riepilogo della tua prenotazione</h4>
            <p><strong>Categoria:</strong> <span id="summary-category"><?php echo $servizio; ?></span></p>
            <p><strong>Servizio:</strong> <span id="summary-service"></span></p>
            <p><strong>Momento del giorno:</strong> <span id="summary-time"></span></p>
            <p><strong>Durata:</strong> <span id="summary-duration"></span></p>
            <p><strong>Data:</strong> <span id="summary-date"></span></p>
            <p><strong>Data flessibile:</strong> <span id="summary-flexible"></span></p>

            <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Indietro</button>
            <button type="button" class="btn btn-success" onclick="submitStep()">GET YOUR QUOTE</button>
        </div>

    </form>
</div>

<script>
    let currentStep = 1;

    // Funzione per passare al prossimo step
    function nextStep(step) {
        // Nasconde il passo corrente
        document.getElementById('step-' + currentStep).classList.add('d-none');
        // Mostra il passo successivo
        document.getElementById('step-' + step).classList.remove('d-none');
        // Aggiorna la barra di progresso
        updateProgressBar(step);
        // Aggiorna il passo corrente
        currentStep = step;

        // Popola il riepilogo alla fine
        if (step === 5) {
            document.getElementById('summary-service').textContent = document.querySelector('input[name="service"]:checked').nextElementSibling.textContent;
            document.getElementById('summary-time').textContent = document.querySelector('input[name="time_of_day"]:checked').nextElementSibling.textContent;
            document.getElementById('summary-duration').textContent = document.querySelector('input[name="duration"]:checked').nextElementSibling.textContent || document.getElementById('custom_duration').value + " Ore";
            document.getElementById('summary-date').textContent = document.querySelector('input[name="date"]').value;
            document.getElementById('summary-flexible').textContent = document.getElementById('flexibleDateSwitch').checked ? "Sì" : "No";
        }
    }

    // Funzione per tornare allo step precedente
    function prevStep(step) {
        // Nasconde il passo corrente
        document.getElementById('step-' + currentStep).classList.add('d-none');
        // Mostra il passo precedente
        document.getElementById('step-' + step).classList.remove('d-none');
        // Aggiorna la barra di progresso
        updateProgressBar(step);
        // Aggiorna il passo corrente
        currentStep = step;
    }

    // Funzione per aggiornare la barra di avanzamento
    function updateProgressBar(step) {
        // Rimuove la classe attiva da tutti i passi
        const steps = document.querySelectorAll('.progress-bar-step');
        steps.forEach((element, index) => {
            element.classList.remove('active');
            if (index < step - 1) {
                element.classList.add('active');
            }
        });
    }

    // Funzione per inviare il modulo
    function submitStep() {
        const formData = new FormData(document.getElementById('multiStepForm'));

        fetch('process_booking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Mostra il risultato del server nella console
            alert('Prenotazione inviata con successo!'); // Notifica all'utente
            // Reset del modulo e ritorno al primo step
            document.getElementById('multiStepForm').reset();
            currentStep = 1;
            nextStep(1); // Torna al primo step
        })
        .catch(error => console.error('Error:', error));
    }
</script>

<?php require 'components/footer.php'; ?>
