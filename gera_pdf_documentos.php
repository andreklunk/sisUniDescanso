<?php
	include_once "intranet/conexao.php";
	include_once('intranet/config.inc.php');

//GERANDO O PDF
//require('fpdf/fpdf.php');
require('fpdf/mem_image.php');
//$pdf= new FPDF("P","pt","A4");
$pdf = new PDF_MemImage("P","pt","A4");
 
 
//BUSCANDO DADOS PESSOAIS
if(isset($_GET['origem']) == 'I') {//se vem da Intranet
		$id_pessoa = $_GET['codPessoa'];
	} else {
		$id_pessoa = base64_decode($_GET['codPessoa']); //caso venha do front-end
	}
$sql = "Select nome, sobrenome, cpf from pessoa where id_pessoa = $id_pessoa;";
$resultado = mysqli_query($link, $sql) or die (mysqli_error($link));;
$reg = mysqli_fetch_array($resultado);
	$nome = utf8_decode(htmlspecialchars_decode($reg['nome'])).' '.utf8_decode(htmlspecialchars_decode($reg['sobrenome']));
	$cpf = $reg['cpf'];


$pdf->AddPage();
$pdf->SetTitle(utf8_decode('SISUNI - Programa de Auxílio a Estudantes'));
$pdf->Image('logo.jpg',30,15,50);
$encoding = 'UTF-8';
$mun = mb_convert_case($municipio, MB_CASE_UPPER, $encoding);
//$mun = mb_strtoupper($municipio,$encoding);
$titulo =  utf8_decode(htmlspecialchars_decode("PREFEITURA MUNICIPAL DE $mun")); 
$pdf->SetFont('arial','B',16);
$pdf->Cell(0,5,$titulo,0,0,'C');
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(16);

$titulo =  utf8_decode(htmlspecialchars_decode("Programa de Auxílio a Estudantes")); 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,5,$titulo,0,0,'C');
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(12);

$titulo = "Aluno: $nome"; 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,5,$titulo,0,1,'C');

$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(15);

//BUSCA DOCUMENTOS SE HOUVER
$consultaSQL = "SELECT id_documento, doc_texto, tipo_descricao,doc_tipo, doc_conteudo 
					FROM documento D LEFT JOIN tipo_doc as T on D.id_tipo=T.id_tipo
					where id_pessoa='$id_pessoa' order by id_documento desc;";
//echo $consultaSQL;
if($result_docs = mysqli_query($link, $consultaSQL)){
$coluna=30;
$linha = 100;
$qtdeReg = 1;
while($reg_docs=mysqli_fetch_array($result_docs)){
				$cod_doc = $reg_docs['id_documento'];
				$texto = $reg_docs['tipo_descricao'];
				$tipo = $reg_docs['doc_tipo'];
				$conteudo = $reg_docs['doc_conteudo'];			

if($qtdeReg <= 2){
	$pdf->MemImage($conteudo, $coluna, $linha, 250, 170);
	$coluna=$coluna+260;
} else {
	$coluna=30;	
	$pdf->MemImage($conteudo, $coluna, $linha+190, 250, 170);
}
$qtdeReg = $qtdeReg+1;  
}}


$pdf->Ln(400);
$pdf->Cell(0,0,"","B",2,'C');
//assinatura
$pdf->SetFont('arial','',12);
$pdf->Ln(5);
$pdf->Cell(0,5,$nome,0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('arial','',12);
$pdf->Cell(0,5,$cpf,0,1,'C');
$pdf->Ln(16);

$pdf->Output("documentos.pdf","I");
?>
