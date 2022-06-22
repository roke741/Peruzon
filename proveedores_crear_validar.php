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
if ($_POST["dni_ruc"] == "") {

	$_SESSION['contenido_mensaje_proveedor']='Debes escribir el campo de DNI O RUC';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
    /* $nac=$_POST["nac"];
    
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];
   
    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}else{
    $dni_ruc=$_POST["dni_ruc"];
}

/* if ($_POST["cedula"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Cédula o Rif';
    $_SESSION['proveedor_mensaje']='si';

    $nac=$_POST["nac"];
    $cedula="";
    $_SESSION['rif_final']=$_POST["rif_final"];
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?nac=$nac'</script>";    
    exit();

}else{

    $cedula=$_POST["cedula"];

} */

$dni_ruc_numero =  is_numeric($_POST["dni_ruc"]);
if ($dni_ruc_numero==false){

    $_SESSION['contenido_mensaje_proveedor']='El DNI O RUC debe ser un número';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $cedula="";
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"];
     */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}

$dni_ruc_decimal=number_format($_POST["dni_ruc"],1);
$dni_ruc_decimal = explode('.', $dni_ruc_decimal);

if ($dni_ruc_decimal[1]!=0){

    $_SESSION['contenido_mensaje_proveedor']='El DNI O RUC debe ser un número entero';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/* 
    $nac=$_POST["nac"];
    $cedula="";
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */

    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}


/* if ($_POST["rif_final"] != "") {

    $rif_final_numero =  is_numeric($_POST["rif_final"]);
    if ($rif_final_numero==false){

        $_SESSION['contenido_mensaje_proveedor']='Numeral del Rif debe ser un número';
        $_SESSION['proveedor_mensaje']='si';

        $nac=$_POST["nac"];
        $_SESSION['cedula']=$_POST["cedula"];
        $rif_final="";
        $_SESSION['nombres']=$_POST["nombres"];
        $_SESSION['apellidos']=$_POST["apellidos"];
        $_SESSION['telefono']=$_POST["telefono"];
        $_SESSION['direccion']=$_POST["direccion"];
        $_SESSION['correo']=$_POST["correo"];
        $_SESSION['comercio']=$_POST["comercio"];

        echo "<script>location.href = 'proveedores_crear.php?nac=$nac'</script>";    
        exit();

    }

}

if ($_POST["rif_final"] == "") {

    $rif_final="";

}else{

    $rif_final=$_POST["rif_final"];

} */

if ($_POST["nombres"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir los Nombres';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']="";
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();

}else{
    $nombres=utf8_encode($_POST["nombres"]);
}

if ($_POST["apellidos"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir los Apellidos';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']="";
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}else{
    $apellidos=utf8_encode($_POST["apellidos"]);
}

if ($_POST["telefono"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir el Teléfono';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']="";
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}else{
    $telefono=$_POST["telefono"];
}

if ($_POST["direccion"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Dirección';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']="";
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}else{
    $direccion=utf8_encode($_POST["direccion"]);
}

if ($_POST["correo"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Correo';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']="";
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();

}else{

    $correo=$_POST["correo"];

}

if ($_POST["comercio"] == "") {

    $_SESSION['contenido_mensaje_proveedor']='Debes escribir la Comercio';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $nac=$_POST["nac"];
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']="";


    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();

}else{

    $comercio=$_POST["comercio"];

}

/* $cedula=$nac."-".$cedula;

if($rif_final!=""){

    $cedula=$cedula."-".$rif_final;

} */


// Chequea que existe la cédula o rif del proveedor
$sql20="SELECT dni_ruc FROM tab_proveedores WHERE (dni_ruc = '$dni_ruc')";
$query20 = $mysqli->query($sql20);
// $row20=$query20->fetch_assoc();

if ($query20->num_rows!=0) {

    $_SESSION['contenido_mensaje_proveedor']='DNI O RUC ya existe';
    $_SESSION['proveedor_mensaje']='si';

    $dni_ruc=$_POST["dni_ruc"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"];
     */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
    $_SESSION['comercio']=$_POST["comercio"];

    echo "<script>location.href = 'proveedores_crear.php?dni_ruc=$dni_ruc'</script>";    
    exit();
}

$valores_fecha_act = explode('-', $_SESSION['fecha']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];
$hora_actual=$_SESSION['hora_actual'];

$id_usuario_cp=$_SESSION["id_usuario"];

// Guarda datos 
$sql="INSERT INTO tab_proveedores (dni_ruc, nombres, apellidos, telefono, direccion, correo, comercio, fecha_reg, hora_reg, id_usuario) ";
$sql.="VALUES ('$dni_ruc','$nombres','$apellidos','$telefono','$direccion','$correo','$comercio','$fecha_act','$hora_actual','$id_usuario_cp')";

// echo $sql;
// exit();

$query = $mysqli->query($sql);

/* $id_usuario_cp=$_SESSION["id_usuario"]; */

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

$_SESSION['proveedor_guardado']="si";
echo "<script>location.href = 'comprar_proveedores.php'</script>";    

?>