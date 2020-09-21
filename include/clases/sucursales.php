<?php 
include "base/pagina.php";
class sucursales extends pagina{
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
	                  			<table id="example1" class="table responsive table-bordered table-striped">
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
					                        <td>'.utf8_encode($inf['ciudad']).'</td>
					                        <td>'.$inf['clave'].'</td>
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
		$dato = '
		<div class="col-md-6 col-sm-12" id="formNPerfil" style="display:none">
            <div class="box-footer">
            	<div class="box-header">
                    <h3 class="box-title">Información Nueva Sucursal</h3>
                </div>
                <div class="box-body">
                    <form role="form">
                        <div class="form-group">
                            <label>Nombre Sucursal</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el nombre de la sucursal"/>
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad"  placeholder="Escribe la ciudad donde está esta sucursal"/>
                        </div>
                        <div class="form-group">
                            <label>Clave Sucursal</label>
                            <input type="text" class="form-control" id="clave" name="clave"  placeholder="Escribe la clave de esta sucursal"/>
                        </div>
                    </form>
                </div>
                <button type="button" class="btn btn-primary" id="addSucursal">Guardar Nueva Sucursal</button>
                <button type="button" class="btn btn-primary hideForms" >Cancelar</button>
            </div>
        </div>';

        return $dato;
	}
	private function getFormEPerfil(){
		$dato = '
		<div class="col-md-6 col-sm-12" id="formEPerfil" style="display:none">
            <div class="box-footer">
            	<div class="box-header">
                    <h3 class="box-title">Información Sucursal</h3>
                </div>
                <div class="box-body">
                    <form role="form">
                    	<input type="hidden" id="id" >
                        <div class="form-group">
                            <label>Nombre Sucursal</label>
                            <input type="text" class="form-control" id="nombreSuc" name="nombreSuc"/>
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" class="form-control" id="ciudadSuc" name="ciudadSuc"/>
                        </div>
                        <div class="form-group">
                            <label>Clave Sucursal</label>
                            <input type="text" class="form-control" id="claveSuc" name="claveSuc"/>
                        </div>
                    </form>
                </div>
                <button type="button" class="btn btn-primary" id="SendEditSucursal">Guardar Sucursal</button>
                <button type="button" class="btn btn-primary hideForms">Cancelar</button>
            </div>
        </div>';

        return $dato;
	}
	private function getHeadTable(){
		$dato = '
		<tr>
			<th>ID</th>
	        <th>Nombre</th>
	        <th>Ciudad</th>
	        <th>Clave</th>
	        <th>Estatus</th>
	        <th>Acciones</th>
		</tr>';

		return $dato;
	}
	private function getSQL(){
		$sql = '
			SELECT * FROM in_sucursales ';

			if($this->level != "1"){
				$sql .= ' WHERE status <> 9';
			}

		return $sql;
	}
	private function getStatus($tipo){
		$dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

		return $dato;
	}
	private function getBotones($tipo, $id){
		$dato = '
			<a href="#" class="editSucursal" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
			<a href="#" class="elimSucursal" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';

		if($tipo == 1){//Entra porque esta activo
			$dato .= '<a href="#" class="susSucursal" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
		}
		elseif($tipo == 2){//Entra porque esta inactivo
			$dato .= '<a href="#" class="actSucursal" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
		}
		elseif($tipo == 9 AND $this->level == "1"){
			$dato .= '<a href="#" class="actSucursal" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
		}

		return $dato;					                        	
	}
	private function getTitulo(){
        $dato = '
        <section class="content-header">
          <h1>
            Lista de Sucursales
            <small><button type="button" class="btn btn-primary" id="showPerfil">Nueva Sucursal</button></small>
          </h1>
          '.$this->getTimeLine().'
        </section>';

        return $dato;
    }
    private function getTimeLine(){
		$dato = '
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="#">Lista de Sucursales</a></li>
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
$pagina = new sucursales($section, $subsection);
