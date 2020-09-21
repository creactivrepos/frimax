
<?php 
include_once "include/clases/base/submit.php";
$submit = new submit();
$func = $_POST['func'];

if($func == "addUsuario"){
	$res = $submit->addUsuario($_POST['usuario'], $_POST['clave'], $_POST['nombre'], $_POST['paterno'], $_POST['materno'], $_POST['email'], $_POST['celular'], $_POST['sucursal'], $_POST['nivel'], $_POST['firma']);
	
	echo $res;
}
elseif($func == "sendEditUsuario"){
	$res = $submit->sendEditUsuario($_POST['id']);

	echo $res;
}
elseif($func == "editUsuario"){
	$res = $submit->editUsuario($_POST['id'], $_POST['usuario'], $_POST['clave'], $_POST['nombre'], $_POST['paterno'], $_POST['materno'], $_POST['email'], $_POST['celular'], $_POST['firmaDigitalEdit'], $_POST['sucursal'], $_POST['nivel']);
	
	echo $res;	
}
elseif($func == "enviarMiPerfil"){
	$res = $submit->editUsuario($_POST['id'], $_POST['usuario'], $_POST['contrasena'], $_POST['nombre'], $_POST['paterno'], $_POST['materno'], $_POST['email'], $_POST['celular'], $_POST['distribuidora'], $_POST['nivel'], $_POST['clave'], $_POST['zona']);
	
	echo $res;
}
elseif($func == "elimUsuario"){
	$res = $submit->elimUsuario($_POST['id']);

	echo $res;
}
elseif($func == "elimPerfil"){
	$res = $submit->elimPerfil($_POST['id']);

	echo $res;
}
elseif($func == "susPerfil"){
	$res = $submit->susPerfil($_POST['id']);

	echo $res;
}
elseif($func == "actPerfil"){
	$res = $submit->actPerfil($_POST['id']);

	echo $res;
}
elseif($func == "editPerfil"){
	$res = $submit->editPerfil($_POST['id']);

	echo $res;
}
elseif($func == "addPerfil"){
	$res = $submit->addPerfil($_POST['nombre'], $_POST['descripcion']);

	echo $res;
}
elseif($func == "SendEditPerfil"){
	$res = $submit->SendEditPerfil($_POST['id'], $_POST['nombre'], $_POST['descripcion']);

	echo $res;
}
elseif($func == "elimSucursal"){
	$res = $submit->elimSucursal($_POST['id']);

	echo $res;
}
elseif($func == "addCliente"){
	$res = $submit->addCliente($_POST);
	echo $res;
}
elseif($func == "elimCliente"){
	$res = $submit->elimCliente($_POST['id']);

	echo $res;
}
elseif($func == "susSucursal"){
	$res = $submit->susSucursal($_POST['id']);

	echo $res;
}
elseif($func == "susCliente"){
	$res = $submit->susCliente($_POST['id']);

	echo $res;
}
elseif($func == "actSucursal"){
	$res = $submit->actSucursal($_POST['id']);

	echo $res;
}
elseif($func == "actCliente"){
	$res = $submit->actCliente($_POST['id']);

	echo $res;
}
elseif($func == "editSucursal"){
	$res = $submit->editSucursal($_POST['id']);

	echo $res;
}
elseif($func == "editCliente"){
	$res = $submit->editCliente($_POST['id']);

	echo $res;
}
elseif($func == "addSucursal"){
	$res = $submit->addSucursal($_POST['nombre'], $_POST['ciudad'], $_POST['clave']);

	echo $res;
}
elseif($func == "SendEditSucursal"){
	$res = $submit->SendEditSucursal($_POST['id'], $_POST['nombre'], $_POST['ciudad'], $_POST['clave']);

	echo $res;
}
elseif($func == "SendEditCliente"){
	$res = $submit->SendEditCliente($_POST);

	echo $res;
}
elseif($func == "nivelRelMP"){
	$res = $submit->nivelRelMP($_POST['nivel']);

	echo $res;
}
elseif($func == "relmenper"){
	$res = $submit->relmenper($_POST['idPerfil'], $_POST['id'], $_POST['valor']);

	echo $res;
}
elseif($func == "addAccesorio"){
	$res = $submit->addAccesorio($_POST['nombre']);

	echo $res;
}
elseif($func == "editAccesorio"){
	$res = $submit->editAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "SendEditAccesorio"){
	$res = $submit->SendEditAccesorio($_POST['id'], $_POST['nombre']);

	echo $res;
}
elseif($func == "elimAccesorio"){
	$res = $submit->elimAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "susAccesorio"){
	$res = $submit->susAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "actAccesorio"){
	$res = $submit->actAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "addEstatusAccesorio"){
	$res = $submit->addEstatusAccesorio($_POST['nombre']);

	echo $res;
}
elseif($func == "editEstatusAccesorio"){
	$res = $submit->editEstatusAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "elimEstatusAccesorio"){
	$res = $submit->elimEstatusAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "susEstatusAccesorio"){
	$res = $submit->susEstatusAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "actEstatusAccesorio"){
	$res = $submit->actEstatusAccesorio($_POST['id']);

	echo $res;
}
elseif($func == "SendEditEstatusAccesorio"){
	$res = $submit->SendEditEstatusAccesorio($_POST['id'], $_POST['nombre']);

	echo $res;
}
elseif($func == "addRecepcion"){
	$res = $submit->addRecepcion($_POST);
	echo $res;
}
elseif($func == "updRecepcion"){
	$res = $submit->updRecepcion($_POST);

	echo $res;
}
elseif($func == "searchClients"){
	$res = $submit->searchClients($_POST['valor']);

	echo $res;
}
elseif($func == "elimRecepcion"){
	$res = $submit->elimRecepcion($_POST['id']);

	echo $res;
}
elseif($func == "susRecepcion"){
	$res = $submit->susRecepcion($_POST['id']);

	echo $res;
}
elseif($func == "actRecepcion"){
	$res = $submit->actRecepcion($_POST['id']);

	echo $res;
}
elseif($func == "editRecepcion"){
	$res = $submit->editRecepcion($_POST['id']);

	echo $res;
}
elseif($func == "loadTipoUnidad"){	
	$res = $submit->loadTipoUnidad($_POST['id']);

	echo $res;
}
elseif($func == "showAccesorios"){	
	$res = $submit->showAccesorios($_POST['id']);

	echo $res;
}
elseif($func == "showMedidasChasis"){	
	$res = $submit->showMedidasChasis($_POST['id']);

	echo $res;
}
elseif($func == "loadAccesorios"){
	$res = $submit->loadAccesorios($_POST['id']);

	echo $res;
}
elseif($func == "loadMotivo"){
	$res = $submit->loadMotivo($_POST['id']);

	echo $res;
}
elseif($func == "loadAsesor"){
	$res = $submit->loadAsesor($_POST['id']);

	echo $res;
}
elseif($func == "loadCombustible"){
	$res = $submit->loadCombustible($_POST['id']);

	echo $res;
}elseif($func == "cambiarcontrasena"){
	$res = $submit->cambiarcontrasena($_POST['email']);

	return $res;
}elseif($func == "actualizarFechas"){
	$res = $submit->actualizarFechas();
	echo $res;
}elseif($func == "usuarioEntrega"){
	$res = $submit->usuarioEntrega($_POST);
	echo $res;
}
elseif($func == "accesoriosTipo"){
	$res = $submit->accesoriosTipo($_POST['id']);
	echo $res;
}
?>