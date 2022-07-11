<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
<style type="text/css">
.inicio {
	width:25%;
	margin:0 auto;
	margin-top: 50px;
	border:1px solid black;
	text-align:center;
}
</style>
</head>

<body>
<div class="inicio">
<h3>Seja Bem-Vindo!</h3>
<p>Usuário Logado </p>
<h4><?php echo $_SESSION['us_nome']; ?></h4>
<div>

</body>
</html>