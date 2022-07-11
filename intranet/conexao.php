<?php	
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
echo $server; 
echo "<br>";
echo $db;
$conn = new mysqli($server, $username, $password, $db);


mysqli_set_charset($conn, "utf8");
?>