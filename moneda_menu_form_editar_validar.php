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

$user = $_POST['user'];
$pass = $_POST['pass'];
$id_moneda = $_POST['idmoneda'];

//validación
$error_form = "";
$monto_entero =  is_numeric($_POST["pass"]);

if ($_POST["user"] == "") {

	//$error_form = "Debes escribir la Moneda ";
	//echo "<span style='color:red;'>$error_form</span>";
    $_SESSION['contenido_mensaje']='Debes escribir la Moneda';
    $_SESSION['moneda_mensaje']='si';

    $id_moned=$_SESSION['id_moneda2'];
    $user=$_SESSION['moneda2'];
    $pass=$_SESSION['valor_cambio2'];

    echo "<script>location.href = 'moneda_menu_form_editar.php?id_moneda=$id_moneda&moneda=$user&valor_cambio=$pass'</script>";    
	exit();

}

if ($_POST["pass"] == "") {

    //$error_form = "Debes escribir el Monto";
    //echo "<span style='color:red;'>$error_form</span>";
    
    $_SESSION['contenido_mensaje']='Debes escribir el Monto';
    $_SESSION['moneda_mensaje']='si';

    $id_moned=$_SESSION['id_moneda2'];
    $user=$_SESSION['moneda2'];
    $pass=$_SESSION['valor_cambio2'];

    echo "<script>location.href = 'moneda_menu_form_editar.php?id_moneda=$id_moneda&moneda=$user&valor_cambio=$pass'</script>";    
    exit();

}

if ($monto_entero==false){
    
    //$error_form = "El monto debe ser un n&uacutemero";
    //echo "<span style='color:red;'>$error_form</span>";

    $_SESSION['contenido_mensaje']='El monto debe ser un n&uacutemero';
    $_SESSION['moneda_mensaje']='si';

    $id_moned=$_SESSION['id_moneda2'];
    $user=$_SESSION['moneda2'];
    $pass=$_SESSION['valor_cambio2'];

    echo "<script>location.href = 'moneda_menu_form_editar.php?id_moneda=$id_moneda&moneda=$user&valor_cambio=$pass'</script>";    
    exit();

}  

// Guarda datos 
$sql="UPDATE tab_monedas SET moneda = '".utf8_encode($user)."', valor_cambio = '".$pass."', id_user = '".$_SESSION['id_usuario']."' ";
$sql.="WHERE (tab_monedas.id_moneda = ".$id_moneda.")"; 

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