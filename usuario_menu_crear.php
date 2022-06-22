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
// Viene de valida usuario crear
if(isset($_GET['usuario'])) {
    $usuario=utf8_decode($_SESSION['usuario2']);
    $contrasena=$_SESSION['contrasena2'];
    $nombre=utf8_decode($_SESSION['nombre2']);
    $rol=$_SESSION['rol2'];
}else{
    $usuario="";
    $contrasena="";
    $nombre="";
    $rol="";
}
//echo $_SESSION['usuario2'];
//echo "...";
//exit();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Usuario-Crear</title>

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
            <div class="col-3  align-self-center menu">
                <div class="menu_bar">
                    <a href="#" class="bt-menu"><span class="icon-menu"><i class="bi bi-list"></i></span>PERUZON</a>
                </div>
                <nav class="nav-menu py-4">
                    <ul class="nav flex-column text-center fw-bold text-light" >
                        <li>
                            <h2 class="title fw-bold fst-italic pb-2">PERUZON</h2>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#"><i class="bi bi-file-earmark-person"></i> USUARIOS</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="usuario_menu.php"><i class="bi bi-file-earmark-person"></i> VOLVER</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light pt-3">CREAR USUARIO</h2>
                <br>
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
                    <form id="formulario_usuario_crear" class="form-horizontal" method="post" action="return false" onsubmit="return false">
                        <div class="row mb-3 align-items-center text-end">
                            <label for="usuario" class="col-sm-2 col-form-label">Usuario:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="usuario" class="form-control" type="text" name="usuario" value="<?php echo $usuario ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="contrasena" class="col-sm-2 col-form-label">Contraseña:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="contrasena" class="form-control" type="text" name="contrasena" value="<?php echo $contrasena ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombres:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="nombre" class="form-control" type="text" name="nombre" value="<?php echo $nombre ?>" size="20" maxlength="50" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="rol" class="col-sm-2 col-form-label">Rol:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="rol" class="form-control" type="text" name="rol" value="<?php echo $rol ?>" size="50" maxlength="20" >
                            </div>
                        </div>

                        <input id="id_usuario" class="form-control" type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>"/>

                        <div class="row justify-content-center mb-3">
                            <div class="col-sm-8 ps-4 align-self-center">
                                <button id="btn_enviar" onclick="AgregarUsuario();" class="btn btn-danger col-sm-12"><i class="bi bi-person-plus"></i> Guardar</button>
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
                <br>
                <p class="text-center fs-5 fw-bold fst-italic text-light" style="text-shadow: 3px 1px black">Desarrollado x Roke</p>
            </div>

        </div>
    </div>
    <?php 

    if ( isset($_SESSION['usuario_mensaje']) && $_SESSION['usuario_mensaje'] == "si" ) {
        $_SESSION['usuario_mensaje']='no';
        $contenido_mensaje=$_SESSION['contenido_usuario_mensaje'];
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
    function AgregarUsuario(){
/*     $(document).on('ready',function(){
        $('#btn-enviar').click(function(){ */
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
                        var url = "usuario_menu_crear_validar.php";     
                        $.ajax({                        
                        type: "POST",                 
                        url: url,                    
                        data: $("#formulario_usuario_crear").serialize(),
                        beforeSend: function (){
                            $("#resp").html("<img src='imagenes/load.gif' width='30px' height='30px'/><font color='white'>&nbsp&nbspPor favor espere...</font>");
                        },
                        success: function(data){
                            $('#resp').html(data);           
                        }
                        });          
                    } // action: function(){
                }, // confirm: {
                cancelar: function(){
                } // cancelar: function()
                } // buttons
            }); // $.confirm
/*         });
    }); */
    }
    </script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 

</body>
</html>