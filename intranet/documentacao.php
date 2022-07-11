<?php
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
if($_SESSION['us_sessao']!=session_id())
{
	header("Location: index.php?mensagem=erro_sessao");
}
$_SESSION['us_sessao'];
$_SESSION['us_id'];
$_SESSION['us_nome'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body>
<div class="container">
<div class="col-md-12 column">
<div id="corpo">
	<h3 class="text-center"> Documentação Enviada </h3> 
	<?php
	include_once('conexao.php');
	$sql = "Select DISTINCT id_pessoa, concat(pessoa.nome,' ',pessoa.sobrenome)as nome 
	from pessoa WHERE id_pessoa in (SELECT DISTINCT id_pessoa FROM documento)";
	
	$resultado = mysqli_query($link, $sql)or die(mysqli_error($link));		
	?>
	
<table class="table table-hover table-sm">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NOME</th>
      <th scope="col">AÇÃO</th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  while($reg = mysqli_fetch_array($resultado)) {
			$codPessoa = $reg['id_pessoa'];
			$nome = $reg['nome'];
	  ?>
    <tr>
      <th scope="row"><?= $codPessoa; ?></th>
      <td><?= $nome; ?></td>
      <td><a href="../gera_pdf_documentos.php?codPessoa=<?= base64_encode($codPessoa);?>" target="_blank" class="btn btn-warning btn-sm" role="button">Imprimir</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>

</div>
</div>
</div>
</body>
</html>