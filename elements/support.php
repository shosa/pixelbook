<style>
    /* Pulsante WhatsApp fluttuante */
    .whatsapp-button {
        position: fixed;
        bottom: 5%;
        right: 2%;
        width: 60px;
        height: 60px;
        background-color: #25D366;
        border-radius: 50%;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .whatsapp-button a {
        color: white;
        font-size: 28px;
        line-height: 1;
        text-decoration: none;
        z-index: 10;
    }

    /* Cerchi di irradiazione */
    .whatsapp-button::before,
    .whatsapp-button::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid #25D366;
        border-radius: 50%;
        opacity: 0;
        animation: pulse 2s infinite;
    }

    .whatsapp-button::after {
        animation-delay: 1s;
        /* Ritardo per creare un effetto a doppio cerchio */
    }

    /* Animazione dei cerchi */
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        50% {
            opacity: 0.4;
        }

        100% {
            transform: scale(2.5);
            opacity: 0;
        }
    }
</style>
<div class="whatsapp-button">
    <a href="https://wa.me/393206397274" target="_blank" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>