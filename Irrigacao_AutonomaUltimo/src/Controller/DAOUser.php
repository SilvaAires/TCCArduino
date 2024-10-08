<?php 
    include_once __DIR__ .'/../Conexao/Conexao.php';
    include_once __DIR__ .'/../Model/User.php';
    include_once __DIR__ .'/../Controller/DAORegistro.php';
    include_once __DIR__ .'/../Model/Registro.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    class DAOUser{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertUser(User $User){
            $pstmt = $this->conexao->prepare("INSERT INTO user 
            (usuario, senha, cargo, email, telefone) VALUES 
            (?,?,?,?,?)");
            $pstmt->bindValue(1, $User->getUsuario());
            $pstmt->bindValue(2, $User->getSenha());
            $pstmt->bindValue(3, $User->getCargo());
            $pstmt->bindValue(4, $User->getEmail());
            $pstmt->bindValue(5, $User->getTelefone());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectAllUser(){
            $pstmt = $this->conexao->prepare("SELECT * FROM user");
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, User::class);
            return $lista;
        }
        public function deleteUser(){
            $idUser = $_POST['idUser'];
            $pstmt = $this->conexao->prepare("DELETE FROM user WHERE idUser = ?");
            $pstmt->bindValue(1, $idUser);
            unset($_SESSION["login"]);
            unset($_SESSION["senha"]);
            echo json_encode($pstmt->execute());
        }  
        public function updateUser(){
            $idUser = $_POST['idUser'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $cargo = $_POST['cargo'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];

            $pstmt = $this->conexao->prepare("UPDATE user SET usuario = ?, senha = ?,
            cargo = ?, email = ?, telefone = ?
            WHERE idUser = ?");
            $pstmt->bindValue(1, $usuario);
            $pstmt->bindValue(2, $senha);
            $pstmt->bindValue(3, $cargo);
            $pstmt->bindValue(4, $email);
            $pstmt->bindValue(5, $telefone);
            $pstmt->bindValue(6, $idUser);
            $_SESSION["login"] = $usuario;
            $_SESSION["senha"] = $senha;
            echo json_encode($pstmt->execute());
        }
        public function selectValidacaoLogin() {
            $login = $_POST['login'];
            $senha = $_POST['senha'];

            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM user 
                                              WHERE usuario = ? AND senha = ?");
            $pstmt->bindValue(1, $login);
            $pstmt->bindValue(2, $senha);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, User::class);
                $User = new User($lista[0]);
                $arrrayRegistro = array("fkUser" => $User->getIdUser());
                $registro = new Registro($arrrayRegistro);
                $DAORegistro = new DAORegistro();
                $DAORegistro->insertRegistro($registro);

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["idUser"] = $User->getIdUser();
                $_SESSION["login"] = $login;
                $_SESSION["senha"] = $senha;
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } 
        public function insertUserAjax(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $cargo = $_POST['cargo'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];

            $pstmt = $this->conexao->prepare("INSERT INTO user 
            (usuario, senha, cargo, email, telefone) VALUES 
            (?,?,?,?,?)");
            $pstmt->bindValue(1, $usuario);
            $pstmt->bindValue(2, $senha);
            $pstmt->bindValue(3, $cargo);
            $pstmt->bindValue(4, $email);
            $pstmt->bindValue(5, $telefone);
            $_SESSION["login"] = $usuario;
            $_SESSION["senha"] = $senha;
            echo json_encode($pstmt->execute());
        }
        public function selectAnotacao($login, $senha) {
            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM user 
                                              WHERE usuario = ? AND senha = ?");
            $pstmt->bindValue(1, $login);
            $pstmt->bindValue(2, $senha);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, User::class);
                $User = new User($lista[0]);
                return $User->getIdUser();
            } else {
                return 1;
            }
        } 
        public function selectExibePerfil() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $login = $_SESSION["login"];
            $senha = $_SESSION["senha"];

            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM user 
                                              WHERE usuario = ? AND senha = ?");
            $pstmt->bindValue(1, $login);
            $pstmt->bindValue(2, $senha);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, User::class);
                $User = new User($lista[0]);
                $response ='<div class="container mt-5">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="text-center">Dados do Usuário</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="userForm">
                                            <div class="form-group">
                                                <input type="hidden" name="idUser" id="idUser" value="'.$User->getIdUser().'">
                                                <label for="usuario">Usuário</label>
                                                <input type="text" id="usuario" name="usuario" class="form-control" value="'.$User->getUsuario().'">
                                            </div>
                                            <div class="form-group">
                                                <label for="senha">Senha</label>
                                                <input type="password" id="senha" name="senha" class="form-control" value="'.$User->getSenha().'">
                                            </div>
                                            <div class="form-group">
                                                <label for="cargo">Cargo</label>
                                                <input type="text" id="cargo" name="cargo" class="form-control" value="'.$User->getCargo().'">
                                            </div>
                                            <div class="form-group">
                                                <label for="criacao">Data de Criação</label>
                                                <input type="text" id="criacao" name="criacao" class="form-control" value="'.$User->getCriacao().'" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control" value="'.$User->getEmail().'">
                                            </div>
                                            <div class="form-group">
                                                <label for="telefone">Telefone</label>
                                                <input type="text" id="telefone" name="telefone" class="form-control" value="'.$User->getTelefone().'">
                                            </div>

                                            <!-- Botões -->
                                            <div class="text-center">
                                                <button type="button" class="btn btn-warning" onclick="editarDados()">Editar Dados</button>
                                                <button type="button" class="btn btn-danger" onclick="excluirConta()">Excluir Conta</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                
                echo $response;
            } else {
                echo "Erro ao Buscar";
            }
        } 
    }
?>