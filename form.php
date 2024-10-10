<?php require 'config/db.php';
require 'components/header.php';
$categoria = isset($_GET['category']) ?
    htmlspecialchars($_GET['category']) : ''; ?>
<link rel="stylesheet" href="form.css">
<div class="container ">
    <h1 class="text-center text-gradient-custom font-weight-bold mb-4" style="font-size: 5rem;">
        <span id="category" > <?php echo $categoria ?> </span>
    </h1>
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
    <h5 class="text-center text-dark mb-1">Get your price in 5 simple steps</h5>
    <div class="container">
        <!-- Form a step -->
        <form id="multiStepForm">
            <input type="text" name="category" value="<?php echo $categoria ?>" hidden>

            <!-- Step 1: Scelta del servizio -->
            <div class="step" id="step-1">
                <h4 class="text-dark">What are you looking for?</h4>
                <input type="radio" class="btn-check" name="service" id="photo" value="Photo" required>
                <label
                    class="btn btn-block d-flex align-items-center justify-content-between btn-gradient-custom shadow-sm"
                    onclick="nextStep(2)" for="photo">
                    <i class="fal fa-image "></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">PHOTO</span> <!-- testo centrato -->
                </label>


                <input type="radio" class="btn-check" name="service" id="video" value="Video" required>
                <label
                    class="btn  btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(2)" for="video">
                    <i class="fal fa-video"></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">VIDEO</span> <!-- testo centrato -->
                </label>

                <input type="radio" class="btn-check" name="service" id="photo_video" value="Photo & Video" required>
                <label
                    class="btn  btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(2)" for="photo_video">
                    <i class="fal fa-photo-video"></i> <!-- icona all'inizio a sinistra -->
                    <span class="mx-auto">PHOTO & VIDEO</span> <!-- testo centrato -->
                </label>

            </div>

            <!-- Step 2: Scelta del momento del giorno -->
            <div class="step d-none" id="step-2">

                <h4 class="text-dark">What time?</h4>

                <input type="radio" class="btn-check" name="time_of_day" id="morning" value="Mattina" required>
                <label
                    class="btn btn-gradient-custom shadow-sm btn-block d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="morning">
                    <i class="fal fa-sunrise"></i>
                    <span class="mx-auto">MORNING</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="afternoon" value="Pomeriggio" required>
                <label
                    class="btn btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="afternoon">
                    <i class="fal fa-sun"></i>
                    <span class="mx-auto">AFTERNOON</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="evening" value="Sera" required>
                <label
                    class="btn btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
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
                <label class="btn btn-gradient-custom shadow-sm btn-block" onclick="nextStep(4)" for="one_hour">1
                    HOUR</label>

                <input type="radio" class="btn-check" name="duration" id="two_hours" value="2 Ore" required>
                <label class="btn btn-gradient-custom shadow-sm btn-block mt-4" onclick="nextStep(4)" for="two_hours">2
                    HOURS</label>

                <input type="radio" class="btn-check" name="duration" id="three_hours" value="3 Ore" required>
                <label class="btn btn-gradient-custom shadow-sm btn-block mt-4" onclick="nextStep(4)"
                    for="three_hours">3
                    HOURS</label>
                <input type="radio" class="btn-check" name="duration" id="custom_duration_radio" value="Custom"
                    required>
                <label class="btn text-gradient-custom font-weight-bold btn-block mt-4" for="custom_duration_radio"
                    onclick="showCustomDuration()">CUSTOM DURATION</label>
                <div class="form-group custom-duration">
                    <label for="custom_duration">ENTER HOURS:</label>
                    <div class="input-group">
                        <input type="number" id="custom_duration" name="custom_duration" class="form-control"
                            placeholder="Es. 5" aria-label="Durata personalizzata">
                        <button class="btn btn-gradient-custom shadow-sm"
                            style="border-radius: 0 0.35rem 0.35rem  0 !important;" type="button"
                            onclick="nextStep(4)">OK</button>
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
                <button type="button" class="btn btn-gradient-custom btn-block" id="nextStepBtn"
                    style="font-size:2rem!important" onclick="nextStep(5)" disabled>Get your Quote</button>
                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(3)">
                    <i class="fal fa-chevron-left"></i> Previous
                </button>
            </div>

            <!-- Step 5: Riepilogo -->
            <div class="step d-none" id="step-5">
                <h2 class="text-gradient-custom mb-4 text-center">Is this correct?</h2>
                <div class="container summary-container bg-gradient-custom shadow-lg">
                    <h2 class="summary-title text-white mb-4">Booking Details</h2>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="text-white">Category:</strong>
                                </td>
                                <td>
                                    <span id="summary-category" class="text-white"></span>
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
                        <span class="text-gradient-custom font-weight-bold">GET YOUR QUOTE</span>
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
            nextStepBtn.classList.add("pulse");
        } else {
            nextStepBtn.disabled = true; // Disabilita il pulsante se la data non è selezionata
            nextStepBtn.classList.remove("pulse");
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
                document.getElementById('summary-category').textContent = document.getElementById('category').textContent;
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

    function submitStep() {
    const form = document.getElementById('multiStepForm');
    const formData = new FormData(form);

    // Invia i dati usando fetch
    fetch('offer.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (response.ok) {
            return response.text(); // o response.json() se aspettati un JSON
        }
        throw new Error('Errore nella risposta dalla rete');
    })
    .then(data => {
        // Puoi gestire la risposta qui, ad esempio reindirizzando alla pagina di conferma
        // Se offer.php reindirizza a un'altra pagina, potresti doverlo gestire
        // come un reindirizzamento client-side
        document.open();
        document.write(data); // Visualizza la risposta ricevuta (ad esempio, il contenuto di offer.php)
        document.close();
    })
    .catch(error => {
        console.error('Errore:', error);
    });
}
</script>

<?php require 'components/footer.php'; ?>