<?php 
include "base/pagina.php";
class addUsuario extends pagina{
	public function __construct($section, $subsection=""){
		@session_start();
		parent::__construct($section, $subsection);
		$this->seccion = $section;
		$this->subseccion = $subsection;
		$this->level = $_SESSION['nivel'];
		$this->idUser = $_SESSION['id'];
        $this->getID = $_GET['id'];
        $this->info = parent::fetch_array(parent::query('SELECT * FROM usuarios WHERE id = "'.$this->getID.'"'));
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
        $let = $this->getID == "" ? "Guardar" : "Actualizar";
        $acc = $this->getID == "" ? "addUsuario" : "editUsuario";
		$dato = '
        <input type="hidden" id="id" name="id" value="'.$this->getID.'">
        <div class="content-wrapper">
            '.$this->getAlerts().$this->getTitulo().'
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Información de Acceso </h3>
                            </div>
                            <div class="box-body">
                                <form role="form">
                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" value="'.$this->info['user'].'"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Clave</label>
                                        <input type="password" class="form-control" placeholder="Clave" id="clave" name="clave" value="'.$this->info['pass'].'" />
                                    </div>
                                    <div class="form-group">
                                        '.$this->getNivel().'
                                    </div>
                                    <div class="form-group">
                                        '.$this->getSucursal().'
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
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el nombre" value="'.$this->info['nombre'].'"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" class="form-control" id="paterno" name="paterno"  placeholder="Escribe el apellido paterno" value="'.$this->info['paterno'].'"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" class="form-control" id="materno" name="materno"  placeholder="Escribe el apellido materno" value="'.$this->info['materno'].'">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="email" name="email"  placeholder="Escribe el email" value="'.$this->info['email'].'"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular"  placeholder="Escribe el número de celular" value="'.$this->info['celular'].'"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" id="'.$acc.'" name="'.$acc.'">'.$let.'</button>
                            <button type="button" class="btn btn-primary" id="cancelar" name="cancelar">Cancelar</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        ';

	    return $dato;
	}
	private function getTitulo(){
        $let = $this->getID == "" ?"Agregar nuevo usuario" : "Editar usuario existente";

        $dato = '
        <section class="content-header">
          <h1>
            '.$let.'
            <small></small>
          </h1>
          '.$this->getTimeLine().'
        </section>';

        return $dato;
    }
    private function getTimeLine(){
        $let = $this->getID == "" ? "Dar de alta un usuario" : "Editar usuario";
		$dato = '
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="#">'.$let.'</a></li>
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
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
		}
		$dato .= '
		</select>';

		return $dato;
	}
}
$pagina = new addUsuario($section, $subsection);
