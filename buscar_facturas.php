<?php
session_start();
define("NRO_REGISTROS",10);
require_once('conexion/conexion.php');

// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
    header("Location:error1.php");
    exit();  
}

if(isset($_GET['id_cliente'])){

	$id_cliente=$_GET['id_cliente'];

	$sql2='SELECT id_cliente, nombres, apellidos, dni, telefono FROM tab_clientes WHERE (id_cliente = '.$id_cliente.')';
    
	$query2 = $pdo_conn -> prepare($sql2); 
	$query2 -> execute(); 
	$results = $query2 -> fetchAll(PDO::FETCH_OBJ); 

	if($query2 -> rowCount() > 0) { 
        foreach($results as $result) { 
        
            $cliente = $result -> nombres." ".$result -> apellidos;
            $_SESSION['cliente'] = $cliente;
            $_SESSION['dni'] = $result -> dni;
            $_SESSION['id_cliente'] = $id_cliente;
            $_SESSION['telefono'] = $result -> telefono;
        } // foreach($results as $result)
    } // if($query2 -> rowCount() > 0)	
} // if(isset($_GET['id_cliente']))	

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Facturas-Listas</title>
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
                <h2 class="fw-bold fst-italic text-center text-light pt-3">CLIENTE - LISTA DE FACTURAS</h2>
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
                <p class="usuario fw-bold ps-3 ">
                    <span class="text-warning">
                        CLIENTE: <?php echo $_SESSION['cliente']; ?>
                        <br/>
                        DNI: <?php echo $_SESSION['dni']; ?>
                        <br/>
                        TELÉFONO: <?php echo $_SESSION['telefono']; ?>
                        <br/>
                        MONEDA: <?php echo $_SESSION['moneda_base']; ?>
                    </span>
                </p>
                <?php
                function verfecha($vfecha){
                    $fch=explode("-",$vfecha);
                    $tfecha=$fch[2]."-".$fch[1]."-".$fch[0];
                    return $tfecha;
                }
                $search_keyword = '';
                if(!empty($_POST['search']['keyword'])) {
                    $search_keyword = $_POST['search']['keyword'];
                }
                $sql = 'SELECT * FROM tab_facturas WHERE (nro_factura LIKE :keyword OR fecha_reg LIKE :keyword OR total LIKE :keyword OR descuento LIKE :keyword OR total_desc LIKE :keyword) AND (id_cliente = '.$_SESSION['id_cliente'].') ORDER BY fecha_reg DESC, id_factura DESC';
                /* Pagination Code starts */
                $per_page_html = '';
                $page = 1;
                $start=0;
                if(!empty($_POST["page"])) {
                    $page = $_POST["page"];
                    $start=($page-1) * NRO_REGISTROS;
                }
                $limit=" limit " . $start . "," . NRO_REGISTROS;
                $pagination_statement = $pdo_conn->prepare($sql);
                $pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
                $pagination_statement->execute();

                $row_count = $pagination_statement->rowCount();
                if(!empty($row_count)){
                    $per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
                    $page_count=ceil($row_count/NRO_REGISTROS);
                    if($page_count>1) {
                        for($i=1;$i<=$page_count;$i++){
                            if($i==$page){
                                $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
                            } else {
                                $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
                            }
                        }
                    }
                    $per_page_html .= "</div>";
                }
                    
                $query = $sql.$limit;
                $pdo_statement = $pdo_conn->prepare($query);
                $pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
                $pdo_statement->execute();
                $resultados = $pdo_statement->fetchAll();
                ?>

                <div class="container px-1">
                    <form name='frmSearch' action='' method='post'>
                        <!--<input type='text' name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>-->
                        <div class="row justify-content-end mb-1">
                            <div class="col-7">
                                <div class="input-group mb-3">
                                    <input type="text" name="search[keyword]" class="form-control" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="Buscar" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='50'>
                                    <button class="btn btn-outline-light bg-danger" type="submit" name="submit" value="Buscar" id="buscar"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-start mb-1">
                            <div class="col-6 d-flex">
                                <p class="btn-agregar px-2"><a href="crear_factura.php">Crear Factura</a></p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-danger table-bordered  table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th class='table-header' width='12%'>N° Factura</th>
                                        <th class='table-header' width='10%'>Fecha</th>
                                        <th class='table-header' width='16%'>Total</th>
                                        <th class='table-header' width='16%'>Desc.(%)</th>
                                        <th class='table-header' width='16%'>Total con desc.</th>
                                        <th class='table-header' width='10%'>Anulado</th>
                                        <th class='table-header' width='20%'>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody id='table-body' style="white-space: nowrap;">
                                    <?php
                                    if(!empty($resultados)) {
                                        foreach($resultados as $row) {
                                            /*$valores[0], año
                                            $valores[1], mes
                                            $valores[2], dia*/
                                            $valores_fecha_reg = explode('-', $row['fecha_reg']);
                                            $fecha_reg=$valores_fecha_reg[2]."-".$valores_fecha_reg[1]."-".$valores_fecha_reg[0];
                                    ?>
                                    <tr>
                                        <td><?php echo $row['nro_factura']; ?></td>
                                        <td><?php echo $fecha_reg; ?></td>
                                        <td><?php echo number_format($row['total'],2,',','.'); ?></td>
                                        <td><?php echo number_format($row['descuento'],2,',','.'); ?></td>
                                        <td><?php echo number_format($row['total_desc'],2,',','.'); ?></td>
                                        <td><?php echo $row['anulado'];?></td>
                                        <td>
                                            <a href="factura_reporte.php?id_factura=<?php echo $row['id_factura'] ?>&nro_factura=<?php echo $row['nro_factura'] ?>&fecha_reg=<?php echo $fecha_reg ?>&total=<?php echo $row['total'] ?>&descuento=<?php echo $row['descuento'] ?>&total_desc=<?php echo $row['total_desc'] ?>" class="btn btn-danger p-1"><i class="bi bi-eye"></i> Vista</a>
                                            <?php
                                            if($row['anulado']=='no'){
                                                $id_factura_anular=$row['id_factura'];
                                                $nro_factura=$row['nro_factura'];
                                                $id_cliente_a=$_SESSION['id_cliente'];
                                                echo "<a href='#' onclick='Validar4($id_factura_anular, $nro_factura, $id_cliente_a)'>Anular</a>";
                                            }else{
                                                echo "";
                                            }
                                            ?>   
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?> 
                                </tbody>
                            </table>
                        </div>
                        <?php echo $per_page_html; ?>
                    </form>
                </div>
            
            </div>

        </div>
    
    </div>
    <script>
    // Anular factura
    function Validar4(id_factura, nro_factura, id_cliente){
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en anular <br/> la factura nro. '+nro_factura+'?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
            action: function(){
            window.location.href="anular_factura_validar.php?id_factura="+id_factura+"&id_cliente="+id_cliente;
            } // action: function(){
        }, // confirm: {
        cancelar: function(){   
        } // cancelar: function()
    } // buttons
    }); // $.confirm
    }
    </script>
    <?php 
    if ( isset($_SESSION['factura_guardada']) && $_SESSION['factura_guardada'] == "si" ) {

        unset($_SESSION['factura_guardada']);
        unset($_SESSION['descuento']);

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

    <?php 
    if ( isset($_SESSION['factura_anulada']) && $_SESSION['factura_anulada'] == "si" ) {

        unset($_SESSION['factura_anulada']);
        echo "<script>
        $.confirm({
        title: 'Mensaje',
        content: '<span style=color:green>Factura anulado con éxito.</span>',
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