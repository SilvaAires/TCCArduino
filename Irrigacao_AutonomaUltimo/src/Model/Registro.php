<?php
    class Registro{			
        private $idRegistro;
        private $fkUser;
        private $DataHoraLogin;
        public function __construct(){
            if (func_num_args() != 0) {
                $atributos = func_get_args()[0];
                foreach ($atributos as $atributo => $valor) {
                    if(isset($valor) && property_exists(get_class($this), $atributo)){
                        $this->$atributo = $valor;
                    }    			
                }
            }
        }
        function atualizar($atributos) {
            foreach ($atributos as $atributo => $valor) {
                if(isset($valor) && property_exists(get_class($this), $atributo)){            	
                    $this->$atributo = $valor;
                }
            }
        }
        public function getIdRegistro(){
            return $this->idRegistro;
        } 
        public function setIdRegistro($idRegistro){
            return $this->idRegistro = $idRegistro;
        }
        public function getFkUser(){
            return $this->fkUser;
        } 
        public function setFkUser($fkUser){
            return $this->fkUser = $fkUser;
        }
        public function getDataHoraLogin(){
            return $this->DataHoraLogin;
        } 
        public function setDataHoraLogin($DataHoraLogin){
            return $this->DataHoraLogin = $DataHoraLogin;
        }
        public function __toString(){
            return "idRegistro: " . $this->idRegistro . 
                   " fkUser: " . $this->fkUser . 
                   " DataHoraLogin: " . $this->DataHoraLogin . 
                   "<br><br>";
        } 
    }
?>