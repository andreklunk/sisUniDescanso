<?php
include_once('intranet/conexao.php');

$cod_pessoa = base64_decode($_POST['cod_pessoa']);
$cpf = $_POST['cpf2'];
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$rg = $_POST['rg'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$associacao = $_POST['associacao'];
if($_POST['temConta']=='S') { 
	$banco = $_POST['banco'];
	$tp_conta = $_POST['tp_conta'];
	$agencia = $_POST['agencia'];
	$conta = $_POST['conta'];
	$pix = $_POST['pix'];
} else {
	$banco = '';
	$tp_conta = '';
	$agencia = '';
	$conta = '';	
	$pix = '';
}
$obs = $_POST['obs'];

$query = "UPDATE pessoa set 
		nome = '$nome',
		sobrenome = '$sobrenome',
		rg = '$rg',
		endereco = '$endereco',
		telefone = '$telefone',
		email = '$email',
		id_associacao = '$associacao',
		banco = '$banco',
		agencia = '$agencia',
		conta = '$conta',
		tipo_conta = '$tp_conta',
		pix = '$pix',
		obs = '$obs'
		WHERE id_pessoa = '$cod_pessoa';";
	//echo $query; break;
if(mysqli_query($link,$query) or die (mysqli_error())) {
	$cod_p = base64_encode($cod_pessoa);
	header("Location: index.php?url=msgCadPessoalOK&id=$cod_p");
} else {
	header('Location: index.php?url=msgErro');	
}
?>