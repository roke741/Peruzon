<?php
sleep(2);
require("conexion/connection.php");
session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];

$_SESSION['usuario_2']=$user;
$_SESSION['clave_2']=$pass;

$sql="SELECT * FROM tab_usuarios WHERE (usuario = '".$user."') AND (contrasena = '".$pass."')";
$row = $mysqli->query($sql); 
$fila = $row->fetch_assoc();

$_SESSION["usuario"] = $user;
$_SESSION["id_usuario"] = $fila["id_usuario"];

if ($user==$fila['usuario']){ 
    unset($_SESSION['usuario_2']);
    unset($_SESSION['clave_2']);

    $_SESSION['moneda_base']="Dólares";
    $_SESSION["usuario"] = $user;
    $_SESSION["id_usuario"] = $fila["id_usuario"];
    echo '<script>location.href = "cargando.php"</script>';
} 
else{
    // echo "<span style='color:red'>El usuario o la clave son incorrectas.</span>";
    $_SESSION['usuario_valido']='no';
    echo "<script>location.href = 'index.php'</script>";
}

?>