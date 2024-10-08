<?php
    class DadoEsp{
        private $IdDado ;
        private $IdenEsp;
        private $TempDoAr;
        private $UmidDoAr;
        private $PorUmidSolo;
        private $UmidSolo;
        private $DataCaptura;
        private $HoraCaptura;
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
        public function getIdDado (){
            return $this->IdDado ;
        } 
        public function setIdDado ($IdDado ){
            return $this->IdDado  = $IdDado ;
        }
        public function getIdenEsp(){
            return $this->IdenEsp;
        } 
        public function setIdenEsp($IdenEsp){
            return $this->IdenEsp = $IdenEsp;
        }
        public function getTempDoAr(){
            return $this->TempDoAr;
        } 
        public function setTempDoAr($TempDoAr){
            return $this->TempDoAr = $TempDoAr;
        }
        public function getUmidDoAr(){
            return $this->UmidDoAr;
        } 
        public function setUmidDoAr($UmidDoAr){
            return $this->UmidDoAr = $UmidDoAr;
        }
        public function getPorUmidSolo(){
            return $this->PorUmidSolo;
        } 
        public function setPorUmidSolo($PorUmidSolo){
            return $this->PorUmidSolo = $PorUmidSolo;
        }
        public function getUmidSolo(){
            return $this->UmidSolo;
        } 
        public function setUmidSolo($UmidSolo){
            return $this->UmidSolo = $UmidSolo;
        }
        public function getDataCaptura(){
            return $this->DataCaptura;
        } 
        public function setDataCaptura($DataCaptura){
            return $this->DataCaptura = $DataCaptura;
        }
        public function getHoraCaptura(){
            return $this->HoraCaptura;
        } 
        public function setHoraCaptura($HoraCaptura){
            return $this->HoraCaptura = $HoraCaptura;
        }
        public function __toString(){
            return "IdDado: " . $this->IdDado  . 
                   " IdenEsp: " . $this->IdenEsp . 
                   " TempDoAr: " . $this->TempDoAr . 
                   " UmidDoAr: " . $this->UmidDoAr . 
                   " PorUmidSolo: " . $this->PorUmidSolo . 
                   " UmidSolo: " . $this->UmidSolo . 
                   " DataCaptura: " . $this->DataCaptura . 
                   " HoraCaptura: " . $this->HoraCaptura . 
                   "<br><br>";
        } 
    }
?>