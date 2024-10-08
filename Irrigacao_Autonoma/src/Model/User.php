<?php
    class User{
        private $idUser;
        private $usuario;
        private $senha;
        private $cargo;
        private $criacao;
        private $email;
        private $telefone;
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
        public function getIdUser(){
            return $this->idUser;
        } 
        public function setIdUser($idUser){
            return $this->idUser = $idUser;
        }
        public function getUsuario(){
            return $this->usuario;
        } 
        public function setUsuario($usuario){
            return $this->usuario = $usuario;
        }
        public function getSenha(){
            return $this->senha;
        } 
        public function setSenha($senha){
            return $this->senha = $senha;
        }
        public function getCargo(){
            return $this->cargo;
        } 
        public function setCargo($cargo){
            return $this->cargo = $cargo;
        }
        public function getCriacao(){
            return $this->criacao;
        } 
        public function setCriacao($criacao){
            return $this->criacao = $criacao;
        }
        public function getEmail(){
            return $this->email;
        } 
        public function setEmail($email){
            return $this->email = $email;
        }
        public function getTelefone(){
            return $this->telefone;
        } 
        public function setTelefone($telefone){
            return $this->telefone = $telefone;
        }
        public function __toString(){
            return "idUser: " . $this->idUser . 
                   " usuario: " . $this->usuario . 
                   " senha: " . $this->senha . 
                   " cargo: " . $this->cargo . 
                   " criacao: " . $this->criacao . 
                   " email: " . $this->email . 
                   " telefone: " . $this->telefone . 
                   "<br><br>";
        } 
    }
?>