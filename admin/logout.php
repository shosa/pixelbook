<?php
session_start();
session_unset();
session_destroy();

// Cancella i cookie
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_email", "", time() - 3600, "/");

header("Location: login");
exit();
