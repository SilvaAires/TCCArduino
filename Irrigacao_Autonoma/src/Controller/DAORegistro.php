<?php 
    include_once __DIR__ .'/../Conexao/Conexao.php';
    include_once __DIR__ .'/../Model/Registro.php';
    class DAORegistro{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertRegistro(Registro $Registro){
            $pstmt = $this->conexao->prepare("INSERT INTO registrologin 
            (fkUser) VALUES (?)");
            $pstmt->bindValue(1, $Registro->getFkUser());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectAllRegistro(){
            $pstmt = $this->conexao->prepare("SELECT * FROM registrologin");
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Registro::class);
            return $lista;
        }
        public function deleteRegistro($idRegistro){
            $pstmt = $this->conexao->prepare("DELETE FROM registrologin WHERE idRegistro = ?");
            $pstmt->bindValue(1, $idRegistro);
            $pstmt->execute();
            return $pstmt;
        }  
        public function updateRegistro(Registro $Registro){
            $pstmt = $this->conexao->prepare("UPDATE registrologin SET fkUser = ?, DataHoraLogin = ?
            WHERE idRegistro = ?");
            $pstmt->bindValue(1, $Registro->getFkUser());
            $pstmt->bindValue(2, $Registro->getDataHoraLogin());
            $pstmt->bindValue(3, $Registro->getIdRegistro());
            $pstmt->execute();
            return $pstmt;
        } 
        public function selectRegistroLogin() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $idUser = $_SESSION["idUser"];
            $login = $_SESSION["login"];

            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM registrologin 
                                              WHERE fkUser = ?");
            $pstmt->bindValue(1, $idUser);
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Registro::class);
            $response = '<div class="container mt-5">
                            <div class="card-header bg-primary text-white">
                                <h4 class="text-center">Registro de Login</h4>
                            </div>
                            <div class="row">'; // Início da estrutura da grid

            foreach ($lista as $index => $Registro) {
                $Registro = new Registro($Registro);

                // Abrindo uma coluna para cada card
                $response .= '<div class="col-md-4 mb-4"> 
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="idUserRegistro">IdUser: ' . $idUser . '</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="loginRegistro">Login: ' . $login . '</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="DataHoraLoginRegistro">Data: ' . $Registro->getDataHoraLogin() . '</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>'; // Fechando a coluna

                // A cada 3 elementos, fechar e abrir uma nova linha
                if (($index + 1) % 3 == 0) {
                    $response .= '</div><div class="row">'; // Fechar a linha atual e abrir outra
                }
            }

            $response .= '</div></div>'; // Fechar a última linha e o container
            echo $response;
        }
    }
?>