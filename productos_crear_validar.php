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

//validación
$error_form = "";
if ($_POST["producto"] == "") {

	$_SESSION['contenido_mensaje_prod']='Debes escribir el Producto';
    $_SESSION['producto_mensaje']='si';

    $producto="";
    $descripcion=$_POST["descripcion"];
    $precio_compra=$_POST["precio_compra"];
    $precio_final=$_POST["precio_final"];

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
	exit();

}else{
    $producto=utf8_encode($_POST["producto"]);
}

if ($_POST["descripcion"] == "") {

	$_SESSION['contenido_mensaje_prod']='Debes escribir la Descripcion';
    $_SESSION['producto_mensaje']='si';

    $producto=$_POST["producto"];
    $descripcion="";
    $precio_compra=$_POST["precio_compra"];
    $precio_final=$_POST["precio_final"];

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
	exit();

}else{
    $descripcion=utf8_encode($_POST["descripcion"]);
}

if ($_POST["precio_compra"] == "") {

    $_SESSION['contenido_mensaje_prod']='Debes escribir el Precio Compra';
    $_SESSION['producto_mensaje']='si';

    $producto=$_POST["producto"];
    $descripcion=$_POST["descripcion"];
    $precio_compra="";
    $precio_final=$_POST["precio_final"];

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
    exit();

}else{
    $precio_compra=$_POST["precio_compra"];
}

if ($_POST["precio_final"] == "") {

    $_SESSION['contenido_mensaje_prod']='Debes escribir el Precio Final';
    $_SESSION['producto_mensaje']='si';

    $producto=$_POST["producto"];
    $descripcion=$_POST["descripcion"];
    $precio_compra=$_POST["precio_compra"];
    $precio_final="";

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
    exit();

}else{
    $precio_final=$_POST["precio_final"];
}

$monto_precio_compra =  is_numeric($precio_compra);

if ($monto_precio_compra==false){

    $_SESSION['contenido_mensaje_prod']='El Precio Compra debe ser un número';
    $_SESSION['producto_mensaje']='si';

    $producto=$_POST["producto"];
    $descripcion=$_POST["descripcion"];
    $precio_compra=$_POST["precio_compra"];
    $precio_final=$_POST["precio_final"];

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
    exit();
}

$monto_precio_final =  is_numeric($precio_final);

if ($monto_precio_final==false){

    $_SESSION['contenido_mensaje_prod']='El Precio Final debe ser un número';
    $_SESSION['producto_mensaje']='si';

    $producto=$_POST["producto"];
    $descripcion=$_POST["descripcion"];
    $precio_compra=$_POST["precio_compra"];
    $precio_final=$_POST["precio_final"];

    echo "<script>location.href = 'productos_crear.php?producto=$producto&descripcion=$descripcion&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
    exit();
}

// exit();

/*
$producto = $_POST['producto'];
$descripcion = $_POST['descripcion'];
$precio_compra=$_POST["precio_compra"];
$precio_final=$_POST["precio_final"];
*/

$valores_fecha_act = explode('-', $_SESSION['fecha']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];
$hora_actual=$_SESSION['hora_actual'];

// Buscar cod_producto en tab_correlativos
$sql="SELECT * FROM tab_correlativos";
$query = $mysqli->query($sql);
$row=$query->fetch_assoc();

$cod_producto=$row["cod_producto"];
$cod_producto_nuevo=$cod_producto + 1;

// Guarda cod_producto en tab_correlativos
$sql3="UPDATE tab_correlativos SET cod_producto=$cod_producto_nuevo";
$query3=$mysqli->query($sql3);   

$cod_producto_nuevo_2="cod-".$cod_producto_nuevo;   
$id_usuario_cp=$_SESSION["id_usuario"];

$ganancia=$precio_final-$precio_compra;

// Guarda datos 
$sql="INSERT INTO tab_productos (cod_producto_1, cod_producto_2, producto, descripcion, precio_compra, precio_final, ganancia, fecha_reg, hora_reg, id_usuario) ";
$sql.="VALUES ('$cod_producto_nuevo','$cod_producto_nuevo_2','$producto','$descripcion','$precio_compra','$precio_final','$ganancia','$fecha_act','$hora_actual','$id_usuario_cp')";

$query = $mysqli->query($sql);

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

$_SESSION['producto_guardada']="si";
echo "<script>location.href = 'productos.php'</script>";    

?>