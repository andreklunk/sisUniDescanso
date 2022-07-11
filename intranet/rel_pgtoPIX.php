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
var valor1 = document.getElementById('ano').value;
var valor2 = document.getElementById('semestre').value;
var valor3 = document.getElementById('banco').value;
endereco = lk+'?ano='+valor1+'&semestre='+valor2+'&banco='+valor3;
if((valor1=='')||(valor2=='')){
document.getElementById('erro').lastChild.data = "Advertência: Favor informar ano/semestre";
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
<h3> Relatório de Pagamentos </h3> 
  <p>
  <form class="form-inline" role="form" name="form1">
  <div class="col-md-4">
     <label for="ano">Ano:</label>
     <input type="text" name="ano" id="ano">
  </div>
  <div class="col-md-4">
     <label for="semestre">Semestre:</label>
     <input type="text" name="semestre" id="semestre">
  </div> 
  <div class="col-md-6">
   <?php
   include_once("conexao.php");
  	 $query2 = "Select distinct banco from
					pagamento order by banco desc;";
		$resultado2 = mysqli_query($link, $query2)or die(mysqli_error($link));
		while($registro2 = mysqli_fetch_assoc($resultado2)){
			$dados2[] = array (
				'banco' => $registro2['banco'],
			);
		}
	?>	
    <label for="banco">Banco:</label>	
    <select name="banco" id="banco" class="form-control">
    <option value="" selected="selected"> Qualquer Banco </option>
    <option value="S"> Banco Não Informado </option>    
     <?php
	foreach($dados2 as $item2) {
 	 echo "<option value='{$item2[banco]}'>{$item2[banco]}</option>";
	}
	?>
    </select>
    </div>
    <button type="button" class="btn btn-primary" id="button" onclick="envia_rel('pdf_pgtoPIX.php')">Imprimir</button>
    </form>
    <div class="alert" id="erro">   </div>
  </p>
  

</div>
</div>
</div>
</body>
</html>