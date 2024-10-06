<?php require 'config/db.php';
require 'components/header.php';
$servizio = isset($_GET['service']) ?
    htmlspecialchars($_GET['service']) : ''; ?>
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
        transform: scale(1.1);
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .progress-bar-step .step-number {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #ddd;
        border-radius: 50%;
        margin: 0 auto;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.3s;
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
        margin-bottom: 10px;
        /* Spazio tra i pulsanti */
    }

    /* Nasconde i radio button */
    input[type="radio"] {
        display: none;
    }

    .step {
        transition: opacity 0.5s ease-in-out;
        opacity: 1;
    }

    .d-none {

        opacity: 0;
    }

    .summary-container {
        border: 2px solid var(--success);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }

    .summary-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--success);
        margin-bottom: 20px;
        text-align: center;
    }

    .summary-item {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #333;
    }

    .summary-item strong {
        color: var(--primary);
    }

    .summary-divider {
        border-top: 2px solid var(--light);
        margin: 15px 0;
    }

    .btn-submit {
        background-color: var(--success);
        color: white;
        padding: 10px 20px;
        font-size: 1.2rem;
        border-radius: 30px;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: var(--primary);
        color: white;
    }

    /* Stili per il toggle switch */
    .form-check-input {
        -webkit-appearance: none;
        width: 50px;
        height: 25px;
        background-color: #ddd;
        border-radius: 15px;
        cursor: pointer;
        position: relative;
        outline: none;
        transition: background-color 0.3s;
    }

    /* Colore quando è attivo */
    .form-check-input:checked {
        background-color: var(--success);
    }

    /* Pallino del toggle switch */
    .form-check-input::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        transition: transform 0.3s;
        top: 50%;
        /* Posizione verticale centrata */
        left: 3px;
        /* Allineamento orizzontale a sinistra */
        transform: translateY(-50%);
        /* Centra verticalmente */
    }

    /* Quando il toggle è attivo */
    .form-check-input:checked::before {
        transform: translate(25px, -50%);
        /* Sposta il pallino a destra */
    }

    /* Altri stili per la label */
    .flexible-date-label {
        margin-left: 10px;
    }

    .form-check.form-switch {
        display: flex;
        /* Usa flexbox per allineare gli elementi */
        align-items: center;
        /* Allinea verticalmente al centro */
    }

    .flexible-date-label {
        margin-left: 10px;
        /* Mantieni un margine a sinistra per distanziare il testo */
    }
</style>

<div class="container mt-5">
    <h1 class="text-center text-success font-weight-bold mb-4"><?php echo $servizio ?></h1>
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
    <h5 class="text-center text-dark mb-4">Get your price in 5 simple steps</h5>
    <div class="container mt-5">
        <!-- Form a step -->
        <form id="multiStepForm">

            <!-- Step 1: Scelta del servizio -->
            <div class="step" id="step-1">
                <h4 class="text-dark">What are you looking for?</h4>
                <input type="radio" class="btn-check" name="service" id="photo" value="Photo" required>
                <label class="btn btn-outline-success btn-block d-flex align-items-center justify-content-between"
                    onclick="nextStep(2)" for="photo">
                    <i class="fal fa-image "></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">PHOTO</span> <!-- testo centrato -->
                </label>


                <input type="radio" class="btn-check" name="service" id="video" value="Video" required>
                <label class="btn btn-outline-success btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(2)" for="video">
                    <i class="fal fa-video"></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">VIDEO</span> <!-- testo centrato -->
                </label>

                <input type="radio" class="btn-check" name="service" id="photo_video" value="Photo & Video" required>
                <label class="btn btn-outline-success btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(2)" for="photo_video">
                    <i class="fal fa-photo-video"></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">VIDEO</span> <!-- testo centrato -->
                </label>

            </div>

            <!-- Step 2: Scelta del momento del giorno -->
            <div class="step d-none" id="step-2">

                <h4 class="text-dark">What time?</h4>

                <input type="radio" class="btn-check" name="time_of_day" id="morning" value="Mattina" required>
                <label class="btn btn-outline-success btn-block d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="morning">
                    <i class="fal fa-sunrise"></i>
                    <span class="mx-auto">MORNING</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="afternoon" value="Pomeriggio" required>
                <label class="btn btn-outline-success btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="afternoon">
                    <i class="fal fa-sun"></i>
                    <span class="mx-auto">AFTERNOON</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="evening" value="Sera" required>
                <label class="btn btn-outline-success btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="evening">
                    <i class="fal fa-moon"></i>
                    <span class="mx-auto">EVENING</span>
                </label>

                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(1)"><i
                        class="fal fa-chevron-left"></i> Previous</button>
            </div>

            <!-- Step 3: Scelta della durata -->
            <div class="step d-none" id="step-3">

                <h4 class="text-dark">How long?</h4>

                <input type="radio" class="btn-check" name="duration" id="one_hour" value="1 Ora" required>
                <label class="btn btn-outline-success btn-block" onclick="nextStep(4)" for="one_hour">1 HOUR</label>

                <input type="radio" class="btn-check" name="duration" id="two_hours" value="2 Ore" required>
                <label class="btn btn-outline-success btn-block mt-4" onclick="nextStep(4)" for="two_hours">2
                    HOURS</label>

                <input type="radio" class="btn-check" name="duration" id="three_hours" value="3 Ore" required>
                <label class="btn btn-outline-success btn-block mt-4" onclick="nextStep(4)" for="three_hours">3
                    HOURS</label>
                <input type="radio" class="btn-check" name="duration" id="custom_duration_radio" value="Custom"
                    required>
                <label class="btn btn-outline-success btn-block mt-4" for="custom_duration_radio"
                    onclick="showCustomDuration()">CUSTOM DURATION</label>
                <div class="form-group custom-duration">
                    <label for="custom_duration">ENTER HOURS:</label>
                    <div class="input-group">
                        <input type="number" id="custom_duration" name="custom_duration" class="form-control"
                            placeholder="Es. 5" aria-label="Durata personalizzata">
                        <button class="btn btn-outline-success" style="border-radius: 0 0.35rem 0.35rem  0 !important;"
                            type="button" onclick="nextStep(4)">OK</button>
                    </div>
                </div>

                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(2)"><i
                        class="fal fa-chevron-left"></i> Previous</button>
            </div>

            <!-- Step 4: Scelta della data -->
            <div class="step d-none" id="step-4">
                <h4 class="text-dark">When?</h4>
                <input type="date" class="form-control" name="date" id="dateInput" required>

                <div class="form-check form-switch my-3">
                    <input class="form-check-input" type="checkbox" id="flexibleDateSwitch" name="flexible_date">
                    <label class="form-check-label flexible-date-label" for="flexibleDateSwitch">Is the date
                        flexible?</label>
                </div>
                <button type="button" class="btn btn-success btn-block" id="nextStepBtn" onclick="nextStep(5)"
                    disabled>Get your Quote</button>
                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(3)">
                    <i class="fal fa-chevron-left"></i> Previous
                </button>
            </div>

            <!-- Step 5: Riepilogo -->
            <div class="step d-none" id="step-5">
                <h2 class="text-success mb-4 text-center">Is this correct?</h2>
                <div class="container summary-container bg-success shadow-lg">
                    <h2 class="summary-title text-white mb-4">Booking Details</h2>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="text-white">Category:</strong>
                                </td>
                                <td>
                                    <span id="summary-category" class="text-white"><?php echo $servizio; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-white">Type of service:</strong>
                                </td>
                                <td>
                                    <span class="text-white" id="summary-service"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-white">Time:</strong>
                                </td>
                                <td>
                                    <span class="text-white" id="summary-time"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-white">Duration:</strong>
                                </td>
                                <td>
                                    <span class="text-white" id="summary-duration"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-white">Date:</strong>
                                </td>
                                <td>
                                    <span class="text-white" id="summary-date"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-white">Flexible:</strong>
                                </td>
                                <td>
                                    <span class="text-white" id="summary-flexible"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="summary-divider"></div>

                    <button type="button" class="btn btn-light btn-block" onclick="submitStep()">
                        <span class="text-success font-weight-bold">GET YOUR QUOTE</span>
                    </button>
                </div>
                <button type="button" class="btn bg-transparent text-dark mt-3" onclick="prevStep(4)">
                    <i class="fal fa-chevron-left"></i> Previous
                </button>
            </div>


        </form>
    </div>
</div>

<script>
    let currentStep = 1;
    document.getElementById('dateInput').addEventListener('change', function () {
        const dateInput = document.getElementById('dateInput').value;
        const nextStepBtn = document.getElementById('nextStepBtn');

        if (dateInput) {
            nextStepBtn.disabled = false; // Abilita il pulsante se la data è selezionata
        } else {
            nextStepBtn.disabled = true; // Disabilita il pulsante se la data non è selezionata
        }
    });

    function showCustomDuration() {
        document.querySelector('.custom-duration').style.display = 'block';
    }
    // Funzione per passare al prossimo step
    function nextStep(step) {
        const currentStepElement = document.getElementById('step-' + currentStep);
        const nextStepElement = document.getElementById('step-' + step);

        // Dissolvenza uscita step corrente
        currentStepElement.style.opacity = 0;

        // Dopo la dissolvenza, nasconde lo step corrente e mostra quello successivo
        setTimeout(() => {
            currentStepElement.classList.add('d-none');
            nextStepElement.classList.remove('d-none');
            nextStepElement.style.opacity = 1; // Dissolvenza entrata step successivo

            // Aggiorna la barra di progresso
            updateProgressBar(step);
            currentStep = step;

            // Popola il riepilogo alla fine
            if (step === 5) {
                document.getElementById('summary-service').textContent = document.querySelector('input[name="service"]:checked').nextElementSibling.textContent;
                document.getElementById('summary-time').textContent = document.querySelector('input[name="time_of_day"]:checked').nextElementSibling.textContent;
                document.getElementById('summary-duration').textContent = document.querySelector('input[name="duration"]:checked').nextElementSibling.textContent || document.getElementById('custom_duration').value + " Ore";
                document.getElementById('summary-duration').textContent =
                    document.querySelector('input[name="duration"]:checked')?.value === 'Custom'
                        ? document.getElementById('custom_duration').value + "  HOURS"
                        : document.querySelector('input[name="duration"]:checked').nextElementSibling.textContent;
                document.getElementById('summary-date').textContent = document.getElementById('dateInput').value;
                document.getElementById('summary-flexible').textContent = document.getElementById('flexibleDateSwitch').checked ? "Yes" : "No";
            }
        }, 500); // Tempo della transizione (corrispondente a quella definita in CSS)
    }

    // Funzione per tornare allo step precedente con transizione
    function prevStep(step) {
        const currentStepElement = document.getElementById('step-' + currentStep);
        const prevStepElement = document.getElementById('step-' + step);

        // Dissolvenza uscita step corrente
        currentStepElement.style.opacity = 0;

        setTimeout(() => {
            currentStepElement.classList.add('d-none');
            prevStepElement.classList.remove('d-none');
            prevStepElement.style.opacity = 1; // Dissolvenza entrata step precedente

            // Aggiorna la barra di progresso
            updateProgressBar(step);
            currentStep = step;
        }, 500); // Tempo della transizione
    }
    // Funzione per aggiornare la barra di avanzamento
    function updateProgressBar(step) {

        document.querySelectorAll('.progress-bar-step').forEach(function (el) {
            el.classList.remove('active');
        });
        document.getElementById('step' + step).classList.add('active');
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
                console.log(data); // Puoi gestire la risposta del server qui
                alert('Booking processed successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error processing your booking.');
            });
    }
</script>

<?php require 'components/footer.php'; ?>