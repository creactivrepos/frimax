<?php 

include "include/clases/base/MySQL.php";
$DB = new MySQL();

extract($_POST);

$folio = $DB->fetch_array($DB->query('SELECT folio FROM controlRecibe WHERE id = "'.$idRecepcion.'"'));
$folio = $folio['folio'];
//Crea la carpeta en caso de que no exista con el ID de la orden
$dir = "uploads/".$folio."/";
if(!file_exists($dir))
	mkdir($dir,0777,true);

$dir = $dir."derecha/";
if(!file_exists($dir))
	mkdir($dir,0777,true);

echo $dir;

	
	$nombreArchivo = $dir.$_FILES['subirDerecha']['name'];


	if (move_uploaded_file($_FILES['subirDerecha']['tmp_name'], $nombreArchivo)) {
		echo "1";///Subido correctamente
	} 
	else {
	    echo "2";///Error en la carga del archivo
	}
?>