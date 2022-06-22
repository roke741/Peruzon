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
if ($_POST["usuario"] == "") {

	$_SESSION['contenido_usuario_mensaje']='Debes escribir el Usuario';
    $_SESSION['usuario_mensaje']='si';

    $usuario=$_POST["usuario"];
        
    $_SESSION['usuario2']="";
    $_SESSION['contrasena2']=$_POST["contrasena"];
    $_SESSION['nombre2']=$_POST["nombre"];
    $_SESSION['rol2']=$_POST["rol"];

    echo "<script>location.href = 'usuario_menu_crear.php?usuario=$usuario'</script>";    
    exit();

}else{
    $usuario=utf8_encode($_POST["usuario"]);
}

if ($_POST["contrasena"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir la Contraseña';
    $_SESSION['usuario_mensaje']='si';

    $usuario=$_POST["usuario"];
    
    $_SESSION['usuario2']=$_POST["usuario"];
    $_SESSION['contrasena2']="";
    $_SESSION['nombre2']=$_POST["nombre"];
    $_SESSION['rol2']=$_POST["rol"];

    echo "<script>location.href = 'usuario_menu_crear.php?usuario=$usuario'</script>";        
    exit();

}else{
    $contrasena=$_POST["contrasena"];
}

if ($_POST["nombre"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir el Nombre';
    $_SESSION['usuario_mensaje']='si';

    $usuario=$_POST["usuario"];
    
    $_SESSION['usuario2']=$_POST["usuario"];
    $_SESSION['contrasena2']=$_POST["contrasena"];
    $_SESSION['nombre2']="";
    $_SESSION['rol2']=$_POST["rol"];

    echo "<script>location.href = 'usuario_menu_crear.php?usuario=$usuario'</script>";        
    exit();

}else{
    $nombre=$_POST["nombre"];
}

if ($_POST["rol"] == "") {

    $_SESSION['contenido_usuario_mensaje']='Debes escribir el Rol';
    $_SESSION['usuario_mensaje']='si';

    $usuario=$_POST["usuario"];
    
    $_SESSION['usuario2']=$_POST["usuario"];
    $_SESSION['contrasena2']=$_POST["contrasena"];
    $_SESSION['nombre2']=$_POST["nombre"];
    $_SESSION['rol2']="";

    echo "<script>location.href = 'usuario_menu_crear.php?usuario=$usuario'</script>";        
    exit();

}else{
    $rol=$_POST["rol"];
}

// Guarda datos 
$sql="INSERT INTO tab_usuarios (usuario, contrasena, nombre, rol) ";
$sql.="VALUES ('$usuario','$contrasena','$nombre','$rol')";

$query = $mysqli->query($sql);

$_SESSION['usuario_guardado']="si";
echo "<script>location.href = 'usuario_menu.php'</script>";    

?>