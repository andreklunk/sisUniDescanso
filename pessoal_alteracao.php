<div class="panel panel-default">
  <!-- Default panel contents -->
<?php
include_once('intranet/conexao.php');
$cpf = $_POST['valor1'];
$query = "Select * from pessoa where cpf = '$cpf';";
$resultado = mysqli_query($link,$query) or die (mysqli_error());
//if(mysqli_num_rows($resultado)>0) {
	$reg = mysqli_fetch_array($resultado);
	$cod_pessoa = $reg['id_pessoa'];
	$associacao = $reg['id_associacao'];
	$nome = $reg['nome'];
	$sobrenome = $reg['sobrenome'];
	$rg = $reg['rg'];
	$endereco = $reg['endereco'];
	$telefone = $reg['telefone'];
	$email = $reg['email'];
	$banco = $reg['banco'];
	$agencia = $reg['agencia'];
	$conta = $reg['conta'];
	$pix = $reg['pix'];
	$tp_conta = $reg['tipo_conta'];
	$obs = $reg['obs'];
?>
  
	<script type="text/javascript" src="intranet/js/jquery.min.js"></script>
     <script src="intranet/js/jquery.maskedinput.js" type="text/javascript"></script>

<script language="javascript"> 
function validaData(){
	var valor1 = document.getElementById('cpf');		
	vlr = valor1.value;
if (!vlr) {
	    document.getElementById('erro').lastChild.data = "Favor preencher o CPF ";
		//alert("Intervalo entre as datas superior a 30 dias!");
		cpf.focus();
		return false;
	}		
//limpar a DIV caso não tenha mais msg de erro
 document.getElementById('erro').lastChild.data = "";
}

jQuery(function($){
	$("#telefone").mask("(99)99999-9999",{placeholder:"(xx)xxxxx-xxxx"});
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
  // $("#phone").mask("(999) 999-9999");
  // $("#tin").mask("99-9999999");
  // $("#ssn").mask("999-99-9999");
});
</script>

<script type="text/javascript">
function verificaConta(emp){
var div = document.getElementById('div_'+ emp.id);

if (emp.checked == true)
div.style.display = 'block';
else
div.style.display = 'none';
}
</script>

<style type="text/css">
.cl_conta{
	margin-top: 20px;
	margin-left: 50px;
	display: none;
}
</style>


<form action="pessoal_alteracaoBD.php" method="post" enctype="multipart/form-data" class="form-horizontal">
<!-- Form Name -->
<legend>Cadastro dos Dados Pessoais</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="cpf">CPF</label>  
  <div class="col-md-4"><input name="cpf2" type="hidden" id="cpf2" value="<?php echo $cpf; ?>"><?php echo $cpf; ?>
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nome">Nome</label>  
  <div class="col-md-6">
  <input name="nome" type="text" required class="form-control input-md" id="nome" placeholder="Informe seu nome" value="<?php echo $nome; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="sobrenome">Sobrenome</label>  
  <div class="col-md-4">
  <input name="sobrenome" type="text" required class="form-control input-md" id="sobrenome" placeholder="Informe apenas o Sobrenome" value="<?php echo $sobrenome; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="rg">RG</label>  
  <div class="col-md-4">
  <input name="rg" type="text" class="form-control input-md" id="rg" placeholder="Documento de Identidade" value="<?php echo $rg; ?>">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="endereco">Endereço</label>  
  <div class="col-md-6">
  <input name="endereco" type="text" class="form-control input-md" id="endereco" placeholder="Rua, nº, localidade, etc" value="<?php echo $endereco; ?>">
  <span class="help-block"> </span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="endereco">Telefone/Celular</label>  
  <div class="col-md-6">
  <input name="telefone" type="text" class="form-control input-md" id="telefone" placeholder="Nº telefone" value="<?php echo $telefone; ?>">
  <span class="help-block"> </span>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="endereco">E-Mail</label>  
  <div class="col-md-6">
  <input name="email" type="text" required class="form-control input-md" id="email" placeholder="Informe e-mail válido!" value="<?php echo $email; ?>">
  <span class="help-block"> </span>  
  </div>
</div>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="associacao">Associação Filiada</label>
  <div class="col-md-6">
     <?php
   	$query_ass = "Select id_associacao, razao_social from associacao order by sigla asc";
	$resultado_ass = mysqli_query($link,$query_ass) or die (mysqli_error());
	while ($reg_ass = mysqli_fetch_assoc($resultado_ass)) {
		$dados_assoc[] =  array(
						'cod'   =>$reg_ass['id_associacao'] , 
						'valor' =>$reg_ass['razao_social']
					);				
	}
  ?>
  <select id="associacao" name="associacao" class="form-control">
    <?php
	 $selecionado = $associacao;
     foreach ($dados_assoc as $item) {
  		$selected = ($selecionado == $item['cod'] ? 'selected' : null);
  		echo "<option value='{$item[cod]}' {$selected}>{$item[valor]}</option>";
	} ?>
    </select>
  </div>
</div>
<fieldset class="table-bordered">
<br>

<div class="form-group">
  <label class="col-md-4 control-label" for="banco">Conta Bancária</label>
    <div class="col-md-6">
    <input name="temConta" type="checkbox" id="temConta" onClick="verificaConta(this);" value="S" checked <?php if($conta) echo "checked='checked'"; ?>>&nbsp;Selecione para informar a conta bancária
    </div>
</div> 
  
<div class="cl_conta" id="div_temConta"><!-- Div Possuo Conta -->
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="banco">Banco</label>
  <div class="col-md-4">
  <?php
	 $bancos = array(
		1=>array("valor"=>"BB","descricao"=>"Banco do Brasil"),
		2=>array("valor"=>"Sicoob","descricao"=>"Sicoob"),
		3=>array("valor"=>"Sicredi","descricao"=>"Sicredi"),
		4=>array("valor"=>"Bradesco","descricao"=>"Bradesco"),
		5=>array("valor"=>"Caixa","descricao"=>"Caixa Econômica")
		);
      $selecionado = $banco;	 
    ?>  
    <select name="banco" required class="form-control" id="banco">
    <option value="">Selecione um Banco</option>
     <?php
     foreach ($bancos as $item) {
   		$selected = ($selecionado == $item['valor'] ? 'selected' : null);
  		echo "<option value='{$item[valor]}' {$selected}>{$item[descricao]}</option>";
	} ?>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tp_conta">Tipo de Conta Bancária</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="tp_conta-0">
      <input name="tp_conta" id="tp_conta-0" value="C" <?php if($tp_conta == 'C') { echo "checked=checked"; } ?> type="radio">
      Corrente
    </label> 
    <label class="radio-inline" for="tp_conta-1">
      <input name="tp_conta" id="tp_conta-1" value="P" <?php if($tp_conta == 'P') { echo "checked=checked"; } ?> type="radio">
      Poupança
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="agencia">Nº Agência</label>  
  <div class="col-md-4">
  <input name="agencia" type="text" class="form-control input-md" id="agencia" placeholder="Agência Bancária" value="<?php echo $agencia; ?>">
  <span class="help-block"> </span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="conta">Nº Conta</label>  
  <div class="col-md-4">
  <input name="conta" type="text" class="form-control input-md" id="conta" placeholder="Número da Conta Bancária" value="<?php echo $conta; ?>">    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pix">Chave PIX</label>  
  <div class="col-md-6">
  <input name="pix" type="text" class="form-control input-md" id="pix" placeholder="Chave PIX" value="<?php echo $pix; ?>" required>    
  </div>
</div>

</div> <!--fim do div Possuo Conta-->
</fieldset>
<br>
<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="obs">Observações</label>
  <div class="col-md-6">                     
    <textarea name="obs" class="form-control" id="obs" placeholder="Somente se necessário"><?php echo $obs; ?></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="salvar"></label>
  <div class="col-md-4">
    <button id="salvar" name="salvar" class="btn btn-primary">SALVAR</button>
    <input name="cod_pessoa" type="hidden" id="cod_pessoa" value="<?php echo base64_encode($cod_pessoa); ?>">
  </div>
</div>


</form>
</div>

<!-- Abre/Esconde a parte dos dados bancarios conforme situação -->
<script type="text/javascript">
window.onload=verificaConta(temConta);
</script>