<?php
include_once "config.php";

class MySQL extends config{
    
    public $total_query;
    public $link;
    public $fecha;
    public $section;
	public function __construct($seccion=false){
        parent:: __construct();
        $this->section = $seccion;
        $this->fecha = date("Y-m-d H:i:s");
        $this->link = mysqli_connect(parent::getServer(), parent::getUser(), parent::getPassword()) or die(mysql_error());
        mysqli_select_db( $this->link, parent::getDataBase()) or die(mysqli_error());
	}
	public function getPath($absolute=FALSE){

        $local = TRUE;
        if($local)
            return "http://".$_SERVER['HTTP_HOST']."/frimax/";
        else
            return "http://".$_SERVER['HTTP_HOST']."/frimax/";
	}
    public function getCarpeta($nombre){
        $texto = ($nombre);
        $texto = str_replace(" ", "-", $texto);
        $texto = str_replace("á", "a", $texto);
        $texto = str_replace("é", "e", $texto);
        $texto = str_replace("í", "i", $texto);
        $texto = str_replace("ó", "o", $texto);
        $texto = str_replace("ú", "u", $texto);
        $texto = str_replace("ñ", "n", $texto);
        $texto = str_replace("Á", "a", $texto);
        $texto = str_replace("É", "e", $texto);
        $texto = str_replace("Í", "i", $texto);
        $texto = str_replace("Ó", "o", $texto);
        $texto = str_replace("Ú", "u", $texto);
        $texto = str_replace("Ñ", "n", $texto);

        return $texto;        
    }
	public function query($value){
		$this->total_query++;
		//$result = mysqli_query($value, $this->link);
        $result = $this->link->query($value);

        echo $this->link->error;


		if (!$result){
			exit;
		}
		return $result;
	}
	public function fetch_array($value){
		return mysqli_fetch_array($value);
	}
	public function num_rows($value){
		return mysql_num_rows($value);
	}
	public function fetch_row($value){
		return mysql_fetch_row($value);
	}
	public function fetch_assoc($value){
		return mysql_fetch_assoc($value);
	}
    public function getTitle(){
     $dato='';
        if($this->section == "home"){
            $dato = "Recepción Logística - FRIMAX";
        }else{
            $dato = "Recepción Logística - FRIMAX";
        }

        return $dato;
    }
    public function getActive(){
    	if($_SESSION['id'] != "")
    		return FALSE;//usuario validado
    	else
    		return TRUE;//Usuario no logueado


    }
    public function getNameUsuario($idUser){
    	$sql = $this->fetch_array($this->query('SELECT CONCAT(nombre, " ", paterno, " ", materno) AS nombre FROM usuarios WHERE id = "'.$idUser.'"'));

    	return $sql['nombre'];
    }
    public function getNivelUsuario($level){
    	$sql = $this->fetch_array($this->query('SELECT descripcion FROM in_niveles WHERE id = "'.$level.'"'));

    	return $sql['descripcion'];


    }
    public function getSucursalUsuario($idUser){
    	$sql = $this->fetch_array($this->query('SELECT in_sucursales.nombre FROM in_sucursales 
    	INNER JOIN usuarios ON usuarios.sucursal = in_sucursales.id AND usuarios.id = "'.$idUser.'"'));

    	return $sql['nombre'];
    }
}
?>