<?php
require("conexion/connection.php");
session_start();
// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
	header("Location:error1.php");
	exit();
}

$nro_factura_proveedor=$_SESSION['nro_factura_porveed'];
$fecha_factura_porveedor=$_SESSION['fecha_factura_porveed'];

// Chequea si hay un valor vacio
for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++){

	if(empty($_SESSION['carrito_proveed'][$i]['cantidad'])){
		$_SESSION['nro_reglon_nulo']=$i;
		$_SESSION['cantidad_nulo']="si";
		//echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Debes introducir la cantidad en el reglon nro.".$_SESSION['carrito_proveed'][$i]['orden']."</p>";
		echo "<script>location.href = 'crear_proveed_factura.php'</script>";
		exit();
	}
} // for($i=0;$i<$_SESSION['total_productos_proveed'];$i++)

// Suma a cantidad productos e existencia
for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++){
	$id_producto_b=$_SESSION['carrito_proveed'][$i]['id_producto'];
	// Buscar id_producto
	$sql3="SELECT id_producto, cantidad_producto, cantidad_producto, cantidad_existencia FROM tab_productos WHERE (id_producto = ".$id_producto_b.")";
	$query3=$mysqli->query($sql3);
	$row3=$query3->fetch_assoc();

	if($query3->num_rows!=0){
    	$existencia_b=$row3["cantidad_existencia"];
		$nor_productos_b=$row3["cantidad_producto"];
	}else{
		echo "Producto no existe de id: ".$row3["id_producto"];
		exit();
	}	
	//echo $_SESSION['carrito_proveed'][$i]['orden'];
	//exit();

	// Suma a 
	$existencia_bd=$existencia_b+$_SESSION['carrito_proveed'][$i]['cantidad'];
	$nor_productos_bd=$nor_productos_b+$_SESSION['carrito_proveed'][$i]['cantidad'];

	// Guarda datos 
	$sql="UPDATE tab_productos SET cantidad_existencia = '".$existencia_bd."', cantidad_producto = '".$nor_productos_bd."' ";
	$sql.="WHERE (tab_productos.id_producto = ".$id_producto_b.")";

	$query = $mysqli->query($sql);
} // for($i=0;$i<$_SESSION['total_productos_proveed'];$i++)

$total_productos=0;
// Chequea totales
for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++){

	$total_productos=$total_productos+$_SESSION['carrito_proveed'][$i]['cantidad']*$_SESSION['carrito_proveed'][$i]['precio'];
	
} // for($i=0;$i<$_SESSION['total_productos_proveed'];$i++)

if($total_productos!=$_SESSION['totalprice_proveed']){
	echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Totales no coinciden</p>";
	exit();
}

/*

$_SESSION['carrito_proveed'][$i]['precio']
$_SESSION['carrito_proveed'][$i]['cantidad']

$_SESSION['id_proveedor']
$_SESSION["id_usuario"]
$_SESSION['fecha']

$valores[0], año
$valores[1], mes
$valores[2], dia

*/

$id_proveedor=$_SESSION['id_proveedor'];
$id_usuario=$_SESSION["id_usuario"];
$total_precio=$_SESSION['totalprice_proveed'];
$descuento=$_SESSION['descuento_proveed'];

$total_desc=$_SESSION['total_desc_proveed'];

$valores_fecha_factura_porveedor = explode('-', $fecha_factura_porveedor);
$fecha_factura_porveedor_2=$valores_fecha_factura_porveedor[2]."-".$valores_fecha_factura_porveedor[1]."-".$valores_fecha_factura_porveedor[0];

$valores_fecha_act = explode('-', $_SESSION['fecha']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];

$hora_actual=$_SESSION['hora_actual'];

// $sql="SELECT * FROM tab_correlativos";
// $query = $mysqli->query($sql);
// $row=$query->fetch_assoc();

// $nro_factura=$row["nro_factura"];
// $nro_factura_proveedor=$nro_factura+1;

// Guarda datos en tab_facturas
$sql2="INSERT INTO tab_proveedores_facturas (nro_factura_proveedor,fecha_factura_proveedor,fecha_reg,hora_reg,id_proveedor,total,descuento,total_desc,id_user) ";
$sql2.="VALUES ('$nro_factura_proveedor','$fecha_factura_porveedor_2','$fecha_act','$hora_actual','$id_proveedor','$total_precio','$descuento','$total_desc','$id_usuario')";
$query2=$mysqli->query($sql2);

// Buscar id_factura_proveedor
$sql3="SELECT id_factura_proveedor FROM tab_proveedores_facturas WHERE (nro_factura_proveedor = '".$nro_factura_proveedor."')";
$query3=$mysqli->query($sql3);
$row3=$query3->fetch_assoc();

// Guarda datos en tab_correlativos
// $sql3="UPDATE tab_correlativos SET nro_factura=$nro_factura_proveedor";
// $query3=$mysqli->query($sql3);      

$id_factura_proveedor=$row3["id_factura_proveedor"];

// Guarda datos en tab_facturas_reng
for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++){

	$id_orden=$_SESSION['carrito_proveed'][$i]['orden'];
	$id_producto=$_SESSION['carrito_proveed'][$i]['id_producto'];
	$cantidad=$_SESSION['carrito_proveed'][$i]['cantidad'];
	$precio_unitario=$_SESSION['carrito_proveed'][$i]['precio'];
	$precio_total=$_SESSION['carrito_proveed'][$i]['cantidad']*$_SESSION['carrito_proveed'][$i]['precio'];

	$precio_unitario_desc=$precio_unitario-$precio_unitario*$descuento/100;

	$sql4="SELECT precio_compra "; 
  	$sql4.="FROM tab_productos WHERE (id_producto = $id_producto)";

  	$query4 = $mysqli->query($sql4);
  	$row4=$query4->fetch_assoc();
  	$precio_costo=$row4['precio_compra'];

	$sql4="INSERT INTO tab_proveedores_facturas_reng (id_factura_proveedor,nro_reglon,id_producto,cantidad,precio_unitario,precio_total,descuento,precio_unitario_desc,precio_costo) ";
	$sql4.="VALUES ('$id_factura_proveedor','$id_orden','$id_producto','$cantidad','$precio_unitario','$precio_total','$descuento','$precio_unitario_desc','$precio_costo')";
	$query4=$mysqli->query($sql4);

} // for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++)

//Guarda datos en tab_facturas_monedas
$sql5="SELECT moneda, valor_cambio FROM tab_monedas ORDER BY id_moneda";
$query5=$mysqli->query($sql5);
while ($row5=$query5->fetch_assoc()) {

	$moneda5=$row5['moneda'];
	$valor_cambio5=$row5['valor_cambio'];

	$sql6="INSERT INTO tab_proveedores_facturas_monedas (id_factura_proveedor,moneda,valor_cambio) ";
	$sql6.="VALUES ('$id_factura_proveedor','$moneda5','$valor_cambio5')";
	$query6=$mysqli->query($sql6);

}//$row5=$query5->fetch_assoc()

// Chequea si el proveedores tiene movimientos
$sql8="SELECT movimiento "; 
$sql8.="FROM tab_proveedores WHERE (id_proveedor = $id_proveedor)";

$query8 = $mysqli->query($sql8);
$row8=$query8->fetch_assoc();
$movimiento8=$row8['movimiento'];

if($movimiento8=='no'){
	$sql9="UPDATE tab_proveedores SET movimiento = 'si' ";
	$sql9.="WHERE (tab_proveedores.id_proveedor = ".$id_proveedor.")"; 
	$query9 = $mysqli->query($sql9);
}

// Chequea si el producto tiene facturas
$sql12="SELECT facturas "; 
$sql12.="FROM tab_productos WHERE (id_producto = $id_producto)";

$query12 = $mysqli->query($sql12);
$row12=$query12->fetch_assoc();
$facturas12=$row12['facturas'];

if($facturas12=='no'){
	$sql13="UPDATE tab_productos SET facturas = 'si' ";
	$sql13.="WHERE (tab_productos.id_producto = ".$id_producto.")"; 

	$query13 = $mysqli->query($sql13);
}

$id_usuario_cp=$_SESSION["id_usuario"];

// Chequea si el usuario tiene movimientos
$sql8="SELECT movimiento "; 
$sql8.="FROM tab_usuarios WHERE (id_usuario = $id_usuario_cp)";

$query8 = $mysqli->query($sql8);
$row8=$query8->fetch_assoc();
$movimiento8=$row8['movimiento'];

if($movimiento8=='No'){
    $sql9="UPDATE tab_usuarios SET movimiento = 'Si' ";
    $sql9.="WHERE (id_usuario = ".$id_usuario_cp.")"; 
    $query9 = $mysqli->query($sql9);
}

unset($_SESSION['carrito_proveed']);
unset($_SESSION['total_productos_proveed']);
unset($_SESSION['descuento_proveed']);
unset($_SESSION['nro_factura_porveed']);
unset($_SESSION['fecha_factura_porveed']);
unset($_SESSION['$moneda_s']);

// echo "<script>alert('Factura registrada exitosamente.')</script>";
$_SESSION['factura_guardada_proveedor']="si";
echo "<script>location.href = 'buscar_facturas_proveed.php?id_proveedor=".$id_proveedor."'</script>";
?>