<?php
ob_start(); // Inizia il buffer di output
require("../../config/config.php");
include(BASE_PATH . "/components/header.php");

$pdo = Database::getInstance();
include("dataset.php");
?>

<div class="page-wrapper">

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                <div class="mb-1">
                        <ol class="breadcrumb" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="../../index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="index">Database</a></li>

                        </ol>
                    </div>
                    <h2 class="page-title">Gestione Database</h2>
                    <p class="text-muted">Cerca e correggi errori nella struttura del database.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Controllo Struttura Database</h3>
                    <button class="btn rounded-pill shadow-sm" id="checkDatabase">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-database-search text-info">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                            <path d="M4 6v6c0 1.657 3.582 3 8 3m8 -3.5v-5.5" />
                            <path d="M4 12v6c0 1.657 3.582 3 8 3" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M20.2 20.2l1.8 1.8" />
                        </svg>
                        Avvia Controllo
                    </button>
                </div>
                <div class="card-body">
                 
                    <div class="progress mt-4" style="height: 25px;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                            style="width: 0%;">
                            <span id="progressText">0%</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4>Console Log</h4>
                        <pre id="consoleLog" class="bg-dark text-white p-3 rounded" style="overflow-y: auto;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(BASE_PATH . "/components/footer.php"); ?>

    <script>
        // Configurazione struttura database
        const desiredStructure = <?php echo json_encode($desiredStructure); ?>;
        const versione = "<?php echo $versione; ?>";

        document.getElementById('checkDatabase').addEventListener('click', function () {
            const consoleLog = document.getElementById('consoleLog');
            consoleLog.innerHTML = `<span style="color: cyan;">========= Inizio controllo database =========</span><br>`;
            consoleLog.innerHTML += `<span style="color: lightgreen;">Dataset Versione del:</span> <strong style="color: yellow;">${versione}</strong><br>`;
            consoleLog.innerHTML += `<span style="color: white;" class="badge badge-success bg-success">Database Connesso!</span><br>`;
            consoleLog.innerHTML += `<span style="color: cyan;">==========================================</span><br><br>`;

            let progress = 0;
            updateProgress(progress);

            // Funzione asincrona per il controllo e la correzione
            async function checkDatabaseStructure() {
                for (const [table, details] of Object.entries(desiredStructure)) {
                    await checkTable(table, details);
                    progress += 100 / Object.keys(desiredStructure).length;
                    updateProgress(progress);
                }
                consoleLog.innerHTML += `<br><span style="color: cyan;">=========================================</span>`;
                consoleLog.innerHTML += `<br><span style="color: lightgreen;"><strong>CONTROLLO E CORREZIONE COMPLETATO.</strong></span><br>`;
            }

            // Controlla e corregge una tabella
            async function checkTable(table, details) {
                consoleLog.innerHTML += `<br><span style="color: orange;">---------------------------------------</span><br>`;
                consoleLog.innerHTML += `<span style="color: lightblue;">Controllo tabella:</span> <strong style="color: yellow;">${table}</strong><br>`;

                try {
                    const response = await fetch(`checkTable.php?table=${table}&details=${encodeURIComponent(JSON.stringify(details))}`);
                    const result = await response.json();

                    consoleLog.innerHTML += `<span style="color: lightgreen;">Tabella "${table}":</span> <strong>${result.message}</strong><br>`;
                    if (result.corrections.length > 0) {
                        consoleLog.innerHTML += `<span style="color: lightblue;">Correzioni effettuate:</span><br>`;
                        result.corrections.forEach(correction => {
                            consoleLog.innerHTML += `<span style="color: yellow;">- ${correction}</span><br>`;
                        });
                    }
                } catch (error) {
                    consoleLog.innerHTML += `<span style="color: red;"><strong>Errore con la tabella "${table}":</strong> ${error.message}</span><br>`;
                }
            }

            // Aggiorna la barra di progresso
            function updateProgress(value) {
                const progressBar = document.getElementById('progressBar');
                const progressText = document.getElementById('progressText');
                progressBar.style.width = value + '%';
                progressText.textContent = Math.round(value) + '%';
            }

            // Avvia il controllo
            checkDatabaseStructure();
        });
    </script>

</div>