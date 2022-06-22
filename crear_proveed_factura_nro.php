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

if(!isset($_SESSION['nro_factura_porveed'])) {

  $_SESSION['nro_factura_porveed']="";

} 

if(!isset($_SESSION['fecha_factura_porveed'])) {

  $_SESSION['fecha_factura_porveed']="";

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Crear Facturas-Nro</title>
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
                            <a class="nav-link disabled" href="#"><i class="bi bi-cart4"></i> CREAR FACTURA</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="crear_factura.php"><i class="bi bi-cart4"></i> VOLVER</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light pt-3">CREAR FACTURAS PROVEEDOR</h2>
                <p class="usuario fw-bold ps-3">
					<span class="text-light ">
                        <br/>			
                        Fecha del Sistema: <?php echo $_SESSION['fecha']; ?>
                        <br/>			
                        Hora del Sistema: <?php echo $_SESSION['hora_actual']; ?>
                        <br/>
                        Usuario: <?php echo $_SESSION['usuario']; ?>
                        <br/>
                    </span>
				</p>

				<div class="cliente-info">
					<p class="bg-dark px-2 rounded-3 text-center">
						<span class="text-light fs-3 fw-bold"> DATOS DEL CLIENTE: </span> <br>
						<span class="text-light fs-4 fw-bold">Cliente: <?php echo $_SESSION['proveedor']; ?> | DNI: <?php echo $_SESSION['dni_ruc']; ?> | Teléfono: <?php echo $_SESSION['telefono_proveed']; ?> | Moneda: <?php echo $moneda; ?> | Valor cambio $:<?php echo number_format($valor_cambio,2,',','.'); ?> <?php echo $moneda; ?></span>
					</p>
				</div>

                <div class="container px-1">
                    <form id="formulario_factura_proveedor" method="post"  action="return false" onsubmit="return false">
                        
                        <div class="row mb-3 align-items-center text-end">
                            <label for="nro_factura_porveed" class="col-sm-2 col-form-label">Nro. Factura Proveedor:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="user" class="form-control" type="text" name="nro_factura_proveedor" value="<?php echo $_SESSION['nro_factura_porveed'] ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="fecha_factura_proveedor" class="col-sm-2 col-form-label">Nro. Factura Proveedor:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="pass" class="form-control" type="text" name="fecha_factura_proveedor" value="<?php echo $_SESSION['fecha_factura_porveed'] ?>" size="20" maxlength="20" >
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            <div class="col-sm-8 ps-4 align-self-center">
                                <button id="btn_enviar" onclick="Validar(document.getElementById('user').value,document.getElementById('pass').value);" name="submit2" class="btn btn-danger col-sm-12"><i class="bi bi-person-plus"></i> Guardar</button>
                            </div>
                        </div>

                        <div>&nbsp&nbsp</div>
                        <div class="row justify-content-center" style="height:40px;">
                            <div class="col-sm-6 text-center">
                                <div id="resultado" class="resp" style="background-color:#0f0f0fa8; border-radius: 15px;">
                                
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

    
    <script>
    // Boton Guardar
    function Validar(user,pass) {
    // confirmation
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en continuar?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
                action: function(){
                $.ajax({
                url: "crear_proveed_factura_nro_validar.php",
                type: "POST",
                data: "user="+user+"&pass="+pass,
                beforeSend: function () {
                    $("#resultado").html("<img src='imagen/loader-small.gif'/><font color='green'>&nbsp&nbspProcesando, por favor espere...</font>");
                },
                success: function(resp){
                    $('#resultado').html(resp)
                }        
            });
            } // action: function(){
        }, // confirm: {
        cancelar: function(){    
        } // cancelar: function()
    } // buttons
    }); // $.confirm
    } // function Validar(user, pass)
    </script>

    <?php 
    if ( isset($_SESSION['nro_factura_porveed_nulo']) && $_SESSION['nro_factura_porveed_nulo'] == "si" ) {
    unset($_SESSION['nro_factura_porveed_nulo']);

        echo "<script>
        $.alert({
            title: 'Mensaje',
            content: '<span style=color:red>Debes escribir el Nro. de Factura <br/> del Proveedor.</span>',
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

    if ( isset($_SESSION['fecha_factura_porveed_nulo']) && $_SESSION['fecha_factura_porveed_nulo'] == "si" ) {
    unset($_SESSION['fecha_factura_porveed_nulo']);

        echo "<script>
        $.alert({
            title: 'Mensaje',
            content: '<span style=color:red>Debes escribir la fecha de la Factura <br/> del Proveedor.</span>',
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

    if ( isset($_SESSION['fecha_factura_porveed_no_valido']) && $_SESSION['fecha_factura_porveed_no_valido'] == "si" ) {
    unset($_SESSION['fecha_factura_porveed_no_valido']);

        echo "<script>
        $.alert({
            title: 'Mensaje',
            content: '<span style=color:red>Fecha de la Factura del Proveedor <br/>no válido.</span>',
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    


</body>
</html>