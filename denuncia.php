<script type="text/javascript">
jQuery(function($){
	$("#cpf").mask("999.999.999-99",{placeholder:"xxx.xxx.xxx-xx"});
 //  $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
  // $("#phone").mask("(999) 999-9999");
  // $("#tin").mask("99-9999999");
  // $("#ssn").mask("999-99-9999");
});
</script>

<div class="container">
	<div class="row clearfix">
	  <div class="col-md-8 column" style="width:600px; margin:0 auto;">
			<h3 class="text-center">
				 Espaço para Denúncias 	
		  </h3>
		  <form action="mail_denuncia.php" method="post" enctype="multipart/form-data" role="form">
				<div class="form-group">
					 <label>Nome do Denunciante</label><input name="denunciante" type="text" required class="form-control" id="denunciante" placeholder="Preenchimento Opcional">
				</div>
				<div class="form-group">
					 <label>Nome do Denunciado*</label><input name="denunciado" type="text" required class="form-control" id="denunciado" placeholder="Beneficiado a ser denunciado" title="Preenchimento Obrigatório">
				</div>
        
                <div class="form-group"><label>Descreva aqui o teor da denúncia*</label>	<br>	<textarea name="denuncia" rows="5" required class="form-control" id="denuncia"></textarea>

				</div>
				<button type="submit" class="btn btn-default">Enviar</button>
			</form>
		</div>
	</div>
</div>
