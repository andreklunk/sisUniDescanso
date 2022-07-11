<div class="panel panel-default">
<?php
include_once('intranet/conexao.php');
include_once('intranet/config.inc.php');
$cod = base64_decode($_GET['parc']);
//$tp = 'N';
$query = "Select F.id_parcela, ano, semestre, descricao, nome, sobrenome, cpf,  
         instituicao, curso, num_disciplinas, num_dias_trans, dt_homologacao,
		 CASE F.validacao
		 	when 'S' then 'Sim'
			when 'N' then 'Não'
		 END as validacao
         from frequencia F, parcela PA, pessoa PE, instituicao I, curso C
		 where F.id_parcela=PA.id_parcela and F.id_instituicao=I.id_instituicao
		 and F.id_pessoa=PE.id_pessoa and F.id_curso=C.id_curso";
//if($tp=='S') 
//	$query .= " and F.validacao = 'S'";
//if($tp=='N') 
//	$query .= " and F.validacao = 'N'";
$query .= " and PA.id_parcela = '$cod' order by nome asc, sobrenome asc";
$resultado = mysqli_query($link, $query)or die(mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$parcela = $reg['descricao']??'';
		$semestre = $reg['semestre']??'';
		$ano = $reg['ano']??'';
		if(isset($reg['dt_homologacao'])) {
			$dt_homologacao = date('d/m/Y', strtotime($reg['dt_homologacao']));
		} else $dt_homologacao = 'Sem data informada'; 
?>
  <div class="panel-heading">
      <h3>Lista de Inscrições</h3>
      <h4> Referência: <?= "$semestre/$ano"; ?> </h4>
      <p align="center">Previsão para Homologação do Resultado: <?= $dt_homologacao; ?><br>
Dúvidas, favor entrar em contato com a Secretaria de Educação </p>
  </div>
  <div class="panel-body">
<style type="text/css">
* {
	font-size: 1em;
}
th {
	text-align:center;
}

td {
	font-size: 0.8em;	
}
</style>
 <table width="100%" >
  <tr style="background-color:#666">
    <th>NOME</th>
    <th>INSTITUIÇÃO</th>
    <th>CURSO</th>
    <th>DISC.&nbsp;</th>
    <th>TRANSP.&nbsp;</th>
    <th>VALIDAÇÃO</th>
  </tr>
<?php
$res = mysqli_query($link, $query) or die (mysqli_error($link));
//inicilizar as variáveis
$num = 0;
$zebrado = true ;
while($registro=mysqli_fetch_array($res)){
	$num = $num + 1;
	$nome = $registro['nome'];		
		//$nome = utf8_decode(htmlspecialchars_decode($nome));
		//$nome = mb_strtoupper($nome,'iso-8859-1');
	$sobrenome = $registro['sobrenome'];			
	//	$sobrenome = utf8_decode(htmlspecialchars_decode($sobrenome));
		//$sobrenome = mb_strtoupper($sobrenome,'iso-8859-1');		
	$nome = mb_strtoupper($nome.' '.$sobrenome,'utf-8');
	$cpf = substr($registro['cpf'],0,3).'.XXX.XXX-'.substr($registro['cpf'],-2);
	$curso =  $registro['curso'];
	$instituicao =  $registro['instituicao'];
	$disciplinas = $registro['num_disciplinas'];
	$transp = $registro['num_dias_trans'];
	$validacao = $registro['validacao'];
//cor de fundo... obs, ao final da linha, acrescentar TRUE
if (!$zebrado){
    $corFundo = "";
	$corTexto = "";
    $zebrado = true ;
} else {
    $corFundo = "#999";
	$corTexto = "#333";
    $zebrado = false ;	
}
$corNaoValidado = '#F00';
?>
  <tr style="background-color:<?=$corFundo;?>;color:<?=$corTexto;?>">
    <td style="border:none; text-align:left"><?=$nome;?></td>
    <td style="border:none; text-align:left"><?=$instituicao;?></td>
    <td style="border:none; text-align:left"><?=$curso;?></td>
    <td style="border:none;" align="center"><?=$disciplinas;?></td>
    <td style="border:none;" align="center"><?=$transp;?></td>
    <td style="border:none; color:<?php if($validacao=='Não') echo $corNaoValidado;?>" align="center"><?=$validacao;?></td>
  </tr>
<?php
}

?>
</table>
Nº Inscrições: <?=$num??'';?>
<hr>
<p align="center">Secretaria Municipal de Educação de <?=$municipio; ?>!!!<br>
Fone: <?=$fone_contato;?> </p>
</div>
</div>

