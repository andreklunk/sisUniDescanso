<?php
$arquivo = $_FILES['arquivoTXT']; 
$banco = $arquivo['tmp_name'] ;
//$banco = $_POST['banco'];
//echo "ola <br>";
//echo $banco;break;
include_once('conexao.php');
    $usuario = $DB_USER;
    $senha = $DB_PASS;
    $dbname = $DB_NAME;
	$host = $DB_HOST;

$db = new PDO('mysql:host=127.0.0.1;dbname=teste', 'root', '1234');

try {
    $db->beginTransaction(); // inicia transação
    $db->exec(file_get_contents($banco)); // executa comandos SQL do arquivo de backup
    $db->commit(); // salva alterações no banco
} catch (Exception $e) {
    $db->rollback(); // cancela alterações no banco
    print 'Erro!'; // exibe mensagem de erro
}