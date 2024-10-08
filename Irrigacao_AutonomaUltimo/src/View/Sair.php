<?php
    include_once __DIR__ . '/../Rotas/Constantes.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION["login"]);
    unset($_SESSION["senha"]);
    unset($_SESSION["idUser"]);

    header("Location: ".HOME."Login");
    exit();
?>