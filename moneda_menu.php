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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon - Moneda - Menu</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style -->
    <link rel="stylesheet" href="css/stylepanel.css">
    <link rel="stylesheet" href="css/stylevender.css">
    <link rel="stylesheet" href="css/columna2.css">
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
                            <a class="nav-link disabled" href="#"><i class="bi bi-currency-dollar"></i> DOLAR</a> 
                        </li>
                            
                        <li class="nav-item">
                            <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light pt-3">DOLAR</h2>
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
                <div class="container">
                    <div class="row justify-content-start mb-1">
                        <div class="col-6 d-flex">
                            <p class="btn-agregar px-2"><a href="moneda_menu_form_crear.php">Agregar Moneda</a></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form id="formulario_renglones" method="post" action="crear_factura.php">
                            <?php
                            // Tabla monedas
                            $sql2="SELECT * FROM tab_monedas ORDER BY moneda";
                            $query2 = $mysqli->query($sql2);

                            if($query2->num_rows==0){
                                echo '<p class="text-light">No hay datos para mostrar</p>';
                            }else{ // if($query2->num_rows==0)
                            ?>
                            <table class="table table-danger table-bordered  table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th class='table-header' width='30%'>Moneda</th>
                                    <th class='table-header' width='30%'>Monto</th>
                                    <th class='table-header' width='40%'>Enlace</th>
                                </tr>
                                </thead>

                                <tbody id='table-body' style="white-space: nowrap;">
                                    <?php
                                    while ($row2=$query2->fetch_assoc()) {
                                    ?>
                                    <tr class="table-row">
                                        <td><?php echo  utf8_decode($row2['moneda']) ?></td>
                                        <td><?php echo number_format($row2['valor_cambio'],2,',','.') ?></td>
                                        <td>
                                            <a href="#" onclick="Validar3('<?php echo $row2['moneda']?>', <?php echo $row2['id_moneda']?>, <?php echo $row2['valor_cambio']?>)" class="btn btn-danger p-1"><i class="bi bi-pencil"></i> Editar</a>
                                            <a href="#" onclick="Validar4('<?php echo $row2['moneda']?>', <?php echo $row2['id_moneda']?>)"class="btn btn-danger p-1"><i class="bi bi-x-octagon"></i> Eliminar</a>
                                        </td>
                                    </tr>
                                    <?php
                                    } // while ($row2=$query2->fetch_assoc())   
                                    ?> 
                                </tbody>
                            </table>
                            <?php
                            } // if($query2->num_rows==0)
                            ?>
                        </form>
                    </div>
                    <div id="resultado"></div>
                    <br>

                </div>

                <p class="text-center fs-5 fw-bold fst-italic text-light" style="text-shadow: 3px 1px black">Desarrollado x Roke</p>

            </div>

        </div>
    </div>
    <script>
    function Validar3(moneda,id_moneda,valor_cambio){
    // confirmation en editar moneda
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en editar los '+moneda+'?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
            action: function(){
                window.location.href="moneda_menu_form_editar.php?id_moneda="+id_moneda+"&moneda="+moneda+"&valor_cambio="+valor_cambio;
            } // action: function(){
        }, // confirm: {
        cancelar: function(){
        } // cancelar: function()
        } // buttons
    }); // $.confirm
    }

    // Confirma en eliminar moneda
    function Validar4(moneda,id_moneda){
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en eliminar <br/> la moneda '+moneda+'?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
            action: function(){
            window.location.href="moneda_menu_eliminar_validar.php?id_moneda="+id_moneda;           
            } // action: function(){
        }, // confirm: {
        cancelar: function(){    
        } // cancelar: function()
    } // buttons
    }); // $.confirm
    }
    </script>
    <?php
    if ( isset($_SESSION['moneda_eliminada']) && $_SESSION['moneda_eliminada'] == "si" ) {

        unset($_SESSION['moneda_eliminada']);
        
        echo "<script>
        $.confirm({
        title: 'Mensaje',
        content: '<span style=color:green>Moneda eliminada con éxito.</span>',
        autoClose: 'Cerrar|3000',
        buttons: {
            Cerrar: function () {  
            }
        }
        });</script>";
    }
    ?>
    <?php 
    if ( isset($_SESSION['moneda_guardada']) && $_SESSION['moneda_guardada'] == "si" ) {

        unset($_SESSION['moneda_guardada']);
        
        echo "<script>
        $.confirm({
        title: 'Mensaje',
        content: '<span style=color:green>Datos guardado con éxito.</span>',
        autoClose: 'Cerrar|3000',
        buttons: {
            Cerrar: function () { 
            }
        }
        });</script>";
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