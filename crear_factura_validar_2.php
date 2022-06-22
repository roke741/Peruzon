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

// Chequea si hay un valor vacio
for($i=1;$i<=$_SESSION['total_productos'];$i++){

	if(empty($_SESSION['carrito'][$i]['cantidad'])){
		echo "<p style='font-family: Arial; font-size: 11pt; color: red'>Debes introducir un número en el reglon nro.".$_SESSION['carrito'][$i]['orden']."</p>";
		exit();
	}
	
} // for($i=0;$i<$_SESSION['total_productos'];$i++)
/*
$valores[0], año
$valores[1], mes
$valores[2], dia
*/
$moneda=$_GET['pass'];
echo "<script>location.href = 'crear_factura_moneda.php?moneda=".$moneda."'</script>";
?>