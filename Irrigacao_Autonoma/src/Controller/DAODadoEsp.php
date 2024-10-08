<?php 
    include_once __DIR__ . '/../Conexao/Conexao.php';
    include_once __DIR__ . '/../Model/DadoEsp.php';
    class DAODadoEsp{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertDadoEsp(DadoEsp $DadoEsp){
            $pstmt = $this->conexao->prepare("INSERT INTO dadosdosesp 
            (IdenEsp, TempDoAr, UmidDoAr, PorUmidSolo, UmidSolo) VALUES 
            (?,?,?,?,?)");
            $pstmt->bindValue(1, $DadoEsp->getIdenEsp());
            $pstmt->bindValue(2, $DadoEsp->getTempDoAr());
            $pstmt->bindValue(3, $DadoEsp->getUmidDoAr());
            $pstmt->bindValue(4, $DadoEsp->getPorUmidSolo());
            $pstmt->bindValue(5, $DadoEsp->getUmidSolo());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectAllDadoEsp(){
            $pstmt = $this->conexao->prepare("SELECT * FROM dadosdosesp");
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, DadoEsp::class);
            return $lista;
        }
        public function deleteDadoEsp($IdDado){
            $pstmt = $this->conexao->prepare("DELETE FROM dadosdosesp WHERE IdDado = ?");
            $pstmt->bindValue(1, $IdDado);
            $pstmt->execute();
            return $pstmt;
        }  
        public function updateDadoEsp(DadoEsp $DadoEsp){
            $pstmt = $this->conexao->prepare("UPDATE dadosdosesp SET IdenEsp = ?, TempDoAr = ?,
            UmidDoAr = ?, PorUmidSolo = ?, UmidSolo = ?, DataCaptura = ?, HoraCaptura = ?
            WHERE IdDado = ?");
            $pstmt->bindValue(1, $DadoEsp->getIdenEsp());
            $pstmt->bindValue(2, $DadoEsp->getTempDoAr());
            $pstmt->bindValue(3, $DadoEsp->getUmidDoAr());
            $pstmt->bindValue(4, $DadoEsp->getPorUmidSolo());
            $pstmt->bindValue(5, $DadoEsp->getUmidSolo());
            $pstmt->bindValue(6, $DadoEsp->getDataCaptura());
            $pstmt->bindValue(7, $DadoEsp->getHoraCaptura());
            $pstmt->bindValue(8, $DadoEsp->getIdDado());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectAllDadoPDF($combo){
            $pstmt = $this->conexao->prepare("SELECT IdenEsp, TempDoAr, UmidDoAr, PorUmidSolo, UmidSolo, DataCaptura, HoraCaptura FROM dadosdosesp ORDER BY ".$combo);
            $pstmt->execute();
            $data = [];
            //while ($linha = $pstmt->fetch(PDO::FETCH_ASSOC))
            while ($linha = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $linha;
            }
            return $data;
        }
        public function selectAllDadoPDFData($diaInicio, $diaFinal, $horaInicio, $horaFinal){
            $pstmt = $this->conexao->prepare("SELECT IdenEsp, TempDoAr, UmidDoAr, PorUmidSolo, UmidSolo, DataCaptura, HoraCaptura 
                                              FROM dadosdosesp 
                                              WHERE (DataCaptura BETWEEN ? AND ?) AND (HoraCaptura BETWEEN ? AND ?) 
                                              ORDER BY DataCaptura ASC");
            $pstmt->bindValue(1, $diaInicio);
            $pstmt->bindValue(2, $diaFinal);
            $pstmt->bindValue(3, $horaInicio);
            $pstmt->bindValue(4, $horaFinal);
            $pstmt->execute();
            $data = [];
            //while ($linha = $pstmt->fetch(PDO::FETCH_ASSOC))
            while ($linha = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $linha;
            }
            return $data;
        }
        public function selectTodos() {
            $combobox = $_POST['combobox'];
            
            $pstmt = $this->conexao->prepare("SELECT * FROM dadosdosesp ORDER BY ".$combobox);
            $response = '<div class="card mt-5">
                            <div class="card-header text-center">
                                <h2>Dados de Sensores</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data de Captura</th>
                                            <th>Hora da Captura</th>
                                            <th>Umidade do Ar (%)</th>
                                            <th>Temperatura do Ar (°C)</th>
                                            <th>Umidade do Solo</th>
                                            <th>Umidade do Solo (%)</th>
                                            <th>Fazer Anotação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataBody">';
            if ($pstmt->execute()) {
                while ($linha = $pstmt->fetch()) {
                    $DadoEsp = new DadoEsp($linha);
                    $response .= "<tr>
                                    <td class='center-align'>" . $DadoEsp->getDataCaptura() . "</td>
                                    <td class='center-align'>" . $DadoEsp->getHoraCaptura() . "</td>
                                    <td class='center-align'>" . $DadoEsp->getUmidDoAr() . "</td>
                                    <td class='center-align'>" . $DadoEsp->getTempDoAr() . "</td>
                                    <td class='center-align'>" . $DadoEsp->getUmidSolo() . "</td>
                                    <td class='center-align'>" . $DadoEsp->getPorUmidSolo() . "</td>
                                    <td class='center-align'>
                                        <a href='#!' class='blue-text editar' id='" . $DadoEsp->getIdDado() . "' onclick='anotacao(".$DadoEsp->getIdDado().")'>
                                            <span class='material-icons'>mode_edit</span>
                                        </a>
                                    </td>
                                  </tr>";
                }
                $response .= "</tbody></table></div></div>";
                echo $response;
            } else {
                echo "Erro ao Buscar Carros";
            }
            
        }
        public function selectTodosPesquisa() {
            $diaInicio = $_POST['diaInicio'];
            $diaFinal = $_POST['diaFinal'];
            $horaInicio = $_POST['horaInicio'];
            $horaFinal = $_POST['horaFinal'];
            $combobox = $_POST['combobox'];

            if (in_array($combobox, ['IdDado DESC', 'IdDado ASC', 'TempDoAr DESC', 'TempDoAr ASC', 'UmidDoAr DESC', 'UmidDoAr ASC', 'PorUmidSolo DESC', 'PorUmidSolo ASC'])) {
                $pstmt = $this->conexao->prepare("SELECT * 
                                                  FROM dadosdosesp 
                                                  WHERE (DataCaptura BETWEEN ? AND ?) AND (HoraCaptura BETWEEN ? AND ?) 
                                                  ORDER BY ".$combobox);
                $pstmt->bindValue(1, $diaInicio);
                $pstmt->bindValue(2, $diaFinal);
                $pstmt->bindValue(3, $horaInicio);
                $pstmt->bindValue(4, $horaFinal);
                $response = '<div class="card mt-5">
                                <div class="card-header text-center">
                                    <h2>Dados de Sensores</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data de Captura</th>
                                                <th>Hora da Captura</th>
                                                <th>Umidade do Ar (%)</th>
                                                <th>Temperatura do Ar (°C)</th>
                                                <th>Umidade do Solo</th>
                                                <th>Umidade do Solo (%)</th>
                                                <th>Fazer Anotação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataBody">';
                if ($pstmt->execute()) {
                    while ($linha = $pstmt->fetch()) {
                        $DadoEsp = new DadoEsp($linha);
                        $response .= "<tr>
                                        <td class='center-align'>" . $DadoEsp->getDataCaptura() . "</td>
                                        <td class='center-align'>" . $DadoEsp->getHoraCaptura() . "</td>
                                        <td class='center-align'>" . $DadoEsp->getUmidDoAr() . "</td>
                                        <td class='center-align'>" . $DadoEsp->getTempDoAr() . "</td>
                                        <td class='center-align'>" . $DadoEsp->getUmidSolo() . "</td>
                                        <td class='center-align'>" . $DadoEsp->getPorUmidSolo() . "</td>
                                        <td class='center-align'>
                                            <a href='#!' class='blue-text editar' id='" . $DadoEsp->getIdDado() . "' onclick='anotacao(".$DadoEsp->getIdDado().")'>
                                                <span class='material-icons'>mode_edit</span>
                                            </a>
                                        </td>
                                      </tr>";
                    }
                    $response .= "</tbody></table></div></div>";
                    echo $response;
                } else {
                    echo "Erro ao Buscar Carros";
                }
            } else {
                echo "Opção inválida!";
                exit;
            }
        }
        public function selectDadosGraficos(){
            $pstmt = $this->conexao->prepare("SELECT * FROM dadosdosesp ORDER BY DataCaptura ASC");
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectDadosGraficosData(){
            $diaIniciog = $_POST['diaInicioG'];
            $diaFinalg = $_POST['diaFinalG'];
            $horaIniciog = $_POST['horaInicioG'];
            $horaFinalg = $_POST['horaFinalG'];
            $pstmt = $this->conexao->prepare("SELECT * 
                                              FROM dadosdosesp 
                                              WHERE (DataCaptura BETWEEN ? AND ?) AND (HoraCaptura BETWEEN ? AND ?)
                                              ORDER BY DataCaptura ASC;");
            $pstmt->bindValue(1, $diaIniciog);
            $pstmt->bindValue(2, $diaFinalg);
            $pstmt->bindValue(3, $horaIniciog);
            $pstmt->bindValue(4, $horaFinalg);
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMaiorTemp(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.TempDoAr AS MaiorTemperatura,
                                                  d1.UmidDoAr, 
                                                  d1.PorUmidSolo, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MAX(TempDoAr) AS MaiorTemperatura
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.TempDoAr = d2.MaiorTemperatura
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMenorTemp(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.TempDoAr AS MenorTemperatura,
                                                  d1.UmidDoAr, 
                                                  d1.PorUmidSolo, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MIN(TempDoAr) AS MenorTemperatura
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.TempDoAr = d2.MenorTemperatura
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMaiorUmid(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.UmidDoAr AS MaiorUmidDoAr,
                                                  d1.TempDoAr, 
                                                  d1.PorUmidSolo, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MAX(UmidDoAr) AS MaiorUmidDoAr
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.UmidDoAr = d2.MaiorUmidDoAr
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMenorUmid(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.UmidDoAr AS MenorUmidDoAr,
                                                  d1.TempDoAr, 
                                                  d1.PorUmidSolo, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MIN(UmidDoAr) AS MenorUmidDoAr
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.UmidDoAr = d2.MenorUmidDoAr
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMaiorUmidSolo(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.PorUmidSolo AS MaiorUmidSolo,
                                                  d1.TempDoAr, 
                                                  d1.UmidDoAr, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MAX(PorUmidSolo) AS MaiorUmidSolo
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.PorUmidSolo = d2.MaiorUmidSolo
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
        public function selectMenorUmidSolo(){
            $pstmt = $this->conexao->prepare("SELECT 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') AS MesAno, 
                                                  d1.PorUmidSolo AS MenorUmidSolo,
                                                  d1.TempDoAr, 
                                                  d1.UmidDoAr, 
                                                  d1.UmidSolo, 
                                                  d1.HoraCaptura 
                                              FROM 
                                                  dadosdosesp d1
                                              INNER JOIN (
                                                  SELECT 
                                                      DATE_FORMAT(DataCaptura, '%Y-%m') AS MesAno, 
                                                      MIN(PorUmidSolo) AS MenorUmidSolo
                                                  FROM 
                                                      dadosdosesp
                                                  GROUP BY 
                                                      MesAno
                                              ) d2 
                                              ON 
                                                  DATE_FORMAT(d1.DataCaptura, '%Y-%m') = d2.MesAno 
                                                  AND d1.PorUmidSolo = d2.MenorUmidSolo 
                                              GROUP BY
                                                  MesAno
                                              ORDER BY 
                                                  MesAno ASC"
                                            );
            $pstmt->execute();
            $response = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($response);
        }
    }
?>