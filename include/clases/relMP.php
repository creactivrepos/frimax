<?php 
include "base/pagina.php";
class relMP extends pagina{
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
        <input type="hidden" id="id" name="id" value="'.$this->idUser.'">
        <div class="content-wrapper">
            '.$this->getAlerts().$this->getTitulo().'
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Selecciona un Perfil</h3>
                            </div>
                            <div class="box-body">
                                <form role="form">
                                    <div class="form-group">
                                        '.$this->getNivel().'
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="showLC" style="display:none">
                        <input type="hidden" id="idPerfil" >
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Opciones con acceso</h3>
                            </div>
                            <div class="box-body">
                                <form role="form">
                                    <div class="form-group" id="contieneLC"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        ';

	    return $dato;
	}
	private function getTitulo(){

        $dato = '
        <section class="content-header">
          <h1>
            Editar Relacion Perfil-Menu
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
            <li><a href="#">Editar relación Perfil-Meu</a></li>
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
		$dato = '
        <label>Nivel</label>
        <select class="form-control" name="nivel" id="nivelRelMP">
            <option value="">--Seleccione</option>';
        while($dat = parent::fetch_array($sql)){
            $dato .= '<option value="'.$dat['id'].'">'.$dat['descripcion'].'</option>';
        }
        $dato .= '
        </select>';

        return $dato;
	}
}
$pagina = new relMP($section, $subsection);
