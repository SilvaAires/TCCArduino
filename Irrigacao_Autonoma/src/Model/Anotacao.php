<?php
    class Anotacao{
        private $idAnotacao ;
        private $fkDdado;
        private $fkUser;
        private $Descricao;
        private $DataHora;
        private $Imagem;
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
        public function getIdAnotacao (){
            return $this->idAnotacao ;
        } 
        public function setIdAnotacao ($idAnotacao ){
            return $this->idAnotacao  = $idAnotacao ;
        }
        public function getFkDdado(){
            return $this->fkDdado;
        } 
        public function setFkDdado($fkDdado){
            return $this->fkDdado = $fkDdado;
        }
        public function getFkUser(){
            return $this->fkUser;
        } 
        public function setFkUser($fkUser){
            return $this->fkUser = $fkUser;
        }
        public function getDescricao(){
            return $this->Descricao;
        } 
        public function setDescricao($Descricao){
            return $this->Descricao = $Descricao;
        }
        public function getDataHora(){
            return $this->DataHora;
        } 
        public function setDataHora($DataHora){
            return $this->DataHora = $DataHora;
        }
        public function getImagem(){
            return $this->Imagem;
        } 
        public function setImagem($Imagem){
            return $this->Imagem = $Imagem;
        }
        public function __toString(){
            return "idAnotacao: " . $this->idAnotacao . 
                   " fkDdado: " . $this->fkDdado . 
                   " fkUser: " . $this->fkUser . 
                   " Descricao: " . $this->Descricao . 
                   " DataHora: " . $this->DataHora . 
                   " Imagem: " . $this->Imagem . 
                   "<br><br>";
        } 
    }
?>