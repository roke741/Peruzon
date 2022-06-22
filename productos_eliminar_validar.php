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

$id_producto=$_GET["id_producto"];

//echo $id_producto;
//exit();

$sql="SELECT id_producto, facturas FROM tab_productos WHERE (id_producto = ".$id_producto.")";

$query=$mysqli->query($sql);
$row = $query->fetch_assoc();

if ($query->num_rows!=0) {
	

	if($row['facturas']=='No'){

  		$sql="DELETE FROM tab_productos WHERE (id_producto = ".$id_producto.")";
  		$query=$mysqli->query($sql);
          
  		$_SESSION['producto_eliminado']="Si";
  		echo '<script>location.href = "productos.php"</script>';

  	}else{

  		$_SESSION['producto_tiene_factura']="Si";
    	echo "<script>location.href = 'productos.php'</script>";    

  	}	

}else{
    echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Producto no existe</p>";
}
?>