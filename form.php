<?php require 'config/db.php';
require 'components/header.php';
$pdo = Database::getInstance();

// Recupera l'ID della categoria dalla query string
$categoria_id = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Recupera i dettagli della categoria
$stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
$stmt->execute([$categoria_id]);
$categoria = $stmt->fetch();

if (!$categoria) {
    echo "<div class='container'><p>Categoria non trovata.</p></div>";
    require 'components/footer.php';
    exit();
}
$categoria = $categoria['nome']; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/themes/default.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/themes/default.date.css">
<link rel="stylesheet" href="form.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.date.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<div class="container"></div>
<style>
    @media (min-width: 1025px) {
        .container {
            width: 60% !important;
            margin: 0 auto !important;
            /* Per centrare il contenitore */
        }

        .btn {
            transition: transform 0.3s ease;
            /* Transizione fluida */
        }

        .btn:hover {
            transform: scale(1.1);
            /* Ingrandisce il pulsante del 10% */
        }
    }
</style>
<div class="container mb-5">
    <h1 class="text-center text-gradient-custom font-weight-bold mb-4" style="font-size: 5rem;">
        <span id="category"> <?php echo $categoria ?> </span>
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
            <input type="text" name="category_id" id="category_id" value="<?php echo $categoria_id ?>" hidden>
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
                    class="btn btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
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

                <input type="radio" class="btn-check" name="time_of_day" id="morning" value="Morning" required>
                <label
                    class="btn btn-gradient-custom shadow-sm btn-block d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="morning">
                    <i class="fal fa-sunrise"></i>
                    <span class="mx-auto">MORNING</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="afternoon" value="Afternoon" required>
                <label
                    class="btn btn-gradient-custom shadow-sm btn-block mt-4 d-flex align-items-center justify-content-between"
                    onclick="nextStep(3)" for="afternoon">
                    <i class="fal fa-sun"></i>
                    <span class="mx-auto">AFTERNOON</span>
                </label>

                <input type="radio" class="btn-check" name="time_of_day" id="evening" value="Evening" required>
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

                <input type="radio" class="btn-check" name="duration" id="one_hour" value="1" required>
                <label class="btn btn-gradient-custom shadow-sm btn-block" onclick="nextStep(4)" for="one_hour">1
                    HOUR</label>

                <input type="radio" class="btn-check" name="duration" id="two_hours" value="2" required>
                <label class="btn btn-gradient-custom shadow-sm btn-block mt-4" onclick="nextStep(4)" for="two_hours">2
                    HOURS</label>

                <input type="radio" class="btn-check" name="duration" id="three_hours" value="3" required>
                <label class="btn btn-gradient-custom shadow-sm btn-block mt-4" onclick="nextStep(4)"
                    for="three_hours">3 HOURS</label>

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
                            onclick="setCustomDuration()">OK</button>
                    </div>
                </div>

                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(2)"><i
                        class="fal fa-chevron-left"></i> Previous</button>
            </div>

            <!-- Step 4: Scelta della data -->
            <div class="step d-none" id="step-4">
                <h4 class="text-dark">When?</h4>
                <input type="text" class="form-control" name="date" id="dateInput" required>

                <div class="form-check form-switch my-3">
                    <input class="form-check-input" type="checkbox" id="flexibleDateSwitch" name="flexible_date">
                    <label class="form-check-label flexible-date-label" for="flexibleDateSwitch">Is the date
                        flexible?</label>
                </div>

                <button type="button" class="btn btn-gradient-custom btn-block" id="nextStepBtn" onclick="nextStep(5)"
                    disabled>Almost done!</button>
                <button type="button" class="btn bg-transparent text-dark mt-5" onclick="prevStep(3)">
                    <i class="fal fa-chevron-left"></i> Previous
                </button>
            </div>
           <!-- Step 5: Dati del cliente -->
<div class="step d-none" id="step-5">
    <h4 class="text-dark">Last Steps</h4>
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control required-field" id="first_name" name="first_name" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control required-field" id="last_name" name="last_name" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" class="form-control required-field" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control required-field" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="note">Note</label>
        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
    </div>

    <!-- Pulsante Get your Price! -->
    <button type="button" class="btn btn-light btn-block" id="getPriceButton" onclick="submitStep()" disabled>
        <span class="btn btn-transparent btn-gradient-custom btn-block font-weight-bold"
            style="font-size:2rem!important">Get your Price!</span>
    </button>

    <button type="button" class="btn bg-transparent text-dark mt-3" onclick="prevStep(4)">
        <i class="fal fa-chevron-left"></i> Previous
    </button>
</div>



        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.date.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const getPriceButton = document.getElementById("getPriceButton");
        const requiredFields = document.querySelectorAll(".required-field");

        // Funzione per controllare se tutti i campi richiesti sono compilati
        function validateFields() {
            let allFieldsFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFieldsFilled = false;
                }
            });

            getPriceButton.disabled = !allFieldsFilled;
        }

        // Aggiungi un evento 'input' per ogni campo obbligatorio
        requiredFields.forEach(field => {
            field.addEventListener("input", validateFields);
        });

        // Esegui la convalida iniziale
        validateFields();
    });
    document.addEventListener("DOMContentLoaded", function () {
        // Inizializza Pickadate
        $('#dateInput').pickadate({
            format: 'yyyy-mm-dd',
            min: new Date(),
            onSet: function (context) {
                const nextStepBtn = document.getElementById('nextStepBtn');
                if (context.select) {
                    nextStepBtn.disabled = false;
                    nextStepBtn.classList.add("pulse");
                } else {
                    nextStepBtn.disabled = true;
                    nextStepBtn.classList.remove("pulse");
                }
            }
        });
    });

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

    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.querySelector("#phone");
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "auto",
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });
    });

    function showCustomDuration() {
        document.querySelector('.custom-duration').style.display = 'block';
    }

    // Imposta il valore personalizzato come 'duration' e passa al prossimo step
    function setCustomDuration() {
        const customDurationValue = document.getElementById('custom_duration').value;
        if (customDurationValue && !isNaN(customDurationValue) && customDurationValue > 0) {
            // Imposta il valore del radio con il valore personalizzato
            document.getElementById('custom_duration_radio').value = customDurationValue;
            document.getElementById('custom_duration_radio').checked = true; // Seleziona l'opzione
            nextStep(4); // Vai al passo successivo
        } else {
            alert("Please enter a valid custom duration.");
        }
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
            const selectedDuration = document.querySelector('input[name="duration"]:checked')?.value;
            const customDuration = document.getElementById('custom_duration').value;
            nextStepElement.style.opacity = 1; // Dissolvenza entrata step successivo

            // Aggiorna la barra di progresso
            updateProgressBar(step);
            currentStep = step;

            // Popola il riepilogo alla fine

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
<script>

</script>
<div class="container"></div>
<div class="container"></div>
<div class="container"></div>
<div class="container"></div>
<div class="container"></div>
<?php require 'components/footer.php'; ?>