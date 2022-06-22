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

if(isset($_GET['id_moneda'])) {
    $id_moneda=$_GET['id_moneda'];
    $moneda=utf8_decode($_GET['moneda']);
    $valor_cambio=number_format($_GET['valor_cambio'],2,'.','');
    $_SESSION['id_moneda2']=$id_moneda;
    $_SESSION['moneda2']=$moneda;
    $_SESSION['valor_cambio2']=$valor_cambio;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Moneda-Editar-Form</title>
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
                            <a class="nav-link disabled" href="#"><i class="bi bi-shop"></i> CREAR CLIENTE</a> 
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
                <h2 class="fw-bold fst-italic text-center text-light pt-3">EDITAR MONEDA</h2>
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
                    <form id="formulario_moneda_crear" class="form-horizontal" method="post" action="return false" onsubmit="return false">
                       
                        <div class="row mb-3 align-items-center text-end">
                            <label for="moneda" class="col-sm-2 col-form-label">Moneda:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="user" class="form-control" type="text" name="moneda" value="<?php echo $moneda ?>" size="20" maxlength="8" >
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center text-end">
                            <label for="monto" class="col-sm-2 col-form-label">Monto:</label>
                            <div class="col-sm-8 ps-4">
                                <input id="pass" class="form-control" type="text" name="monto" value="<?php echo $valor_cambio ?>" size="20" maxlength="8" >
                            </div>
                        </div>

                        <input id="idmoneda" class="form-control" type="hidden" name="id" value="<?php echo $id_moneda ?>"/>

                        <div class="row justify-content-center mb-3">
                            <div class="col-sm-8 ps-4 align-self-center">
                                <button id="btn_enviar" onclick="Validar(document.getElementById('user').value,document.getElementById('pass').value,document.getElementById('idmoneda').value);" class="btn btn-danger col-sm-12"><i class="bi bi-save"></i> Guardar</button>
                            </div>
                        </div>

                        <div>&nbsp&nbsp</div>
                        <div class="row justify-content-center" style="height:40px;">
                            <div class="col-sm-6 text-center">
                                <div id="resp" class="resp" style="background-color:#0f0f0fa8; border-radius: 15px;">
                                
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
    function Validar(user,pass,idmoneda) {
    // confirmation
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en guardar?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-orange',

                action: function(){

                $.ajax({
                url: "moneda_editar_form_validar.php",
                type: "POST",
                data: "user="+user+"&pass="+pass+"&idmoneda="+idmoneda,
                beforeSend: function () {
                    $("#resp").html("<img src='imagen/loader.gif'/><font color='green'>&nbsp&nbspProcesando, por favor espere...</font>");
                },
                success: function(resp){
                    $('#resp').html(resp)
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
    if ( isset($_SESSION['moneda_mensaje']) && $_SESSION['moneda_mensaje'] == "si" ) {

    $_SESSION['moneda_mensaje']='no';
    $contenido_mensaje=$_SESSION['contenido_mensaje'];
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
</body>
</html>