<?php

class ControladorCategorias{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "controlRecibe";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);
		return $respuesta;		
	}


}