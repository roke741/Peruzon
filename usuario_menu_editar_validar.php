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

$id_usuario = $_POST['id_usuario'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$nombre = $_POST['nombre'];
$rol = $_POST['rol'];

//validación
$error_form = "";

if ($_POST["usuario"] == "") {

	$_SESSION['contenido_usuario_mensaje']='Debes escribir el Usuario';
    $_SESSION['usuario_mensaje']='si';

    $id_usuario=$_SESSION['id_usuario2'];
    $usuario = $_SESSION['usuario2'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    echo "<script>location.href = 'usuario_menu_editar.php?id_usuario=$id_usuario&usuario=$usuario&contrasena=$contrasena&nombre=$nombre&rol=$rol'</script>";    
	exit();
}

if ($_POST["contrasena"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir la Contraseña';
    $_SESSION['usuario_mensaje']='si';

    $id_usuario=$_SESSION['id_usuario2'];
    $usuario = $_POST['usuario'];
    $contrasena =  $_SESSION['contrasena2'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    echo "<script>location.href = 'usuario_menu_editar.php?id_usuario=$id_usuario&usuario=$usuario&contrasena=$contrasena&nombre=$nombre&rol=$rol'</script>";    
    exit();
}

if ($_POST["nombre"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir el Nombre';
    $_SESSION['usuario_mensaje']='si';

    $id_usuario=$_SESSION['id_usuario2'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_SESSION['nombre2'];
    $rol = $_POST['rol'];

    echo "<script>location.href = 'usuario_menu_editar.php?id_usuario=$id_usuario&usuario=$usuario&contrasena=$contrasena&nombre=$nombre&rol=$rol'</script>";    
    exit();
}

if ($_POST["rol"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir el Rol';
    $_SESSION['usuario_mensaje']='si';

    $id_usuario=$_SESSION['id_usuario2'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $rol = $_SESSION['rol2'];

    echo "<script>location.href = 'usuario_menu_editar.php?id_usuario=$id_usuario&usuario=$usuario&contrasena=$contrasena&nombre=$nombre&rol=$rol'</script>";    
    exit();
}

// Guarda datos 
$sql="UPDATE tab_usuarios SET usuario = '".utf8_encode($usuario)."', contrasena = '".$contrasena."', nombre = '".utf8_encode($nombre)."', rol = '".$rol."' ";
$sql.="WHERE (tab_usuarios.id_usuario = ".$id_usuario.")"; 

$query = $mysqli->query($sql);

$_SESSION['usuario_guardado']="si";
echo "<script>location.href = 'usuario_menu.php'</script>";	

?>