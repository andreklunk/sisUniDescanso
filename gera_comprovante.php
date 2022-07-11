<?php
	include_once "intranet/conexao.php";
	include_once('intranet/config.inc.php');
	if(isset($_GET['origem']) == 'I') {//se vem da Intranet
		$cod_freq = $_GET['freq'];
	} else {
		$cod_freq = base64_decode($_GET['freq']); //caso venha do front-end
	}
	$query = "Select F.id_frequencia, PE.id_pessoa, nome, sobrenome, cpf, rg, endereco, telefone, email, banco, agencia, conta, tipo_conta, obs, razao_social as associacao, instituicao, curso, descricao as parcela, ano, semestre, num_dias_trans, num_disciplinas, num_reprovacao, DATE_FORMAT(F.data_cadastro,'%d/%m/%Y %H:%i:%s')as data_cadastro,DATE_FORMAT(F.dt_alteracao,'%d/%m/%Y %H:%i:%s')as dt_alteracao 
	from pessoa PE, frequencia F, instituicao I, curso C, parcela PA, associacao A
	where F.id_pessoa=PE.id_pessoa and F.id_instituicao=I.id_instituicao
	and F.id_curso=C.id_curso and F.id_parcela=PA.id_parcela and PE.id_associacao=A.id_associacao
	and F.id_frequencia=$cod_freq;";
	$resultado = mysqli_query($link, $query) or die (mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$id_pessoa = $reg['id_pessoa'];
		$nome = utf8_decode(htmlspecialchars_decode($reg['nome'])).' '.utf8_decode(htmlspecialchars_decode($reg['sobrenome']));
		$rg = $reg['rg'];
		$cpf = $reg['cpf'];
		$endereco = utf8_decode(htmlspecialchars_decode($reg['endereco']));
		$telefone = $reg['telefone'];
		$email = $reg['email'];
		$banco = utf8_decode(htmlspecialchars_decode($reg['banco']));
		$agencia = $reg['agencia'];
		$conta = $reg['conta'];
		$tp_conta = $reg['tipo_conta'];
		switch($tp_conta){
			case 'C': $tp_conta = "Conta Corrente"; break;
			case 'P': $tp_conta = utf8_decode(htmlspecialchars_decode('Conta Poupança')); break;	
		}
		$obs = utf8_decode(htmlspecialchars_decode($reg['obs']));
		$associacao = utf8_decode(htmlspecialchars_decode($reg['associacao']));
		$instituicao = utf8_decode(htmlspecialchars_decode($reg['instituicao']));
		$curso = utf8_decode(htmlspecialchars_decode($reg['curso']));
		$parcela = utf8_decode(htmlspecialchars_decode($reg['parcela']));
		$ano = $reg['ano'];
		$semestre = $reg['semestre'];
		$num_dias = $reg['num_dias_trans'];
		$num_disciplinas = $reg['num_disciplinas'];
		$num_reprovacao = $reg['num_reprovacao'];
		$data_cad = $reg['data_cadastro'];
		$data_alt = $reg['dt_alteracao']??'';
		
		
		/*$data = substr($data_hora,0,10);
	 	$data= explode("-",$data);
	    $data=$data[2]."/".$data[1]."/".$data[0];		
		$hora = substr($data_hora,11,10);*/
		

//GERANDO O PDF
//require('fpdf/fpdf.php');
require('fpdf/mem_image.php');
//$pdf= new FPDF("P","pt","A4");
$pdf = new PDF_MemImage("P","pt","A4");
 
 
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

$titulo =  utf8_decode(htmlspecialchars_decode("Parcela Referência: $ano/$semestre")); 
$pdf->SetFont('arial','B',14);
$pdf->Cell(0,5,$titulo,0,1,'C');
$pdf->Cell(0,5,"","B",1,'C');

$pdf->Ln(18);

//numero
$pdf->SetFont('arial','B',12);
$pdf->Cell(80,20,utf8_decode(htmlspecialchars_decode("Inscrição Nº:")),0,0,'L');
$pdf->setFont('arial','B',16);
$pdf->Cell(240,20,$cod_freq,0,0,'L');

//data cadastro
$pdf->SetFont('arial','B',12);
$pdf->Cell(100,20,utf8_decode(htmlspecialchars_decode("Data Inscrição:")),0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(75,20,$data_cad,0,1,'L');
 
//nome
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,"Nome:",0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(250,20,$nome,0,0,'L');
 
//data alteração
$pdf->SetFont('arial','B',12);
$pdf->Cell(100,20,utf8_decode(htmlspecialchars_decode("Data Alteração:")),0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(75,20,$data_alt,0,1,'L');

//cpf
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,"CPF:",0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(150,20,$cpf,0,0,'L');//mantem na mesma lina

//RG
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,"RG:",0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$rg,0,1,'L');

//Endereço
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Endereço:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$endereco,0,1,'L');

//Telefone
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Telefone:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$telefone,0,1,'L');

//Email
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("E-Mail:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$email,0,1,'L');
 
//banco
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,"Banco:",0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(150,20,$banco,0,0,'L');

//tipo conta
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,"Tipo:",0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$tp_conta,0,1,'L');
 
//agencia
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Agência:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(150,20,$agencia,0,0,'L');

//conta
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,utf8_decode(htmlspecialchars_decode("Conta Nº:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$conta,0,1,'L');
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(20);
 
//Instituição
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Instituição:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(150,20,$instituicao,0,0,'L');

//Curso
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,utf8_decode(htmlspecialchars_decode("Curso:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$curso,0,1,'L');

//Parcela
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Parcela:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(150,20,$parcela,0,1,'L');

//Associação
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,utf8_decode(htmlspecialchars_decode("Associação:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$associacao,0,1,'L');

//Dias Transporte
$pdf->SetFont('arial','B',12);
$pdf->Cell(120,20,utf8_decode(htmlspecialchars_decode("N° Dias/Transporte:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(105,20,$num_dias,0,0,'L');

//Disciplinas
$pdf->SetFont('arial','B',12);
$pdf->Cell(90,20,utf8_decode(htmlspecialchars_decode("N° Disciplinas/Semestre:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$num_disciplinas,0,1,'L');
 
//Reprovacoes
$pdf->SetFont('arial','B',12);
$pdf->Cell(120,20,utf8_decode(htmlspecialchars_decode("Qtde Reprovações:")),0,0,'R');
$pdf->setFont('arial','',12);
$pdf->Cell(70,20,$num_reprovacao,0,1,'L');
 
$pdf->ln(10);
//Observações
$pdf->SetFont('arial','B',12);
$pdf->Cell(70,20,utf8_decode(htmlspecialchars_decode("Observações:")),0,1,'L');
$pdf->setFont('arial','',12);
$pdf->MultiCell(0,20,$obs,0,'J');
$pdf->Cell(0,5,"","B",1,'C');

$pdf->Ln(10);
//Declaração
$texto1 = utf8_decode(htmlspecialchars_decode("Nestes termos, solicito deferimento da inscrição no Programa Municipal de Concessão de Bolsas de Estudo."));
$texto2 = utf8_decode(htmlspecialchars_decode("Declaro sob as penas da Lei, que as informações acima prestadas correspondem a realidade e que tenho "));
$texto3 = utf8_decode(htmlspecialchars_decode("total conhecimento do regulamento editado pelo Município, cumprindo na íntegra as disposições lá contidas."));
$pdf->SetFont('arial','',10);
$pdf->Cell(0,5,$texto1,0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('arial','',10);
$pdf->Cell(0,5,$texto2,0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('arial','',10);
$pdf->Cell(0,5,$texto3,0,1,'C');
$pdf->Ln(16);


$pdf->Ln(50);
//assinatura
$pdf->SetFont('arial','',12);
$pdf->Cell(0,5,$nome,0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('arial','',12);
$pdf->Cell(0,5,$cpf,0,1,'C');
$pdf->Ln(16);

$pdf->Output("comprovante_inscricao.pdf","I");
?>
