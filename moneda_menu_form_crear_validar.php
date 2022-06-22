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
if ($_POST["moneda"] == "") {
	$_SESSION['contenido_moneda_mensaje']='Debes escribir la Moneda';
    $_SESSION['moneda_mensaje']='si';

    $moneda=$_POST["moneda"];
    
    $_SESSION['$moneda2']=$_POST["moneda"];
    $_SESSION['$monto2']=$_POST["monto"];

    echo "<script>location.href = 'moneda_menu_form_crear.php?moneda=$moneda'</script>";    
    exit();

}else{
    $moneda=utf8_encode($_POST["moneda"]);
}

if ($_POST["monto"] == "") {
    $_SESSION['contenido_moneda_mensaje']='Debes escribir el Monto';
    $_SESSION['moneda_mensaje']='si';

    $moneda=$_POST["moneda"];
    $monto="";
    $_SESSION['$moneda2']=$_POST["moneda"];
    $_SESSION['$monto2']=$_POST["monto"];
    
    echo "<script>location.href = 'moneda_menu_form_crear.php?moneda=$moneda'</script>";        
    exit();

}else{
    $monto=$_POST["monto"];
}

$id_usuario=$_SESSION["id_usuario"];

// Guarda datos 
$sql="INSERT INTO tab_monedas (moneda, valor_cambio, id_user) ";
$sql.="VALUES ('$moneda','$monto','$id_usuario')";

// echo $sql;
// exit();

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

$_SESSION['moneda_guardada']="si";
echo "<script>location.href = 'moneda_menu.php'</script>";    

?>