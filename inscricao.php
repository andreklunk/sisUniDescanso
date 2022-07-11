<script type="text/javascript" src="intranet/js/jquery.min.js"></script>
<script src="intranet/js/jquery.maskedinput.js" type="text/javascript"></script>

<script language="javascript"> 
function validarCPF(cpf) { 
if (!cpf.value) {
	    document.getElementById('erro').lastChild.data = "Favor preencher o CPF ";
		cpf.focus();
		return false;
}
     // Elimina mascaras  
	cpf = cpf.value.replace(/[^\d]+/g,''); 
 
    if(cpf == '') return false; 
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999") {
         	document.getElementById('erro').lastChild.data = "CPF informado Inválido";
 			cpf.focus();
		   return false;     
		}
    // Valida 1o digito 
    add = 0;    
    for (i=0; i < 9; i ++)       
        add += parseInt(cpf.charAt(i)) * (10 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11)     
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9)))  {
			document.getElementById('erro').lastChild.data = "CPF informado Inválido ";  
			cpf.focus(); 
            return false;       }
    // Valida 2o digito 
    add = 0;    
    for (i = 0; i < 10; i ++)        
        add += parseInt(cpf.charAt(i)) * (11 - i);  
    rev = 11 - (add % 11);  
    if (rev == 10 || rev == 11) 
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10))) {
		document.getElementById('erro').lastChild.data = "CPF informado Inválido ";
		cpf.focus();
        return false;       } else {
     document.getElementById('erro').lastChild.data = "";
	return true;   }
}

jQuery(function($){
	$("#cpf").mask("999.999.999-99",{placeholder:"xxx.xxx.xxx-xx"});
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
  // $("#phone").mask("(999) 999-9999");
  // $("#tin").mask("99-9999999");
  // $("#ssn").mask("999-99-9999");
});

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

//impede ENTER submeter formulário
function handleEnter (field, event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
					break;
			i = (i + 1) % field.form.elements.length;
			field.form.elements[i].focus();
			return false;
		} 
		else 
		return true; 
	}      
</script>

<script language="javascript" type="text/javascript">
// limpando a div antes de um novo envio
function envia_form(lk) {
jQuery("#mostraResultado").empty();
	      
// pegando os campos do formulário
var valor1 = document.getElementById('cpf').value;
var vlr = document.getElementById('cpf');
if(lk == 'BUSCA') {
 	var endereco = 'inscricao_opcao.php?valor1='+valor1;
} else if (lk == 'ATUALIZA') {	
	var endereco = 'pessoal_alteracao.php?valor1='+valor1;
} else if (lk == 'DOC_PES') {	
	var endereco = 'documentacao.php?valor1='+valor1;
} else if (lk == 'FREQ_CAD') {	
	var endereco = 'frequencia_cadastro.php?valor1='+valor1;
} else if (lk == 'LIMPA') {	
	var endereco = 'limpa.php';
	document.getElementById('cpf').value = "";
	document.getElementById('cpf').focus();
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

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4>Inscrição para Requisição de Auxílio Estudante</h4>
  </div>
 
 
  <div class="panel-body">
        <p>Preencha corretamente todos os seus dados pessoais</p>
        <p></p>
   </div>

	<form class="form-inline" role="form" name="form1">
		&nbsp;&nbsp;&nbsp;&nbsp;<label>Informe o CPF*&nbsp;</label><input name="cpf" type="text" required class="form-control" id="cpf" style="width:200px;" onkeydown="if (event.keyCode == 13) document.getElementById('button').click()" onkeypress="return handleEnter(this, event)" >	
		<button type="button" class="btn btn-primary" id="button" onclick="envia_form('LIMPA_DIV'); if(validarCPF(form1.cpf)!=false) {; envia_form('BUSCA');  }">Enviar</button>
        <button type="reset" class="btn btn-default" onclick="envia_form('LIMPA')">Limpar</button>
        <p><div id="erro" style="color:#FFF; margin-left:15px">&nbsp; </div></p>
<p> </p>
	</form>
<div id="mostraResultado"></div>



</div>

