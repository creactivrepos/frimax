<?php 
@session_start();
$func = $_POST['func'];

if($func == "cerrarSesion"){//Entra para cerrar la sesion
	@session_destroy();
}
?>