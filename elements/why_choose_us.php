<style>
    .why-choose-us .card {
        position: relative;
        /* Posizionamento relativo per la card */
        overflow: hidden;
        /* Nascondere eventuali eccessi */
        padding-left: 60px;
        /* Spazio per l'icona */
        text-align: right;
        /* Allineamento del testo a destra */
    }

    .choose-icon {
        position: absolute;
        /* Posizionamento assoluto per la posizione dell'icona */
        left: -20px;
        /* Sposta l'icona a sinistra */
        width: 70px;
        /* Larghezza dell'icona */
        height: 100%;
        /* Altezza dell'icona */
        opacity: 0.7;
        display: flex;
        /* Usato per centrare l'icona */
        justify-content: center;
        /* Centratura orizzontale */
        align-items: center;
    }

    .choose-icon i {
        font-size: 5rem;
        /* Dimensione dell'icona */
        color: #ededed;
        /* Colore dell'icona */
    }
</style>
<section class="container py-1 why-choose-us mb-1">
    <div class="text-center mb-1">
        <h2 class="font-weight-bold">Why Choose Us</h2>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-4" style="text-align: right;">
                <!-- Rimosso text-center -->
                <div class="choose-icon">
                    <i class="p-2 fal fa-star text-gradient-custom"></i>
                </div>
                <p>All our photographers and videographers are highly rated experts, ensuring top-notch quality in every
                    shot.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4" style="text-align: right;">
                <!-- Rimosso text-center -->
                <div class="choose-icon">
                    <i class="p-2  fal fa-dollar-sign text-gradient-custom"></i>
                </div>
                <p>Our services are priced at fair market rates, reflecting our commitment to superior quality and
                    value.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4" style="text-align: right;">
                <!-- Rimosso text-center -->
                <div class="choose-icon">
                    <i class="p-2  fal fa-calendar-check text-gradient-custom"></i>
                </div>
                <p>Expect fast, on-time, and professional service every time you book with us.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-4" style="text-align: right;">
                <!-- Rimosso text-center -->
                <div class="choose-icon">
                    <i class=" p-2 fal fa-thumbs-up text-gradient-custom"></i>
                </div>
                <p>We offer a satisfaction guarantee or a free replacement, ensuring you receive only the best
                    experience.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4" style="text-align: right;">
                <!-- Rimosso text-center -->
                <div class="choose-icon">
                    <i class="p-2  fal fa-lock text-gradient-custom"></i>
                </div>
                <p>With the option to pay 80% post-shoot, we provide safe and convenient online payments.</p>
            </div>
        </div>
    </div>
</section>