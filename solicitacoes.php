<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4>Lista de Inscrições</h4>
  </div>
  <div class="panel-body">
    <p>Listagem de Solicitações feitas até o momento atual</p>
<hr>
<p style="font-style:italic; font-weight:bold">Selecione a Parcela</p>
<?php
include_once('intranet/conexao.php');
$query = "Select id_parcela, descricao from
					parcela where ativa='S'
					order by id_parcela desc;";
		$resultado = mysqli_query($link, $query)or die(mysqli_error($link));
		while($registro = mysqli_fetch_assoc($resultado)){
			$dados[] = array (
				'cod' => $registro['id_parcela'],
				'valor' => $registro['descricao']
			);
		}		
?>
<ul>
<?php
    if(isset($dados)){
	foreach($dados as $item) {
		$cod=base64_encode($item['cod']);
 	 echo "<li> <a href='?url=sol_lista&parc=$cod'> {$item['valor']} </a></li>";
	}
	}
?>
</ul>
</div>
</div>
