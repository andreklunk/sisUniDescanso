<script language="javascript" type="text/javascript">
// limpando a div antes de um novo envio
function envia_pgto(lk) {
window.location = lk;
}
</script>

<p>
<?php
	include_once('conexao.php');
	
	/*function calcula_vlr_proporcional($parc) {
    $sql_dias = "Select sum(num_dias_trans)as total_dias from frequencia F, parcela P
		where F.id_parcela=P.id_parcela and P.id_parcela = $parc
		and F.validacao='S';";
	$res = mysqli_query($link, $sql_dias);
    $reg=mysqli_fetch_array($res);
    return $reg['total_dias'];
	} */
	
	if($_POST['valor1']) {
		$cod = $_POST['valor1'];
		$sql_dias = "Select sum(num_dias_trans)as total_dias, 
		sum(IF(num_disciplinas<=6,num_disciplinas,6))as total_disciplinas
		from frequencia F, parcela P
		where F.id_parcela=P.id_parcela and P.id_parcela = $cod
		and F.validacao='S';";
		$res = mysqli_query($link, $sql_dias);
    	$reg=mysqli_fetch_array($res);
		$soma_dias_trans = $reg['total_dias'];
		$soma_disciplinas = $reg['total_disciplinas'];
		//$soma_dias_trans = calcula_vlr_proporcional($cod);
	} else  {
		$cod = 0;		
	}

	if(!$soma_dias_trans)
		$soma_dias_trans = 0;
	if(!$soma_disciplinas)
		$soma_disciplinas = 0;
	//SQL LIMITA DISCIPLINAS AO MÁXIMO 06
	$query = "Select nome, sobrenome, num_dias_trans, num_disciplinas, num_reprovacao,
			 valor_dia, tp_pgto, ((num_dias_trans-num_reprovacao)*valor_dia) as total_T,
			 ((num_dias_trans*valor_dia)/$soma_dias_trans) as total_P,
			  IF ((num_disciplinas <= 6), ((num_disciplinas*valor_dia)/$soma_disciplinas),((6*valor_dia)/$soma_disciplinas) ) as total_D
			 from pessoa P, frequencia F, parcela PA
			 where P.id_pessoa=F.id_pessoa
			 and F.id_parcela=PA.id_parcela
			 and F.validacao='S'
			 and PA.id_parcela = $cod
			  order by nome";
	$resultado = mysqli_query($link, $query);
?>
Somente as Inscrições validadas serão computadas
  <table class="table table-striped">
  <tr>
    <th align="center">#</th>
    <th>Aluno</th>
    <th align="center">Dias Transp.</th>
    <th align="center">Reprovações</th>
    <th align="right">Valor Gerado</th>
  </tr>
  <?php
  while($registro=mysqli_fetch_array($resultado)){
		$num = $num + 1;
		$nome = $registro['nome'].' '.$registro['sobrenome'];
			$nome = mb_strtoupper($nome);
		$num_dias = $registro['num_dias_trans']; 
		$num_rep = $registro['num_reprovacao'];  
		$vlr_dia = $registro['valor_dia'];
		$tp_pgto = $registro['tp_pgto'];
		$total_T = $registro['total_T'];
		$total_P = $registro['total_P'];
	  	$total_D = $registro['total_D'];
		
		if($tp_pgto=='T') { //caso for fixo por dias de transporte-disciplinas
			$valor = $total_T;			
		} elseif ($tp_pgto=='P') {//caso for proporcional por dias de transporte
			//$valor = ($vlr_dia * $num_dias)/calcula_vlr_proporcional($cod);
			$valor = $total_P;
		} elseif ($tp_pgto=='D') {//caso for proporcional por DISCIPLINAS			
			$valor = $total_D;
		} else {//caso for fixo por dia
			$valor = $vlr_dia;
		}
		
		$valorPrint = number_format($valor, 2, ',', '.');
		$total = $total+$valor;
  ?> 
  <tr>
    <td align="center"><?php echo $num; ?></td>
    <td><?php echo $nome; ?></td>
    <td align="center"><?php echo $num_dias; ?></td>
    <td align="center"><?php echo $num_rep; ?></td>
    <td align="center"><?php echo $valorPrint; ?></td>
  </tr>
  <?php
  	}
  ?>
   <tr>
    <td colspan="5" align="right"><strong><?php echo 'VALOR TOTAL - R$ '. number_format($total, 2, ',', '.'); ?></strong></td>
  </tr>
</table>
  </p>

  <p align="right">
  <form class="form-inline" role="form" name="form1">
    <button type="button" class="btn btn-primary" id="button" onclick="envia_pgto('inicial.php?url=salva_pgto&cod=<?php echo $cod; ?>&tp=<?php echo $tp_pgto; ?>&soma_dias=<?=$soma_dias_trans;?>&soma_disc=<?=$soma_disciplinas;?>')">Salvar Pagamento</button>
 </form>
  </p>