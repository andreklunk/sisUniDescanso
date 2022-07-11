<script type="text/javascript" src="intranet/js/jquery.min.js"></script>
<script src="intranet/js/jquery.maskedinput.js" type="text/javascript"></script>

<script language="javascript"> 
function validaForm(){
	var valor1 = document.getElementById('num_dias');		
	vlr = valor1.value;
if (vlr > 6) { 
	//alert('errrroo');
	    document.getElementById('erro').lastChild.data = "Nº de dias Presenciais não pode ser superior a 6  ";
		num_dias.focus();
		return false;
	}	else {	
	//limpar a DIV caso não tenha mais msg de erro
	 document.getElementById('erro').lastChild.data = "";
	 return true;
	}
}
</script>

<script type="text/javascript">
	
function verificaSuperior(emp){
var div = document.getElementById('div_'+ emp.id);

if (emp.checked == true)
div.style.display = 'block';
else
div.style.display = 'none';
} 
</script>

<style type="text/css">
.cl_superior{
	margin-top: 20px;
	margin-left: 50px;
	display: none;
}
</style>
<div class="panel panel-default">
  <!-- Default panel contents -->
<?php
	include_once('intranet/conexao.php');
	if(isset($_GET['cod_freq'])!=null){
		$codFreq = base64_decode($_GET['cod_freq']);
		$query = "Select F.id_pessoa, nome, sobrenome, cpf, id_parcela, id_curso, id_instituicao, 
			num_dias_trans,	num_disciplinas,num_reprovacao from pessoa P, frequencia F		
			where P.id_pessoa=F.id_pessoa and F.id_frequencia = '$codFreq'";
	}
	//echo $query;
	$resultado = mysqli_query($link,$query) or die (mysql_error($link));
	if(mysqli_num_rows($resultado)>0) {
		$reg = mysqli_fetch_array($resultado);
		$cpf = $reg['cpf'];
		$nome = $reg['nome'].' '.$reg['sobrenome'];
		$cod_pessoa = $reg['id_pessoa'];
		
		$parcelaSel=$reg['id_parcela'];
		$cursoSel=$reg['id_curso'];
		$instituicaoSel=$reg['id_instituicao'];
		$diasTrans = $reg['num_dias_trans'];
		$numDisc = $reg['num_disciplinas'];
		$numRep = $reg['num_reprovacao'];
	}
?>


<form action="frequencia_alteracaoBD.php" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return validaForm();">

<!-- Form Name -->
<legend>Dados de Frequência </legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="nome">Nome</label>
  <div class="col-md-5">
  <?php echo $nome; ?>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="cpf">CPF</label>
  <div class="col-md-5">
  <?php echo $cpf; ?>
  </div>
</div>



<div class="alert alert-warning" role="alert">Após concluir a Alteração, não esqueça de novamente imprimir o Comprovante de Solicitação</div>

<!-- Select Basic -->
<input type="hidden" name="idFreq" value="<?= $codFreq; ?>">
	
<div class="form-group">
  <label class="col-md-4 control-label" for="parcela">Parcela/Repasse</label>
  <div class="col-md-5">
  <?php
   	$query_parcela = "Select id_parcela, descricao from parcela where ativa = 'S'";
	$resultado_parcela = mysqli_query($link,$query_parcela) or die (mysqli_error($link));
	while ($reg_parcela = mysqli_fetch_assoc($resultado_parcela)) {
		$dados_parcela[] =  array(
						'cod'   =>$reg_parcela['id_parcela'] , 
						'valor' =>$reg_parcela['descricao']
					);
				
	}
  ?>
    <select name="parcela" required class="form-control" id="parcela">
    <option value=""> Selecione o Nível de Ensino correspondente </option>
      <?php
     	foreach ($dados_parcela as $item) {
		 $selected = ($parcelaSel == $item['cod'] ? 'selected' : null);
		 echo "<option value='{$item[cod]}' {$selected}>{$item[valor]}</option>";
	} ?>
    </select>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="instituicao">Instituição de Ensino</label>
  <div class="col-md-5">
  <?php
   	$query_inst = "Select id_instituicao, instituicao from instituicao order by instituicao asc";
	$resultado_inst = mysqli_query($link,$query_inst) or die (mysqli_error($link));
	while ($reg_inst = mysqli_fetch_assoc($resultado_inst)) {
		$dados_inst[] =  array(
						'cod'   =>$reg_inst['id_instituicao'] , 
						'valor' =>$reg_inst['instituicao']
					);
				
	}
  ?>
    <select name="instituicao" required class="form-control" id="instituicao">
    <option value=""> Instituição frequentada no semestre </option>
      <?php
     foreach ($dados_inst as $item) {
		 $selected = ($instituicaoSel == $item['cod'] ? 'selected' : null);
		 echo "<option value='{$item[cod]}' {$selected}>{$item[valor]}</option>";
	} ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="curso">Curso</label>
  <div class="col-md-5">
  <?php
   	$query_curso = "Select id_curso, curso from curso order by curso asc";
	$resultado_curso = mysqli_query($link,$query_curso) or die (mysqli_error($link));
	while ($reg_curso = mysqli_fetch_assoc($resultado_curso)) {
		$dados_curso[] =  array(
						'cod'   =>$reg_curso['id_curso'] , 
						'valor' =>$reg_curso['curso']
					);
				
	}
  ?>
    <select name="curso" required class="form-control" id="curso">
    <option value=""> Selecione o curso </option>
      <?php
     foreach ($dados_curso as $item) {
  		$selected = ($cursoSel == $item['cod'] ? 'selected' : null);
		 echo "<option value='{$item[cod]}' {$selected}>{$item[valor]}</option>";
	} ?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="num_dias">Nº Dias Transporte</label>  
  <div class="col-md-2">
  <input name="num_dias" type="number" required class="form-control input-md" id="num_dias" placeholder="Nº dias de transporte" max="6" min="1" title="Nº de dias que utiliza transporte" maxlength="1" value="<?= $diasTrans; ?>">    
  </div>Aulas presenciais por Semana
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="num_dias">Nº Disciplinas</label>  
  <div class="col-md-2">
  <input name="num_disciplina" type="number" required class="form-control input-md" id="num_disciplina" placeholder="Nº de Disciplinas no Semestre Atual" min="1" title="Nº de Disciplinas no Semestre Atual" maxlength="1" value="<?= $numDisc; ?>">     
  </div>Frequentadas no Semestre
</div>
 

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="num_dias">Nº Disciplinas Reprovadas</label>  
  <div class="col-md-2">
  <input name="num_reprovacao" type="number" class="form-control input-md" id="num_reprovacao" placeholder="Nº de Disciplinas Reprovadas" min="0" title="Nº de Disciplinas Reprovadas" maxlength="1" value="<?= $numRep; ?>">    
  </div>
</div>



<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="salvar"></label>
  <div class="col-md-4">
    <button id="salvar" name="salvar" class="btn btn-primary">Salvar Alterações</button>
    <input name="cod_pessoa" type="hidden" id="cod_pessoa" value="<?php echo $cod_pessoa; ?>">
            <p><div id="erro" style="color:#FFF; margin-left:15px"> </div></p>
		<p> </p>

  </div>
</div>



</form>

</div>

<!-- Abre/Esconde a parte dos dados  conforme situação -->
<script type="text/javascript">
window.onload=verificaSuperior(reprovacao);
</script>