<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>

<body>
<?php 
$banco = "" ;
if (count($_POST)){ 
$arquivo = $_FILES['arquivoTXT']; 
$ponteiro = fopen ($arquivo['tmp_name'], 'r'); 
while (!feof ($ponteiro)) { 
$linha = fgets($ponteiro, 4096);
$banco .= $linha;
}
fclose ($ponteiro); 
} 
?>
<form action="" method="post" enctype="multipart/form-data" name="cadastro" > 
<input type="file" name="arquivoTXT" value="Selecionar" size="87" />
<br />
<input type="submit" name="cadastrar" value="Ler Arquivo" /> 
</form>

<form action="backup_restaurarBD.php" method="post" enctype="multipart/form-data" name="enviar" target="_blank">
<textarea name="banco" cols="100" rows="25" id="banco"><?php echo $banco; ?></textarea><br />
<input name="Criar BD" type="submit" value="Criar BD" id="Criar BD" /></form>
</body>
</html>