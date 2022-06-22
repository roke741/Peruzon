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

//validación
$error_form = "";
if ($_POST["dni"] == "") {

	$_SESSION['contenido_mensaje_cliente']='Debes escribir el campo DNI';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
    
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"];
 */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];
   
    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{
    $dni=$_POST["dni"];
}

/* if ($_POST["cedula"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir la Cédula o Rif';
    $_SESSION['cliente_mensaje']='si';

    $nac=$_POST["nac"];
    $cedula="";
    $_SESSION['rif_final']=$_POST["rif_final"];
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?nac=$nac'</script>";    
    exit();

}else{

    $cedula=$_POST["cedula"];

} */

$dni_numero =  is_numeric($_POST["dni"]);
if ($dni_numero==false){

    $_SESSION['contenido_mensaje_cliente']='El DNI debe ser un número';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $cedula="";
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"] */;

    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}

$dni_decimal=number_format($_POST["dni"],1);
$dni_decimal = explode('.', $dni_decimal);

if ($dni_decimal[1]!=0){

    $_SESSION['contenido_mensaje_cliente']='El DNI debe ser un número entero';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];

/*     $cedula="";
    $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */

    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();
}


/* if ($_POST["rif_final"] != "") {

    $rif_final_numero =  is_numeric($_POST["rif_final"]);
    if ($rif_final_numero==false){

        $_SESSION['contenido_mensaje_cliente']='Numeral del Rif debe ser un número';
        $_SESSION['cliente_mensaje']='si';

        $nac=$_POST["nac"];
        $_SESSION['cedula']=$_POST["cedula"];
        $rif_final="";
        $_SESSION['nombres']=$_POST["nombres"];
        $_SESSION['apellidos']=$_POST["apellidos"];
        $_SESSION['telefono']=$_POST["telefono"];
        $_SESSION['direccion']=$_POST["direccion"];
        $_SESSION['correo']=$_POST["correo"];

        echo "<script>location.href = 'clientes_crear.php?nac=$nac'</script>";    
        exit();

    }

}

if ($_POST["rif_final"] == "") {

    $rif_final="";

}else{

    $rif_final=$_POST["rif_final"];

} */

if ($_POST["nombres"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir los Nombres';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']="";
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{
    $nombres=utf8_encode($_POST["nombres"]);
}

if ($_POST["apellidos"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir los Apellidos';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']="";
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{

    $apellidos=utf8_encode($_POST["apellidos"]);

}

if ($_POST["telefono"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir el Teléfono';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']="";
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{
    $telefono=$_POST["telefono"];
}

if ($_POST["direccion"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir la Dirección';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']="";
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{
    $direccion=utf8_encode($_POST["direccion"]);
}

if ($_POST["correo"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir la Correo';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']="";

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}else{
    $correo=$_POST["correo"];
}

/* $cedula=$nac."-".$cedula;

if($rif_final!=""){

    $cedula=$cedula."-".$rif_final;

} */
/* $dniform = $dni; */


// Chequea que existe la cédula o rif del cliente
$sql20="SELECT dni FROM tab_clientes WHERE (dni = '$dni')";
$query20 = $mysqli->query($sql20);
// $row20=$query20->fetch_assoc();

if ($query20->num_rows!=0) {

    $_SESSION['contenido_mensaje_cliente']='El DNI ya existe';
    $_SESSION['cliente_mensaje']='si';

    $dni=$_POST["dni"];
/*     $_SESSION['cedula']=$_POST["cedula"];
    $_SESSION['rif_final']=$_POST["rif_final"]; */
    $_SESSION['nombres']=$_POST["nombres"];
    $_SESSION['apellidos']=$_POST["apellidos"];
    $_SESSION['telefono']=$_POST["telefono"];
    $_SESSION['direccion']=$_POST["direccion"];
    $_SESSION['correo']=$_POST["correo"];

    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}

$valores_fecha_act = explode('-', $_SESSION['fecha']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];
$hora_actual=$_SESSION['hora_actual'];

$id_usuario_cp=$_SESSION["id_usuario"];

// Guarda datos 
$sql="INSERT INTO tab_clientes (dni, nombres, apellidos, telefono, direccion, correo, fecha_reg, hora_reg, id_usuario) ";
$sql.="VALUES ('$dni','$nombres','$apellidos','$telefono','$direccion','$correo','$fecha_act','$hora_actual','$id_usuario_cp')";

// echo $sql;
// exit();

$query = $mysqli->query($sql);

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

$_SESSION['cliente_guardado']="si";
echo "<script>location.href = 'vender_clientes.php'</script>";    

?>