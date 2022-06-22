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

$user = $_POST['user'];
$pass = $_POST['pass'];

//echo $_POST['user'];
//exit();

//validación
$error_form = "";

if ($_POST["user"] == "") {

	$_SESSION['nro_factura_porveed']="";
    $_SESSION['fecha_factura_porveed']=$_POST['pass'];
    $_SESSION['nro_factura_porveed_nulo']="si";
    echo "<script>location.href = 'crear_proveed_factura_nro.php'</script>";
    exit();

}

$nro_factura_proveedor=$_POST['user'];

if ($_POST["pass"] == "") {

    $_SESSION['nro_factura_porveed']=$_POST['user'];
    $_SESSION['fecha_factura_porveed']="";
    $_SESSION['fecha_factura_porveed_nulo']="si";
    echo "<script>location.href = 'crear_proveed_factura_nro.php'</script>";
    exit();

}

$fecha_factura_porveedor=$_POST['pass'];

$_SESSION['nro_factura_porveed']=$_POST['user'];
$_SESSION['fecha_factura_porveed']=$_POST['pass'];

$fecha=trim($fecha_factura_porveedor);
$longitud_fecha=strlen($fecha);

if ($longitud_fecha==10){

    $valores = explode('-', $fecha);
    if (is_numeric($valores[0]) && is_numeric($valores[1]) && is_numeric($valores[2]) && strlen($valores[2])==4){

        if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
            $error_fecha="fecha valido";
        }else{
            $error_fecha="fecha no valido";
        }
    }else{
        $error_fecha="fecha no valido";       
    }
}else{
    $error_fecha="fecha no valido";
}   

if ($error_fecha=="fecha no valido"){

    $_SESSION['fecha_factura_porveed_no_valido']="si";
    echo "<script>location.href = 'crear_proveed_factura_nro.php'</script>";
    exit();

}
echo "<script>location.href = 'crear_proveed_factura.php'</script>";	
?>