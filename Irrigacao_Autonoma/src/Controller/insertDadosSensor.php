<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $soil_moisture_percentage = $_POST['soil_moisture_percentage'];
    $soil_moisture = $_POST['soil_moisture'];
    $ident = $_POST['ident'];
    
    include_once __DIR__ ."../Model/DadoEsp.php";
    include_once __DIR__ ."../Controller/DAODadoEsp.php";

    $arrayDadoEsp = array("IdenEsp" => $ident,
                          "TempDoAr" => $temperature,
                          "UmidDoAr" => $humidity,
                          "PorUmidSolo" => $soil_moisture_percentage,
                          "UmidSolo" => $soil_moisture);
    
    $DAODadoEsp = new DAODadoEsp();
    $DadoEsp = new DadoEsp($arrayDadoEsp);
    $result = $DAODadoEsp->insertDadoEsp($DadoEsp);
   
    if ($result) {
      echo "Dado inserido com sucesso!";
  } 
  }

  /* 
  CREATE TABLE nome_da_tabela (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    temperature FLOAT NOT NULL,
    humidity FLOAT NOT NULL,
    soil_moisture FLOAT NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );
  else {
      $errorInfo = $result->errorInfo();
      echo "Erro ao inserir: " . $errorInfo[2];
  }
  */

?>
