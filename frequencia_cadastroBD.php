<?php
include_once('intranet/conexao.php');

$cod_pessoa = $_POST['cod_pessoa'];
$parcela = $_POST['parcela'];
$instituicao = $_POST['instituicao'];
$curso = $_POST['curso'];
$num_dias = $_POST['num_dias'];
$num_disciplina = $_POST['num_disciplina'];
if($_POST['num_reprovacao'] == ''){
	$num_reprovacao = 0;
} else {
	$num_reprovacao = $_POST['num_reprovacao'];
}
$validacao = 'N';

date_default_timezone_set('America/Sao_Paulo');
$dt = date('d/m/Y');
$hr = date('H:i:s');
$data= explode("/",$dt);
	$data=$data[2]."-".$data[1]."-".$data[0];
$data = $data.' '.$hr;
$query = "INSERT INTO frequencia (data_cadastro, id_pessoa, id_parcela, id_instituicao,		
			id_curso, num_dias_trans, num_disciplinas, num_reprovacao, validacao) VALUES (
		  	'$data', '$cod_pessoa', '$parcela', '$instituicao', '$curso', '$num_dias',
			'$num_disciplina', '$num_reprovacao', '$validacao');";
if((mysqli_query($link,$query) & strpos(mysqli_error($link),'Duplicate entry')==0)) {
	$cod_freq = base64_encode(mysqli_insert_id($link));
	header("Location: index.php?url=inscOK&cod_freq=$cod_freq&mail=S");
} else {
	header('Location: index.php?url=msgDuplicado');	
}
?>