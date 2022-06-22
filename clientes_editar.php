<?php
require("conexion/connection.php");
session_start();

//si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
//no está definido la variable
if ($definido==false){
    header("Location:error1.php");
    exit();  
}

if(isset($_GET['id_cliente'])){
    $id_cliente=$_GET['id_cliente'];

    $sql="SELECT * FROM tab_clientes WHERE (id_cliente = ".$id_cliente.")";

    $query = $mysqli->query($sql);
    $row = $query->fetch_assoc();
    if ($query->num_rows!=0) {
        
        $_SESSION['dni_actual2']=$row['dni'];

        $dni=utf8_decode($row['dni']);
        $nombres=utf8_decode($row['nombres']);
        $apellidos=utf8_decode($row['apellidos']);
        $telefono=$row['telefono'];
        $direccion=utf8_decode($row['direccion']);
        $correo=$row['correo'];

        $_SESSION['id_cliente2']=$id_cliente;
        $_SESSION['dni2']=$dni;
        $_SESSION['nombres2']=$nombres;
        $_SESSION['apellidos2']=$apellidos;
        $_SESSION['telefono2']=$telefono;
        $_SESSION['direccion2']=$direccion;
        $_SESSION['correo2']=$correo;
    
    }else{ // $row = $query->fetch_assoc()
        echo "Cliente no existe.";
        exit();
    }// $row = $query->fetch_assoc()
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Vender-Editar</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style - ventas -->
    <link rel="stylesheet" href="css/stylepanel.css">
    <link rel="stylesheet" href="css/stylevender.css">
    <link rel="stylesheet" href="css/styleclientes.css">
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
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-3 align-self-center menu">
                <div class="menu_bar">
                    <a href="#" class="bt-menu"><span class="icon-menu"><i class="bi bi-list"></i></span>PERUZON</a>
                </div>

                <nav class="nav-menu py-4">
                    <ul class="nav flex-column text-center fw-bold text-light" >
                        <li>
                            <h2 class="title fw-bold fst-italic pb-2">PERUZON</h2>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#"><i class="bi bi-shop"></i> EDITAR CLIENTE</a> 
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="vender_clientes.php"><i class="bi bi-cart4"></i> VOLVER</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light pt-3">CREAR CLIENTE</h2>
                <p class="usuario fw-bold ps-3">
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
                <div class="container">
                    <form id="formulario_cliente" class="form-horizontal" method="post" action="return false" onsubmit="return false">
                        <div class="row mb-3 align-items-center text-end">
                            <label for="dni" class="col-sm-2 col-form-label">DNI:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="dni" class="form-control" type="text" name="dni" value="<?php echo $dni ?>" size="20" maxlength="8" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombres:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="nombres" class="form-control" type="text" name="nombres" value="<?php echo $nombres ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="apellido" class="col-sm-2 col-form-label">Apellidos:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="apellidos" class="form-control" type="text" name="apellidos" value="<?php echo $apellidos ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="telefono" class="form-control" type="text" name="telefono" value="<?php echo $telefono ?>" size="50" maxlength="9" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="direccion" class="col-sm-2 col-form-label">Dirección:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="direccion" class="form-control" type="text" name="direccion" value="<?php echo $direccion ?>" size="100" maxlength="100" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="correo" class="form-control" type="text" name="correo" value="<?php echo $correo ?>" size="50" maxlength="50" >
                            </div>
                        </div>

                        <input id="id_cliente" class="form-control" type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">

                        <div class="row justify-content-center mb-3">
                            <div class="col-sm-8 ps-4 align-self-center">
                                <button id="btn_enviar" onclick="Editar();" class="btn btn-danger col-sm-12"><i class="bi bi-person-plus"></i> Guardar</button>
                            </div>
                        </div>

                        <div>&nbsp&nbsp</div>
                        <div class="row justify-content-center" style="height:40px;">
                            <div class="col-sm-6 text-center">
                                <div id="resp" class="resp" style="background-color:#0f0f0fa8; border-radius: 15px;">
                                
                                </div>
                            </div>
                        </div>
                        <!-- <div id="resp"></div> -->

                    </form>
                </div>
                <div id="resultado"></div>
            </div>

        </div>

    </div>
    <?php 
    if ( isset($_SESSION['cliente_mensaje']) && $_SESSION['cliente_mensaje'] == "si" ) {
        $_SESSION['cliente_mensaje']='no';
        $contenido_mensaje=$_SESSION['contenido_mensaje_cliente'];
        echo "<script>
            $.alert({
                title: 'Mensaje',
                content: '<span style=color:red>$contenido_mensaje.</span>',
                animation: 'scale',
                closeAnimation: 'scale',
                buttons: {
                    okay: {
                        text: 'Cerrar',
                        btnClass: 'btn-danger'
                    }
                }
            }); 
        </script>";
        }
    ?>

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
    /* $(document).on('ready',function(){
        $('#btn-enviar').click(function(){ */
        function Editar(){
        // confirmation
        $.confirm({
        title: 'Mensaje',
        content: '¿Confirma en guardar?',
        animation: 'scale',
        closeAnimation: 'zoom',
            buttons: {
            confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
                action: function(){
                var url = "clientes_editar_validar.php";     
                $.ajax({                        
                type: "POST",                 
                url: url,                    
                data: $("#formulario_cliente").serialize(),
                beforeSend: function () {
                    $("#resp").html("<img src='imagenes/load.gif' width='30px' height='30px'/><font color='white'>&nbsp&nbspProcesando, por favor espere...</font>");
                },
                success: function(data) {
                    $('#resp').html(data);           
                }
                });          
                } // action: function(){
            }, // confirm: {
            cancelar: function(){
            } // cancelar: function()
            } // buttons
        }); // $.confirm
        } // function Editar()
 /*        });
    }); */
    </script>
    
</body>
</html>