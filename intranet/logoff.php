<?php
	session_start();
	session_destroy();
	include('conexao.php');
	mysqli_close($link);
	header("Location: index.php");
?>