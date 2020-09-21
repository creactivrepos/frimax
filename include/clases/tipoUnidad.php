<?php 
include "base/pagina.php";
class TipoUnidad extends pagina{
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
		<div class="col-xs-12">
		<div class="box">
		<div class="box-body">
		<table id="example1" class="table table-bordered responsive table-striped">
		<thead>'.$this->getHeadTable().'</thead>
		<tbody>';
		$sql = $this->getSQL();

		$sql = parent::query($sql);
		while($inf = parent::fetch_array($sql)){	                    				
			$botones = $this->getBotones($inf['id']);
			$dato .= '
			<tr>
			<td>'.$inf['id'].'</td>
			<td>'.$inf['nombre'].'</td>
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
		'.$this->getFormNTipo().$this->getFormETipo().'
		</div>
		</section>
		</div>';

		return $dato;
	}
	private function getFormNTipo(){
		$dato = '
		<div class="col-md-6 col-sm-12" id="formNPerfil" style="display:none">
		<div class="box-footer">
		<div class="box-header">
		<h3 class="box-title">Información Nuevo Perfil</h3>
		</div>
		<div class="box-body">
		<form role="form">                        
		<div class="form-group">
		<label>Nombre Tipo de Vehíchulo</label>
		<input type="text" class="form-control" id="descripcion" name="descripcion"  placeholder="Escribe el nombre del perfil" value=""/>
		</div>
		</form>
		</div>
		<button type="button" class="btn btn-primary" id="addTipo">Guardar Nuevo Perfil</button>
		<button type="button" class="btn btn-primary hideForms" >Cancelar</button>
		</div>
		</div>';

		return $dato;
	}
	private function getFormETipo(){
		$dato = '
		<div class="col-md-6 col-sm-12" id="formETipo" style="display:none">
		<div class="box-footer">
		<div class="box-header">
		<h3 class="box-title">Información Tipo de Vehiculo</h3>
		</div>
		<div class="box-body">
		<form role="form">
		<input type="hidden" id="id" >
		<div class="form-group">
		<label>Nombre Tipo de Vehíchulo</label>
		<input type="text" class="form-control" id="descPerfil" name="descPerfil"/>
		</div>
		</form>
		</div>
		<button type="button" class="btn btn-primary" id="SendEditPerfil">Guardar</button>
		<button type="button" class="btn btn-primary hideForms">Cancelar</button>
		</div>
		</div>';

		return $dato;
	}
	private function getHeadTable(){
		$dato = '
		<tr>
		<th>ID</th>	        
		<th>Tipo de Vehículo</th>

		</tr>';

		return $dato;
	}
	private function getSQL(){
		$sql = '
		SELECT * FROM in_tipo_unidad ';		

		return $sql;
	}
	private function getStatus($tipo){
		$dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

		return $dato;
	}
	private function getBotones($id){
		$dato = '
		<a href="#" class="editTipo" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
		<a href="#" class="elimTipo" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';
		return $dato;					                        	
	}
	private function getTitulo(){
		$dato = '
		<section class="content-header">
		<h1>
		Lista de Tipos de Vehículo
		<small><button type="button" class="btn btn-primary" id="showUnidad">Nuevo Tipo de Vehículo</button></small>
		</h1>
		'.$this->getTimeLine().'
		</section>';

		return $dato;
	}
	private function getTimeLine(){
		$dato = '
		<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="#">Lista de Tipos de Vehículo</a></li>
		</ol>';

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
$pagina = new TipoUnidad($section, $subsection);
