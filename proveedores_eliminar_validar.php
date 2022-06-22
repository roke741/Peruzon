<?php  
sleep(1);
require("conexion/connection.php");
session_start();

// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
	header("Location:error1.php");
	exit();
}

// echo "...";
// exit();

$id_proveedor=$_GET["id_proveedor"];

$sql="SELECT movimiento FROM tab_proveedores WHERE (id_proveedor = ".$id_proveedor.")";
$query=$mysqli->query($sql);
$row=$query->fetch_assoc();

if ($query->num_rows!=0) {
	if ($row['movimiento']=="no") {

  		$sql="DELETE FROM tab_proveedores WHERE (id_proveedor = ".$id_proveedor.")";
  		$query=$mysqli->query($sql);
          
  		$_SESSION['proveedor_eliminado']="si";
  		echo '<script>location.href = "buscar_proveedores.php"</script>';

	}else{

    	$_SESSION['proveedor_tiene_factura']="si";
    	echo "<script>location.href = 'buscar_proveedores.php'</script>";    

	}
}

?>