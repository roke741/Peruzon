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

if(isset($_GET['fecha_inicial'])) {
    $fecha_inicial=$_GET['fecha_inicial'];
    $fecha_final=$_GET['fecha_final'];
}

/*
$valores_fecha_inicial[2], año
$valores_fecha_inicial[1], mes
$valores_fecha_inicial[0], dia
*/

$valores_fecha_inicial = explode('-', $fecha_inicial);
$fecha_inicial_b=$valores_fecha_inicial[2]."/".$valores_fecha_inicial[1]."/".$valores_fecha_inicial[0];

$valores_fecha_final = explode('-', $fecha_final);
$fecha_final_b=$valores_fecha_final[2]."/".$valores_fecha_final[1]."/".$valores_fecha_final[0];

// Factura clientes fechas
$sql2="SELECT id_factura_proveedor, fecha_factura_proveedor, descuento ";
$sql2.="FROM tab_proveedores_facturas WHERE (fecha_factura_proveedor BETWEEN '$fecha_inicial_b' AND '$fecha_final_b') AND (anulado = 'no')";

$query2 = $mysqli->query($sql2);

if($query2->num_rows==0){
    $_SESSION['contenido_mensaje_repor']='No hay facturas con esa fecha';
    $_SESSION['reporte_mensaje']='si';  
    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>"; 
    exit();
}

// Totaliza los renglones de la factura segun la cantidad del producto
$ii=0;
$sql3="SELECT id_producto, SUM(cantidad) AS cantidad_total, precio_unitario_desc, descuento, precio_costo FROM tab_proveedores_facturas_reng ";
while ($row2=$query2->fetch_assoc()) {
    $ii=$ii+1;
    $id_factura_proveedor3=$row2['id_factura_proveedor']; 
    if($ii==1){
        $sql3.="WHERE (id_factura_proveedor = $id_factura_proveedor3) ";
    }
    if($ii>1){

        $sql3.="OR (id_factura_proveedor = $id_factura_proveedor3) ";
  }
}

$sql3.="GROUP BY id_producto";

$query3 = $mysqli->query($sql3);

if($query3->num_rows==0){
    $_SESSION['contenido_mensaje_repor']='Factura no tiene renglones';
    $_SESSION['reporte_mensaje']='si';  
    echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>"; 
    exit();
}

// Lista los totales de las cantidades del producto
$i=0;
while ($row3=$query3->fetch_assoc()) {
    //echo $row3['id_producto'];
    //echo "---";
    //echo $row3['total'];
    //echo "---";
    $i=$i+1;
    $id_producto_4=$row3['id_producto'];

    $sql4="SELECT producto, descripcion "; 
    $sql4.="FROM tab_productos WHERE (id_producto = $id_producto_4)";

    $query4 = $mysqli->query($sql4);

    if($query4->num_rows==0){
        $_SESSION['contenido_mensaje_repor']='El producto no se encuentra';
        $_SESSION['reporte_mensaje']='si';  
        echo "<script>location.href = 'reportes_compras.php?fecha_inicial=$fecha_inicial&fecha_final=$fecha_final'</script>"; 
        exit();
    }

    $row4=$query4->fetch_assoc();

    if ($i==1){
        $productos_a = array(

        $i => array(
            
            'nombre_p' => $row4['producto'],
            'descripcion_p' => $row4['descripcion'],
            'cantidad_p' => $row3['cantidad_total'],
            'precio_unitario_desc_p' => $row3['precio_unitario_desc'],
            'monto_pp' => $row3['cantidad_total']*$row3['precio_unitario_desc'],
        ),
        );
    }

    if ($i>1){

        array_push($productos_a, 
        array(

            'nombre_p' => $row4['producto'],
            'descripcion_p' => $row4['descripcion'],
            'cantidad_p' => $row3['cantidad_total'],
            'precio_unitario_desc_p' => $row3['precio_unitario_desc'],
            'monto_pp' => $row3['cantidad_total']*$row3['precio_unitario_desc'],
        )
        );
    }

}

//print_r($productos_a);
//echo "----";
//exit();

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
    <title>Peruzon-Reporte-Compras</title>
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
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js" integrity="sha512-QEAheCz+x/VkKtxeGoDq6nsGyzTx/0LMINTgQjqZ0h3+NjP+bCsPYz3hn0HnBkGmkIFSr7QcEZT+KyEM7lbLPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->    <!--jquery barcode segunda opcion-->
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
            <h6 class="text-center fecha_rep">Fecha Inicial: <?php echo $fecha_inicial; ?></h6>
            <h6 class="text-center fecha_rep">Fecha Final: <?php echo $fecha_final; ?></h6>
            <h5>Monedad: <b> <?php echo $_SESSION['moneda_base']; ?></b> </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class='table-header' width='5%' style="vertical-align:middle">Nro.</th>
                        <th class='table-header' width='30%' style="vertical-align:middle">Producto</th>
                        <th class='table-header' width='40%' style="vertical-align:middle">Descripción</th>
                        <th class='table-header' width='7%' style="vertical-align:middle">Cantidad</th>
                        <th class='table-header' width='7%' style="vertical-align:middle">Prec/Unit</th>
                        <th class='table-header' width='7%' style="vertical-align:middle">Monto</th>                    
                    </tr>
                </thead>
                <tbody>
                <?php
                $new_array_2 = array();
                $new_array_2 = array_sort($productos_a, 'nombre_p', SORT_ASC);

                $total_ganacia=0;
                $nro_pp=0;
                foreach($new_array_2 as $id=>$a){

                    $p="";
                    foreach($a as $b=>$c){
            
                    $p.="|||".$c;
            
                    }

                    $nro_pp=$nro_pp+1;

                    $pp = explode("|||", $p);

                    $total_ganacia=$total_ganacia+$pp[4];
                   
                ?>

                    <tr>
                        <td><?php echo $nro_pp;; ?></td>
                        <td><?php echo $pp[1]; ?></td>
                        <td><?php echo $pp[2]; ?></td>
                        <td><div class="monto2"><?php echo $pp[3] ?></div></td>
                        <td><div class="monto"><?php echo number_format($pp[4],2,',','.') ?></div></td>
                        <td><div class="monto"><?php echo number_format($pp[5],2,',','.') ?></div></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="productodato">
            <?php
                echo "<b>Total: </b>".number_format($total_ganacia,2,',','.');
            ?>
            </div> 
        </div>

        <div class="text-center">
            <a id="menu" href="panel.php">Menu</a>
            <a id="volver" href="reportes_compras.php?fecha_inicial=<?php echo $fecha_inicial; ?>&fecha_final=<?php echo $fecha_final; ?>">Volver</a>
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