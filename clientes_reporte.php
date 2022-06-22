<?php 
require("conexion/connection.php");
session_start();

// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
    header("Location:error1.php");
    exit();     
}

if(isset($_GET['id_cliente'])) {
    $id_cliente=$_GET['id_cliente'];
}

// Tabla clientes
$sql2="SELECT * FROM tab_clientes WHERE (id_cliente = $id_cliente)";
$query2 = $mysqli->query($sql2);

if($query2->num_rows==0){
    echo "No hay datos para mostrar";
    exit();
}

$row2=$query2->fetch_assoc();

$valores_fecha_act = explode('-', $row2['fecha_reg']);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];
// echo $id_cliente;
// exit();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Cliente-Vista</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style - vistas-->

    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Share+Tech+Mono&family=Turret+Road&display=swap" rel="stylesheet">
    <!--iconos-->
    <link rel="shortcut icon" href="imagenes/icon.png">
    <!--jquery online-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--jquery confirm-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    <!--jquery barcode-->
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js" integrity="sha512-QEAheCz+x/VkKtxeGoDq6nsGyzTx/0LMINTgQjqZ0h3+NjP+bCsPYz3hn0HnBkGmkIFSr7QcEZT+KyEM7lbLPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->    <!--jquery barcode segunda opcion-->
    <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
    <style> body{font-family:'Share Tech Mono', monospace;} p{ margin: 0;}</style>
    <!-- <style> body{font-family:'Turret Road', cursive;}</style> -->
    <!-- <style> body{font-family:'Press Start 2P', cursive;}</style> -->
</head>
<body>
    <div class="container px-4 ">
        <div class="text-center py-4 ">
            <img src="imagenes/fondoperuzon.png" width="100">
            <h3>Tienda Peruzon</h3>
        </div>
        <div class="row fw-bold">
            <div class="col mb-2 text-center">
                <p class="usuario fw-bold text-dark ">		
                    Fecha del Sistema: <?php echo $_SESSION['fecha']; ?>
                    <br/>			
                    Hora del Sistema: <?php echo $_SESSION['hora_actual']; ?>
                    <br/>
                    Usuario: <?php echo $_SESSION['usuario']; ?>
                </p>
            </div>
            <hr>
            <h3 class="text-center">Datos del cliente</h3>
            <div class="d-flex align-content-around flex-column flex-wrap" >
                <div class="row">
                    <div class="col ">DNI: <?php echo $row2['dni'] ?></div>
                </div>
                <div class="row">
                    <div class="col">NOMBRE: <?php echo utf8_decode($row2['nombres']) ?></div>
                </div>
                <div class="row">
                    <div class="col">APELLIDO: <?php echo utf8_decode($row2['apellidos']) ?></div>
                </div>
                <div class="row">
                    <div class="col">TELEFONO: <?php echo $row2['telefono'] ?></div>
                </div>
                <div class="row">
                    <div class="col">DIRECCION: <?php echo utf8_decode($row2['direccion']) ?></div>
                </div>
                <div class="row">
                    <div class="col">CORREO: <?php echo $row2['correo'] ?></div>
                </div>
                <div class="row">
                    <div class="col">FECHA DE REGISTRO: <?php echo $fecha_act ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col">HORA DE REGISTRO: <?php echo $row2['hora_reg'] ?></div>
                </div>
            </div>
            <hr>
        </div>
        <div class="text-center">
            <a id="menu" href="panel.php">Menu</a>
            <a id="volver" href="vender_clientes.php">Volver</a>
            <a href="#" id="Imprimir" onclick="printe()">Imprimir</a> 
        </div>

    </div>
    <script>
    function printe(){
        //desaparece el boton
        document.getElementById("menu").style.display='none';
        document.getElementById("volver").style.display='none';
        document.getElementById("Imprimir").style.display='none';
        
        //se imprime la pagina
        window.print();
        //reaparece el boton
        document.getElementById("menu").style.display='inline';
        document.getElementById("volver").style.display='inline';
        document.getElementById("Imprimir").style.display='inline';
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 

    
</body>
</html>