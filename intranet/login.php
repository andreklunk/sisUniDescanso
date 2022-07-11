<?php
	session_start();
	unset($_SESSION['us_id']);
	unset($_SESSION['us_nome']);

if ($_GET[acao]=='V') {
	include "conexao.php";
	$query = "Select id_usuario,nome from usuario
						where login = '$_POST[login]' and senha = '$_POST[senha]'";
	$resultado = mysql_query($query);
	$registros = mysql_num_rows($resultado);
		
if ($registros > 0)
  {
    $linha=mysql_fetch_array($resultado);
    $id_usuario = $linha['id_usuario'];
    $us_nome = $linha['nome'];
	$_SESSION['us_id'] = $id_usuario;
	$_SESSION['us_nome'] = $us_nome;
	$_SESSION['us_sessao'] = session_id();
	header("Location: inicial.php");
  }		
  else  {
    $mensagem = 'msg_erro_login';
  }


}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Simple Login Form</title>
<meta charset="UTF-8" />
<meta name="Designer" content="PremiumPixels.com">
<meta name="Author" content="$hekh@r d-Ziner, CSSJUNTION.com">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/structure.css">
</head>

<body>
<form class="box login">
	<fieldset class="boxBody">
	  <label>Username</label>
	  <input type="text" tabindex="1" placeholder="PremiumPixel" required>
	  <label><a href="#" class="rLink" tabindex="5">Esqueceu sua senha?</a>Password</label>
	  <input type="password" tabindex="2" required>
	</fieldset>
	<footer>
	  <label><input type="checkbox" tabindex="3">Manter Logado</label>
	  <input type="submit" class="btnLogin" value="Login" tabindex="4">
	</footer>
</form>

</body>
</html>
