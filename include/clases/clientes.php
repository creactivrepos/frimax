<?php 
include "base/pagina.php";
class clientes extends pagina{

	public function __construct($section, $subsection=""){		
		@session_start();
		parent::__construct($section, $subsection);

		$this->seccion = $section;
		$this->subseccion = $subsection;
		$this->level = $_SESSION['nivel'];
		$this->idUser = $_SESSION['id'];
	}
	public function createPage(){
		if($this->idUser != ""){//ya está logueado
			$dato = parent::supHalfPage().$this->contenido().parent::infHalfPage();
		}
		else{//No está logueado
			$dato =  parent::showLogin();
		}
		
		echo $dato;
	}
	private function contenido(){
		$dato = '
		<div class="content-wrapper">
		'.$this->getAlerts().$this->getTitulo().'
		<section class="content">
		<div class="row">
		<div id="totalclientes" class="col-xs-12">
		<div class="box">
		<div class="box-body">
		<table id="example1" class="table table-bordered responsive table-striped">
		<thead>'.$this->getHeadTable().'</thead>
		<tbody>';
		$sql = $this->getSQL();

		$sql = parent::query($sql);
		while($inf = parent::fetch_array($sql)){
			$status = $this->getStatus($inf['status']);
			$botones = $this->getBotones($inf['status'], $inf['id']);
			$dato .= '
			<tr>
			<td>'.$inf['id'].'</td>
			<td>'.utf8_encode($inf['nombre']).'</td>
			<td>'.$inf['RFC'].'</td>
			<td>'.$inf['razon'].'</td>
			<td>'.utf8_encode($inf['calle'].' '.$inf['numero'].' '.$inf['interior'].' '.$inf['colonia']).'</td>
			<td>'.$inf['ciudad'].'</td>
			<td>'.$inf['municipio'].'</td>
			<td>'.$inf['estado'].'</td>
			<td>'.$inf['telefono'].'</td>
			<td>'.$inf['email'].'</td>
			<td>'.$botones.'</td>

			</tr>';
		}
		$dato .= '
		</tbody>
		<tfoot>'.$this->getHeadTable().'</tfoot>
		</table>
		</div>
		</div>
		</div>
		'.$this->getFormNPerfil().$this->getFormEPerfil().'
		</div>
		</section>
		</div>';

		return $dato;
	}
	private function getFormNPerfil(){
		$dato = '
		<div  id="formNPerfil" style="display:none">
		<div class="col-md-6 col.sm-12">
		<div class="box box-warning">
		<div class="box-header">
		<h3 class="box-title">Información de Acceso </h3>
		</div>
		<div class="box-body">
		<form role="form">
		<div class="form-group">
		<label>Nombre</label>
		<input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre"/>
		</div>
		<div class="form-group">
		<label>RFC</label>
		<input type="text" class="form-control" placeholder="RFC" id="rfc" name="rfc"/>
		</div>
		<div class="form-group">
		<label>Razón social</label>
		<input type="text" class="form-control" placeholder="Razon Social" id="razon" name="razon"/>
		</div>
		<div class="form-group">
		<label>Calle</label>
		<input type="text" class="form-control" placeholder="Calle" id="calle" name="calle"/>
		</div>
		<div class="form-group col-xs-6 col-md-6">
		<label>Num. Int</label>
		<input type="text" class="form-control" placeholder="Nombre" id="interior" name="interior"/>
		</div>
		<div class="form-group col-xs-6 col-md-6">
		<label>Num. ext</label>
		<input type="text" class="form-control" placeholder="Nombre" id="exterior" name="exterior"/>
		</div>
		<div class="form-group">
		<label>Colonia</label>
		<input type="text" class="form-control" placeholder="Calle" id="colonia" name="colonia" />
		</div>
		</form>
		</div>
		</div>
		</div>
		<div class="col-md-6">
		<div class="box box-warning">
		<div class="box-header">
		<h3 class="box-title">Información Personal</h3>
		</div>
		<div class="box-body">
		<form role="form">
		<div class="form-group">
		<label>C.P.</label>
		<input type="text" class="form-control" id="cp" name="cp" placeholder="Código Postal"/>
		</div>
		<div class="form-group">
		<label>Ciudad</label>
		<input type="text" class="form-control" id="ciudad" name="ciudad"  placeholder="Escribe el nombre de tu ciudad"/>
		</div>
		<div class="form-group">
		<label>Municipio</label>
		<input type="text" class="form-control" id="municipio" name="municipio"  placeholder="Escribe el  nombre del Municipio"/>
		</div>
		<div class="form-group">
		<label>Estado</label>
		<input type="text" class="form-control" id="estado" name="estado"  placeholder="Escribe el nombre de tu estado"/>
		</div>
		<div class="form-group">
		<label>Teléfono</label>
		<input type="phone" class="form-control" id="telefono" name="telefono"  placeholder="Teléfono"/>
		</div>
		<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" id="email" name="email"  placeholder="Email"/>
		</div>
		</form>
		</div>
		</div>
		</div>
		<div class="container">
		<button type="button" class="btn btn-primary" id="addCliente">Guardar Nuevo Usuario</button>
		<button type="button" class="btn btn-primary hideForms" >Cancelar</button>
		</div>
		</div>
		<div class="col-md-12" style="display:none" id="showErrors"><div class="box-footer" id="spcError" style="color:red"></div></div>
		';

		return $dato;
	}
	private function getFormEPerfil(){
		$dato = '
		<div  id="formEPerfil" style="display:none">
		<div class="col-md-6 col.sm-12">
		<div class="box box-warning">
		<div class="box-header">
		<h3 class="box-title">Información del cliente </h3>
		</div>
		<div class="box-body">
		<form role="form">
		<div class="form-group">
		<input type="hidden" id="eid"/>
		<label>Nombre</label>
		<input type="text" class="form-control" placeholder="Nombre" id="enombre"/>
		</div>
		<div class="form-group">
		<label>RFC</label>
		<input type="text" class="form-control" placeholder="RFC" id="erfc"/>
		</div>
		<div class="form-group">
		<label>Razón social</label>
		<input type="text" class="form-control" placeholder="Razon Social" id="erazon"/>
		</div>
		<div class="form-group">
		<label>Calle</label>
		<input type="text" class="form-control" placeholder="Calle" id="ecalle"/>
		</div>
		<div class="form-group col-xs-6 col-md-6">
		<label>Num. Int</label>
		<input type="text" class="form-control" placeholder="Nombre" id="einterior"/>
		</div>
		<div class="form-group col-xs-6 col-md-6">
		<label>Num. ext</label>
		<input type="text" class="form-control" placeholder="Nombre" id="eexterior"/>
		</div>
		<div class="form-group">
		<label>Colonia</label>
		<input type="text" class="form-control" placeholder="Calle" id="ecolonia"/>
		</div>
		</form>
		</div>
		<button type="button" class="btn btn-primary" id="SendEditCliente">Actualizar Cliente</button>
		<button type="button" class="btn btn-primary hideForms" >Cancelar</button>
		</div>
		</div>
		<div class="col-md-6">
		<div class="box box-warning">
		<div class="box-header">
		<h3 class="box-title">Información Personal</h3>
		</div>
		<div class="box-body">
		<form role="form">
		<div class="form-group">
		<label>C.P.</label>
		<input type="text" class="form-control" id="ecp" placeholder="Código Postal"/>
		</div>
		<div class="form-group">
		<label>Ciudad</label>
		<input type="text" class="form-control" id="eciudad" placeholder="Escribe el nombre de tu ciudad"/>
		</div>
		<div class="form-group">
		<label>Municipio</label>
		<input type="text" class="form-control" id="emunicipio" placeholder="Escribe el nombre del Municipio"/>
		</div>
		<div class="form-group">
		<label>Estado</label>
		<input type="text" class="form-control" id="eestado" placeholder="Escribe el nombre de tu estado"/>
		</div>
		<div class="form-group">
		<label>Teléfono</label>
		<input type="phone" class="form-control" id="etelefono" placeholder="Teléfono"/>
		</div>
		<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" id="eemail" placeholder="Email"/>
		</div>
		</form>
		</div>
		</div>
		</div>
		</div>';

		return $dato;
	}
	private function getHeadTable(){
		$dato = '
		<tr>
		<th>ID</th>
		<th>Nombre</th>
		<th>RFC</th>
		<th>Razon</th>
		<th>Direcion</th>
		<th>Ciudad</th>
		<th>Municipio</th>
		<th>Estado</th>
		<th>Telefono</th>
		<th>Email</th>
		<th>Acciones</th>
		</tr>';

		return $dato;
	}
	private function getStatus($tipo){
		$dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

		return $dato;
	}
	private function getBotones($tipo, $id){

		$dato = '
		<a href="#" class="editCliente" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
		<a href="#" class="elimCliente" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';

		if($tipo == 1){//Entra porque esta activo
			$dato .= '<a href="#" class="susCliente" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
		}
		elseif($tipo == 2){//Entra porque esta inactivo
			$dato .= '<a href="#" class="actCliente" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
		}
		elseif($tipo == 9 AND $this->level == "1"){
			$dato .= '<a href="#" class="actCliente" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
		}

		return $dato;					                        	
	}
	private function getSQL(){
		$sql = 'SELECT in_clientes.* FROM in_clientes';

		return $sql;
	}
	private function getTitulo(){
		$dato = '
		<section class="content-header">
		<h1>
		Lista de Clientes
		<small><button type="button" class="btn btn-primary" id="showPerfil">Nuevo Cliente</button></small>
		</h1>
		'.$this->getTimeLine().'
		</section>';

		return $dato;
	}
	private function getTimeLine(){
		$dato = '
		<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="#">Lista de Clientes</a></li>
		</ol>';

		return $dato;
	}
	private function getNivel(){
		$add = $this->level != "1" ? " WHERE id != 1 " : "";
		$sql = parent::query('SELECT * FROM in_niveles'.$add);
		$disa = ($this->getID != "" AND $this->level != "WB") ? "disabled" : "";
		$dato = '
		<label>Nivel</label>
		<select class="form-control" name="nivel" id="nivel" '.$disa.'>
		<option value="">--Seleccione</option>';
		while($dat = parent::fetch_array($sql)){
			$sel = $dat['id'] == $this->info['nivel'] ? "selected" : "";
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['descripcion'].'</option>';
		}
		$dato .= '
		</select>';

		return $dato;
	}
	private function getSucursal(){
		$sql = parent::query('SELECT * FROM in_sucursales ORDER BY nombre ASC');
		$dato = '
		<label>Sucursal</label>
		<select class="form-control" name="sucursal" id="sucursal">
		<option value="">--Seleccione</option>';
		while($dat = parent::fetch_array($sql)){
			$sel = $dat['id'] == $this->info['sucursal'] ? "selected" : "";
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['nombre'].'</option>';
		}
		$dato .= '
		</select>';

		return $dato;
	}
	private function getAlerts(){
		$dato = '
		<div class="portlet-body">
		<div class="alert alert-success alert-dismissable" id="exito" style="display:none">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<strong>Exito!</strong> La información ha sido almacenada de forma correcta</div>
		<div class="alert alert-warning alert-dismissable" id="warning" style="display:none">
		<strong>Cuidado!</strong> El usuario que intentas registrar, ya existe.</div>
		<div class="alert alert-danger alert-dismissable" id="error" style="display:none">
		<strong>Error!</strong> Hemos tenido un inconveniente, por favor intentalo mas tarde. </div>
		</div>';

		return $dato;
	}
}
$pagina = new clientes($section, $subsection);
