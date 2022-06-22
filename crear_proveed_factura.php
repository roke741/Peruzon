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
	header("Location:error1.php");
    exit();
}	

if(!isset($_SESSION['fecha_factura_porveed'])) {
	header("Location:error1.php");
    exit();
}	
/*
Nota:
echo $_SESSION['carrito_proveed'][1]['id_producto'];
exit();*/

if(isset($_GET['existencia_proveed'])) {
	$existencia=$_GET['existencia_proveed'];
	$hayexistencia="si";		
	$producto_e=$_GET['producto'];
}

if (!isset($_SESSION['$moneda_s'])){
    $_SESSION['$moneda_s']="Seleccione";     
}

if (isset($_POST['pass'])){
    $_SESSION['$moneda_s']=$_POST['pass'];
}

// Tabla monedas
$sql2="SELECT moneda FROM tab_monedas ORDER BY id_moneda";
$query2 = $mysqli->query($sql2);
$combobit2="<option value='Seleccione'>Seleccione</option>";
while ($row2=$query2->fetch_assoc()) { 

	if($row2['moneda']==$_SESSION['$moneda_s']){
		$combobit2.=" <option value='".$row2['moneda']."' selected='selected'>".$row2['moneda']."</option>"; 
	}else{
		$combobit2.=" <option value='".$row2['moneda']."'>".$row2['moneda']."</option>"; 
	}
}

if(!isset($_SESSION['factura_proveedor_moneda'])) {
	$_SESSION['factura_proveedor_moneda']='si';
}else{
	$_SESSION['factura_proveedor_moneda']='si';
}

if(!isset($_SESSION['total_productos_proveed'])) {
	$_SESSION['total_productos_proveed']=0;
}	

if(!isset($_SESSION['descuento_proveed'])) {
	$_SESSION['descuento_proveed']=0;
}	

// Eliminar producto 
if(isset($_GET['orden'])) {

	$orden=$_GET['orden'];

	if($_SESSION['total_productos_proveed']==1){

		if(isset($_SESSION['carrito_proveed'][1]['orden'])) {
			$_SESSION['total_productos_proveed']--;	
			unset($_SESSION['carrito_proveed']);
		}
	}

	if($_SESSION['total_productos_proveed']!=1){
		
		if(isset($_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]['orden'])) {

			if($orden==$_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]['orden']){
				$_SESSION['total_productos_proveed']--;	
				unset($_SESSION['carrito_proveed'][$orden]);
			}else{ // if($orden==$_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]['orden'])

				for($i=$orden;$i<=$_SESSION['total_productos_proveed'];$i++){

					if($_SESSION['total_productos_proveed']!=$i){ 

						$_SESSION['carrito_proveed'][$i]['id_producto']	= $_SESSION['carrito_proveed'][$i+1]['id_producto'];
						$_SESSION['carrito_proveed'][$i]['cantidad']	= $_SESSION['carrito_proveed'][$i+1]['cantidad'];
						$_SESSION['carrito_proveed'][$i]['producto']	= $_SESSION['carrito_proveed'][$i+1]['producto'];
						$_SESSION['carrito_proveed'][$i]['descripcion']	= $_SESSION['carrito_proveed'][$i+1]['descripcion'];
						$_SESSION['carrito_proveed'][$i]['precio']	= $_SESSION['carrito_proveed'][$i+1]['precio'];
						$_SESSION['carrito_proveed'][$i]['orden']	= $_SESSION['carrito_proveed'][$i]['orden'];

					}else{ // if($_SESSION['total_productos_proveed']!=$i)
						$_SESSION['total_productos_proveed']--;	
						unset($_SESSION['carrito_proveed'][$i]);
					} // if($_SESSION['total_productos_proveed']!=$i)	
				} // for($i=$orden;$i<=$_SESSION['total_productos_proveed'];$i++)
			} // if($orden==$_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]['orden'])
		} // if(isset($_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]['orden']))
	} // if($_SESSION['total_productos_proveed']!=1)
} // if(isset($_GET['orden']))

$producto_agregado='no';
$producto_mensaje='no';

// agregar producto
if(isset($_GET['id_producto'])) {
	// id del producto
	$id_producto=$_GET['id_producto'];
	$producto=$_GET['producto'];
	$descripcion=$_GET['descripcion'];
	$precio_final=$_GET['precio_final'];
	//echo $producto;
	//exit();	
	if ($hayexistencia=="si"){
		if(isset($_SESSION['carrito_proveed'])) {
			for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++){
				if($_SESSION['carrito_proveed'][$i]['id_producto']==$id_producto) {
					$ii=$i;
					// echo "<script>alert('Producto ya agregado en reglon nro.:".$i."')</script>";
					$producto_agregado='si';
					$producto_mensaje='si';
				}		
			} // for($i=1;$i<=$_SESSION['total_productos_proveed'];$i++)
		} // if(isset($_SESSION['carrito_proveed']))
	}

	if($producto_agregado=='no' && $hayexistencia=="si"){

		$_SESSION['total_productos_proveed']++;	
		$_SESSION['carrito_proveed'][$_SESSION['total_productos_proveed']]=array(
			"id_producto" => $id_producto,
			"cantidad" => "",
			"producto" => $producto,
			"descripcion" => $descripcion,
			"precio" => $precio_final,
			"orden"  => $_SESSION['total_productos_proveed']
		);	
	} // if($producto_agregado=='no')	
} // isset($_GET['id_producto'])

// Boton guardar
if(isset($_POST['submit2'])){

	$_SESSION['guardar']="si";

	$k8['entro'][0]=0;
	$kk8=0;
	foreach($_POST['cantidad'] as $key => $val) {

		$kk8=$kk8+1;
		$k8['entro'][$kk8]=0;

		if ($val==0){
			$val="";			
		}

		if ($val<0){
			$val="";			
		}

		if (is_numeric($val)){	
		
    		$_SESSION['cantidad3'][$key]=$val;
			if($val!=$_SESSION['carrito_proveed'][$key]['cantidad']){
				$_SESSION['carrito_proveed'][$key]['cantidad']="";
				$_SESSION['nro_reglon3']=$key;
				$k8['entro'][$kk8]=1;
			}
		}else{
			$_SESSION['carrito_proveed'][$key]['cantidad']="";
			$_SESSION['nro_reglon3']=$key;
			$k8['entro'][$kk8]=1;
		}
	}

	$entro=0;
	foreach($k8['entro'] as $kkey => $vval) {

		if($vval==1){
			if($entro==0){
				$entro=$vval;
				$indicee=$kkey;
			}
		}
	}

	if($entro!=0){
		$_SESSION['reglon_actualizado']="no";
		$_SESSION['mensaje_no_actualizado']="El reglon nro. $indicee no se actualizó la Cantidad";
	}

	if ($_POST['descuento']!=$_SESSION['descuento_proveed']){
		$_SESSION['descuento']=0;
		$_SESSION['reglon_actualizado']="no";
		$_SESSION['mensaje_no_actualizado']="No se actualizó el porcentaje de Descuento";
	}
	// echo $_SESSION['cantidad3'][2];
}

// Lo direcciona el boton guardar al presinar si
if(isset($_GET['guardar2'])){
	echo "<script>location.href = 'crear_proveed_factura_validar.php'</script>";
}

// Boton totalizar productos
if(isset($_POST['submit'])){

	foreach($_POST['cantidad'] as $key => $val) {
		if ($val==0){
			$val="";			
		}
		if ($val<0){
			$val="";			
		}

		if (is_numeric($val)){

			$val=intval($val);

			$id_producto_b=$_SESSION['carrito_proveed'][$key]['id_producto'];

			// Buscar id_producto
			$sql3="SELECT id_producto, cantidad_existencia FROM tab_productos WHERE (id_producto = ".$id_producto_b.")";
			$query3=$mysqli->query($sql3);
			$row3=$query3->fetch_assoc();

			if($query3->num_rows!=0){
    			$existencia_b=$row3["cantidad_existencia"];
			}
			$_SESSION['carrito_proveed'][$key]['cantidad']=$val;
		}else{ // if (is_numeric($val))
			$_SESSION['carrito'][$key]['cantidad']="";	
		} // if (is_numeric($val))
	} // foreach($_POST['cantidad'] as $key => $val)	
	if (is_numeric($_POST['descuento'])){
		$_SESSION['descuento_proveed']=$_POST['descuento'];
	}else{
		$_POST['descuento']=0;
	}
} // isset($_POST['submit'])

// Boton vista moneda
if(isset($_POST['submit3'])){

	$k8['entro'][0]=0;
	$kk8=0;
	foreach($_POST['cantidad'] as $key => $val) {
		$kk8=$kk8+1;

		if ($val==0){
			$val="";
		}
		if ($val<0){
			$val="";			
		}
		if (is_numeric($val)){	
    		//$_SESSION['orden3'][$key]=$key;		
			$_SESSION['cantidad3'][$key]=$val;

			if($val!=$_SESSION['carrito_proveed'][$key]['cantidad']){

				$_SESSION['reglon_actualizado']="no";
				$_SESSION['carrito_proveed'][$key]['cantidad']="";
				$_SESSION['nro_reglon3']=$key;

				$_SESSION['mensaje_no_actualizado']="El reglon nro. $key no se actualizó la cantidad";
				$_SESSION['mensaje_vista_moneda']="no";
				$_SESSION['guardar']="si";
				$k8['entro'][$kk8]=1;
			}else{
				$k8['entro'][$kk8]=0;
			}
		}else{
			$_SESSION['reglon_actualizado']="no";
			$_SESSION['carrito_proveed'][$key]['cantidad']="";
			$_SESSION['nro_reglon3']=$key;

			$_SESSION['mensaje_no_actualizado']="El reglon nro. $key no se actualizó la Cantidad";
			$_SESSION['mensaje_vista_moneda']="no";
			$_SESSION['guardar']="si";
			$k8['entro'][$kk8]=1;
		}
	}
	$entro=0;
	foreach($k8['entro'] as $kkey => $vval) {
		if($vval==1){
			$entro=$vval;
		}
	}

	if($entro==0){
		$_SESSION['mensaje_vista_moneda']="si";
	}else{
		$_SESSION['mensaje_vista_moneda']="no";
	}
	if ($_POST['descuento']!=$_SESSION['descuento_proveed']){
		$_SESSION['descuento']=0;

		$_SESSION['reglon_actualizado']="no";
		$_SESSION['mensaje_no_actualizado']="No se actualizó el porcentaje de Descuento";
		$_SESSION['mensaje_vista_moneda']="no";
		$_SESSION['guardar']="si";
	}

	if($_SESSION['mensaje_vista_moneda']=="si"){
		if($_POST['pass']=="Seleccione"){
			$_SESSION['selecciono_moneda']="no";
			$_SESSION['cont_mensaje_vista_moneda']="No seleccionó la moneda.";
		}else{
			$_SESSION['selecciono_moneda']="si";
			$_SESSION['moneda']=$_POST['pass'];
		}	
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Crear Facturas-Proveedor</title>
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
                            <a class="nav-link " href="buscar_facturas.php?id_cliente=<?php echo $_SESSION['id_cliente'] ?>"><i class="bi bi-cart4"></i> VOLVER</a>
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
                    <form name='formulario_renglones' action="crear_proveed_factura.php" method='post'>

                        <div class="row justify-content-start mb-1">
                            <div class="col-6 d-flex">
                                <p class="btn-agregar px-2"><a href="buscar_productos_proveed.php">Agregar Productos</a></p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-danger table-bordered  table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th class='table-header' width='5%'>Nro.</th>
                                        <th class='table-header' width='27%'>Producto</th>
                                        <th class='table-header' width='32%'>Descripción</th>
                                        <th class='table-header' width='10%'>Cantidad</th>
                                        <th class='table-header' width='10%'>Prec/Unit</th>
                                        <th class='table-header' width='10%'>Prec/Total</th>
                                        <th class='table-header' width='6%'>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody id='table-body' style="white-space: nowrap;">
                                    <?php
                                    $totalprice=0;
                                    $nro_reng2=0;
                                    $cantidad2=0;

                                    for($i=0;$i<$_SESSION['total_productos_proveed'];$i++){

                                        $nro_reng2++;
                                        $nro_reglon=$nro_reng2;
                                        
                                        $subtotal=$_SESSION['carrito_proveed'][$nro_reglon]['cantidad']*$_SESSION['carrito_proveed'][$nro_reglon]['precio'];
                                        $totalprice+=$subtotal;

                                        $cantidad2+=$_SESSION['carrito_proveed'][$nro_reglon]['cantidad'];
                                    ?>
                                    <tr>
                                        <td><?php echo $_SESSION['carrito_proveed'][$nro_reglon]['orden'] ?></td>
                                        <td><?php echo $_SESSION['carrito_proveed'][$nro_reglon]['producto'] ?></td>
                                        <td><?php echo $_SESSION['carrito_proveed'][$nro_reglon]['descripcion'] ?></td>
                                        <td align="center"><input class="form-control" id="cantidad" type="text" name="cantidad[<?php echo $nro_reglon ?>]" size="6" maxlength="6" value="<?php echo $_SESSION['carrito_proveed'][$nro_reglon]['cantidad'] ?>" /></td>
                                        <td><div class="monto"><?php echo number_format($_SESSION['carrito_proveed'][$nro_reglon]['precio'],2,',','.') ?></div></td>
                                        <td><div class="monto"><?php echo number_format($_SESSION['carrito_proveed'][$nro_reglon]['cantidad']*$_SESSION['carrito_proveed'][$nro_reglon]['precio'],2,',','.'); ?></div></td>
                                        <td><a href="#" onclick="Validar3(<?php echo $_SESSION['carrito_proveed'][$nro_reglon]['orden']?>)">Eliminar</a></td>
                                    </tr>
                                    <?php
                                        } // for($i=0;$i<$_SESSION['total_productos_proveed'];$i++)

                                        $_SESSION['totalprice_proveed']=$totalprice;
                                        $_SESSION['total_desc_proveed']=$totalprice-$totalprice*$_SESSION['descuento_proveed']/100;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="total_factura">
                            <table align="right">

                            <tr>	
                            <td>
                                <div align="right">
                                <b>Sub-Total: </b>
                                </div>
                            </td>	
                            <td>
                                <div align="right">
                                <?php echo number_format($totalprice,2,',','.'); ?>
                                </div>
                            </td>
                            </tr>	

                            <tr>	
                            <td>	
                                <label for="descuento">Descuento(%): </label>
                            </td>	
                            <td>
                                <input class="form-control" id="descuento" type="text" name="descuento" size="6" maxlength="6" value="<?php echo number_format($_SESSION['descuento_proveed'],2,'.','.') ?>" />
                            </td>
                            </tr>

                            <tr>	
                            <td>
                                <div align="right">
                                <button class="btn btn-xs btn-success" type="submit" name="submit" style="font-family: Arial; font-size: 12pt;"><b>Total:</b></button>
                                </div>
                            </td>	
                            <td>
                                <div align="right">
                                <?php echo number_format($_SESSION['total_desc_proveed'],2,',','.'); ?>
                                </div>
                            </td>
                            </tr>

                            </table>

                            <br/><br/><br/><br/>
                            <div align="right">
                            <b>Nro. de Productos: </b> <?php echo number_format($cantidad2,0,',','.'); ?>
                            </div>

                        </div>

                        <button class="btn btn-xs btn-success" type="submit" name="submit2" style="font-family: Arial; font-size: 12pt;"><b>Guardar</b></button>
                        <br/>
                        <br/>

                        <span class="encab">Ver factura en otra moneda: </span></b><select name="pass" id="pass"><?php echo $combobit2;?></select>
                        <button class="btn btn-xs btn-success" type="submit" name="submit3" style="font-family: Arial; font-size: 12pt;"><b>Vista</b></button></p>

                    </form>
                    <a href="moneda_editar.php"><span class="encab">Valor del dólar en otra moneda</span></a>
                    <br/>
                    <?php 
                    } // if(isset($_SESSION['carrito_proveed']))
                    ?>
                    <div id="resultado"></div>
                    <br/>
                    <p>
                        <label for="nro_factura_porveed">Nro. Factura Proveedor: </label>
                        <label for="nro_factura_porveed"><?php echo $_SESSION['nro_factura_porveed'] ?></label>
                        <br/>
                        <label for="fecha_factura_porveed">Fecha Factura Proveedor: </label>
                        <label for="fecha_factura_porveed"><?php echo $_SESSION['fecha_factura_porveed'] ?></label>
                    </p>
                    <br/>

                </div>

            </div>


        </div>
    </div>
    <script>
    // Boton Moneda
    function Validar2(user, pass){
    // No seleccionó la moneda
    var pass3=pass; 
        if (pass3=="Seleccione") {
        $.alert({
            title: 'Mensaje',
            content: '<span style=color:red>No seleccionó la moneda.</span>',
            animation: 'scale',
            closeAnimation: 'scale',
            buttons: {
                okay: {
                    text: 'Cerrar',
                    btnClass: 'btn-danger'
                    }
                }
            });
        } else {
            $.ajax({
                url: "crear_proveed_factura_validar_2.php",
                type: "POST",
                data: "user="+user+"&pass="+pass,
                beforeSend: function () {
                    $("#resultado").html("<img src='imagen/loader-small.gif'/><font color='green'>&nbsp&nbspProcesando, por favor espere...</font>");
                },
                success: function(resp){
                    $('#resultado').html(resp)
                }        
            });
        }
    }

    function Validar3(pass){
    // Nro. de reglon
    var pass2=pass; 
    // confirmation
    $.confirm({
    title: 'Mensaje',
    content: '¿Confirma en eliminar el reglon nro.'+pass2+'?',
    animation: 'scale',
    closeAnimation: 'zoom',
    buttons: {
        confirm: {
            text: 'Si',
            btnClass: 'btn-danger',
            action: function(){
                window.location.href="crear_proveed_factura.php?orden="+pass2;				     

            } // action: function(){
        }, // confirm: {
        cancelar: function(){    
        } // cancelar: function()
        } // buttons
    }); // $.confirm
    }
    </script>
    <?php 
    if ( $producto_mensaje == "si" ) {
        $producto_mensaje='no';
        echo "<script>
            $.alert({
                title: 'Mensaje',
                content: '<span style=color:red>Producto ya agregado en reglon nro.:$ii.</span>',
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

    if ( isset($_SESSION['cantidad_nulo']) && $_SESSION['cantidad_nulo'] == "si" ) {
        $nro_reglon_nulo=$_SESSION['nro_reglon_nulo'];
        unset($_SESSION['cantidad_nulo']);
        unset($_SESSION['nro_reglon_nulo']);
        echo "<script>
            $.alert({
                title: 'Mensaje',
                content: '<span style=color:red>Debes introducir la cantidad <br/> en el reglon nro.: $nro_reglon_nulo.</span>',
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

    // Boton Guardar
    if (isset($_SESSION['guardar']) && $_SESSION['guardar']=="si") {
        unset($_SESSION['guardar']);
        if (isset($_SESSION['reglon_actualizado']) && $_SESSION['reglon_actualizado']="no") {
        unset($_SESSION['reglon_actualizado']);
        $nro_reglon3=$_SESSION['nro_reglon3'];
        $mensaje_no_actualizado=$_SESSION['mensaje_no_actualizado'];
        echo "<script>
            $.alert({
                title: 'Mensaje',
                content: '<span style=color:red>$mensaje_no_actualizado</span>',
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
        }else{
            // confirmation para guardar
            echo "<script> 
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
                            location.href = 'crear_proveed_factura.php?guardar2=1';
                        } // action: function(){
                }, // confirm: {
                    cancelar: function(){
                        } // cancelar: function()
                    } // buttons
                }); // $.confirm
            </script>";
        }
    }

    // Boton vista moneda
    if (isset($_SESSION['mensaje_vista_moneda']) && $_SESSION['mensaje_vista_moneda']=="si") {
        unset($_SESSION['mensaje_vista_moneda']);
        if (isset($_SESSION['selecciono_moneda']) && $_SESSION['selecciono_moneda']=="no") {
        unset($_SESSION['selecciono_moneda']);
        $cont_mensaje_vista_moneda=$_SESSION['cont_mensaje_vista_moneda'];
        echo "<script>
            $.alert({
                title: 'Mensaje',
                content: '<span style=color:red>$cont_mensaje_vista_moneda</span>',
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
        }else{
            $moneda5=$_SESSION['moneda'];
            // confirmation para guardar
            echo "<script> 
                $.confirm({
                    title: 'Mensaje',
                    content: '¿Confirma en ver moneda en $moneda5?',
                    animation: 'scale',
                    closeAnimation: 'zoom',
                    buttons: {
                        confirm: {
                        text: 'Si',
                        btnClass: 'btn-orange',
                        action: function(){
                            location.href = 'crear_proveed_factura_validar_2.php?pass=$moneda5';
                        } // action: function(){
                }, // confirm: {
                    cancelar: function(){
                        } // cancelar: function()
                    } // buttons
                }); // $.confirm
            </script>";
        }
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