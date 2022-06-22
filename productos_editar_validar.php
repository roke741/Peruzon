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
/*
$producto = $_POST['producto'];
$descripcion = $_POST['descripcion'];
$idproducto = $_POST['id_producto'];

echo $producto;
echo "<br/>";
echo $descripcion;
echo "<br/>";
echo $idproducto;

exit();
*/
//validación
$error_form = "";
if ($_POST["producto"] == "") {

	$_SESSION['contenido_mensaje_prod']='Debes escribir el Producto';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";    
	exit();

}

if ($_POST["descripcion"] == "") {

	$_SESSION['contenido_mensaje_prod']='Debes escribir la Descripcion';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";        
	exit();

}

if ($_POST["precio_compra"] == "") {

    $_SESSION['contenido_mensaje_prod']='Debes escribir el Precio Compra';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";        
    exit();

}

if ($_POST["precio_final"] == "") {

    $_SESSION['contenido_mensaje_prod']='Debes escribir el Precio Final';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";        
    exit();

}

$precio_compra=$_POST["precio_compra"];
$monto_precio_compra =  is_numeric($precio_compra);

if ($monto_precio_compra==false){

    $_SESSION['contenido_mensaje_prod']='El Precio Compra debe ser un número';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";        
    exit();

}

$precio_final=$_POST["precio_final"] ;
$monto_precio_final =  is_numeric($precio_final);

if ($monto_precio_final==false){

    $_SESSION['contenido_mensaje_prod']='El Precio Final debe ser un número';
    $_SESSION['producto_mensaje']='si';

    $id_producto=$_SESSION['id_producto2'];
    $producto=$_SESSION['producto2'];
    $descripcion=$_SESSION['descripcion2'];
    $cod_producto=$_SESSION['cod_producto2'];
    $precio_compra=$_SESSION['precio_compra2'];
    $precio_final=$_SESSION['precio_final2'];

    echo "<script>location.href = 'productos_editar.php?id_producto=$id_producto&producto=$producto&descripcion=$descripcion&cod_producto=$cod_producto&precio_compra=$precio_compra&precio_final=$precio_final'</script>";        
    exit();

}

$producto=utf8_encode($_POST['producto']);
$descripcion=utf8_encode($_POST['descripcion']);
$precio_compra=$_POST['precio_compra'];
$precio_final=$_POST['precio_final'];
$id_producto = $_POST['id_producto'];

$ganancia=$precio_final-$precio_compra;

// Guarda datos 
$sql="UPDATE tab_productos SET producto = '".$producto."', descripcion = '".$descripcion."', precio_compra = ".$precio_compra.", precio_final = ".$precio_final.", ganancia = ".$ganancia;
$sql.=" WHERE (tab_productos.id_producto = ".$id_producto.")"; 

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