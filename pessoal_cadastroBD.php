<?php
include_once('intranet/conexao.php');

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

$query = "INSERT INTO pessoa (nome, sobrenome, cpf, rg, endereco, telefone, email, id_associacao,
		  banco, tipo_conta, agencia, conta, pix, obs) VALUES (
		  '$nome', '$sobrenome', '$cpf', '$rg', '$endereco', '$telefone', '$email', '$associacao', '$banco',
		  '$tp_conta', '$agencia', '$conta', '$pix', '$obs');";
	// echo $query; break;
if(mysqli_query($link,$query) or die (mysqli_error($link))) {
	$cod_pessoa = base64_encode(mysqli_insert_id($link));
	header("Location: index.php?url=msgOK_PrimeiroCad&id=$cod_pessoa");
} else {
	header('Location: index.php?url=msgErro');	
}
?>