<?php 
    include_once __DIR__ .'/../Conexao/Conexao.php';
    include_once __DIR__ .'/../Model/Anotacao.php';
    include_once __DIR__ .'/../Controller/DAOUser.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    class DAOAnotacao{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertAnotacao(Anotacao $Anotacao){
            $pstmt = $this->conexao->prepare("INSERT INTO anotacaodados 
            (fkDdado, fkUser, Descricao, Imagem) VALUES 
            (?,?,?,?)");
            $pstmt->bindValue(1, $Anotacao->getFkDdado());
            $pstmt->bindValue(2, $Anotacao->getFkUser());
            $pstmt->bindValue(3, $Anotacao->getDescricao());
            $pstmt->bindValue(4, $Anotacao->getImagem());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectAllAnotacao(){
            $pstmt = $this->conexao->prepare("SELECT * FROM anotacaodados");
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Anotacao::class);
            return $lista;
        }
        public function deleteAnotacao($idAnotacao){
            $pstmt = $this->conexao->prepare("DELETE FROM anotacaodados WHERE idAnotacao = ?");
            $pstmt->bindValue(1, $idAnotacao);
            $pstmt->execute();
            return $pstmt;
        }  
        public function updateAnotacao(Anotacao $Anotacao){
            $pstmt = $this->conexao->prepare("UPDATE anotacaodados SET fkDdado = ?, Descricao = ?
            WHERE idAnotacao = ?");
            $pstmt->bindValue(1, $Anotacao->getFkDdado());
            $pstmt->bindValue(2, $Anotacao->getDescricao());
            $pstmt->bindValue(3, $Anotacao->getIdAnotacao());
            $pstmt->execute();
            return $pstmt;
        } 
        public function insertAnotacaoAjax(){
            if (isset($_POST['descricao']) && isset($_FILES['file']) && isset($_POST['idDado'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $descricao = $_POST['descricao'];
                $idDado = $_POST['idDado'];

                // Pasta onde o arquivo será salvo
                $target_dir = "src/View/ImagensAnotacao/";
                // Caminho completo do arquivo
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
            
                // Verifica se $uploadOk é 0 por causa de um erro
                if ( 0 < $_FILES['file']['error'] ) {
                    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
                } else{
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                        //echo "O arquivo " . htmlspecialchars(basename($_FILES["fileIMG"]["name"])) . " foi enviado.";
                        
                        $DAOUser = new DAOUser();
                        $login2 = $_SESSION["login"];
                        $senha2 = $_SESSION["senha"];
                        $idRetorno = $DAOUser->selectAnotacao($login2, $senha2);

                        $pstmt = $this->conexao->prepare("INSERT INTO anotacaodados (fkDdado, fkUser, Descricao, Imagem) 
                                                          VALUES (?,?,?,?)");
                        $pstmt->bindValue(1, $idDado);
                        $pstmt->bindValue(2, $idRetorno);
                        $pstmt->bindValue(3, $descricao);
                        $pstmt->bindValue(4, $target_file);
                        $pstmt->execute();
                        echo json_encode(true);
                    }else {
                        echo json_encode("Desculpe, houve um erro ao enviar seu arquivo."); 
                    }
                }
            }else{
                echo json_encode("Desculpe, houve um erro ao enviar seu arquivo.");
            }
        }
        public function selectAnotacaoAjax(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $fkUser = $_SESSION["idUser"];
            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM anotacaodados    
                                              WHERE fkUser = ?");
            $pstmt->bindValue(1, $fkUser);
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Anotacao::class);
            $response = '<div class="container mt-5">
                            <div class="card-header bg-primary text-white">
                                <h4 class="text-center">Histórico de anotação</h4>
                            </div>
                            <div class="row">';
            foreach ($lista as $index => $Anotacao) {
                $Anotacao = new Anotacao($Anotacao);

                // Abrindo uma coluna para cada card
                $response .= '<div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="Descricao">Descricao: ' . $Anotacao->getDescricao() . '</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="Dia">Dia: ' . $Anotacao->getDataHora() . '</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="Imagem"><a href="'.$Anotacao->getImagem().'">Imagem</a></label>
                                                <img src="'.$Anotacao->getImagem().'" alt="'.$Anotacao->getImagem().'" class="img-fluid">
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