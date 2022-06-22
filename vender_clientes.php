<!--buscar_clientes=vender_clientes-->
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Vender-C.Lista</title>

    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style - ventas -->
    <link rel="stylesheet" href="css/stylepanel.css">
    <link rel="stylesheet" href="css/stylevender.css">
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
                        <a href="#" class="bt-menu"><span class="icon-menu"><i class="bi bi-list"></i></span>PERUZON-MENU</a>
                    </div>

                    <nav class="nav-menu py-4">
                        <ul class="nav flex-column text-center fw-bold text-light" >
                            <li>
                                <h2 class="title fw-bold fst-italic pb-2">PERUZON</h2>
                            </li>
                            <br>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="" aria-current="page"><i class="bi bi-cart4"></i> VENTAS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <div class="col-9 panel">
                    <h2 class="fw-bold fst-italic text-center text-light pt-3">VENTAS - CLIENTES LISTA</h2>
                    <p class="usuario fw-bold ps-3">
                        <span class="text-light">
                        <br/>			
                        Fecha del Sistema: <?php echo $_SESSION['fecha']; ?>
                        <br/>			
                        Hora del Sistema: <?php echo $_SESSION['hora_actual']; ?>
                        <br/>
                        Usuario: <?php echo $_SESSION['usuario']; ?>
                        </span>
                    <p>
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
                            $sql = 'SELECT * FROM tab_clientes WHERE nombres LIKE :keyword OR apellidos LIKE :keyword OR dni LIKE :keyword ORDER BY id_cliente DESC';
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
                        <form action="" name="frmSearch" method="post">
<!--<input type='text' name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>-->
                            <div class="row justify-content-end mb-1">
                                <div class="col-7">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search[keyword]" class="form-control" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="Buscar" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='30'>
                                        <button class="btn btn-outline-light bg-danger" type="submit" name="submit" value="Buscar" id="buscar"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-start mb-1">
                                <div class="col-6 d-flex">
                                    <p class="btn-agregar px-2"><a href="clientes_crear.php">Agregar Cliente</a></p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-danger table-bordered  table-hover">
                                    <thead class="table-dark">
                                    <tr>
                                        <th class="table-header" width="5%">N°</th>
                                        <th class="table-header" width="25%">Nombres</th>
                                        <th class="table-header" width="25%">Apellidos</th>
                                        <th class="table-header" width="15%">DNI</th>
                                        <th class="table-header" width="30%">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id='table-body' style="white-space: nowrap;">
                                        <?php
                                        if(!empty($resultados)) {
                                            foreach($resultados as $row) {
                                        ?>
                                        <tr class="table-row">
                                            <td><?php echo $row['id_cliente']; ?></td>
                                            <td><?php echo $row['nombres']; ?></td>
                                            <td><?php echo $row['apellidos']; ?></td>
                                            <td><?php echo $row['dni']; ?></td>
                                            <td>
                                                <a href="clientes_reporte.php?id_cliente=<?php echo $row['id_cliente']?>" class="btn btn-danger p-1"><i class="bi bi-eye"></i> Vista</a> 
                                                <a href="#" onclick="Validar3(<?php echo $row['id_cliente'] ?>, '<?php echo $row['nombres'] ?>')" class="btn btn-danger p-1"><i class="bi bi-pencil"></i> Editar</a> 
                                                <a href="#" onclick="Validar4(<?php echo $row['id_cliente'] ?>, '<?php echo $row['nombres'] ?>')" class="btn btn-danger p-1"><i class="bi bi-x-octagon"></i> Eliminar</a> 
                                                <a href="buscar_facturas.php?id_cliente=<?php echo $row['id_cliente'] ?>" class="btn btn-danger p-1"><i class="bi bi-file-earmark-text"></i> Facturas</a>
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
                    <p class="text-center fs-5 fw-bold fst-italic text-light" style="text-shadow: 3px 1px black">Desarrollado x Roke</p>
                </div>
            </div>
            <script>
            // Editar cliente
            function Validar3(id_cliente, nombres){
                $.confirm({
                title: 'Mensaje',
                content: '¿Confirma en editar <br/> el cliente '+nombres+'?',
                animation: 'scale',
                closeAnimation: 'zoom',
                buttons: {
                    confirm: {
                        text: 'Si',
                        btnClass: 'btn-danger',
                        action: function(){
                        window.location.href="clientes_editar.php?id_cliente="+id_cliente;              
                        } // action: function(){
                    }, // confirm: {
                    cancelar: function(){ 
                    } // cancelar: function()
                } // buttons
                }); // $.confirm
            }

            // Eliminar cliente
            function Validar4(id_cliente, nombres){
                $.confirm({
                title: 'Mensaje',
                content: '¿Confirma en eliminar <br/> el cliente '+nombres+'?',
                animation: 'scale',
                closeAnimation: 'zoom',
                buttons: {
                    confirm: {
                        text: 'Si',
                        btnClass: 'btn-danger',
                        action: function(){
                        window.location.href="clientes_eliminar_validar.php?id_cliente="+id_cliente;           
                        } // action: function(){
                    }, // confirm: {
                    cancelar: function(){      
                    } // cancelar: function()
                } // buttons
                }); // $.confirm
            }
            </script>
            <?php 
            // Cliente guardado
            if ( isset($_SESSION['cliente_guardado']) && $_SESSION['cliente_guardado'] == "si" ) {
                unset($_SESSION['cliente_guardado']);
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

            if ( isset($_SESSION['cliente_eliminado']) && $_SESSION['cliente_eliminado'] == "si" ) {
                unset($_SESSION['cliente_eliminado']);
                echo "<script>
                $.confirm({
                    title: 'Mensaje',
                    content: '<span style=color:green>Cliente eliminado con éxito.</span>',
                    autoClose: 'Cerrar|3000',
                    buttons: {
                        Cerrar: function () {
                        }
                    }
                });</script>";
            }

            if ( isset($_SESSION['cliente_tiene_factura']) && $_SESSION['cliente_tiene_factura'] == "si" ) {
                unset($_SESSION['cliente_tiene_factura']);
                echo "<script>
                $.confirm({
                    title: 'Mensaje',
                    content: '<span style=color:red>No se puede eliminar el cliente <br/>porque tiene facturas.</span>',
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

            <!-- <script>
            function Validar3(){
            // confirmation
            $.confirm({
            title: 'Mensaje',
            content: '¿Confirma en cerrar Sesion?',
            animation: 'scale',
            closeAnimation: 'zoom',
            buttons: {
                confirm: {
                    text: 'Si',
                    btnClass: 'btn-danger',
                    action: function(){
                        window.location.href="cerrando.php";				     
                    } // action: function(){
                }, // confirm: {
                cancelar: function(){
                } // cancelar: function()
                } // buttons
            }); // $.confirm
            }
            </script> -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    

</body>
</html>