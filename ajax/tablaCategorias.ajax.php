<?php
require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";


class TablaCategorias{

    /*=============================================
  	MOSTRAR LA TABLA DE CATEGORÍAS
    =============================================*/ 

  public $level="1";

    public function getStatus($tipo){
        $dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

        return $dato;
    }

    public function getBotones($tipo,$id,$folio){
        $dato = "<a href='verImagenes.php?folio=".$folio."' target='_blank'><i class='fa fa-image'></i> Ver imágenes </a><br />";

        if($this->level!= 5){

            $dato .= "<a href='#' class='editRecepcion' id='".$id."'><i class='fa fa-edit'></i> Editar </a><br />";
            if($tipo == 1){          
                $dato .= "<a href='#' class='susRecepcion' id='".$id."'><i class='fa fa-warning'></i> Suspender </a><br />";
             }
            elseif($tipo == 2){
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
            }
            elseif($tipo == 9 AND $this->level == 1){
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
            }
         }

        if($this->level != 4 AND $this->level != 5){
            $dato .= "<a href='#' class='elimRecepcion' id='".$id."'><i class='fa fa-trash'></i> Eliminar </a><br />";
        }

        return $dato;
    }


    public function mostrarTabla(){	

        $item = null;
        $valor = null;

        $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);	  		
        $datosJson = '{"data": [';

        for($i = 0; $i < count($categorias); $i++){

           $acciones = "<div class='btn-group'><button class='btn btn-info' idCategoria='".$categorias[$i]["id"]."'><i class='fa fa-picture-o'></i></button><button class='btn btn-warning btnEditarCategoria' idCategoria='".$categorias[$i]["id"]."' data-toggle='modal' data-target='#modalEditarCategoria'><i class='fa fa-pencil'></i></button><button class='btn btn-info' idCategoria='".$categorias[$i]["id"]."'><i class='fa fa-exclamation-triangle'></i></button><button class='btn btn-danger btnEliminarCategoria' idCategoria='".$categorias[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
           $status = $this->getStatus($categorias[$i]["status"]);
           $botones = $this->getBotones($categorias[$i]["status"], $categorias[$i]["id"], $categorias[$i]["folio"]);

           $datosJson.= '[          
             "'.$categorias[$i]["folio"].'",
             "'.$categorias[$i]["noPedido"].'",
             "'.$categorias[$i]["nCliente"].'",
             "'.$categorias[$i]["placa"].'/'.$categorias[$i]["chasis"].'/'.$categorias[$i]["noSerie"].'",
             "'.$categorias[$i]["fecha"].'",
             "'.$categorias[$i]["nRecibe"].'",
             "'.$categorias[$i]["nombre_estatus_actual"].'", 
             "'.$status.'"	,	
             "'.$botones.'"        
       ],';
   }
   $datosJson = substr($datosJson,0,-1);
   $datosJson .= ']

}';

echo $datosJson;

}


}


/*=============================================
ACTIVAR TABLA DE CATEGORÍAS
=============================================*/ 
$activar = new TablaCategorias();
$activar -> mostrarTabla();