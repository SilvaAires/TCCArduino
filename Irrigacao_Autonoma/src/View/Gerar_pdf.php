<?php
    require(__DIR__ . '/../fpdf186/fpdf.php');
    include_once __DIR__ . '/../Conexao/Conexao.php';
    include_once __DIR__ . '/../Controller/DAODadoEsp.php';
    include_once __DIR__ . '/../Rotas/Constantes.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["login"]) && !isset($_SESSION["senha"])){
        header("Location: ".HOME."Login");
        exit();
    }

    class PDF extends FPDF{
        // Cabeçalho do PDF
        function Header(){
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Relatorio de Dados dos Esp', 0, 1, 'C');
            $this->Ln(10);
        }
    
        // Rodapé do PDF
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        }
    
        // Tabela com os dados
        function DadosTabela($header, $data){
            $this->SetFont('Arial', 'B', 10);
            $cellWidth = 30; // Ajuste a largura das células
    
            // Largura total da tabela
            $tableWidth = $cellWidth * count($header);
    
            // Verifica se a tabela cabe na página
            if ($tableWidth > $this->GetPageWidth() - 20) { // Considere margens
                $cellWidth = ($this->GetPageWidth() - 20) / count($header);
                $tableWidth = $cellWidth * count($header);
            }
    
            // Centraliza a tabela na página
            $this->SetX(($this->GetPageWidth() - $tableWidth) / 2);
    
            // Cabeçalho
            foreach ($header as $col) {
                $this->Cell($cellWidth, 7, $col, 1, 0, 'C');
            }
            $this->Ln();
    
            // Dados
            $this->SetFont('Arial', '', 10);
            foreach ($data as $row) {
                $this->SetX(($this->GetPageWidth() - $tableWidth) / 2);
                foreach ($row as $col) {
                    $this->Cell($cellWidth, 7, $col, 1, 0, 'C');
                }
                $this->Ln();
            }
        }
    }
    $pdf = new PDF();
    $pdf->AddPage();
    // Títulos das colunas
    $header = ['Esp', 'Temp', 'Umid', 'Umid. Solo %', 'Umid. Solo', 'dia', 'HR'];
    $DAODadoEsp = new DAODadoEsp();
    if(isset($_POST['btnGerarPDF'])){
        $retorno = $DAODadoEsp->selectAllDadoPDF($_POST['options']);
        $pdf->DadosTabela($header, $retorno);
        $pdf->Output();
    }else{
        if(isset($_POST['btnGerarPDFDia'])){
            $retorno = $DAODadoEsp->selectAllDadoPDFData($_POST['diaInicio'], $_POST['diaFinal'], $_POST['horaInicio'], $_POST['horaFinal']);
            $pdf->DadosTabela($header, $retorno);
            $pdf->Output();
        }
    }
/*
    // Cria um objeto PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Títulos das colunas
    $header = ['Identificador', 'Temperatura', 'Umidade do Ar', 'Porc. Umid. Solo', 'Umid. Solo'];

    // Conecte ao banco de dados e busque os dados
    $conexao = Conexao::getConexao();
    $sql = "SELECT IdenEsp, TempDoAr, UmidDoAr, PorUmidSolo, UmidSolo FROM dadosdosesp";
    $resultado = $conexao->query($sql);

    // Transforme os resultados em um array
    $data = [];
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    // Adiciona a tabela ao PDF
    $pdf->DadosTabela($header, $data);

    // Gera o PDF
    $pdf->Output();

    $pstmt = $this->conexao->prepare("SELECT IdenEsp, TempDoAr, UmidDoAr, PorUmidSolo, UmidSolo, DataCaptura, HoraCaptura FROM dadosdosesp ORDER BY ".$comboboxPDF);
            
            if ($pstmt->execute()) {
                $response = "";
                $data = [];
                while ($linha = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $linha;
                }

                $pdf = new PDF();
                $pdf->AddPage();
                
?>*/
