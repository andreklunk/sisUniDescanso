<style>
.mensagem {
    display: block; 
    position: fixed; 
    left: 40%; 
    right: 20%; 
    width: 30%; 
    padding-top: 10px; 
    z-index: 9999;
}
.mensagem .alert {
    margin: auto; 
    box-shadow: 1px 1px 5px black;
}
</style>
<div class="panel panel-default">
<h3 class="text-center"> Cadastro de Documentos Pessoais </h3>
        <p class="text-center">Inclua imagem recortada do seu RG (Frente e Verso) e seu Título de Eleitor (frente)</p>
<hr>
<div style="border: 5px">
	<ul class="border border-primary">
		<li>Tamanho Máximo do Arquivo 500kb</li>
		<li>Imagem dos documentos na Horizontal</li>
		<li>Recorte apenas do espaço do documento</li>
	</ul>
</div>
<hr>
<form enctype="multipart/form-data" method="post" name="envio_arquivo">
			 <!-- TIPO DE DOCUMENTO -->
			<div class="form-group">  			
  			<div class="col-md-5">				
			 <?php
			include_once('intranet/conexao.php');
			$cod_pessoa = $_GET['cod_p'];
	 		$cod_pessoa = base64_decode($_GET['cod_p']);
				
			$query_doc = "Select id_tipo, tipo_descricao from tipo_doc 
						  where ativo = 'S' and id_tipo not in 
						  (select id_tipo from documento where id_pessoa=$cod_pessoa)
						  order by tipo_descricao;";
			$resultado_doc = mysqli_query($link,$query_doc) or die (mysqli_error());
			while ($reg_doc = mysqli_fetch_assoc($resultado_doc)) {
				$dados_doc[] =  array(
								'cod_tipo'   =>$reg_doc['id_tipo'] , 
								'tipo_desc' =>$reg_doc['tipo_descricao']
							);				
			}
		  ?>
  			<select id="doc_tipo" name="doc_tipo" class="form-control form-control-sm" required>
				<option value="">Tipo de Documento</option>
			<?php
			 $selecionado = $cod_tipo;
			 foreach ($dados_doc as $item) {
				$selected = ($selecionado == $item['cod_tipo'] ? 'selected' : null);
				echo "<option value='{$item[cod_tipo]}' {$selected}>{$item[tipo_desc]}</option>";
			} ?>
			</select>
  		</div>
		</div> <!-- FIM DIV TIPO DOCUMENTO -->
					
		 <div class="form-group">
			<div class="col-md-7">
    				 <input style="color: antiquewhite" id="uploadBtn" type="file" name="arquivo" class="form-control-file text-white" accept="image/*" required />
			 </div>
		</div>
        
		<div class="form-group">
			<div class="col-md-12  text-right"><br>
            	<button type="submit" name='submited' class="btn btn-warning">Enviar arquivo</button>
			</div>
			
			<input type="hidden" name="idPessoa" value="<?= $cod_pessoa; ?>">
		</div> 
        </form>
	 
	  <?php
      // if($_POST['$cat_doc']!='') {  
	 	if(isset($_POST['submited'])) {
			include_once("intranet/conexao.php");
            $arquivo = $_FILES["arquivo"]["tmp_name"]; 
            $tamanho = $_FILES["arquivo"]["size"];
            $tipo_arquivo    = $_FILES["arquivo"]["type"];
            $titulo  = $_POST["titulo"]??'';
			$cat_doc = $_POST['doc_tipo']??'';

            if ( $arquivo != "none" )				
            {
				$tamanho_arq = round($tamanho / 1024);
				if($tamanho_arq < 600) 
				{
					$fp = fopen($arquivo, "rb");
					$conteudo = fread($fp, $tamanho);
					$conteudo = addslashes($conteudo);
					fclose($fp);             

						 $comandoSQL = "INSERT INTO documento (id_pessoa,id_tipo, doc_texto,doc_tipo,doc_conteudo) 
						 VALUES ('$cod_pessoa','$cat_doc','$titulo','$tipo_arquivo','$conteudo')";		
						 if(mysqli_query($link, $comandoSQL) ) 
						 {                                       
						 		echo '<br/><div class="mensagem"><div class="alert alert-success" role="alert">	Arquivo enviado com sucesso para o servidor!
								</div></div>';
	
					 	} else {

						 		echo '<br/><div class="mensagem"><div class="alert alert-danger" role="alert">
									Erro: ' . die (mysqli_error($link)) . 
							  	'</div></div>';
					  	} 
				} else {
					echo '<br/><div class="mensagem"><div class="alert alert-warning" role="alert">
									Arquivo excede tamanho máximo permitido! <br>'.$tamanho_arq.'kb
									
						 </div></div>';
				}				
			}
		}
    ?>
      
    <div style="height:100px"></div>
	 
	  <?php include("documentacao_lista.php")?>
</div>


<!--Fecha a tela de mensagem após determinado período-->
<script type="text/javascript">
    setTimeout(function () {
        $('.alert').fadeOut('fast');
    }, 2000);
</script>
<!-- FUNCIONAR O COMPONENTE FILE -->
<script>
	document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};	
</script>

 <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
        (function() {
            'use strict'

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement('style')
                msViewportStyle.appendChild(
                    document.createTextNode(
                        '@-ms-viewport{width:auto!important}'
                    )
                )
                document.head.appendChild(msViewportStyle)
            }

        }())

    </script>