<?php
    include_once __DIR__ . '/../Controller/DAODadoEsp.php';
    include_once __DIR__ . '/../Rotas/Constantes.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["login"]) && !isset($_SESSION["senha"])){
        header("Location: ".HOME."Login");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?=HOME?>src/View/Css/estilo.css">
</head>
<body onload="selectPerfil(); selectRegistroLogin();">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="<?=HOME?>Home">Menu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HOME?>Graficos">Gráficos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HOME?>GerarPDF">Gerar PDF</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HOME?>Anotacao_Historico">Histórico de Anotação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HOME?>Perfil">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=HOME?>Sair">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <div id="pasteHere">

    </div>
      
    <div id="pasteHere2">
                        
    </div>

    <script src="<?=HOME?>src/View/Js/jquery-3.7.1.min.js"></script>
    <script src="<?=HOME?>src/View/Js/toast.js"></script>
    <script src="<?=HOME?>src/View/Js/comandosAjax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>