<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PixelShoot</title>
    <!-- CSS files -->
    <link href="<?php echo BASE_URL ?>/dist/css/tabler.min.css?1692870487" rel="stylesheet" />

    <link href="<?php echo BASE_URL ?>/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet" />
    <link href="<?php echo BASE_URL ?>/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet" />
    <link href="<?php echo BASE_URL ?>/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
    <link href="<?php echo BASE_URL ?>/dist/css/demo.min.css?1692870487" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>


<body>
    <script src="<?php echo BASE_URL ?>/dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="#">
                        Pixel<span class="text-info">Shoot</span> [<span class="text-success">Admin</span> Console]
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">

                    <div class="d-none d-md-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <!-- INIZIO SEZIONE GESTIONE NOTIFICHE -->
                        <?php
                        $pdo = Database::getInstance();
                        $user_id = $_SESSION['user_id'] ?? 1;
                        $stmt = $pdo->prepare("SELECT * FROM notifiche WHERE user_id = :user_id AND nascosta = 0 ORDER BY data_creazione DESC");
                        $stmt->execute(['user_id' => $user_id]);
                        $notifiche = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $haNotifiche = count($notifiche) > 0;
                        ?>
                        <style>
                            .list-group-item a {
                                text-decoration: none !important;
                            }

                            .list-group-item a:hover {
                                text-decoration: none !important;
                            }
                        </style>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                aria-label="Show notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red <?= $haNotifiche ? '' : 'd-none' ?>"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Notifiche</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <?php foreach ($notifiche as $notifica): ?>
                                            <div class="list-group-item" id="notifica-<?= $notifica['id'] ?>">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <?php
                                                        // Colore del pallino in base alla priorità
                                                        $statusColor = 'bg-secondary';
                                                        if ($notifica['priorita'] === 'alta') {
                                                            $statusColor = 'bg-red';
                                                        } elseif ($notifica['priorita'] === 'media') {
                                                            $statusColor = 'bg-yellow';
                                                        } elseif ($notifica['priorita'] === 'bassa') {
                                                            $statusColor = 'bg-green';
                                                        }
                                                        ?>
                                                        <span
                                                            class="status-dot status-dot-animated <?= $statusColor ?> d-block"></span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <a href="<?= BASE_URL . htmlspecialchars($notifica['link']) ?>"
                                                            class="text-body d-block">
                                                            <span><?= htmlspecialchars($notifica['titolo']) ?></span>
                                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                                <?= htmlspecialchars($notifica['descrizione']) ?>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="#" onclick="segnalaLetta(<?= $notifica['id'] ?>, event)"
                                                            class="list-group-item-actions">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon text-primary" width="24" height="24"
                                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                                                <path
                                                                    d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                                                <path d="M3 3l18 18" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function segnalaLetta(notificaId, event) {
                                // Previene la propagazione del clic sul link principale
                                event.preventDefault();
                                event.stopPropagation();

                                fetch('<?php echo BASE_URL . "/utils/markRead"; ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'notifica_id=' + notificaId
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            console.log('Notifica segnata come letta');
                                            // Rimuove l'elemento della notifica dalla pagina
                                            const notificaElement = document.getElementById('notifica-' + notificaId);
                                            if (notificaElement) {
                                                notificaElement.remove();
                                            }
                                        } else {
                                            console.error('Errore durante la segnalazione della notifica');
                                        }
                                    })
                                    .catch(error => console.error('Errore nella richiesta:', error));
                            }
                        </script>
                        <!-- FINE SEZIONE GESTIONE NOTIFICHE -->
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"><svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size"
                                    x-bind:height="size" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    x-bind:stroke-width="stroke" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2">
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                </svg></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?php echo $_SESSION['username']; ?></div>
                                <div class="mt-1 small text-secondary">Backend</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="<?php echo BASE_PATH; ?>/logout" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Navbar -->
        <?php include("menu.php") ?>