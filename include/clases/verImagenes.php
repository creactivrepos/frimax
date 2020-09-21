<?php 
include "base/pagina.php";
class recepcion extends pagina{
	public function __construct($section, $subsection=""){
		@session_start();
		parent::__construct($section, $subsection);
		$this->seccion = $section;
		$this->subseccion = $subsection;
		$this->level = $_SESSION['nivel'];
		$this->idUser = $_SESSION['id'];

        $this->info = parent::fetch_array(parent::query('SELECT CONCAT(nombre," ", paterno, " ", materno) AS nombreC, usuarios.* FROM usuarios WHERE id = "'.$this->idUser.'"'));
        $this->folio = $_GET['folio'];
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
        <div class="col-sm-12">
        <div class="row">
        <div class="col-md-6 col-xs-12">
        <h4  class="text-center">Imagenes de Recepción</h4>
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imágenes Frente</h4>
        '.$this->getImagenes(1).'
        </div>
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imágenes Traseras</h4>
        '.$this->getImagenes(2).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Izquierda</h4>
        '.$this->getImagenes(3).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Derecha</h4><br />
        '.$this->getImagenes(4).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Identificacion</h4><br />
        '.$this->getImagenes(5).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Otras imágenes</h4><br />
        '.$this->getImagenes(6).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes INE</h4><br />
        '.$this->getImagenes(7).'
        </div> 
        </div>
        <div class="col-md-6 col-xs-12">
        <h4  class="text-center">Imagenes de Entrega</h4>
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imágenes Frente</h4>
        '.$this->getImagenesEntrega(1).'
        </div>
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imágenes Traseras</h4>
        '.$this->getImagenesEntrega(2).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Izquierda</h4>
        '.$this->getImagenesEntrega(3).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Derecha</h4><br />
        '.$this->getImagenesEntrega(4).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes Identificacion</h4><br />
        '.$this->getImagenesEntrega(5).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Otras imágenes</h4><br />
        '.$this->getImagenesEntrega(6).'
        </div> 
        <div class="col-md-12 well well-sm titulo-imagen">
        <h4 class="box-title">Imagenes INE</h4><br />
        '.$this->getImagenesEntrega(7).'
        </div> 
        </div>
        </div>
        </div>
        </div>
        </section>
        </div>';

        return $dato;
    }
    private function getImagenes($tipo){
        $dir = $this->getCarpImg($tipo);
        $dato = '';
        if(file_exists($dir)) {
            $directorio = opendir($dir); //ruta actual
            $lado = $this->getLado($tipo);
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if ($archivo != "." AND $archivo != "..") {
                    $nom=explode(".", $archivo);                    
                    $dato .= '
                    <div class="col-md-6 imagen">
                    <form id="' . $lado . '">

                    <a href="' . $dir . $archivo . '" target="_blank">
                    <img src="' . $dir . $archivo . '" width="90%" style="position:relative;display:block;margin:auto;">
                    </a>
                    <input type="hidden" value="' . $dir . $archivo . '" id="rutaImg_' . $lado.'_' .$nom[0] . '">';
                    if ($this->level == 1 OR $this->level == 2) {
                        $dato .= '<a href="#" class="elimImagen" data="' . $lado.'_' .$nom[0] . '">Eliminar</a>';
                    }
                    $dato .= '

                    </div>
                    </form>';
                }
            }
        }

        return $dato;

    }

    private function getImagenesEntrega($tipo){
        $dir = $this->getCarpImgEntrega($tipo);
        $dato = '';
        if(file_exists($dir)) {
            $directorio = opendir($dir); //ruta actual
            $lado = $this->getLadoEntrega($tipo);
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                if ($archivo != "." AND $archivo != "..") {
                    $nom=explode(".", $archivo);                    
                    $dato .= '
                    <div class="col-md-6 imagen">
                    <form id="' . $lado . '">

                    <a href="' . $dir . $archivo . '" target="_blank">
                    <img src="' . $dir . $archivo . '" width="90%" style="position:relative;display:block;margin:auto;">
                    </a>
                    <input type="hidden" value="' . $dir . $archivo . '" id="rutaImg_' . $lado.'_' .$nom[0] . '">';
                    if ($this->level == 1 OR $this->level == 2) {
                        $dato .= '<a href="#" class="elimImagen" data="' . $lado.'_' .$nom[0] . '">Eliminar</a>';
                    }
                    $dato .= '

                    </div>
                    </form>';
                }
            }
        }

        return $dato;

    }

    private function getCarpImg($tipo){
        $lado = $tipo == 1 ? "delantera" : ($tipo == 2 ? "trasera" : ($tipo == 3 ? "izquierda" : ($tipo == 4 ? "derecha" : ($tipo == 5 ? "ife" : ($tipo == 6 ? "otro" : "ine")))));

        $dir = "uploads/".$this->folio."/".$lado."/";

        return $dir;
    }

    private function getCarpImgEntrega($tipo){
        $lado = $tipo == 1 ? "delantera" : ($tipo == 2 ? "trasera" : ($tipo == 3 ? "izquierda" : ($tipo == 4 ? "derecha" : ($tipo == 5 ? "ife" : ($tipo == 6 ? "otro" : "ine")))));

        $dir = "uploadsEntrega/".$this->folio."/".$lado."/";

        return $dir;
    }

    private function getLado($tipo){
        $lado = $tipo == 1 ? "delantera" : ($tipo == 2 ? "trasera" : ($tipo == 3 ? "izquierda" : ($tipo == 4 ? "derecha" : ($tipo == 5 ? "ife" : ($tipo == 6 ? "otro" : "Ine")))));        

        return $lado;
    }

    private function getLadoEntrega($tipo){
        $lado = $tipo == 1 ? "delantera" : ($tipo == 2 ? "trasera" : ($tipo == 3 ? "izquierda" : ($tipo == 4 ? "derecha" : ($tipo == 5 ? "ife" : ($tipo == 6 ? "otro" : "Ine")))));        

        return $lado;
    }


    private function getTitulo(){
        $dato = '
        <section class="content-header">
        <h1>
        Vista de imagenes de Unidad
        </h1>
        '.$this->getTimeLine().'
        </section>';

        return $dato;
    }
    private function getTimeLine(){
      $dato = '
      <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="#">Recepción de Unidad</a></li>
      <li><a href="#">Vista de imagenes</a></li>
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
$pagina = new recepcion($section, $subsection);