<?php
if (session_status() !== PHP_SESSION_ACTIVE) {	
	session_start();
}
session_unset();
session_destroy();
//	unset($_SESSION['us_id']);
//	unset($_SESSION['us_nome']);

if (isset($_GET['acao'])=='V') {
	include_once "conexao.php";
	$query = "Select id_usuario, nome from usuario
						where login = '$_POST[login]' and senha = '$_POST[senha]'";
echo $query; exit;
	$resultado = mysqli_query($link,$query) or die(mysql_error($link));
	$registros = mysqli_num_rows($resultado);
		
	if ($registros > 0)
	  {
		$linha=mysqli_fetch_array($resultado);
		$id_usuario = $linha['id_usuario'];
		$us_nome = $linha['nome'];
		if (session_status() !== PHP_SESSION_ACTIVE) {	
			session_start();
		}	
		$_SESSION['us_id'] = $id_usuario;
		$_SESSION['us_nome'] = $us_nome;
		$_SESSION['us_sessao'] = session_id();		
		header("location: inicial.php");		
	  }		
	  else  {
		$mensagem = 'msg_erro_login';
	  }

}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>SISUNI - Controle de Repasses Financeiros</title>
<meta charset="UTF-8" />
<meta name="Itech" content="Itech Tecnologia">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/structure.css">
 <link rel="shortcut icon" href="img/favicon.png">
</head>

<body>
<form class="box login" action="index.php?acao=V" method="post" enctype="multipart/form-data" name="acesso">
	<fieldset class="boxBody">
	  <label>Usuário</label>
	  <input type="text" tabindex="1" placeholder="Login" name="login" id="login" required >
	 <!-- <label><a href="#" class="rLink" tabindex="5">Forget your password?</a>Password</label>-->
     <label> Senha</label>
	  <input type="password" tabindex="2" name="senha" placeholder="Senha" required>
	</fieldset>
	<footer>
	<!--  <label><input type="checkbox" tabindex="3">Keep me logged in</label> -->
    <?php
if( isset($_GET['mensagem']) || isset($mensagem) ) {
		if($mensagem=='msg_erro_login') 
			echo "Usuário/Senha Inválidos!!!";
		if(isset($_GET['mensagem'])=='erro_sessao')
			echo "Necessário estar logado para <br>acessar o sistema!!!";
	}	
?>
	  <input type="submit" class="btnLogin" value="Login" tabindex="4">
	</footer>
</form>

<script language="javascript">
	document.getElementById('login').focus();
</script>
   
</body>
</html>
