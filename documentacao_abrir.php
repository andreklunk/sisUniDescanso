<?php
 include_once("intranet/conexao.php");
		$consultaSQL = "SELECT doc_tipo, doc_conteudo FROM documento WHERE id_documento=$_GET[id_doc];";

		if($resultado = mysqli_query($link, $consultaSQL)){
		$resultado=mysqli_fetch_array($resultado);
            $tipo = $resultado['doc_tipo'];
            $conteudo = $resultado['doc_conteudo'];
            header("Content-Type: $tipo");
            echo $conteudo;
    	} else 	{
		echo("Errrooooo! foi esse: " . die(mysql_error($link)));
	}
?>