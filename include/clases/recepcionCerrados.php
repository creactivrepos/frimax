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
        $this->fecha = date('Y-m-d');
        $this->hora = date("h:i:s");
        $this->info = parent::fetch_array(parent::query('SELECT CONCAT(nombre," ", paterno, " ", materno) AS nombreC, usuarios.* FROM usuarios WHERE id = "'.$this->idUser.'"'));
        $folio = parent::fetch_array(parent::query('SELECT id FROM controlRecibe ORDER BY id DESC LIMIT 1'));
        $this->folio = $folio['id'] + 1;
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
                                        $status = $this->getStatus($inf['status']);
                                        $botones = $this->getBotones($inf['status'], $inf['folio']);
                                        $dato .= '
                                        <tr>
                                            <td>'.$inf['folio'].'</td>
                                            <td>'.$inf['noPedido'].'</td>
                                            <td>'.$inf['nombre'].'</td>
                                            <td>'.$inf['placa'].'</td>
                                            <td>'.$inf['chasis'].'</td>
                                            <td>'.$inf['noSerie'].'</td>
                                            <td>'.$inf['fecha'].'</td>
                                            <td>'.$status.'</td>
                                            <td>'.$botones.'</td>

                                        </tr>';
                                    }
                                    $dato .= '
                                    </tbody>
                                    <tfoot>'.$this->getHeadTable().'</tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    '.$this->getFormNPerfil().$this->getFormEPerfil().'
                </div>
            </section>
        </div>';

        return $dato;
    }
	private function getFormNPerfil(){
		$dato = '
        <div  id="formNPerfil" style="display:none">
            <input type="hidden" id="id" name="id" value="'.$this->getID.'">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Información de Unidad</h3>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            <div class="form-group col-md-9">
                                <label>Responsable de revisión</label>
                                <input type="hidden" value="'.$this->idUser.'" id="responsable">
                                <input type="text" class="form-control" value="'.$this->info['nombreC'].'" readonly/>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Fecha</label>
                                <input type="text" class="form-control" id="fecha" value="'.$this->fecha.'" readonly/>
                            </div>
                            <div class="form-group col-md-9">
                                <label>Cliente</label>
                                <input type="hidden" id="cliente">
                                <input type="text" class="form-control" placeholder="Cliente" id="nombreCliente"/>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Folio</label>
                                <input type="text" class="form-control" id="folio" value="'.$this->folio.'" readonly/>
                            </div>
                            <div class="form-group col-md-5">
                                '.$this->getAsesor().'
                            </div>
                            <div class="form-group col-md-4">
                                '.$this->getResponsable().'
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Ingreso</label>
                                <input type="text" class="form-control" id="hora" value="'.$this->hora.'" readonly/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. de pedido</label>
                                <input type="text" class="form-control" id="nopedido" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. Operación</label>
                                <input type="text" class="form-control" id="nooperacion" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. Serie</label>
                                <input type="text" class="form-control" id="noserie" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Chasis</label>
                                <input type="text" class="form-control" id="chasis" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Modelo</label>
                                <input type="text" class="form-control" id="modelo" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Año</label>
                                <input type="text" class="form-control" id="anio" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Placa</label>
                                <input type="text" class="form-control" id="placa" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Accesorios</h3><br />
                        <small>R = Resguardo en almacen</small>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            '.$this->getAccesorios().'
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Información Adicional</h3>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            <div class="form-group col-md-4">
                                <label>Enciende el tablero</label><br />
                                Si <input type="radio" name="tablero" id="tab_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" name="tablero" id="tab_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-4">
                                <label>Enciende la alarma</label><br />
                                Si <input type="radio" nombre="alarma" id="enc_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" nombre="alarma" id="enc_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-4">
                                <label>Alarma de reversa</label><br />
                                Si <input type="radio" nombre="alarma" id="ala_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" nombre="alarma" id="ala_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kilometraje</label>
                                <input type="text" value="" class="form-control" id="kilometraje"/>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Otro</label>
                                <input type="text" placeholder="Killometraje" value="" class="form-control" id="otro"/>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Observaciones</label>
                                <input type="text" placeholder="Observaciones" class="form-control" id="observaciones"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="addRecepcion" name="addRecepcion">Guardar</button>
                    <button type="button" class="btn btn-primary" id="cancelar" name="cancelar">Cancelar</button>
                </div>
            </div>
        </div>
        ';

	    return $dato;
	}
    private function getFormEPerfil(){
        $dato = '
         <div id="formEPerfil" style="display:none">
            <input type="text" id="eid">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Información de Unidad</h3>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            <div class="form-group col-md-9">
                                <label>Responsable de revisión</label>
                                <input type="hidden" id="eresponsable">
                                <input type="text" class="form-control" id="ename" readonly/>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Fecha</label>
                                <input type="text" class="form-control" id="efecha" readonly/>
                            </div>
                            <div class="form-group col-md-9">
                                <label>Cliente</label>
                                <input type="hidden" id="ecliente">
                                <input type="text" class="form-control" id="enombreCliente"/>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Folio</label>
                                <input type="text" class="form-control" id="efolio" readonly/>
                            </div>
                            <div class="form-group col-md-5">
                                '.$this->getAsesor().'
                            </div>
                            <div class="form-group col-md-4">
                                '.$this->getResponsable().'
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hora de Ingreso</label>
                                <input type="text" class="form-control" id="ehora" readonly/>
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. de pedido</label>
                                <input type="text" class="form-control" id="enopedido" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. Operación</label>
                                <input type="text" class="form-control" id="enooperacion" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>No. Serie</label>
                                <input type="text" class="form-control" id="enoserie" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Chasis</label>
                                <input type="text" class="form-control" id="echasis" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Modelo</label>
                                <input type="text" class="form-control" id="emodelo" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Año</label>
                                <input type="text" class="form-control" id="eanio" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>Placa</label>
                                <input type="text" class="form-control" id="eplaca" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Accesorios</h3><br />
                        <small>R = Resguardo en almacen</small>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            '.$this->getAccesorios().'
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Información Adicional</h3>
                    </div>
                    <div class="box-body">
                        <form role="form">
                            <div class="form-group col-md-4">
                                <label>Enciende el tablero</label><br />
                                Si <input type="radio" name="tablero" id="etab_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" name="tablero" id="etab_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-4">
                                <label>Enciende la alarma</label><br />
                                Si <input type="radio" nombre="alarma" id="eenc_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" nombre="alarma" id="eenc_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-4">
                                <label>Alarma de reversa</label><br />
                                Si <input type="radio" nombre="alarma" id="eala_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                No <input type="radio" nombre="alarma" id="eala_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kilometraje</label>
                                <input type="text" class="form-control" id="ekilometraje"/>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Otro</label>
                                <input type="text" class="form-control" id="eotro"/>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Observaciones</label>
                                <input type="text" class="form-control" id="eobservaciones"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box-footer">';
                if($this->level == "1" OR $this->level == "2"){
                    $dato .= '<a href="descargaRecepcion.php?folio="><button type="button" class="btn btn-primary">PDF</button></a>';
                }
                $dato.= '
                    <button type="button" class="btn btn-primary" id="addRecepcion" name="addRecepcion">Guardar</button>
                    <button type="button" class="btn btn-primary" id="cancelar" name="cancelar">Cancelar</button>
                </div>
            </div>
        </div>
        ';

        return $dato;
    }
    private function getHeadTable(){
        $dato = '
        <tr>
            <th>Folio</th>
            <th>Pedido</th>
            <th>Cliente</th>
            <th>Placa</th>
            <th>Chasis</th>
            <th>No. Serie</th>
            <th>Fecha Recepción</th>
            <th>Status</th>';

        if($this->level == 1 OR $this->level == 2){
            $dato .= '
            <th>Acciones</th>';
        }
        $dato .= '
        </tr>';

        return $dato;
    }
    private function getSQL(){
        $sql = '
            SELECT * FROM controlRecibe
            INNER JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.folio
            INNER JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.folio
            INNER JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente';

            if($this->level != "1"){
                $sql .= ' WHERE controlRecibe.status <> 9 AND id > 1';
            }

        return $sql;
    }
    private function getStatus($tipo){
        $dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

        return $dato;
    }
    private function getBotones($tipo, $id){
        if($this->level == 1 OR $this->level == 2){
            $dato = '
                <a href="#" class="editRecepcion" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
                <a href="#" class="elimRecepcion" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';

            if($tipo == 1){//Entra porque esta activo
                $dato .= '<a href="#" class="susRecepcion" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
            }
            elseif($tipo == 2){//Entra porque esta inactivo
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
            }
            elseif($tipo == 9 AND $this->level == "1"){
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
            }

            return $dato;
        } 
    }
	private function getTitulo(){
        $dato = '
        <section class="content-header">
          <h1>
            Recepción de Unidad
            <small><button type="button" class="btn btn-primary" id="showPerfil">Nueva Unidad</button></small>
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
	private function getAccesorios(){
        $sql = parent::query('SELECT * FROM in_accesorios WHERE status <> 9');
        while($dat = parent::fetch_array($sql)){
            $dato .= '
            <div class="form-group col-md-4">
                <label>'.$dat['nombre'].'</label><br />
                Si <input type="radio" name="'.$dat['nombre'].'" id="'.$dat['id'].'_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No <input type="radio" name="'.$dat['nombre'].'" id="'.$dat['id'].'_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                R  <input type="radio" name="'.$dat['nombre'].'" id="'.$dat['id'].'_3"/>
            </div>';
        }
        
        return $dato;
	}
	private function getAsesor(){
		$sql = parent::query('SELECT CONCAT(nombre, " ", paterno," ", materno) AS nombre, id FROM usuarios');
		$dato = '
		<label>Asesor Comercial</label>
		<select class="form-control" name="sucursal" id="sucursal">
            <option value="">--Seleccione</option>';
		while($dat = parent::fetch_array($sql)){
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
		}
		$dato .= '
		</select>';

		return $dato;
	}
    private function getResponsable(){
        $sql = parent::query('SELECT CONCAT(nombre, " ", paterno," ", materno) AS nombre, id FROM usuarios');
        $dato = '
        <label>Asesor Servicio</label>
        <select class="form-control" name="aresponsable" id="aresponsable">
            <option value="">--Seleccione</option>';
        while($dat = parent::fetch_array($sql)){
            $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
        }
        $dato .= '
        </select>';

        return $dato;
    }
}
$pagina = new recepcion($section, $subsection);