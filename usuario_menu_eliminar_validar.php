<?php  
sleep(2);
require("conexion/connection.php");
session_start();

// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
	header("Location:error1.php");
	exit();
}

$id_usuario=$_GET["id_usuario"];
//echo $id_usuario;
//exit();

// Elimina el cliente si no tiene movimientos
$sql="SELECT movimiento, usuario FROM tab_usuarios WHERE (id_usuario = ".$id_usuario.")";
$query=$mysqli->query($sql);
$row=$query->fetch_assoc();

if($query->num_rows!=0){
	if ($row['movimiento']=="No") {

  		$sql="DELETE FROM tab_usuarios WHERE (id_usuario = ".$id_usuario.")";
  		$query=$mysqli->query($sql);
      
  		$_SESSION['usuario_eliminado']="si";
  		echo '<script>location.href = "usuario_menu.php"</script>';

	}else{

  		$_SESSION['usuario_npe']=$row['usuario'];
      $_SESSION['usuario_tiene_mov']="si";
  		echo "<script>location.href = 'usuario_menu.php'</script>";    

	}
}

?>