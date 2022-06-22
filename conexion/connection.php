<?php

$server="localhost"; 
$user="root";
$pass="";
$db="peruzon";


$mysqli = new mysqli($server, $user, $pass, $db);

/* comprobar la conexión */
if ($mysqli->connect_errno) {
  	printf("Falló la conexión con la base de datos: %s\n", $mysqli->connect_error);
    exit();   
}
$mysqli->set_charset("utf8");
?>