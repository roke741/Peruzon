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
$sql = "SELECT current_date";
$row = $mysqli->query($sql);
$consultaf = $row->fetch_assoc();

$fechadelmysql = date_create($consultaf['current_date']);
$fechadelmysql = date_format($fechadelmysql, 'd-m-Y');
$_SESSION['fecha'] = $fechadelmysql;

$sql = "SELECT DATE_FORMAT(NOW( ), '%h:%i:%S %p' ) as hora";
$row2 = $mysqli->query($sql);
$consultaf2 = $row2->fetch_assoc();
$hora_actual=$consultaf2['hora'];
$_SESSION['hora_actual'] = $hora_actual;
/*
$sql = "SELECT DATE_FORMAT(NOW( ), '%d-%m-%Y' ) as fecha";
$row3 = $mysqli->query($sql);
$consultaf3 = $row3->fetch_assoc();
$fecha_actual=$consultaf3['fecha'];
$_SESSION['fecha'] = $fecha_actual;
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Inicio</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style-->
    <!--link rel="stylesheet" href="css/style.css"-->
    <!--style panel-->
    <link rel="stylesheet" href="css/stylepanel.css">
    <!--fontawesome-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <!--iconos-->
    <link rel="shortcut icon" href="imagenes/icon.png">
    <!--jquery online-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--jquery local-->
    <!--script src="jquery-1.3.2.min.js" type="text/javascript"></script-->
    <!--jquery confirm-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
</head>

<body>
    <div class="container-fluid" >
        <div class="row" style="height: 100vh;">
            <div class="col-3  align-self-center menu">
                <div class="menu_bar">
                    <a href="#" class="bt-menu"><span class="icon-menu"><i class="bi bi-list"></i></span>PERUZON</a>
                </div>

                <nav class="nav-menu py-4">
                    <ul class="nav flex-column text-center fw-bold text-light" >
                        <li class="nav-item">
                            <a class="nav-link active" href="vender_clientes.php" aria-current="page"><i class="bi bi-cart4"></i> VENTAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comprar_proveedores.php"><i class="bi bi-shop"></i> COMPRAS</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="productos.php"><i class="bi bi-box-seam"></i> PRODUCTOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reportes.php"><i class="bi bi-file-text"></i> REPORTES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="moneda_menu.php"><i class="bi bi-currency-dollar"></i> DOLAR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="usuario_menu.php"><i class="bi bi-file-earmark-person"></i> USUARIOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="acerca.php"><i class="bi bi-gear"></i> ACERCA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " onclick="Validar3();"><i class="bi bi-x-circle"></i> CERRAR</a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light py-4">BIENVENIDO</h2>
                <div class="text-center py-3">
                    <img class="img1" src="imagenes/fondoperuzon.png" alt="logo" >
                </div>
                <br>
                <div class="text-center py-3">
                    <img class="img2" src="imagenes/user.png" width="300px" alt="logo" >
                </div>
                <br>
                
                <p class="usuario fw-bold fs-4 ps-4">
                    <span class="text-light">
                    <br/>			
                    Fecha del Sistema: <?php echo $_SESSION['fecha']; ?>
                    <br/>			
                    Hora del Sistema: <?php echo $_SESSION['hora_actual']; ?>
                    <br/>
                    Usuario: <?php echo $_SESSION['usuario']; ?>
                    </span>
                </p>
                    <br>
                    <br>
                    <br>
                <p class="text-center fs-5 fw-bold fst-italic text-light" style="text-shadow: 3px 1px black">Desarrollado x Roke</p>
            </div>
        </div>
        <script>
            $(document).ready(main);
            var contador = 1;
            
            function main(){
                $('.menu_bar').click(function(){
                    // $('nav').toggle(); 
                    if(contador == 1){
                        $('nav').animate({
                            left: '0'
                        });
                        contador = 0;
                    } else {
                        contador = 1;
                        $('nav').animate({
                            left: '-100%'
                        });
                    }
                });
            }; 
        </script>

        <script>
        function Validar3(){
        // confirmation
        $.confirm({
        title: 'Mensaje',
        content: '¿Confirma en cerrar Sesion?',
        animation: 'scale',
        closeAnimation: 'zoom',
        buttons: {
            confirm: {
                text: 'Si',
                btnClass: 'btn-danger',
                action: function(){
                    window.location.href="cerrando.php";				     
                } // action: function(){
            }, // confirm: {
            cancelar: function(){
            } // cancelar: function()
            } // buttons
        }); // $.confirm
        }
        </script>
    </div>
<!-- <div class="container-fluid">
    <div class="row">
        <div class="col-sm-auto bg-primary sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap align-items-center bg-success sticky-top ">
                <a href="" class="d-block text-decoration-none">Peruzon</a>

                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-100 px-3 align-items-center">
                    <li class="nav-item ">
                        <a class="nav-link" href="panel.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panel.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-person-circle h2"></i>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="col-sm p-3 min-vh-100">

        </div>
    </div>
</div> -->

</body>
</html>