<?php	
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$link = new mysqli($server, $username, $password, $db);
    
//TESTAR ERROS    
    if($mysqli->connect_errno){
        echo "Falha na Conexão: ".$mysqli->connect_errno;
        echo "<br>".$mysqli->connect_error;
    }
/*
echo "INFORMAÇÕES DO BD <br>";
echo $server; 
echo "<br>";
echo $db;
echo "<br>";
echo $username;
echo " - ";
echo $password; 
*/
mysqli_set_charset($link, "utf8");
?>