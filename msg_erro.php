<?php
//	include "intranet/sessao.php";
if($_GET['acao']=='V'){
	echo "ola";
}
?>
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
</script>

<script language="javascript" type="text/javascript">
// limpando a div antes de um novo envio
function envia_form(lk) {
jQuery("#mostraResultado").empty();
	      
// pegando os campos do formulário
var valor1 = document.getElementById('cpf').value;

if(lk=='BUSCA')
 	var endereco = 'dadosPessoais.php?valor1='+valor1;
else
	var endereco = 'limpa.php';
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
</head>

<body>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4 style="color:#F00"> Erro ao tentar Salvar os Dados Informados </h4>
  </div>
  <div class="panel-body">
        <p> Tente efetuar o procedimento novamente </p>
        <p></p>
   </div>
</div>

