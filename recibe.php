<?php 

include "include/clases/base/MySQL.php";
$DB = new MySQL();

extract($_POST);

$folio = $DB->fetch_array($DB->query('SELECT folio FROM controlRecibe WHERE id = "'.$idRecepcion.'"'));
$folio = $folio['folio'];
//Crea la carpeta en caso de que no exista con el folio de la orden de recpcion
$dir = "uploads/".$folio."/";
if(!file_exists($dir))
	mkdir($dir,0777,true);

//Crea la carpeta en caso de que no exista con el nombre de la seleccionada
$dir = $dir.$lado."/";
if(!file_exists($dir))
	mkdir($dir,0777,true);

$nombreFile = "subir".$lado;
	
$nombreArchivo = $dir.$_FILES[$nombreFile]['name'];

//echo $nombreFile;

if (move_uploaded_file($_FILES[$nombreFile]['tmp_name'], $nombreArchivo)) {
	echo "1";///Subido correctamente
} 
else {
    echo "2";///Error en la carga del archivo
}
?>