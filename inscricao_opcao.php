<?php
include_once('intranet/conexao.php');

//VERIFICAÇÃO SE EXISTE PARCELA EM DATA PARA SER PERMITIDO CADASTRO
include_once('intranet/conexao.php');
$dt_hoje = date('Y-m-d');
$sql = "Select count(id_parcela) as qtde from parcela where '$dt_hoje' between dt_inicio and dt_fim and ativa = 'S';";
$resultado = mysqli_query($link,$sql) or die (mysqli_error());
$reg = mysqli_fetch_array($resultado);
if($reg['qtde']>0){

$cpf = $_POST['valor1'];
$query = "Select id_pessoa from pessoa where cpf = '$cpf';";
$resultado = mysqli_query($link,$query) or die (mysqli_error());
$reg = mysqli_fetch_array($resultado);
	$cod_pessoa = $reg['id_pessoa']??'';
	$cod_p=base64_encode($cod_pessoa);
	if($cod_pessoa==null) {
	include_once('pessoal_cadastro.php');
	} else {			
		echo "<hr>";
		echo "<p style='text-align:center; margin-top:10px;'>";
		echo " Antes de Solicitar Novo Auxílio, confira e atualize seus dados cadastrais!!! <hr>";
		echo "<p style='text-align:center;'>";
		echo "<button type='button' class='btn btn-info' onclick=envia_form('ATUALIZA');>Atualizar dados Pessoais</button> &nbsp;&nbsp;&nbsp;";
		echo "<button type='button' class='btn btn-success'  onclick=envia_form('FREQ_CAD');>Solicitar Novo Auxílio</button> &nbsp;&nbsp;&nbsp;";
		echo "</p>";
		//opção de anexar documentos em teste
		//echo "<a href=index.php?url=doc&cod_p=$cod_p><button type='button' class='btn btn-warning'>Anexar Documentos</button></a> <br/>";
		
	} 
} else { ?>
<div class="panel panel-body">
        <p><?='Hoje: <b>'.date('d/m/Y');?></b> </p>
	 	<?php
		$sql = "Select distinct date_format(dt_inicio,'%d/%m/%Y') as dt_inicio, date_format(dt_fim,'%d/%m/%Y')as dt_fim 
		from parcela where '$dt_hoje' < dt_inicio and ativa = 'S';";
		$resultado = mysqli_query($link,$sql) or die (mysqli_error());
		$reg = mysqli_fetch_array($resultado);
		if(isset($reg['dt_inicio'])!=''){
			echo "<p>Início inscrições: <b>$reg[dt_inicio]</b><br>";
			echo "Fim das inscrições: <b>$reg[dt_fim]</b></p>";
		} else {
			echo  "<p>Data sem permissão para novos cadastros!</p>";
		}
	   }
	echo "</p><br/>";
	include_once('frequencia_lista.php');
?>
 </div>
