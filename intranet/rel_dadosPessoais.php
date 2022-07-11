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
<script language="javascript" type="text/javascript">
function envia_rel(lk) {
var valor1 = document.getElementById('parcela').value;
endereco = lk+'?cod='+valor1;
if(valor1=='') {
document.getElementById('erro').lastChild.data = "Advertência: Favor selecionar uma parcela ";
exit;
}
	window.open(endereco);
}
</script>
</head>

<body>
<div class="container">
<div class="col-md-12 column">
<div id="corpo">
 <h3> Dados Pessoais - Alunos com Solicitações </h3>  
  <p>
  <form class="form-inline" role="form" name="form1">
  <?php
	  	include_once('conexao.php');
		
		$query = "Select id_parcela, descricao from
					parcela order by id_parcela desc;";
		$resultado = mysqli_query($link, $query)or die(mysqli_error($link));
		while($registro = mysqli_fetch_assoc($resultado)){
			$dados[] = array (
				'cod' => $registro['id_parcela'],
				'valor' => $registro['descricao']
			);
		}		
	?>
    <div class="col-md-5">
     <select name="parcela" id="parcela" class="form-control">
    <option value="" selected="selected"> Selecione uma parcela </option>
     <?php
	foreach($dados as $item) {
 	 echo "<option value='{$item[cod]}'>{$item[valor]}</option>";
	}
	?>
    </select>
    </div>
    <button type="button" class="btn btn-primary" id="button" onclick="envia_rel('pdf_dadosPessoais.php')">Imprimir</button>
    </form>
    <div class="alert" id="erro">   </div>
  </p>
</div>
</div>
</div>
</body>
</html>