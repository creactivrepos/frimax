<?php 

//extract($_POST);
//var_dump($_POST);


if(unlink($_POST['ruta']))
	echo "1";
else
	echo "2";
?>