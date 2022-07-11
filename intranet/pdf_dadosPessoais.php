<?php
include "conexao.php";
	
$cod = $_GET['cod'];
$query = "Select F.id_parcela, descricao, nome, sobrenome, cpf, rg, endereco, 
         telefone, instituicao 
         from frequencia F, parcela PA, pessoa PE, instituicao I
		 where F.id_parcela=PA.id_parcela and F.id_instituicao=I.id_instituicao
		 and F.id_pessoa=PE.id_pessoa
		 and PA.id_parcela = '$cod' order by nome asc, sobrenome asc";
$resultado = mysqli_query($link, $query)or die(mysqli_error($link));

	$resultado = mysqli_query($link, $query) or die (mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$parcela = utf8_decode(htmlspecialchars_decode($reg['descricao']));

//GERANDO O PDF===============================================================================
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
	   include('config.inc.php');//dados do municipio
	  $this->SetTitle(utf8_decode('SISUNI - Programa de Auxílio a Estudantes'));
      //insere e posiciona a imagem/logomarca
     $this->Image('../logo.jpg',30,15,50);
	$titulo =  utf8_decode(htmlspecialchars_decode($municipio)); 
	$this->SetFont('arial','B',16);
	$this->Cell(0,5,$titulo,0,0,'C');
	$this->Cell(0,5,"","B",1,'C');
	$this->Ln(16);
	
	$titulo =  utf8_decode(htmlspecialchars_decode("Programa de Auxílio a Estudantes")); 
	$this->SetFont('arial','B',14);
	$this->Cell(0,5,$titulo,0,0,'C');
	$this->Cell(0,5,"","B",1,'C');
	$this->Ln(12);
	
	//traço
	$this->Cell(0,5,"","B",1,'C');
	$this->Ln(10);
 }

//Método Footer que estiliza o rodapé da página
   function Footer() {
      //posicionamos o rodapé a 1,5cm do fim da página
      $this->SetY(-15);      
      //Informamos a fonte, seu estilo e seu tamanho
      $this->SetFont('Arial','I',8);
      //Informamos o tamanho do box que vai receber o conteúdo do rodapé
      //e inserimos o número da página através da função PageNo()
      //além de informar se terá borda e o alinhamento do texto
      $this->Cell(0,10,utf8_decode(htmlspecialchars_decode('Página ')).$this->PageNo().'/{nb}',0,0,'C');
   }

}
//$pdf= new FPDF("P","pt","A4");
$pdf= new PDF("L","pt","A4");//inlcui cabeçalho e rodapé
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('true','20');	
$pdf->AddPage();


$titulo =  utf8_decode(htmlspecialchars_decode("Alunos com solicitação")); 
$pdf->SetFont('arial','B',14);

$t = $parcela;
$titulo =  utf8_decode(htmlspecialchars_decode("Referência: ")).$t; 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,8,$titulo,0,1,'C');
$pdf->Cell(0,5,"","B",1,'C');

$pdf->Ln(10);

//CRIANDO A TABELA
// muda fonte e coloca em negrito
$pdf->SetFont('Arial', 'B', 9);
// largura padrão das colunas
$l = 40;
// altura padrão das linhas das colunas
$a = 12;
// criando os cabeçalhos para 5 colunas
$pdf->Cell($l-20, $a, '#', 1, 0, 'C');
$pdf->Cell($l+170, $a, 'Nome', 1, 0, 'L');
$pdf->Cell($l+35, $a, 'CPF', 1, 0, 'C');
$pdf->Cell($l+25, $a, 'RG', 1, 0, 'C');
$pdf->Cell($l+175, $a, utf8_decode(htmlspecialchars_decode('Endereço')), 1, 0, 'L');
$pdf->Cell($l+40, $a, 'Telefone', 1, 0, 'C');
$pdf->Cell($l+80, $a, utf8_decode(htmlspecialchars_decode('Instituição')), 1, 0, 'L');

// pulando a linha
$pdf->Ln($a+3);

// tirando o negrito
$pdf->SetFont('Arial', '', 9);
//$total = 0;
$res = mysqli_query($link, $query) or die (mysqli_error($link));
while($registro=mysqli_fetch_array($res)){
	$num = $num + 1;
	$nome = $registro['nome'];			
		$nome = mb_strtoupper($nome);
		$nome = utf8_decode(htmlspecialchars_decode($nome));
	$sobrenome = $registro['sobrenome'];			
		$sobrenome = mb_strtoupper($sobrenome);
		$sobrenome = utf8_decode(htmlspecialchars_decode($sobrenome));
	$nome = $nome.' '.$sobrenome;
	$cpf = $registro['cpf'];
	$rg = $registro['rg'];
	$endereco =  utf8_decode(htmlspecialchars_decode($registro['endereco']));
	$telefone = $registro['telefone'];
	$instituicao =  utf8_decode(htmlspecialchars_decode($registro['instituicao']));

//cor de fundo... obs, ao final da linha, acrescentar TRUE
if (!$zebrado){
    $pdf->SetFillColor(255,255,255);
    $zebrado = true ;
} else {
    $pdf->SetFillColor(225,225,225);
    $zebrado = false ;
}		
$pdf->Cell($l-20, $a, $num, 0, 0, 'C',true);
$pdf->Cell($l+170, $a, $nome, 0, 0, 'L',true);
$pdf->Cell($l+35, $a, $cpf, 0, 0, 'C',true);
$pdf->Cell($l+25, $a, $rg, 0, 0, 'C',true);
$pdf->Cell($l+175, $a, $endereco, 0, 0, 'L',true);
$pdf->Cell($l+40, $a, $telefone, 0, 0, 'C',true);
$pdf->Cell($l+80, $a, $instituicao, 0, 0, 'L',true);
$pdf->Ln($a);
}
//traço
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(3);

$pdf->Output("relatorio_pagamentos.pdf","I");
?>
