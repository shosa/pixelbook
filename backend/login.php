<?php
require("config/config.php");
$alertTypes = [
    'success' => 'alert-success',
    'error' => 'alert-danger',
    'warning' => 'alert-warning',
    'info' => 'alert-info'
];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginMethod = $_POST['login_method'];
    $_SESSION['login_method'] = $loginMethod; // Memorizza il metodo di accesso usato
    $rememberMe = isset($_POST['remember_me']);

    // Login tramite email e password
    if ($loginMethod === "password") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verifica dell'utente tramite email e password
        $db = Database::getDatabaseInstance();
        $user = $db->verifyUser($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];

            // Imposta i cookie di sessione
            if ($rememberMe) {
                setcookie("user_id", $user['id'], time() + (7 * 24 * 60 * 60), "/");
                setcookie("user_email", $user['email'], time() + (7 * 24 * 60 * 60), "/");
            } else {
                setcookie("user_id", $user['id'], time() + (1 * 60 * 60), "/");
                setcookie("user_email", $user['email'], time() + (1 * 60 * 60), "/");
            }

            header("Location: index");
            exit();
        } else {
            $_SESSION['error'] = "Credenziali non valide!";
        }
    }

    // Login tramite PIN
    elseif ($loginMethod === "pin") {
        if (isset($_POST['pin_digit'])) {
            $pin = implode('', $_POST['pin_digit']);
        } else {
            $pin = null;
        }

        // Verifica dell'utente tramite PIN
        if ($pin) {
            $db = Database::getDatabaseInstance();
            $user = $db->getUserByPin($pin);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];

                // Imposta i cookie di sessione
                if ($rememberMe) {
                    setcookie("user_id", $user['id'], time() + (7 * 24 * 60 * 60), "/");
                    setcookie("user_email", $user['email'], time() + (7 * 24 * 60 * 60), "/");
                } else {
                    setcookie("user_id", $user['id'], time() + (1 * 60 * 60), "/");
                    setcookie("user_email", $user['email'], time() + (1 * 60 * 60), "/");
                }

                header("Location: index");
                exit();
            } else {
                $_SESSION['error'] = "Pin non valido!";
            }
        } else {
            $_SESSION['error'] = "Pin mancante o incompleto!";
        }
    }
}
?>
<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PixelShoot - Login</title>
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

<body class="d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <h1>Pixel<span class="text-info">Shoot</span> [<span class="text-success">Admin</span> Console]</h1>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login</h2>

                    <!-- Switch login method buttons -->
                    <div class="btn-group w-100 mb-3">
                        <button id="loginWithPasswordBtn" class="btn btn-primary w-50"
                            onclick="showPasswordLogin()">Accedi con Password</button>
                        <button id="loginWithPinBtn" class="btn btn-outline-primary w-50"
                            onclick="showPinLogin()">Accedi con PIN</button>
                    </div>

                    <form id="passwordLoginForm" action="login" method="post" autocomplete="off" novalidate>
                        <input type="hidden" name="login_method" value="password">
                        <div class="mb-3">
                            <label class="form-label">Indirizzo E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="tua@email.com"
                                autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                autocomplete="off">
                        </div>
                        <div class="mb-2 mt-3">
                            <?php foreach ($alertTypes as $key => $class) {
                                if (isset($_SESSION[$key])) {
                                    echo '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">';
                                    echo htmlspecialchars($_SESSION[$key]);
                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                    echo '</div>';
                                  
                                  
                                }
                            } ?>
                            <label class="form-check">
                                <input type="checkbox" name="remember_me" class="form-check-input" />
                                <span class="form-check-label">Ricordami su questo dispositivo</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Accedi</button>
                        </div>
                    </form>

                    <!-- Form di accesso con PIN -->
                    <form id="pinLoginForm" action="login" method="post" style="display: none;" autocomplete="off"
                        novalidate>
                        <input type="hidden" name="login_method" value="pin">
                        <div class="my-5">
                            <div class="row g-4">
                                <div class="col">
                                    <div class="row g-2">
                                        <?php for ($i = 0; $i < 8; $i++): ?>
                                            <div class="col">
                                                <input type="text" name="pin_digit[]"
                                                    class="form-control form-control-lg text-center py-3" maxlength="1"
                                                    inputmode="numeric" pattern="[0-9]*" data-pin-input>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 mt-3">
                            <?php foreach ($alertTypes as $key => $class) {
                                if (isset($_SESSION[$key])) {
                                    echo '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">';
                                    echo htmlspecialchars($_SESSION[$key]);
                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                    echo '</div>';
                                    // Rimuove il messaggio dalla sessione per evitare di visualizzarlo di nuovo
                                    unset($_SESSION[$key]);
                                }
                            } ?>
                            <label class="form-check">
                                <input type="checkbox" name="remember_me" class="form-check-input" />
                                <span class="form-check-label">Ricordami su questo dispositivo</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Accedi con PIN</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showPasswordLogin() {
            document.getElementById('passwordLoginForm').style.display = 'block';
            document.getElementById('pinLoginForm').style.display = 'none';
            document.getElementById('loginWithPasswordBtn').classList.add('btn-primary');
            document.getElementById('loginWithPinBtn').classList.remove('btn-primary');
        }

        function showPinLogin() {
            document.getElementById('passwordLoginForm').style.display = 'none';
            document.getElementById('pinLoginForm').style.display = 'block';
            document.getElementById('loginWithPasswordBtn').classList.remove('btn-primary');
            document.getElementById('loginWithPinBtn').classList.add('btn-primary');
        }

        // Auto-tab functionality for PIN inputs
        document.addEventListener("DOMContentLoaded", function () {
            const pinInputs = document.querySelectorAll('[data-pin-input]');
            pinInputs.forEach((input, index) => {
                input.addEventListener('input', function () {
                    if (input.value.length === 1 && index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                        pinInputs[index - 1].focus();
                    }
                });
            });

            const loginMethod = "<?php echo $_SESSION['login_method'] ?? 'password'; ?>";
            if (loginMethod === 'pin') {
                showPinLogin();
            } else {
                showPasswordLogin();
            }
        });

    </script>

    <?php include("components/footer.php"); ?>