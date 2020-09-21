<?php
include '../include/clases/base/MySQL.php';
$DB = new MySQL();
$user = $_POST['user'];
$pass = $_POST['pass'];

$sel = $DB->fetch_array($DB->query('SELECT id, user, nivel, pass FROM usuarios WHERE user = "'.$user.'" AND status = 1'));

$id = $sel['id'];
date_default_timezone_set("America/Mexico_City");
$fecha = date("Y-m-d H:i:s");

if($id == ''){
	echo "1";//El usuario esta incorrecto
}
elseif($sel['pass'] != sha1($pass)){
	echo "2"; //La contraseña esta incorrecta
}
else{
	@session_start();
	$_SESSION['id'] = $id;
	$_SESSION['user'] = $user;
	$_SESSION['nivel'] = $sel['nivel'];
	$_SESSION['tipo'] = "normal";
	
	echo "3";//Usuario y contraseña correcto, session iniciada sin problemas
}