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
// limpando a div antes de um novo envio
function envia_form(lk) {
jQuery("#mostraResultado").empty();

var valor1 = document.getElementById('parcela').value;
if(valor1=='') {
document.getElementById('erro').lastChild.data = "Advertência: Favor selecionar uma parcela ";
exit;
} else {
	document.getElementById('erro').lastChild.data = "";	
}
if(lk == 'BUSCA') {
 	var endereco = 'gera_pgto.php?valor1='+valor1;
} else {
	var endereco = 'limpa.php';
}
// tipo dos dados, url do documento, tipo de dados, campos enviados    
// para GET mude o type para GET  
jQuery.ajax({
type: "POST",
url: endereco,
dataType: "html",
data: {
     valor1: valor1
    },
// enviado com sucesso
success: function(response){
jQuery("#mostraResultado").append(response);
},
// quando houver erro
error: function(){
//	alert("Ocorreu um erro durante a requisição");
	document.getElementById('erro').lastChild.data = "Ocorreu um erro durante a requisição ";
}
});   
}
</script>
</head>

<body>
<div class="container">
<div class="col-md-12 column">
<div id="corpo">
  
  <p>
  <form class="form-inline" role="form" name="form1">
  <?php
	  	include_once('conexao.php');
		
		$query = "Select id_parcela, descricao from
					parcela where ativa='S' order by id_parcela;";
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
    <button type="button" class="btn btn-primary" id="button" onclick="envia_form('BUSCA')">Demonstrar</button>
    </form>
  </p>
  <div class="alert" id="erro">   </div>
  <div id="mostraResultado"></div>
</div>
</div>
</div>
</body>
</html>