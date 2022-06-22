<?php  
sleep(1);
session_start();
// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
	header("Location:error1.php");
	exit();      
}

$moneda=$_POST['pass'];
echo "<script>location.href = 'factura_proveed_reporte_moneda.php?moneda=".$moneda."'</script>";
?>