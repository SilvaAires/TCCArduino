<?php
    include_once 'DAOAnotacao.php';
    include_once 'DAODadoEsp.php';
    include_once 'DAORegistro.php';
    include_once 'DAOUser.php';

    $classe1 = new DAOAnotacao();
    $classe2 = new DAODadoEsp();
    $classe3 = new DAORegistro();
    $classe4 = new DAOUser();

    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        if(method_exists($classe1, $metodo)){
            $classe1->$metodo();
        }else{
            if(method_exists($classe2, $metodo)){
                $classe2->$metodo();
            }else{
                if(method_exists($classe3, $metodo)){
                    $classe3->$metodo();
                }else{
                    if(method_exists($classe4, $metodo)){
                        $classe4->$metodo();
                    }else{
                        die("Método $metodo não existe.");
                    }
                }
            }
        }
    }
?>