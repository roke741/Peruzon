<?php 
require("conexion/connection.php");
session_start();
/*
Nota:
echo $_SESSION['carrito'][1]['id_producto'];
exit();
*/
// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
    header("Location:error1.php");
    exit();      
}

$valor_cambio=0;
if(isset($_GET['moneda'])) {
	$moneda=$_GET['moneda'];
	$sql="SELECT id_moneda, moneda, valor_cambio ";
	$sql.="FROM tab_monedas WHERE (moneda = '".$moneda."')";

	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc(); 
	if ($query->num_rows!=0) {
		$valor_cambio=$row['valor_cambio'];
		$moneda=$row['moneda'];
	} else { // $row = $query->fetch_assoc()
		echo "La moneda: ".$moneda." no esta registrada";
		exit();
	} // $row = $query->fetch_assoc()
} // if(isset($_GET['moneda']))
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Crear Facturas-Moneda</title>
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
                <h2 class="fw-bold fst-italic text-center text-light pt-3">CREAR FACTURAS CLIENTES</h2>
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
						<span class="text-light fs-4 fw-bold">Cliente: <?php echo $_SESSION['cliente']; ?> | DNI: <?php echo $_SESSION['dni']; ?> | Teléfono: <?php echo $_SESSION['telefono']; ?> | Moneda: <?php echo $_SESSION['moneda_base']; ?></span>
					</p>
				</div>

				<div class="container px-1">
					<?php if(isset($_SESSION['carrito'])) { ?>
						<form id="formulario_renglones" method="post" action="crear_factura.php">							
							<div class="table-responsive">
								<table class="table table-danger table-bordered  table-hover">
									<thead class="table-dark">
										<tr>
											<th class='table-header' width='5%'>Nro.</th>
											<th class='table-header' width='37.5%'>Producto</th>
											<th class='table-header' width='37.5%'>Descripción</th>
											<th class='table-header' width='10%'>Cantidad</th>
											<th class='table-header' width='10%'>Prec/Unit</th>
											<th class='table-header' width='10%'>Prec/Total</th>
										</tr>
									</thead>
									<tbody id='table-body' style="white-space: nowrap;">

									<?php

									$totalprice=0;
									$nro_reng2=0;
									$cantidad2=0;
									
									for($i=0;$i<$_SESSION['total_productos'];$i++){

										$nro_reng2++;
										$nro_reglon=$nro_reng2;
										
										$subtotal=$_SESSION['carrito'][$nro_reglon]['cantidad']*$_SESSION['carrito'][$nro_reglon]['precio'];
										$totalprice+=$subtotal;

										$cantidad2+=$_SESSION['carrito'][$nro_reglon]['cantidad'];

									?>
									<tr>
										<td><?php echo $_SESSION['carrito'][$nro_reglon]['orden'] ?></td>
										<td><?php echo $_SESSION['carrito'][$nro_reglon]['producto'] ?></td>
										<td><?php echo $_SESSION['carrito'][$nro_reglon]['descripcion'] ?></td>
										<td><div class="cantidad"><?php echo $_SESSION['carrito'][$nro_reglon]['cantidad'] ?></div></td>
										<td><div class="monto"><?php echo number_format($_SESSION['carrito'][$nro_reglon]['precio']*$valor_cambio,2,',','.') ?></div></td>
										<td><div class="monto"><?php echo number_format($_SESSION['carrito'][$nro_reglon]['cantidad']*$_SESSION['carrito'][$nro_reglon]['precio']*$valor_cambio,2,',','.'); ?></div></td>
									</tr>
									<?php
										} // for($i=0;$i<$_SESSION['total_productos'];$i++)
										$_SESSION['totalprice']=$totalprice;
									?>
									</tbody>
								</table>	
							</div>

							<div class="total_factura">

								<b>Sub-Total: </b> <?php echo number_format($totalprice*$valor_cambio,2,',','.'); ?>
								<br/>
								<b>Descuento(%): </b> <?php echo $_SESSION['descuento']; ?>
								<br/>
								<b>Total: </b><?php echo number_format($totalprice*$valor_cambio-$totalprice*$valor_cambio*$_SESSION['descuento']/100,2,',','.'); ?>
								<br/>
								<b>Nro. de Productos:</b> <?php echo number_format($cantidad2,0,',','.'); ?>

							</div>

						
						</form>
					<?php 
					} // if(isset($_SESSION['carrito']))
					?>
				</div>


			</div>




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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    

	
</body>
</html>