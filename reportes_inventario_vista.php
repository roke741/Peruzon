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

// Totaliza los renglones de la factura segun la cantidad del producto
$sql3="SELECT id_producto, producto, descripcion, precio_compra, precio_final, ganancia, cantidad_existencia FROM tab_productos ";
$sql3.="GROUP BY id_producto";

$query3 = $mysqli->query($sql3);

if($query3->num_rows==0){
    echo "<p style='font-family: Arial; font-size: 11pt; color: red'>No hay productos</p>"; 
    exit();
}

// Lista los totales de las cantidades del producto
$i=0;
while ($row3=$query3->fetch_assoc()) {
    $i=$i+1;
    $id_producto_4=$row3['id_producto'];
    if ($i==1){
        
        $productos_a = array(
        $i => array(
            'nombre_p' => $row3['producto'],
            'descripcion_p' => $row3['descripcion'],
            'precio_compra_p' => $row3['precio_compra'],
            'precio_final_p' => $row3['precio_final'],
            'ganancia_p' => $row3['ganancia'],
            'cantidad_existencia_p' => $row3['cantidad_existencia'],
        ),
        );
    }

    if ($i>1){
        array_push($productos_a, 
        array(
            'nombre_p' => $row3['producto'],
            'descripcion_p' => $row3['descripcion'],
            'precio_compra_p' => $row3['precio_compra'],
            'precio_final_p' => $row3['precio_final'],
            'ganancia_p' => $row3['ganancia'],
            'cantidad_existencia_p' => $row3['cantidad_existencia'],
        
        )
        );
    }
}

function array_sort($array, $on, $order=SORT_ASC){
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Reporte-Productos</title>
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
    <div class="container px-4">
        <div class="text-start mt-3">
            <img src="imagenes/fondoperuzon.png" width="200" alt="logo">
            <h4 class="text-center fw-bold">Reporte de Productos</h4>
            <h6 class="text-center">Fecha: <?php echo date("d-m-Y"); ?></h6>
            <h6 class="text-center">Hora: <?php echo date("h:i:s"); ?></h6>
            <h5>Monedad: <b> <?php echo $_SESSION['moneda_base']; ?></b> </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class='table-header' width='5%' style="vertical-align:middle">Nro.</th>
                        <th class='table-header' width='30%' style="vertical-align:middle">Producto</th>
                        <th class='table-header' width='35%' style="vertical-align:middle">Descripción</th>
                        <th class='table-header' width='7%'>Precio Compra</th>
                        <th class='table-header' width='7%'>Precio Final</th>
                        <th class='table-header' width='7%' style="vertical-align:middle">Ganacia</th>
                        <th class='table-header' width='10%' style="vertical-align:middle">Existencia</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $new_array_2 = array();
                    $new_array_2 = array_sort($productos_a, 'nombre_p', SORT_ASC);

                    $total_ganacia=0;
                    $nro_pp=0;
                    $pp3=0;
                    $pp4=0;
                    $pp5=0;
                    $pp6=0;
                    foreach($new_array_2 as $id=>$a){
                        $p="";
                        foreach($a as $b=>$c){
                            $p.="|||".$c;

                        }
                        $nro_pp=$nro_pp+1;
                        $pp = explode("|||", $p);

                        // Total precio compra
                        $pp3=$pp3+$pp[3];
                        // Total precio final
                        $pp4=$pp4+$pp[4];
                        // Total ganancia
                        $pp5=$pp5+$pp[5];
                        // Total cantidad
                        $pp6=$pp6+$pp[6];   
                    ?>

                    <tr>
                        <td><?php echo $nro_pp;; ?></td>
                        <td><?php echo utf8_decode($pp[1]); ?></td>
                        <td><?php echo utf8_decode($pp[2]); ?></td>
                        <td><div class="monto"><?php echo number_format($pp[3],2,',','.') ?></div></td>
                        <td><div class="monto"><?php echo number_format($pp[4],2,',','.') ?></div></td>
                        <td><div class="monto"><?php echo number_format($pp[5],2,',','.') ?></div></td>
                        <td><div class="cantidad"><?php echo $pp[6] ?></div></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="productodato">
            <?php
                // echo "<b>Total Ganancia: </b>".number_format($total_ganacia,2,',','.');
            ?>
            </div> 
        </div>

        <div class="text-center">
            <a id="menu" href="panel.php">Menu</a>
            <a id="volver" href="reportes.php">Volver</a>
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
</body>
</html>