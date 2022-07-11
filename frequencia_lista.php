<div class="panel panel-default">
	   <h4>Solicitações Anteriores - Impressão 2ª Via Comprovante </h4>
 <style type="text/css">
 #dados {
	 font-style:italic;
	 font-weight:bold;
 }	 
 </style>   
<?php
	include_once "intranet/conexao.php";
	if(isset($_GET['id'])!=null){
		$cod_p = base64_decode($_GET['id']);
		$query = "Select PA.id_parcela, F.id_frequencia, ano, semestre, descricao from pessoa PE, frequencia F, parcela PA
			where F.id_pessoa=PE.id_pessoa and F.id_parcela=PA.id_parcela and PE.id_pessoa=$cod_p
			order by id_parcela desc;";
	} else {
		$cpf = $_GET['valor1'];
		$query = "Select PA.id_parcela, F.id_frequencia, ano, semestre, descricao, dt_inicio, dt_fim from pessoa PE, frequencia F, parcela PA
			where F.id_pessoa=PE.id_pessoa and F.id_parcela=PA.id_parcela and PE.cpf='$cpf'
			order by id_parcela desc;";
	}
//	echo $query;
	$resultado = mysqli_query($link,$query) or die (mysqli_error($link));
	$dt_hoje = date('Y-m-d');
?>
   <ul>
	   <?php 
	   	while($reg = mysqli_fetch_array($resultado)) {
			$cod_parcela = $reg['id_parcela'];
			$cod_freq = $reg['id_frequencia'];
				$idFreq=base64_encode($cod_freq);
			$ano = $reg['ano'];
			$semestre = $reg['semestre'];
			$descricao = $reg['descricao'];	
			$dt_inicio = $reg['dt_inicio'];
			$dt_fim = $reg['dt_fim'];
		?>
	  <li><?= $descricao; ?> >><a href="index.php?url=inscOK&cod_freq=<?= $idFreq; ?>" class="text-success"> Imprimir </a> 
		  <?php
			if (($dt_hoje>=$dt_inicio) and ($dt_hoje<=$dt_fim)) {
		  ?>	
			|| <a href="index.php?url=freqAlt&cod_freq=<?=$idFreq;?>" class="text-danger">Alterar/Corrigir Solicitação</a>
		  <?php	} ?>  </li> <?php } ?>
	  </ul>

	
	<?php //include_once('frequencia_cadastro.php'); ?>	

</div>

