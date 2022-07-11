<?php
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
if($_SESSION['us_sessao']!=session_id())
   {
   		header("Location: index.php?mensagem=erro_sessao");
   }
   $_SESSION['us_sessao'];
   $_SESSION['us_id'];
   $_SESSION['us_nome'];
?>