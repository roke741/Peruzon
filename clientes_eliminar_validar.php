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
$id_cliente=$_GET["id_cliente"];

// Elimina el cliente si no tiene movimientos
$sql="SELECT movimiento FROM tab_clientes WHERE (id_cliente = ".$id_cliente.")";
$query=$mysqli->query($sql);
$row=$query->fetch_assoc();

if($query->num_rows!=0){
	if ($row['movimiento']=="no") {
  		$sql="DELETE FROM tab_clientes WHERE (id_cliente = ".$id_cliente.")";
  		$query=$mysqli->query($sql);
          
  		$_SESSION['cliente_eliminado']="si";
  		echo '<script>location.href = "vender_clientes.php"</script>';

	}else{
  		$_SESSION['cliente_tiene_factura']="si";
  		echo "<script>location.href = 'vender_clientes.php'</script>";   
	}
}
?>