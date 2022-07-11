<?php	
/*
	$DB_HOST = 'localhost';
    $DB_NAME = 'id1301142_sisuni_md';
    $DB_USER = 'id1301142_sisuni_md';
    $DB_PASS = 'mondai2017';
*/
	$DB_HOST = 'localhost';
    $DB_NAME = 'sisuni_sjo';
    $DB_USER = 'root';
    $DB_PASS = 'maria';
/*	$conexao = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	if(!($conexao))
    {
        echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL.
		 Favor Contactar o Administrador.";
        exit;
    }
	
	$banco = mysql_select_db($DB_NAME,$conexao);
    if(!($banco))
    {
        echo "Não foi possível encontrar o Banco de Dados. 
		Favor Contactar o Administrador.";
        exit;
    }
	mysql_set_charset('UTF8', $conexao);	*/
	//PARÂMETROS PARA MySqli
	$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Erro " . mysqli_error($link));
	mysqli_set_charset($link, "utf8");
?>