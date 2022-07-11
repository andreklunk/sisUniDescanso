<?php	
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$link = new mysqli($server, $username, $password, $db);
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