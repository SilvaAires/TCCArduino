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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?=HOME?>src/View/Css/estilo.css">
</head>
<body>
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

    <div class="container mt-5">
        <h1 class="text-center">DashBoard</h1>
        <br>

        <div class="form-group text-center">
            <label for="combobox" class="d-block"><b>Ordenar a pesquisa por:</b></label>
            <div class="d-flex justify-content-center align-items-center">
                <select id="combobox" name="options" class="form-control w-auto text-center mr-2">
                    <option id="ordem" value="IdDado DESC" checked>Capturas recentes</option>
                    <option id="ordem" value="IdDado ASC">Capturas antigas</option>
                    <option id="ordem" value="TempDoAr DESC">Maior temperatura</option>
                    <option id="ordem" value="TempDoAr ASC">Menor temperatura</option>
                    <option id="ordem" value="UmidDoAr DESC">Maior umidade do ar</option>
                    <option id="ordem" value="UmidDoAr ASC">Menor umidade do ar</option>
                    <option id="ordem" value="PorUmidSolo DESC">Maior umidade do solo</option>
                    <option id="ordem" value="PorUmidSolo ASC">Menor umidade do solo</option>
                </select>
                
            </div>
            <button id="btnBuscarTodos" class="btn btn-secondary">Buscar Todos Dados</button>
        </div>

        <br>

        <div class="form-group text-center">
            <label for="pesquisar"><b>Pesquisar entre as datas:</b></label>
            <div class="form-row justify-content-center">
                <div class="col-md-3">
                    <label for="diaInicio">No dia</label>
                    <input type="date" id="diaInicio" name="diaInicio" class="form-control text-center" required>
                </div>
                <div class="col-md-3">
                    <label for="diaFinal">até o dia</label>
                    <input type="date" id="diaFinal" name="diaFinal" class="form-control text-center" required>
                </div>
                <div class="col-md-3">
                    <label for="horaInicio">às</label>
                    <input type="time" id="horaInicio" name="horaInicio" class="form-control text-center" required>
                </div>
                <div class="col-md-3">
                    <label for="horaFinal">até às</label>
                    <input type="time" id="horaFinal" name="horaFinal" class="form-control text-center" required>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button id="btnProcurar" class="btn btn-primary mt-2">Procurar</button>
        </div>

        <div id="pasteHere" class="mt-4"></div>
    </div>

    <script src="<?=HOME?>src/View/Js/jquery-3.7.1.min.js"></script>
    <script src="<?=HOME?>src/View/Js/toast.js"></script>
    <script src="<?=HOME?>src/View/Js/comandosAjax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
