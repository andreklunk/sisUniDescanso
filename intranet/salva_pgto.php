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


include_once('conexao.php');
$cod = $_GET['cod'];

/* INSERE OS VALORES NA TABELA PAGAMENTO */
$query = "DELETE FROM pagamento WHERE id_parcela=$cod;";
mysqli_query($link, $query);
if($_GET['tp']=='T'){
$query = "INSERT INTO pagamento (id_frequencia, id_parcela, nome, cpf, banco, agencia,
			 conta, pix, tipo_conta, valor) 
		Select F.id_frequencia, PA.id_parcela, CONCAT(nome,' ',sobrenome) AS nome, cpf, banco, agencia,
			 conta, pix, tipo_conta,((num_dias_trans-num_reprovacao)*valor_dia) as valor
			 from pessoa P, frequencia F, parcela PA
			 where P.id_pessoa=F.id_pessoa
			 and F.id_parcela=PA.id_parcela
			 and F.validacao='S'
			 and PA.id_parcela = '$cod'
			  order by nome";
} elseif ($_GET['tp']=='P'){
$soma_dias=$_GET['soma_dias'];
$query = "INSERT INTO pagamento (id_frequencia, id_parcela, nome, cpf, banco, agencia,
			 conta, pix, tipo_conta, valor) 
		Select F.id_frequencia, PA.id_parcela, CONCAT(nome,' ',sobrenome) AS nome, cpf, banco, agencia,
			 conta, pix, tipo_conta,((num_dias_trans*valor_dia)/$soma_dias) as valor
			 from pessoa P, frequencia F, parcela PA
			 where P.id_pessoa=F.id_pessoa
			 and F.id_parcela=PA.id_parcela
			 and F.validacao='S'
			 and PA.id_parcela = '$cod'
			  order by nome";
}elseif ($_GET['tp']=='D'){
$soma_disc=$_GET['soma_disc'];
$query = "INSERT INTO pagamento (id_frequencia, id_parcela, nome, cpf, banco, agencia,
			 conta, pix, tipo_conta, valor) 
		Select F.id_frequencia, PA.id_parcela, CONCAT(nome,' ',sobrenome) AS nome, cpf, banco, agencia,
			 conta, pix, tipo_conta,
			 IF((num_disciplinas <= 6), ((num_disciplinas*valor_dia)/$soma_disc),((6*valor_dia)/$soma_disc)) as valor
			 from pessoa P, frequencia F, parcela PA
			 where P.id_pessoa=F.id_pessoa
			 and F.id_parcela=PA.id_parcela
			 and F.validacao='S'
			 and PA.id_parcela = '$cod'
			  order by nome";
} elseif ($_GET['tp']=='S'){
$query = "INSERT INTO pagamento (id_frequencia, id_parcela, nome, cpf, banco, agencia,
			 conta, pix, tipo_conta, valor) 
		Select F.id_frequencia, PA.id_parcela, CONCAT(nome,' ',sobrenome) AS nome, cpf, banco, agencia,
			 conta, pix, tipo_conta,valor_dia as valor
			 from pessoa P, frequencia F, parcela PA
			 where P.id_pessoa=F.id_pessoa
			 and F.id_parcela=PA.id_parcela
			 and F.validacao='S'
			 and PA.id_parcela = '$cod'
			  order by nome";
}
if(!mysqli_query($link, $query)) {
	echo mysqli_error($link);
	exit;
}
?>

<?php
/* BUSCA INFORMAÇÕES PARA GERAR O CABEÇALHO */
$q = "Select id_parcela, nivel, descricao, semestre, ano, valor_dia, tp_pgto
	  from parcela P, nivel N
	  where P.id_nivel = N.id_nivel
	  and P.id_parcela = '$cod';";
$r = mysqli_query($link, $q);
$reg = mysqli_fetch_array($r);
	$cod_parcela = $reg['id_parcela'];
	$parcela = $reg['descricao'];
	$semestre = $reg['semestre'];
	$ano = $reg['ano'];
	$nivel = $reg['nivel'];
	if($reg['tp_pgto']=='T') {
		$pgto = "Valor por dia: ".$reg['valor_dia'];
	} else {
		$pgto = "Valor por Semestre: ".$reg['valor_dia'];
	}
	$valor_dia = $reg['valor_dia'];
?>
<hr>
<p>Parcela: <?php echo $cod_parcela.' - '.$parcela; ?></p>
<p>Semestre/Ano: <?php echo $semestre.'/'.$ano; ?></p>
<p><?php echo $pgto; ?></p>
  <table class="table table-striped">
  <tr>
    <th align="center">#</th>
    <th>ALUNO</th>
    <th align="center">CPF</th>
    <th align="center">BANCO</th>
    <th align="center">AGÊNCIA</th>
    <th align="center">CONTA</th>
    <th align="center">TP. CONTA</th>
    <th align="center">VALOR</th>
  </tr>
  <?php
/* GERA O RELATÓRIO DAS INFORMAÇÕES DO PAGAMENTO */

$query = "Select id_parcela, id_frequencia, nome, cpf, banco, agencia, conta, tipo_conta, valor
         from pagamento where id_parcela = '$cod' order by nome asc";
$resultado = mysqli_query($link, $query)or die(mysqli_error($link));
  while($registro=mysqli_fetch_array($resultado)){
	  
     	$num = $num + 1;
		$nome = $registro['nome'];
			$nome = mb_strtoupper($nome);
		$cpf = $registro['cpf'];
		$banco = $registro['banco']; 
		$agencia = $registro['agencia'];  
		$conta = $registro['conta'];
		if($registro['tipo_conta']=='C'){
			$tp_conta = 'Corrente';
		} elseif ($registro['tipo_conta']=='P'){
			$tp_conta = 'Poupança';
		} else {
			$tp_conta = '';	
		}
		$valor = $registro['valor'];

		$valor = number_format($valor, 2, ',', '.');
		$total = $total+$valor;
  ?> 
  <tr>
    <td align="center"><?php echo $num; ?></td>
    <td><?php echo $nome; ?></td>
    <td><?php echo $cpf; ?></td>
    <td><?php echo $banco; ?></td>
    <td><?php echo $agencia; ?></td>
    <td><?php echo $conta; ?></td>
    <td><?php echo $tp_conta; ?></td>
    <td align="right"><?php echo $valor; ?></td>
  </tr>
  <?php
  	}
  ?>
   <tr>
    <td colspan="8" align="right"><strong><?php echo 'VALOR TOTAL - R$ '. number_format($total, 2, ',', '.'); ?></strong></td>
  </tr>
</table>
  </p>