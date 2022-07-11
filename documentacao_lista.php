<style>
	.img_doc {
		max-width: 80px;
		max-height: 80px;
	}
</style>
<div style="margin: 5px">
<?php
		include_once("intranet/conexao.php");
		$consultaSQL = "SELECT id_documento, id_pessoa, doc_texto, tipo_descricao,doc_tipo, doc_conteudo 
					FROM documento D LEFT JOIN tipo_doc as T on D.id_tipo=T.id_tipo 
					where id_pessoa=$cod_pessoa
					order by id_documento desc;";

		if($resultado = mysqli_query($link, $consultaSQL)){
		
        echo("
        <table class='table table-striped table-bordered table-hover'>
        <thead class='thead-light'>
        <tr>
            <th width=80%>Documento</th>
            <th>Thumbnail</th>
			<th class='align-middle'>Ação</th>
        </tr>
        </thead>
        ");
		while($registro=mysqli_fetch_array($resultado)){
				$cod_doc = $registro['id_documento'];
				$texto = $registro['tipo_descricao'];
				$tipo = $registro['doc_tipo'];
				$conteudo = $registro['doc_conteudo'];

            echo "
            <tr>
                <td style='vertical-align: middle;'>$texto</td>
                <td><a href='documentacao_abrir.php?id_doc=$cod_doc' download=$cod_doc><img src='documentacao_abrir.php?id_doc=$cod_doc' class='img_doc'/></a></td>
				<td style='vertical-align: middle;'><a href='documentacao_excluir.php?id_doc=$cod_doc&cod_p=$cod_pessoa'> <img src=intranet/img/delete.png alt='' width='20px' title='Excluir Documento'></a> </td>
            </tr>
            ";
		}	
        echo("</table>");
        
	} else 	{
		echo("Errrooooo! foi esse: " . die(mysqli_error($link)));
	}



/*EXCLUSÃO 
if($_GET['acao']=='E') {
	$deleteSQL = "Delete FROM documento WHERE id_documento=$_GET[id_doc];";

if(mysqli_query($link, $deleteSQL) ) {                                       
                     echo '<br/><div class="alert alert-success" role="alert">
                                Arquivo excluído com sucesso!
                            </div>';
		         } else {
                     
                     echo '<br/><div class="alert alert-success" role="alert">
                                Erro ' . die (mysqli_error($link)) . 
                          '</div>';
		          }
} */
?>
</div>