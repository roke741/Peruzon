<?php  
sleep(2);
require("conexion/connection.php");
session_start();

// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
	header("Location:error1.php");
	exit(); 
}

$id_moneda=$_GET["id_moneda"];

// Elimina la moneda
$sql="DELETE FROM tab_monedas WHERE (id_moneda = ".$id_moneda.")";
$query=$mysqli->query($sql);
          
$_SESSION['moneda_eliminada']="si";
echo '<script>location.href = "moneda_menu.php"</script>';

?>