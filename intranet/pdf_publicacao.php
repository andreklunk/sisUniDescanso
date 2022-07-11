<?php
include "conexao.php";
	
$cod = $_GET['cod'];
$tp = $_GET['tp'];
$query = "Select F.id_parcela, descricao, nome, sobrenome, cpf,  
         instituicao, curso, num_disciplinas, num_dias_trans
         from frequencia F, parcela PA, pessoa PE, instituicao I, curso C
		 where F.id_parcela=PA.id_parcela and F.id_instituicao=I.id_instituicao
		 and F.id_pessoa=PE.id_pessoa and F.id_curso=C.id_curso";
if($tp=='S') 
	$query .= " and F.validacao = 'S'";
if($tp=='N') 
	$query .= " and F.validacao = 'N'";
$query .= " and PA.id_parcela = '$cod' order by nome asc, sobrenome asc";
$resultado = mysqli_query($link, $query)or die(mysqli_error($link));
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
$pdf->Cell(0,15,$titulo,0,1,'C');

switch($tp) {
	case 'S': $texto = "Listagem de Validados"; break;	
	case 'N': $texto = "Listagem de Não Validados"; break;
	default: $texto = "Todas Solicitações";
}
$texto =  utf8_decode(htmlspecialchars_decode($texto)); 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,18,$texto,0,1,'C');

//cria linha
$pdf->Cell(0,1,"","B",1,'C');
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
$pdf->Cell($l+40, $a, 'CPF', 1, 0, 'C');
$pdf->Cell($l+175, $a, utf8_decode(htmlspecialchars_decode('Curso')), 1, 0, 'L');
$pdf->Cell($l+80, $a, utf8_decode(htmlspecialchars_decode('Instituição')), 1, 0, 'L');
$pdf->Cell($l+25, $a, utf8_decode('Nº Disciplinas'), 1, 0, 'C');
$pdf->Cell($l+40, $a, 'Dias Transp.', 1, 0, 'C');
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
	$sobrenome = $registro['sobrenome'];			
		$sobrenome = utf8_decode(htmlspecialchars_decode($sobrenome));
		$sobrenome = mb_strtoupper($sobrenome,'iso-8859-1');		
	$nome = $nome.' '.$sobrenome;
	$cpf = substr($registro['cpf'],0,3).'.XXX.XXX-'.substr($registro['cpf'],-2);
	$curso =  utf8_decode(htmlspecialchars_decode($registro['curso']));
	$instituicao =  utf8_decode(htmlspecialchars_decode($registro['instituicao']));
	$disciplinas = $registro['num_disciplinas'];
	$transp = $registro['num_dias_trans'];
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
$pdf->Cell($l+40, $a, $cpf, 0, 0, 'C',true);
$pdf->Cell($l+175, $a, $curso, 0, 0, 'L',true);
$pdf->Cell($l+80, $a, $instituicao, 0, 0, 'L',true);
$pdf->Cell($l+25, $a, $disciplinas, 0, 0, 'C',true);
$pdf->Cell($l+40, $a, $transp, 0, 0, 'C',true);
$pdf->Ln($a);
}
//traço
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(3);

$pdf->Output("SisUNI_Inscricoes.pdf","I");
?>
