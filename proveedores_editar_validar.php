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
/*
$producto = $_POST['nombres'];
echo $nombres;
exit();

$id_proveedor
$cedula
$nombres
$apellidos
$telefono
$direccion
$correo
*/

//validación
$error_form = "";
if ($_POST["nac"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir el campo antes de la Cédula o Rif';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

if ($_POST["cedula"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Cédula o Rif';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

$cedula_numero =  is_numeric($_POST["cedula"]);
if ($cedula_numero==false){

    $_SESSION['contenido_mensaje_proveedor']='La Cédula o Rif debe ser un número';
    $_SESSION['proveedor_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $rif_final=$_SESSION['rif_final2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

$cedula_decimal=number_format($_POST["cedula"],1);
$cedula_decimal = explode('.', $cedula_decimal);

if ($cedula_decimal[1]!=0){

    $_SESSION['contenido_mensaje_proveedor']='La Cédula o Rif debe ser un número entero';
    $_SESSION['proveedor_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $rif_final=$_SESSION['rif_final2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";      
    exit();

}

if ($_POST["rif_final"] != "") {

    $rif_final_numero =  is_numeric($_POST["rif_final"]);
    if ($rif_final_numero==false){

        $_SESSION['contenido_mensaje_proveedor']='Numeral del Rif debe ser un número';
        $_SESSION['proveedor_mensaje']='si';

        $id_cliente=$_SESSION['id_cliente2'];
        $nac=$_SESSION['nac2'];
        $cedula=$_SESSION['cedula2'];
        $rif_final=$_SESSION['rif_final2'];
        $nombres=$_SESSION["nombres2"];
        $apellidos=$_SESSION['apellidos2'];
        $telefono=$_SESSION['telefono2'];
        $direccion=$_SESSION['direccion2'];
        $correo=$_SESSION['correo2'];

        echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
        exit();

    }

}

if ($_POST["rif_final"] == "") {

    $rif_final="";

}else{

    $rif_final=$_POST["rif_final"];

}

if ($_POST["nombres"] == "") {

	$_SESSION['contenido_mensaje_proveedor']='Debes escribir los Nombres';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
	exit();

}

if ($_POST["apellidos"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir los Apellidos';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

if ($_POST["telefono"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir el Teléfono';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

if ($_POST["direccion"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Dirección';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

if ($_POST["correo"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir el Correo';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

if ($_POST["comercio"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir el Comercio';
    $_SESSION['proveedor_mensaje']='si';

    $id_proveedor=$_SESSION['id_proveedor2'];
    $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
    $comercio=$_SESSION['comercio2'];

    echo "<script>location.href = 'proveedores_editar.php?id_proveedor=$id_proveedor'</script>";    
    exit();

}

$nac=$_POST['nac'];
$cedula=$_POST['cedula'];
$rif_final=$_POST['rif_final'];

$cedula=$nac."-".$cedula;

if($rif_final!=""){

    $cedula=$cedula."-".$rif_final;

}

if($cedula!=$_SESSION['cedula_actual2']){

    // Chequea que existe la cédula o rif del proveedor
    $sql20="SELECT cedula FROM tab_proveedores WHERE (cedula = '$cedula')";
    $query20 = $mysqli->query($sql20);
    // $row20=$query20->fetch_assoc();

    if ($query20->num_rows!=0) {

        $_SESSION['contenido_mensaje_proveedor']='Cédula o Rif ya existe';
        $_SESSION['proveedor_mensaje']='si';

        $id_cliente=$_SESSION['id_cliente2'];
        $nac=$_SESSION['nac2'];
        $cedula=$_SESSION['cedula2'];
        $nombres=$_SESSION["nombres2"];
        $apellidos=$_SESSION['apellidos2'];
        $telefono=$_SESSION['telefono2'];
        $direccion=$_SESSION['direccion2'];
        $correo=$_SESSION['correo2'];

        echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
        exit();

    }

}

$id_proveedor=$_POST["id_proveedor"];
$nombres=utf8_encode($_POST["nombres"]);
$apellidos=utf8_encode($_POST['apellidos']);
$telefono=$_POST['telefono'];
$direccion=utf8_encode($_POST['direccion']);
$correo=$_POST['correo'];
$comercio=$_POST['comercio'];

// Guarda datos 
$sql="UPDATE tab_proveedores SET nac = '".$nac."', cedula = '".$cedula."', ";
$sql.="nombres = '".$nombres."', apellidos = '".$apellidos."', ";
$sql.="telefono = '".$telefono."', direccion = '".$direccion."', ";
$sql.="correo = '".$correo."', comercio = '".$comercio."' ";
$sql.="WHERE (tab_proveedores.id_proveedor = ".$id_proveedor.")";

$query = $mysqli->query($sql);

$id_usuario_cp=$_SESSION["id_usuario"];

// Chequea si el usuario tiene movimientos
$sql8="SELECT movimiento "; 
$sql8.="FROM tab_usuarios WHERE (id_usuario = $id_usuario_cp)";

$query8 = $mysqli->query($sql8);
$row8=$query8->fetch_assoc();
$movimiento8=$row8['movimiento'];

if($movimiento8=='no'){

    $sql9="UPDATE tab_usuarios SET movimiento = 'si' ";
    $sql9.="WHERE (id_usuario = ".$id_usuario_cp.")"; 

    $query9 = $mysqli->query($sql9);

}

$_SESSION['proveedor_guardado']="si";
echo "<script>location.href = 'buscar_proveedores.php'</script>";    

?>