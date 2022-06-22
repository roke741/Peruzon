<?php 
require("conexion/connection.php");
session_start();
/*
Nota:
echo $_SESSION['productos2'][1]['id_producto'];
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

	$sql="SELECT id_factura, valor_cambio ";
	$sql.="FROM tab_facturas_monedas ";
	$sql.="WHERE (moneda = '".$moneda."') AND (id_factura = ".$_SESSION['id_factura_rep'].")";

	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc(); 

	if ($query->num_rows!=0) {

		$valor_cambio=$row['valor_cambio'];
	} else { // $row = $query->fetch_assoc()
		echo "La factura no tiene la moneda: ".$moneda." registrada";
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
    <title>Peruzon-Factura-Vista-Moneda</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style corregir-->
    <link rel="stylesheet" href="css/stylepanel.css">
    <link rel="stylesheet" href="css/stylevender.css">
    <link rel="stylesheet" href="css/styleclientes.css">

    <!--verificar-->
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Share+Tech+Mono&family=Turret+Road&display=swap" rel="stylesheet">
    
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
    
    <style> body{font-family:'Share Tech Mono', monospace;} p{ margin: 0;}</style>
</head>
<body>
    <div class="container px-4">
        <div class="text-start mt-3">
            <img src="imagenes/fondoperuzon.png" width="200" alt="logo">
            <h4 class="text-center fw-bold">Factura Nro.:</b> <?php echo $_SESSION['nro_factura_rep']; ?></h4>
            <h6 class="text-center fecha_rep">Fecha Factura:<?php echo $_SESSION['fecha_prov_rep']; ?></h6>
            <h6 class="text-center fecha_rep">Proveedor: <?php echo $_SESSION['proveedor'] ; ?></h6>
            <h6 class="text-center fecha_rep">DNI O RUC: <?php echo $_SESSION['cedula_proveed']; ?></h6>
            <h6 class="text-center fecha_rep">Telefono: <?php echo $_SESSION['telefono_proveed']; ?></h6>
            <h5>Monedad: <b> <?php echo $moneda; ?></b> </h5>
            <h5>Valor cambio por dólar: <b> <?php echo number_format($valor_cambio,2,',','.'); ?></b> </h5>
        </div>
        <div class="table-responsive">
            <?php if(isset($_SESSION['productos2'])) { ?>
            <form id="formulario_renglones" method="post" action="crear_factura.php">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class='table-header' width='5%' style="vertical-align:middle">Nro.</th>
                            <th class='table-header' width='30%' style="vertical-align:middle">Producto</th>
                            <th class='table-header' width='40%' style="vertical-align:middle">Descripción</th>
                            <th class='table-header' width='7%' style="vertical-align:middle">Cantidad</th>
                            <th class='table-header' width='7%' style="vertical-align:middle">Prec/Unit</th>
                            <th class='table-header' width='7%' style="vertical-align:middle">Prec/Total</th>                    
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalprice=0;
                    $nro_reng2=0;
                    $cantidad2=0;

                    for($i=0;$i<$_SESSION['total_renglones_rep'];$i++){
                        $nro_reng2++;
                        $nro_reglon=$nro_reng2;
                        
                        $subtotal=$_SESSION['productos2'][$nro_reglon]['cantidad']*$_SESSION['productos2'][$nro_reglon]['precio'];
                        $totalprice+=$subtotal;

                        $cantidad2+=$_SESSION['productos2'][$nro_reglon]['cantidad'];
                    ?>
                        <tr class='table-row'>
                            <td><?php echo $_SESSION['productos2'][$nro_reglon]['orden'] ?></td>
                            <td><?php echo $_SESSION['productos2'][$nro_reglon]['producto'] ?></td>
                            <td><?php echo $_SESSION['productos2'][$nro_reglon]['descripcion'] ?></td>
                            <td><div class="cantidad"><?php echo $_SESSION['productos2'][$nro_reglon]['cantidad'] ?></div></td>
                            <td><div class="monto"><?php echo number_format($_SESSION['productos2'][$nro_reglon]['precio']*$valor_cambio,2,',','.') ?></div></td>
                            <td><div class="monto"><?php echo number_format($_SESSION['productos2'][$nro_reglon]['cantidad']*$_SESSION['productos2'][$nro_reglon]['precio']*$valor_cambio,2,',','.'); ?></div></td>
                        </tr>

                    <?php
                    } // for($i=0;$i<$_SESSION['total_productos'];$i++)
                    $_SESSION['totalprice']=$totalprice;
                    ?>
                    </tbody>
                </table>
                <div class="total_factura">
                    <b>Sub-Total</b>: <?php echo number_format($totalprice*$valor_cambio,2,',','.'); ?>
                    <br/>
                    <b>Descuento(%)</b>: <?php echo number_format($_SESSION['descuento_rep'],2,',','.'); ?>
                    <br/>
                    <b>Total</b>: <?php echo number_format($_SESSION['total_desc']*$valor_cambio,2,',','.'); ?>
                    <br/>
                    <b>Nro. de Productos:</b> <?php echo number_format($cantidad2,0,',','.'); ?>
                </div>
            </form>
            <p>
                <b>Dirección:</b> Carrera 7, Nro. 6-5, El Corozo, Tovar Edo. Médira.
                <br/>
                <b>Telf:</b> 0424-7519699.
            </p>
            <?php 
            } // if(isset($_SESSION['productos2']))
            ?>
        </div>
		<p>
			<b>Dirección:</b> Carrera 7, Nro. 6-5, El Corozo, Tovar Edo. Médira.
			<br/>
			<b>Telf:</b> 0424-7519699.

		</p>

        <div class="text-center">
            <a id="menu" href="panel.php">Menu</a>
            <a id="volver" href="factura_reporte.php?id_factura=<?php echo $_SESSION['id_factura_rep'] ?>&nro_factura=<?php echo $_SESSION['nro_factura_rep'] ?>&fecha_reg=<?php echo $_SESSION['fecha_reg_rep']?>&total=<?php echo $_SESSION['total']?>&descuento=<?php echo $_SESSION['descuento_rep']?>&total_desc=<?php echo $_SESSION['total_desc']?>">Volver</a>
            <a href="#" id="Imprimir" onclick="printe()">Imprimir</a> 
        </div>
		<div id="resultado"></div>
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
    
</body>
</html>