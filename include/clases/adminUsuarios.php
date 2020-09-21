<?php 
include "base/pagina.php";
class adminUsuarios extends pagina{
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
	                  			<table id="example1" class="table table-bordered table-striped">
	                    			<thead>'.$this->getHeadTable().'</thead>
	                    			<tbody>';
	                    			$sql = $this->getSQL();
	                    			
	                    			$sql = parent::query($sql);
	                    			while($inf = parent::fetch_array($sql)){
	                    				$dato .= '
	                    				<tr>
	                        				<td>'.$inf['user'].'</td>
					                        <td>'.utf8_encode($inf['nombre'].' '.$inf['paterno'].' '.$inf['materno']).'</td>
					                        <td>'.$inf['email'].'</td>
					                        <td>'.$inf['celular'].'</td>
					                        <td>'.$inf['nivel'].'</td>
					                        <td>'.utf8_encode($inf['sucursal']).'</td>
					                        <td>
					                        	<a href="addUsuario.php?id='.$inf['id'].'"><i class="fa fa-edit"></i> Editar </a><br />
					                        	<a href="#" class="elimUsuario" id="'.$inf['id'].'"><i class="fa fa-trash"></i> Eliminar </a>
									            
									        </td>

	                      				</tr>';
	                    			}
	                    			$dato .= '
	                      			</tbody>
	                    			<tfoot>'.$this->getHeadTable().'</tfoot>
	                  			</table>
	                		</div>
	              		</div>
	            	</div>
	          	</div>
	        </section>
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
	        <th>Acciones</th>
		</tr>';

		return $dato;
	}
	private function getSQL(){
		$sql = '
			SELECT usuarios.id, usuarios.user, usuarios.nombre, usuarios.email, usuarios.celular, in_niveles.descripcion AS nivel, in_sucursales.nombre AS sucursal 
			FROM usuarios
			INNER JOIN in_niveles ON in_niveles.id = usuarios.nivel
			INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal
			WHERE usuarios.status <> 9';

			if($this->level > "1"){
				$sql .= 'AND usuarios.nivel > 1';
			}

		return $sql;
	}
	private function getTitulo(){
        $dato = '
        <section class="content-header">
          <h1>
            Lista de Usuarios
            <small></small>
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
$pagina = new adminUsuarios($section, $subsection);
