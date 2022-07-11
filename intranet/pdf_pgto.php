<?php
include_once("conexao.php");

$cod = $_GET['cod'];
$banco = $_GET['banco'];
$query = "Select P.id_parcela, descricao, semestre, ano,id_frequencia, nome, 
         cpf, banco, agencia, conta, tipo_conta, valor
         from pagamento P, parcela PA 
		 where P.id_parcela=PA.id_parcela
		 and P.id_parcela = '$cod' ";
if($banco) $query .=  "and banco = '$banco' ";
$query .= "order by nome asc";
//echo $query; break;
$resultado = mysqli_query($link, $query)or die(mysqli_error($link));

	$resultado = mysqli_query($link, $query) or die (mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$parcela = utf8_decode(htmlspecialchars_decode($reg['descricao']));
		$ano = $reg['ano'];
		$semestre = $reg['semestre'];

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
$pdf= new PDF("P","pt","A4");//inclui cabeçalho e rodapé
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('true','20');	
$pdf->AddPage();

$t = $parcela;
$titulo =  utf8_decode(htmlspecialchars_decode("Referência: ")).$t; 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,8,$titulo,0,1,'C');
$pdf->Cell(0,5,"","B",1,'C');

$pdf->Ln(10);
/*
//parcela
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Referência:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$parcela,0,1,'L');
//traço
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(5);
*/
//CRIANDO A TABELA
// muda fonte e coloca em negrito
$pdf->SetFont('Arial', 'B', 9);
// largura padrão das colunas
$l = 40;
// altura padrão das linhas das colunas
$a = 12;
// criando os cabeçalhos para 5 colunas
$pdf->Cell($l-20, $a, '#', 1, 0, 'C');
$pdf->Cell($l+150, $a, 'Nome', 1, 0, 'L');
$pdf->Cell($l+35, $a, 'CPF', 1, 0, 'C');
$pdf->Cell($l+20, $a, 'Banco', 1, 0, 'L');
$pdf->Cell($l+5, $a, utf8_decode(htmlspecialchars_decode('Agência')), 1, 0, 'C');
$pdf->Cell($l+40, $a, 'Conta', 1, 0, 'C');
$pdf->Cell($l-20, $a, 'T', 1, 0, 'C');
$pdf->Cell($l+10, $a, 'Valor (R$)', 1, 0, 'C');
// pulando a linha
$pdf->Ln($a+3);

// tirando o negrito
$pdf->SetFont('Arial', '', 9);
//$total = 0;
$res = mysqli_query($link, $query) or die (mysqli_error($link));
while($registro=mysqli_fetch_array($res)){
	$num = $num + 1;
	$nome = $registro['nome'];
		$nome = utf8_decode(htmlspecialchars_decode($nome));	
		$nome = mb_strtoupper($nome,'iso-8859-1');
	$cpf = $registro['cpf'];
	$banco =  utf8_decode(htmlspecialchars_decode($registro['banco']));
	$agencia = $registro['agencia'];
	$conta = $registro['conta'];
	$tipo_conta = $registro['tipo_conta'];
	$vlr = $registro['valor'];
	$valor = number_format($vlr, 2, ',', '.');
	$total = $total + $vlr;

//cor de fundo... obs, ao final da linha, acrescentar TRUE
if (!$zebrado){
    $pdf->SetFillColor(255,255,255);
    $zebrado = true ;
} else {
    $pdf->SetFillColor(225,225,225);
    $zebrado = false ;
}		
$pdf->Cell($l-20, $a, $num, 0, 0, 'C',true);
$pdf->Cell($l+150, $a, $nome, 0, 0, 'L',true);
$pdf->Cell($l+35, $a, $cpf, 0, 0, 'C',true);
$pdf->Cell($l+20, $a, $banco, 0, 0, 'L',true);
$pdf->Cell($l+5, $a, $agencia, 0, 0, 'C',true);
$pdf->Cell($l+40, $a, $conta, 0, 0, 'C',true);
$pdf->Cell($l-20, $a, $tipo_conta, 0, 0, 'C',true);
$pdf->Cell($l+10, $a, $valor, 0, 0, 'R',true);
$pdf->Ln($a);
}
//traço
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(3);

//parcela
$total = number_format($total, 2, ',', '.');
$pdf->SetFont('arial','',10);
$pdf->Cell(460,20,utf8_decode(htmlspecialchars_decode("Valor Total:")),0,0,'R');
$pdf->setFont('arial','B',10);
$pdf->Cell(0,20,'R$ '.$total,0,1,'R');


$pdf->Output("relatorio_pagamentos.pdf","I");
?>
