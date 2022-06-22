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

if ($_POST["dni"] == "") {

	$_SESSION['contenido_mensaje_cliente']='Debes escribir el campo DNI';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];
    $dni=$_SESSION['dni2'];
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];
   
    echo "<script>location.href = 'clientes_crear.php?dni=$dni'</script>";    
    exit();

}



$dni_numero =  is_numeric($_POST["dni"]);
if ($dni_numero==false){

    $_SESSION['contenido_mensaje_cliente']='El DNI debe ser un número';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];
    
/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $rif_final=$_SESSION['rif_final2'];
 */
    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

$dni_decimal=number_format($_POST["dni"],1);
$dni_decimal = explode('.', $dni_decimal);

if ($dni_decimal[1]!=0){

    $_SESSION['contenido_mensaje_cliente']='El DNI debe ser un número entero';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2'];
    $rif_final=$_SESSION['rif_final2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";      
    exit();

}


/* if ($_POST["rif_final"] != "") {

    $rif_final_numero =  is_numeric($_POST["rif_final"]);
    if ($rif_final_numero==false){

        $_SESSION['contenido_mensaje_cliente']='Numeral del Rif debe ser un número';
        $_SESSION['cliente_mensaje']='si';

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

} */

if ($_POST["nombres"] == "") {

	$_SESSION['contenido_mensaje_cliente']='Debes escribir los Nombres';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
	exit();

}

if ($_POST["apellidos"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir los Apellidos';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

if ($_POST["telefono"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir el Teléfono';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

if ($_POST["direccion"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir la Dirección';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];

    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

if ($_POST["correo"] == "") {

    $_SESSION['contenido_mensaje_cliente']='Debes escribir el Correo';
    $_SESSION['cliente_mensaje']='si';

    $id_cliente=$_SESSION['id_cliente2'];
    $dni=$_SESSION['dni2'];

/*     $nac=$_SESSION['nac2'];
    $cedula=$_SESSION['cedula2']; */

    $nombres=$_SESSION["nombres2"];
    $apellidos=$_SESSION['apellidos2'];
    $telefono=$_SESSION['telefono2'];
    $direccion=$_SESSION['direccion2'];
    $correo=$_SESSION['correo2'];

    echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
    exit();

}

/* $nac=$_POST['nac'];
$cedula=$_POST['cedula'];
$rif_final=$_POST['rif_final'];

$cedula=$nac."-".$cedula;

if($rif_final!=""){

    $cedula=$cedula."-".$rif_final;

} */

$dni=$_POST['dni'];

if($dni!=$_SESSION['dni_actual2']){

    // Chequea que existe la cédula o rif del cliente
    $sql20="SELECT dni FROM tab_clientes WHERE (dni = '$dni')";
    $query20 = $mysqli->query($sql20);
    // $row20=$query20->fetch_assoc();

    if ($query20->num_rows!=0) {

        $_SESSION['contenido_mensaje_cliente']='DNI ya existe';
        $_SESSION['cliente_mensaje']='si';

        $id_cliente=$_SESSION['id_cliente2'];

        $dni=$_SESSION['dni2'];

/*         $nac=$_SESSION['nac2'];
        $cedula=$_SESSION['cedula2']; */

        $nombres=$_SESSION["nombres2"];
        $apellidos=$_SESSION['apellidos2'];
        $telefono=$_SESSION['telefono2'];
        $direccion=$_SESSION['direccion2'];
        $correo=$_SESSION['correo2'];

        echo "<script>location.href = 'clientes_editar.php?id_cliente=$id_cliente'</script>";    
        exit();

    }

}

$id_cliente=$_POST["id_cliente"];
$nombres=utf8_encode($_POST["nombres"]);
$apellidos=utf8_encode($_POST['apellidos']);
$telefono=$_POST['telefono'];
$direccion=utf8_encode($_POST['direccion']);
$correo=$_POST['correo'];

// Guarda datos 
$sql="UPDATE tab_clientes SET dni = '".$dni."', ";
$sql.="nombres = '".$nombres."', apellidos = '".$apellidos."', ";
$sql.="telefono = '".$telefono."', direccion = '".$direccion."', ";
$sql.="correo = '".$correo."' ";
$sql.="WHERE (tab_clientes.id_cliente = ".$id_cliente.")";

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

$_SESSION['cliente_guardado']="si";
echo "<script>location.href = 'vender_clientes.php'</script>";    

?>