<?php 

include_once "base/pagina.php";
class home extends pagina{
	public function __construct($section, $subsection=""){
		@session_start();
		parent::__construct($section, $subsection);
		$this->seccion = $section;
		$this->subseccion = $subsection;
		if(isset($_SESSION['nivel'])){
			$this->level = $_SESSION['nivel'];
			$this->idUser = $_SESSION['id'];
		}
		else{
			$_SESSION['id'] = "";	
		}
	}
	public function createPage(){
		@session_start();
		if($_SESSION['id'] != ""){//ya está logueado
			$dato = parent::supHalfPage().$this->contenido().parent::infHalfPage();
		}
		else{//No está logueado
			@session_destroy();
			$dato = parent::showLogin();
		}
		echo $dato;
	}
	private function contenido(){
	    $mensaje = '';
	    $tipo_mensaje = '';
	    $class = '';
	    if(isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            $tipo_mensaje = $_GET['tipo_mensaje'];
            if($tipo_mensaje=='error'){
                $class = "alert alert-danger";
            }
        }
		$dato = '
		<div class="content-wrapper">
		    <div class="'.$class.'">
                <strong>'.$tipo_mensaje.'</strong> '.$mensaje.'
            </div>
            
      	</div>';

        return $dato;
	}
}
$pagina = new home($section);
?>