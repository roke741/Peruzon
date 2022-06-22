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

if ($_POST["fecha_inicial"] == "") {

    $_SESSION['contenido_mensaje_repor']='Debes escribir la Fecha Inicial';
    $_SESSION['reporte_mensaje']='si';

    $fecha_inicial="";
    $fecha_final=$_POST["fecha_final"];

    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    
    exit();

}else{

    $fecha_inicial=trim($_POST["fecha_inicial"]);

}

if ($_POST["fecha_final"] == "") {

    $_SESSION['contenido_mensaje_repor']='Debes escribir la Fecha Final';
    $_SESSION['reporte_mensaje']='si';

    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final="";

    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    
    exit();

}else{

    $fecha_final=trim($_POST["fecha_final"]);

}

$fecha=trim($fecha_inicial);
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

    $_SESSION['contenido_mensaje_repor']='Fecha Inicial no válido';
    $_SESSION['reporte_mensaje']='si';

    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final=$_POST["fecha_final"];

    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    
    exit();

}

$fecha=trim($fecha_final);
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

    $_SESSION['contenido_mensaje_repor']='Fecha Final no válido';
    $_SESSION['reporte_mensaje']='si';

    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final=$_POST["fecha_final"];

    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    
    exit();

}

$primera = $fecha_final;
$segunda = $fecha_inicial;

$diferencia_dias=compararFechas ($primera,$segunda);

if($diferencia_dias<0){

    $_SESSION['contenido_mensaje_repor']='Intervalo de Fechas no válido';
    $_SESSION['reporte_mensaje']='si';

    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final=$_POST["fecha_final"];

    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    
    exit();   

}

echo "<script>location.href = 'reportes_compras_vista.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>";    

function compararFechas($primera, $segunda)
 {
  $valoresPrimera = explode ("-", $primera);   
  $valoresSegunda = explode ("-", $segunda); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 

  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];

  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     

  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 

}
?>