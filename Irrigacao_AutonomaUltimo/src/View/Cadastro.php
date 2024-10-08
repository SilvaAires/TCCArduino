<?php
    include_once __DIR__ . '/../Controller/DAODadoEsp.php';
    include_once __DIR__ . '/../Rotas/Constantes.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
        <h1 class="text-center">Cadastro</h1>
        <br>

        <div class="form-group text-center">
            <label for="pesquisar"><b>Indetificadores</b></label>
            <div class="form-row justify-content-center">
                <div class="col-md-3">
                    <label for="usuario">Usuário</label>
                    <input type="text" name="usuario" id="usuario" class="form-control">

                    <label for="senha">Senha</label>
                    <input type="text" id="senha" name="senha" class="form-control">

                    <label for="cargo">Cargo</label>
                    <input type="text" id="cargo" name="cargo" class="form-control">

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control">

                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button id="btnCadastrar" name="btnCadastrar" class="btn btn-primary mt-2">Entrar</button>
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