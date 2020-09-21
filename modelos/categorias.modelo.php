<?php

require_once "../modelos/conexion.php";

class ModeloCategorias{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarCategorias($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare('SELECT controlRecibe.*, controlAdicional.*, controlVehiculo.*, 
        in_clientes.nombre AS nCliente, 
        CONCAT(usuarios.nombre," ",usuarios.paterno," ",usuarios.materno) AS nRecibe, 
        in_sucursales.nombre AS nSucursal, in_estatus.nombre AS nombre_estatus_actual,
        controlRecibe.id AS controlRecibe_id
        FROM controlRecibe
        LEFT JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.id
        LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id
        LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente 
        LEFT JOIN in_estatus ON controlRecibe.proceso = in_estatus.id
        INNER JOIN usuarios ON usuarios.id = controlRecibe.usuarioRecibe
        INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal');

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;
		
	}


}