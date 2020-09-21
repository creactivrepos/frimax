<?php 
class config{
    public $esquema;
	public function __construct(){

		date_default_timezone_set("America/Mexico_City");
		$this->esquema = 'local';
		if($this->esquema == 'local'){
			$this->user  		= 'root';
			$this->password 	= '';
			$this->server 		= 'localhost';
			$this->port			= '3306';
			$this->database 	= 'frimax';
		}
		elseif($this->esquema == 'productivo'){
			$this->user         = 'dbo686363322';
            $this->password     = 'MsEQK#W+!9VV';
            $this->server       = 'db686363322.db.1and1.com';
            $this->port         = '3306';
            $this->database     = 'db686363322';
		}
        elseif($this->esquema == 'pruebas'){
			$this->user         = 'tdesyxwd_frimax';
            $this->password     = 'Moro1983582001';
            $this->server       = 'localhost';
            $this->port         = '3306';
            $this->database     = 'tdesyxwd_recepcion_frimax';
		}
		
	}
	public function getUser(){
		return $this->user;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getServer(){
		return $this->server;
	}
	public function getPort(){
		return $this->port;
	}
	public function getDataBase(){
		return $this->database;
	}
	public function getUbicacion(){
		return $this->local;
	}
}
?>