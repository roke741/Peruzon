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

$id_factura=$_GET["id_factura_proveed"];
$id_proveedor=$_GET["id_proveedor"];

$sql="SELECT id_producto, cantidad ";
$sql.="FROM tab_proveedores_facturas_reng WHERE (id_factura_proveedor = ".$id_factura.")";

$row = $mysqli->query($sql);
$total_rows=$row->num_rows;
if($total_rows!=0){
	while ($fila = $row->fetch_assoc()){
		$sql="SELECT cantidad_producto, cantidad_existencia, producto ";
		$sql.="FROM tab_productos WHERE (id_producto = ".$fila['id_producto'].")";

		$query1 = $mysqli->query($sql);
		$row1=$query1->fetch_assoc();

		$dif_cantidad_producto=$row1['cantidad_producto']-$fila['cantidad'];
		$dif_cantidad_existencia=$row1['cantidad_existencia']-$fila['cantidad'];
		$productoex=$row1['producto'];

		if($dif_cantidad_existencia<0){		
			$_SESSION['factura_existencia']="no";
			$_SESSION['factura_producto_ex']="$productoex";
			echo "<script>location.href = 'buscar_facturas_proveed.php?id_proveedor=$id_proveedor'</script>";
			exit;
		}else{	
			// Guarda datos 
			$sql="UPDATE tab_productos SET cantidad_producto = ".$dif_cantidad_producto.", cantidad_existencia = ".$dif_cantidad_existencia." ";
			$sql.="WHERE (tab_productos.id_producto = ".$fila['id_producto'].")"; 

			$query2 = $mysqli->query($sql);
		}
	} // while ($fila = $row->fetch_assoc())	
}else{ // if($total_rows!=0)
	echo "Factura no tiene productos";
	exit();
} // if($total_rows!=0)

// Guarda datos 
$sql="UPDATE tab_proveedores_facturas SET anulado = 'si' ";
$sql.="WHERE (tab_proveedores_facturas.id_factura_proveedor = $id_factura)"; 

$query = $mysqli->query($sql);

$id_usuario_cp=$_SESSION["id_usuario"];
// Chequea si el usuario tiene movimientos
$sql8="SELECT movimiento "; 
$sql8.="FROM tab_usuarios WHERE (id_usuario = $id_usuario_cp)";

$query8 = $mysqli->query($sql8);
$row8=$query8->fetch_assoc();
$movimiento8=$row8['movimiento'];

if($movimiento8=='No'){

    $sql9="UPDATE tab_usuarios SET movimiento = 'i' ";
    $sql9.="WHERE (id_usuario = ".$id_usuario_cp.")"; 

    $query9 = $mysqli->query($sql9);
}

$_SESSION['factura_anulada']="si";
echo "<script>location.href = 'buscar_facturas_proveed.php?id_proveedor=$id_proveedor'</script>";

?>