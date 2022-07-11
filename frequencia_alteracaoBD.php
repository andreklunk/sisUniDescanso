<?php
include_once('intranet/conexao.php');

$codFreq = $_POST['idFreq'];
$id_curso = $_POST['curso'];
$id_instituicao = $_POST['instituicao'];
$id_parcela = $_POST['parcela'];
$diasTrans = $_POST['num_dias'];
$numDisc = $_POST['num_disciplina'];
$numRep = $_POST['num_reprovacao'];

/*CRIADA TRIGGER PARA ATUALIZAR A DATA NO BD
date_default_timezone_set('America/Sao_Paulo');
$dt = date('d/m/Y');
$hr = date('H:i:s');
$data= explode("/",$dt);
	$data=$data[2]."-".$data[1]."-".$data[0];
$data = $data.' '.$hr;*/

$query = "UPDATE frequencia set 
		id_curso = '$id_curso',
		id_instituicao = '$id_instituicao',
		id_parcela = '$id_parcela',
		num_dias_trans = '$diasTrans',
		num_disciplinas = '$numDisc',
		num_reprovacao = '$numRep'
		WHERE id_frequencia = '$codFreq';";
//	echo $query; exit;
if(mysqli_query($link,$query) or die (mysqli_error())) {
	$cod_f = base64_encode($codFreq);
	header("Location: index.php?url=inscOK&cod_freq=$cod_f&mail=S");
} else {
	header('Location: index.php?url=msgDuplicado');	
}
?>