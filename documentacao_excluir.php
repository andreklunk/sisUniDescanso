<?php
 include_once("intranet/conexao.php");
 $deleteSQL = "Delete FROM documento WHERE id_documento=$_GET[id_doc];";
 if(mysqli_query($link, $deleteSQL) ) {                                       
     $cod_p = base64_encode($_GET['cod_p']);
	 header("Location: index.php?url=doc&cod_p=$cod_p");
 } else {
                     
    echo '<br/><div class="alert alert-success" role="alert">
     Erro ' . die (mysqli_error($link)) . 
     '</div>';
}
?>