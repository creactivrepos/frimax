<?php 
include "base/pagina.php";
class usuarios extends pagina{
	public $getID;
	public $seccion;
	public $subseccion;
	public $level;
	public $idUser;

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
		<div class="col-xs-12" id="totalclientes">
		<div class="box">
		<div class="box-body">
		<table id="example1" class="table table-bordered responsive table-striped">
		<thead>'.$this->getHeadTable().'</thead>
		<tbody>';
		$sql = $this->getSQL();

		$sql = parent::query($sql);
		while($inf = parent::fetch_array($sql)){

			if(!isset($inf['paterno'])){
				$inf['paterno'] = '';
			}
			if(!isset($inf['status'])){
				$inf['status'] = '';
			}
			if(!isset($inf['id'])){
				$inf['id'] = '';
			}
			if(!isset($inf['nombre'])){
				$inf['nombre'] = '';
			}
			if(!isset($inf['materno'])){
				$inf['materno'] = '';
			}
			if(!isset($inf['email'])){
				$inf['email'] = '';
			}
			if(!isset($inf['celular'])){
				$inf['celular'] = '';
			}
			if(!isset($inf['nivel'])){
				$inf['nivel'] = '';
			}
			if(!isset($inf['sucursal'])){
				$inf['sucursal'] = '';
			}

			$status = $this->getStatus($inf['status']);
			$botones = $this->getBotones($inf['status'], $inf['id']);
			$dato .= '
			<tr>
			<td>'.$inf['user'].'</td>
			<td>'.utf8_encode($inf['nombre'].' '.$inf['paterno'].' '.$inf['materno']).'</td>
			<td>'.$inf['email'].'</td>
			<td>'.$inf['celular'].'</td>
			<td>'.$inf['nivel'].'</td>
			<td>'.utf8_encode($inf['sucursal']).'</td>
			<td>'.$status.'</td>
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
		if(!isset($this->info['user'])){
			$this->info['user'] = '';
		}
		if(!isset($this->info['nombre'])){
			$this->info['nombre'] = '';
		}
		if(!isset($this->info['paterno'])){
			$this->info['paterno'] = '';
		}
		if(!isset($this->info['materno'])){
			$this->info['materno'] = '';
		}
		if(!isset($this->info['email'])){
			$this->info['email'] = '';
		}
		if(!isset($this->info['celular'])){
			$this->info['celular'] = '';
		}

		$dato = '
		<div id="formNUser" style="display:none">	

		<form>
		<div class="row">
		<div class="col-sm-6 acceso">
		<legend class="text-center header">Información de Acceso</legend>		
		<div class="form-group">
		<label>Usuario</label>
		<input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" value="'.$this->info['user'].'"/>
		</div>
		<div class="form-group">
		<label>Clave</label>
		<input type="password" class="form-control" placeholder="Clave" id="clave" name="clave" />
		</div>
		<div class="form-group">
		'.$this->getNivel().'
		</div>
		<div class="form-group">
		'.$this->getSucursal().'
		</div>
		</div>
		<div class="col-sm-6 personal">
		<legend class="text-center header">Información Personal</legend>	
		<div class="form-group">
		<label>Nombre</label>
		<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el nombre" value="'.$this->info['nombre'].'"/>
		</div>
		<div class="form-group">
		<label>Apellido Paterno</label>
		<input type="text" class="form-control" id="paterno" name="paterno"  placeholder="Escribe el apellido paterno" value="'.$this->info['paterno'].'"/>
		</div>
		<div class="form-group">
		<label>Apellido Materno</label>
		<input type="text" class="form-control" id="materno" name="materno"  placeholder="Escribe el apellido materno" value="'.$this->info['materno'].'"/>
		</div>
		<div class="col-sm-6">
		<div class="form-group">
		<label>Email</label>
		<input type="text" class="form-control" id="email" name="email"  placeholder="Escribe el email" value="'.$this->info['email'].'"/>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group">
		<label>Celular</label>
		<input type="text" class="form-control" id="celular" name="celular"  placeholder="Escribe el nuvelo de celular" value="'.$this->info['celular'].'"/>
		</div>
		</div>
		<div class="signature-component text-center form-group">   
		<label>Firma</label>
		<span class="btn btn-danger" id="clearNew" style="float:right;">Limpiar</span> 
		<canvas id="firmaNewUsuario" width="340" height="170"></canvas>
		<div>		        

		<span> <input type="hidden" id="firmaDigitalNew"></span>
		</div>                                
		</div>

		</div>
		</div>
		<div class="row btnbotones">
		<div class="col-sm-12 text-center">
		<button type="button" class="btn btn-primary" id="addUsuario">Guardar Nuevo Usuario</button>
		<button type="button" class="btn btn-primary hideForms" >Cancelar</button>
		</div>
		</div>

		</form>
		</div>
		';

		return $dato;
	}
	private function getFormEPerfil(){
		$dato = '
		<div  id="formEUser" style="display:none" class="">
		<input type="hidden" id="eid" value="">
		<div class="row">
		<div class="col-sm-6 ">
		<legend class="text-center header">Información de Acceso</legend>		
		<div class="form-group">
		<label>Usuario</label>
		<input type="text" class="form-control" id="eusuario"/>
		</div>
		<div class="form-group">
		<label>Clave</label>
		<input type="password" class="form-control" id="eclave"/>
		</div>
		<div class="form-group">
		<select id="enivel" class="form-control">
		</select>
		</div>
		<div class="form-group">
		<select id="esucursal" class="form-control">
		</select>
		</div>
		</div>
		<div class="col-sm-6 ">
		<legend class="text-center header">Información Personal</legend>	
		<div class="form-group">
		<label>Nombre</label>
		<input type="text" class="form-control" id="enombre"/>
		</div>
		<div class="form-group">
		<label>Apellido Paterno</label>
		<input type="text" class="form-control" id="epaterno"/>
		</div>
		<div class="form-group">
		<label>Apellido Materno</label>
		<input type="text" class="form-control" id="ematerno"/>
		</div>
		<div class="col-sm-6">
		<div class="form-group">
		<label>Email</label>
		<input type="text" class="form-control" id="eemail"/>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group">
		<label>Celular</label>
		<input type="text" class="form-control" id="ecelular"/>
		</div>
		</div>
		<div id="pintarFirma1" style="display:none;">
		</div>
		<div id="pintarFirma" style="display:none;">
		<div class="signature-component text-center form-group">   
		<label>Firma</label>
		<span class="btn btn-danger" id="clearEdit" style="float:right;">Limpiar</span> 
		<canvas id="firmaEditUsuario" width="340" height="170"></canvas>
		</div>	

		</div>

		<span> <input type="hidden" id="firmaDigitalEdit"></span>
		</div>                                
		</div>
		<div class="row btnbotones">
		<div class="col-sm-12 text-center">
		<button type="button" class="btn btn-primary" id="editUsuario">Actualizar Usuario</button>
		<button type="button" class="btn btn-primary hideForms" >Cancelar</button>
		</div>
		</div>
		</div>';

		return $dato;
	}
	private function getHeadTable(){
		$dato = '
		<tr>
		<th>Usuario</th>
		<th>Nombre</th>
		<th>Email</th>
		<th>Celular</th>
		<th>Nivel</th>
		<th>Sucursal</th>
		<th>Status</th>
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
		<a href="#" class="sendEditUsuario" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
		<a href="#" class="elimUsuario" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';

		if($tipo == 1){//Entra porque esta activo
			$dato .= '<a href="#" class="susUsuario" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
		}
		elseif($tipo == 2){//Entra porque esta inactivo
			$dato .= '<a href="#" class="actUsuario" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
		}
		elseif($tipo == 9 AND $this->level == "1"){
			$dato .= '<a href="#" class="actUsuario" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
		}

		return $dato;					                        	
	}
	private function getSQL(){
		$sql = '
		SELECT usuarios.id, usuarios.user, usuarios.nombre, usuarios.email, usuarios.celular, in_niveles.descripcion AS nivel, in_sucursales.nombre AS sucursal, usuarios.status 
		FROM usuarios
		INNER JOIN in_niveles ON in_niveles.id = usuarios.nivel
		INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal';

		if($this->level > "1"){
			$sql .= ' WHERE usuarios.nivel > 1 AND usuarios.status <> 9';
		}
		else{
				//$sql .= ' WHERE usuarios.status <> 9';
		}

		return $sql;
	}
	private function getTitulo(){
		$dato = '
		<section class="content-header">
		<h1>
		Lista de Usuarios '.$this->level.'
		<small><button type="button" class="btn btn-primary" id="showPerfil">Nuevo Usuario</button></small>
		</h1>
		'.$this->getTimeLine().'
		</section>';

		return $dato;
	}
	private function getTimeLine(){
		$dato = '
		<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="#">Lista de usuarios</a></li>
		</ol>';

		return $dato;
	}
	private function getNivel(){
		if(!isset($this->info['nivel'])){
			$this->info['nivel'] = '';
		}
		if(!isset($this->info['sucursal'])){
			$this->info['sucursal'] = '';
		}

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
$pagina = new usuarios($section, $subsection);
