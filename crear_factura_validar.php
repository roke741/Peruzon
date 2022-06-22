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
//echo "Funciona ...";
//echo $_SESSION['cantidad3'][2];
//echo $_SESSION['orden3'];
//exit();
// Chequea si hay un valor vacio
for($i=1;$i<=$_SESSION['total_productos'];$i++){
	if(empty($_SESSION['carrito'][$i]['cantidad'])){
		$_SESSION['nro_reglon_nulo']=$i;
		$_SESSION['cantidad_nulo']="si";
		//echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Debes introducir la cantidad en el reglon nro.".$_SESSION['carrito'][$i]['orden']."</p>";
		echo "<script>location.href = 'crear_factura.php'</script>";
		exit();

	}
	
} // for($i=0;$i<$_SESSION['total_productos'];$i++)
// Chequea si hay existencia
for($i=1;$i<=$_SESSION['total_productos'];$i++){
	$id_producto_b=$_SESSION['carrito'][$i]['id_producto'];
	// Buscar id_producto
	$sql3="SELECT id_producto, cantidad_producto, cantidad_venta, cantidad_existencia FROM tab_productos WHERE (id_producto = ".$id_producto_b.")";
	$query3=$mysqli->query($sql3);
	$row3=$query3->fetch_assoc();
	if($query3->num_rows==0){
    	$existencia_b=0;
	}else{
		$existencia_b=$row3["cantidad_existencia"];
		$nor_ventas_b=$row3["cantidad_venta"];
	}	

	//echo $_SESSION['carrito'][$i]['orden'];
	//exit();
	if($_SESSION['carrito'][$i]['cantidad']>$existencia_b){

		$_SESSION['hay_existencia_b']="no";
		$_SESSION['orden_b']=$_SESSION['carrito'][$i]['orden'];
				
		echo "<script>location.href = 'crear_factura.php'</script>";
		exit();
	}else{
		$existencia_bd=$existencia_b-$_SESSION['carrito'][$i]['cantidad'];
		$nor_ventas_bd=$nor_ventas_b+$_SESSION['carrito'][$i]['cantidad'];

		// Guarda datos 
		$sql="UPDATE tab_productos SET cantidad_existencia = '".$existencia_bd."', cantidad_venta = '".$nor_ventas_bd."' ";
		$sql.="WHERE (tab_productos.id_producto = ".$id_producto_b.")";

		$query = $mysqli->query($sql);
	}
	
} // for($i=0;$i<$_SESSION['total_productos'];$i++)

$total_productos=0;
// Chequea totales
for($i=1;$i<=$_SESSION['total_productos'];$i++){
	$total_productos=$total_productos+$_SESSION['carrito'][$i]['cantidad']*$_SESSION['carrito'][$i]['precio'];
} // for($i=0;$i<$_SESSION['total_productos'];$i++)

if($total_productos!=$_SESSION['totalprice']){
	echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Totales no coinciden</p>";
	exit();
}

/*
$_SESSION['carrito'][$i]['precio']
$_SESSION['carrito'][$i]['cantidad']
$_SESSION['id_cliente']
$_SESSION["id_usuario"]
$_SESSION['fecha']
$valores[0], año
$valores[1], mes
$valores[2], dia
*/

$id_cliente=$_SESSION['id_cliente'];
$id_usuario=$_SESSION["id_usuario"];
$total_precio=$_SESSION['totalprice'];
$descuento=$_SESSION['descuento'];
$total_desc=$_SESSION['total_desc'];

$valores_fecha_act = explode('-', $_SESSION['fecha']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];

$hora_actual=$_SESSION['hora_actual'];

$sql="SELECT * FROM tab_correlativos";
$query = $mysqli->query($sql);
$row=$query->fetch_assoc();

$nro_factura=$row["nro_factura"];
$nro_factura_nuevo=$nro_factura+1;

// Guarda datos en tab_facturas
$sql2="INSERT INTO tab_facturas (nro_factura,fecha_reg,hora_reg,id_cliente,total,descuento,total_desc,id_user) ";
$sql2.="VALUES ('$nro_factura_nuevo','$fecha_act','$hora_actual','$id_cliente','$total_precio','$descuento','$total_desc','$id_usuario')";
$query2=$mysqli->query($sql2);

// Buscar id_factura
$sql3="SELECT id_factura, nro_factura FROM tab_facturas WHERE (nro_factura = ".$nro_factura_nuevo.")";
$query3=$mysqli->query($sql3);
$row3=$query3->fetch_assoc();

// Guarda datos en tab_correlativos
$sql3="UPDATE tab_correlativos SET nro_factura=$nro_factura_nuevo";
$query3=$mysqli->query($sql3);      

$id_factura=$row3["id_factura"];

//Guarda datos en tab_facturas_reng
for($i=1;$i<=$_SESSION['total_productos'];$i++){

	$id_orden=$_SESSION['carrito'][$i]['orden'];
	$id_producto=$_SESSION['carrito'][$i]['id_producto'];
	$cantidad=$_SESSION['carrito'][$i]['cantidad'];
	$precio_unitario=$_SESSION['carrito'][$i]['precio'];
	$precio_total=$_SESSION['carrito'][$i]['cantidad']*$_SESSION['carrito'][$i]['precio'];

	$precio_unitario_desc=$precio_unitario-$precio_unitario*$descuento/100;

	$sql4="SELECT precio_compra "; 
  	$sql4.="FROM tab_productos WHERE (id_producto = $id_producto)";

  	$query4 = $mysqli->query($sql4);
  	$row4=$query4->fetch_assoc();
  	$precio_costo=$row4['precio_compra'];

	$sql4="INSERT INTO tab_facturas_reng (id_factura,nro_reglon,id_producto,cantidad,precio_unitario,precio_total,descuento,precio_unitario_desc,precio_costo) ";
	$sql4.="VALUES ('$id_factura','$id_orden','$id_producto','$cantidad','$precio_unitario','$precio_total','$descuento','$precio_unitario_desc','$precio_costo')";
	$query4=$mysqli->query($sql4);
} // for($i=1;$i<=$_SESSION['total_productos'];$i++)

//Guarda datos en tab_facturas_monedas
$sql5="SELECT moneda, valor_cambio FROM tab_monedas ORDER BY id_moneda";
$query5=$mysqli->query($sql5);
while ($row5=$query5->fetch_assoc()) {

	$moneda5=$row5['moneda'];
	$valor_cambio5=$row5['valor_cambio'];

	$sql6="INSERT INTO tab_facturas_monedas (id_factura,moneda,valor_cambio) ";
	$sql6.="VALUES ('$id_factura','$moneda5','$valor_cambio5')";
	$query6=$mysqli->query($sql6);

}//$row5=$query5->fetch_assoc()
// Chequea si el cliente tiene movimientos
$sql8="SELECT movimiento "; 
$sql8.="FROM tab_clientes WHERE (id_cliente = $id_cliente)";

$query8 = $mysqli->query($sql8);
$row8=$query8->fetch_assoc();
$movimiento8=$row8['movimiento'];

if($movimiento8=='no'){

	$sql9="UPDATE tab_clientes SET movimiento = 'si' ";
	$sql9.="WHERE (tab_clientes.id_cliente = ".$id_cliente.")"; 

	$query9 = $mysqli->query($sql9);
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

unset($_SESSION['carrito']);
unset($_SESSION['total_productos']);
unset($_SESSION['descuento']);
unset($_SESSION['$moneda_s']);

// echo "<script>alert('Factura registrada exitosamente.')</script>";

$_SESSION['factura_guardada']="si";
echo "<script>location.href = 'buscar_facturas.php?id_cliente=".$id_cliente."'</script>";

?>