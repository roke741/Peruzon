<?php
require("conexion/connection.php");
session_start();

if(!isset($_SESSION['usuario_2'])) {
	$_SESSION['usuario_2']="";
	$_SESSION['clave_2']="";
}
$sql = "SELECT current_date";
$row = $mysqli->query($sql);
$consultaf = $row->fetch_assoc();

$fechadelmysql = date_create($consultaf['current_date']);
$fechadelmysql = date_format($fechadelmysql, 'd-m-Y');
$fecha_pc = $fechadelmysql;

$valores_fecha_act = explode('-', $fecha_pc);
$fecha_act=$valores_fecha_act[2]."-".$valores_fecha_act[1]."-".$valores_fecha_act[0];

$fecha_act_g=$valores_fecha_act[2]."/".$valores_fecha_act[1]."/".$valores_fecha_act[0];

// Fecha invertida
$valores_fecha_act_i= explode('-', $fecha_act);
$fecha_act_i=$valores_fecha_act_i[2]."-".$valores_fecha_act_i[1]."-".$valores_fecha_act_i[0];

/*comparar fecha*/
$sql="SELECT * FROM tab_fecha_pc";
$query = $mysqli->query($sql);
$row=$query->fetch_assoc();

$fecha_pc_last=$row["fecha_pc"];

$valores_fecha_pc_last = explode('-', $fecha_pc_last);
$fecha_pc_last=$valores_fecha_pc_last[2]."-".$valores_fecha_pc_last[1]."-".$valores_fecha_pc_last[0];

$primera = $fecha_act_i;
$segunda = $fecha_pc_last;

$diferencia_dias=compararFechas ($primera,$segunda);

if($diferencia_dias<0){

    echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Fecha del PC incorrecta</p>";
    exit();

}else{

    // Guarda datos en tab_fecha_pc
    // $sql3="UPDATE tab_fecha_pc SET fecha_pc='$fecha_act_g'";
    // $query3=$mysqli->query($sql3);   

}

function compararFechas($primera, $segunda)
 {
  $valoresPrimera = explode ("-", $primera);   
  $valoresSegunda = explode ("-", $segunda); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 

  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];

  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     

  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Login</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style-->
    <link rel="stylesheet" href="css/style.css">
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
    <div class="container">
        <div class="d-flex justify-content-center text-white my-5" >
            <h1 class="title" >Peruzon</h1>
        </div>
        <div class="row justify-content-center my-2">
            <div class="col-4 text-center fst-italic fw-bold text-white pb-3">
                <h3>Iniciar sesion</h3>
            </div>
        </div>
        <div class="row justify-content-center my-2">
            <div class="col-3 text-center p-4" style="background-color: #f0ffffb2;border-radius: 15px;">
<!--<form action="" class="formulario" name="formulario_registro" onsubmit="return false" method="POST">-->
                <form action="" class="formulario" name="formulario_login" onsubmit="return false" method="POST">
                    <div class="mb-3 fw-bold">
                        <label for="usuario" class="form-label" style="font-size: 20px;" ><i class="bi bi-person" width="36" height="36"></i> Usuario</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Nombre de usuario" value=<?php echo $_SESSION['usuario_2']; ?> >
                    </div>
                    <div class="mb-3 fw-bold">
                        <label for="clave" class="form-label" style="font-size: 20px;" >Contraseña</label>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="*******" value=<?php echo $_SESSION['clave_2']; ?> >
                    </div>
                    <div class="mb-0">
                        <button onclick="Validar(document.getElementById('user').value, document.getElementById('pass').value);" id="btn-submit" type="submit" class="btn btn-danger" value="Enviar">Ingresar <i class="bi bi-box-arrow-in-right"></i></button>
                    </div>

                    <script>
    				function Validar(user, pass){
    					if(user==""){
    						$.alert({
                        		title: 'Datos Incorrectos :,c',
                        		content: '<span style=color:red>Porfavor escribe el Usuario.</span>',
                        		animation: 'scale',
                        		closeAnimation: 'scale',
                        		buttons: {
                            		okay: {
                                		text: 'Cerrar',
                                		btnClass: 'btn-danger'
                            		}
                        		}
                    		});
    						return 0;
    					} 
    					if(pass==""){
    						$.alert({
                        		title: 'Datos Incorrectos :,c',
                        		content: '<span style=color:red>Porfavor escribe la Clave.</span>',
                        		animation: 'scale',
                        		closeAnimation: 'scale',
                        		buttons: {
                            		okay: {
                                		text: 'Cerrar',
                                		btnClass: 'btn-danger'
                            		}
                        		}
                    		});
                        return 0;
    					} 
   						$.ajax({
       						url: "validarusuario.php",
        					type: "POST",
        					data: "user="+user+"&pass="+pass,
        					beforeSend: function () {
           					$("#mensaje1").html("<img src='imagenes/load.gif' width='30px' height='30px'/><font color='white'>&nbsp&nbsp Ingresando...&nbsp&nbsp</font>");
        					},
        					success: function(resp){
           					$('#mensaje1').html(resp)
        					}        
        				});
    				}
    		        </script>
                    
                </form>
                
                <?php 
                if ( isset($_SESSION['usuario_valido']) && $_SESSION['usuario_valido'] == "no" ) {

                    unset($_SESSION['usuario_valido']);
                    echo "<script>
                        $.alert({
                            title: 'Datos Incorrectos :,c',
                            content: '<span style=color:red>El usuario o la clave son incorrectas.</span>',
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
                
            </div>
            
        </div>
        <div class="row justify-content-center" style="height:40px;">
            <div class="col-2 text-center">
                <div id="mensaje1" class="mensaje1" style="background-color:#0f0f0fa8; border-radius: 15px"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-white">Copyright © 2021 Peruzon / Roke</p>
            </div>
        </div>
    </div> 

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    
</body>
</html>