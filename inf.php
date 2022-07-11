<div class="panel panel-default">
  <!-- Default panel contents -->
<?php
	include_once('intranet/conexao.php');
	$query = "Select id_inf, titulo, texto_centro, texto_rodape from
		  informacoes where ativo='S' and local_exibicao = '2'
		  order by id_inf desc;";
		$resultado = mysqli_query($link,$query)or die(mysqli_error());
		while($registro = mysqli_fetch_assoc($resultado)){
			$dados[] = array (
				'id_inf' => $registro['id_inf'],
				'titulo' => $registro['titulo'],
				'texto_centro' => $registro['texto_centro'],
				'texto_rodape' => $registro['texto_rodape']
			);
		}		
		if (is_array($dados)) {
			foreach($dados as $item) {		
?>
  <div class="panel-heading">
      <h4><?php	echo " {$item['titulo']} "; ?></h4>
  </div>
  <div class="panel-body">
   <p> <?php echo "{$item['texto_centro']} "; ?></p>
  <hr>
<?php echo "{$item['texto_rodape']} "; ?>
<p align="right">&nbsp;</p>
<hr>
    <div align="right">
    <h5 align="right"><strong>DOWNLOADS:</strong> </h5>
        <ul style="list-style-type:none;">
            <?php 
		   $query_arq = "Select descricao, arquivo from
		  arquivos A, informacoes I where A.ativo='S' and A.id_inf = I.id_inf
		  and A.id_inf={$item['id_inf']}
		  order by id_arquivo desc;";

		   $resultado_arq = mysqli_query($link,$query_arq)or die(mysqli_error());
		
		   while($registro_arq = mysqli_fetch_assoc($resultado_arq)){
				$descricao = $registro_arq['descricao'];
				$arquivo = $registro_arq['arquivo'];				
				$desc = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $descricao); // simple file name validation
				$desc = filter_var($desc, FILTER_SANITIZE_URL); // Remove (more) invalid characters
				
			 echo "<li> <a href='intranet/uploads/$arquivo' download='$desc' target='_blank' title='$arquivo'> &gt;&gt;  $descricao </a></li> "; 
		}			   
            ?>
        </ul>
    </div>
</div>
</div>
<?php
			}
		}
?>
