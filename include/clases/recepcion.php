<?php 
include "base/pagina.php";
class recepcion extends pagina{

    public $getID;
    public $seccion;
    public $subseccion;
    public $level;
    public $idUser;
    public $filtroCliente;
    public $hora;
    public $filtroStatus;
    public $filtroSucursal;
    public $filtroTipoUnidad;

    public function __construct($section, $subsection=""){

        @session_start();
        parent::__construct($section, $subsection);

        if(!isset($_POST['filtroCliente'])){
            $_POST['filtroCliente'] = false;
        }
        if(!isset($_POST['filtroStatus'])){
            $_POST['filtroStatus'] = false;
        }
        if(!isset($_POST['filtroSucursal'])){
            $_POST['filtroSucursal'] = false;
        }
        if(!isset($_POST['filtroTipoUnidad'])){
            $_POST['filtroTipoUnidad'] = false;
        }

        $this->seccion = $section;
        $this->subseccion = $subsection;

        $this->level = false;
        if(isset($_SESSION['nivel'])){
            $this->level = $_SESSION['nivel'];
        }

        $this->idUser = false;
        if(isset($_SESSION['id'])){
            $this->idUser = $_SESSION['id'];
        }

        $this->fecha = date('Y-m-d');
        $this->hora = date("h:i:s");
        $this->filtroCliente    = $_POST['filtroCliente'];
        $this->filtroStatus     = $_POST['filtroStatus'];
        $this->filtroSucursal   = $_POST['filtroSucursal'];
        $this->filtroTipoUnidad   = $_POST['filtroTipoUnidad'];

        $this->info = parent::fetch_array(parent::query('SELECT CONCAT(nombre," ", paterno, " ", materno) AS nombreC, usuarios.* FROM usuarios WHERE id = "'.$this->idUser.'"'));
        $this->folio = $this->createFolio();
    }

    public function createPage(){
        if($this->idUser != ""){
            $dato = parent::supHalfPage().$this->contenido().parent::infHalfPage();
        }
        else{
            $dato =  parent::showLogin();
        }
        echo $dato;
    }
    private function contenido(){
        $dato = '<div class="content-wrapper contenido">'.$this->getAlerts().$this->getTitulo().'
        <section class="content">
        <div class="row">
        <div class="col-xs-12">
        <div class="box">
        <div class="box-body">
        '.$this->filtros().'
        </div>
        </div>
        </div>
        <div class="col-xs-12 tabla-completa">
        <div class="box">
        <div class="">
        <table id="lista-recepcion" class="table responsive table-striped">
        <thead>'.$this->getHeadTable().'</thead>
        <tbody>';
        $sql = $this->getSQL();
        
        $sql = parent::query($sql);       
        while($inf = parent::fetch_array($sql)){                                        
            $status = $this->getStatus($inf['status']);
            $botones = $this->getBotones($inf['status'], $inf['id'], $inf['folio']);
            $botones_movil = $this->getBotonesMovil($inf['status'], $inf['id'], $inf['folio']);
            $estatus = $inf['nombre_estatus_actual'];

            $dato .= '
            <tr>            
            <td>'.$inf['folio'].'</td>
            <td>'.$inf['noPedido'].'</td>
            <td>'.$inf['nCliente'].'</td>
            <td>'.$inf['placa'].' / '.$inf['chasis'].' / '.$inf['noSerie'].'</td>
            <td>'.$inf['fecha'].'</td>
            <td>'.$inf['nRecibe'].'</td>
            <td>'.$estatus.'</td>
            <td>'.$status.'</td>
            <td>
            <div class="botones">'.$botones.'</div>
            <div class="botones-movil">'.$botones_movil.'</div>
            </td>';
            $dato .= '
            </tr>';
        }
        $dato .= '
        </tbody>
        <tfoot>'.$this->getHeadTable().'</tfoot>
        </table>
        </div>
        </div>
        </div>
        '.$this->getFormEPerfil().'
        </div>
        </section>
        </div>';

        return $dato;
    }


    private function getFormEPerfil(){
        $dato = '
        <div id="formEPerfil" class="oculta fondo-blanco">
        <input type="hidden" id="eid">
        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target="#informacion-unidad">
        <h3 class="box-title">Información de Unidad</h3>
        </div>
        <div class="box-body collapse in" id="informacion-unidad">
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
        '.$this->getMotivos("e").'
        </div>
        <div class="form-group col-md-4">
        '.$this->getResponsable("e").'
        </div>
        <div class="form-group col-md-3">
        <label>Hora de Ingreso</label>
        <input type="text" class="form-control" id="ehora" readonly/>
        </div>
        <div class="col-md-9" style="padding:0px;">
        <div class="form-group col-md-3">
        <label>No. de pedido</label>
        <input type="text" class="form-control" id="enopedido" />
        </div>
        <div class="form-group col-md-3">
        <label>No. Orden de Producción</label>
        <input type="text" class="form-control" id="enooperacion" />
        </div>
        <div class="form-group col-md-3">
        <label>No. Serie del chasis</label>
        <input type="text" class="form-control" id="enoserie" />
        </div>
        <div class="form-group col-md-3">
        '.$this->getTipoUnidad("e").'
        </div>
        <div class="form-group col-md-3">
        <label>Marca</label>
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
        <div class="form-group col-md-6">
        <label>Nombre quien entrega</label>
        <input type="text" class="form-control" id="responsableEntrega" readonly />
        </div>
        <div class="form-group col-md-6">
        <label>Nombre quien entrega</label>
        <input type="text" class="form-control" id="eresponsableTelefono" readonly />
        </div>
        </div>
        <div class=" col-md-3 col-sm-12 form-group">   
        <label>Firma de conformidad con políticas de recepción y entrega de vehículo <span><a href="politicas.php" target="_blank">Ver aqui</a></span></label>  
        <img id="base64image" src="" class="img-thumbnail img-responsive" />
        <div>
        </div>                                
        </div>
        </form>
        </div>
        </div>
        </div>
        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target="#accesorios">
        <h3 class="box-title">Accesorios</h3><br />
        <small>R = Resguardo en almacen</small>
        </div>
        <div class="box-body collapse in" id="accesorios">
        <form role="form" id="eformAccesorios">
        
        </form>
        </div>
        </div>
        </div>
        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" data-target="#informacion-adicional">
        <h3 class="box-title">Información Adicional</h3>
        </div>
        <div class="box-body collapse in" id="informacion-adicional">
        <form role="form">
        <div class="form-group col-md-3">
        <label>Enciende el tablero</label><br />
        Si <input type="radio" name="tablero" id="etab_1" value="si"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="tablero" id="etab_2" value="no"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-3">
        <label>Enciende la alarma</label><br />
        Si <input type="radio" name="alarma" id="eenc_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="alarma" id="eenc_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-3">
        <label>Alarma de reversa</label><br />
        Si <input type="radio" name="reversa" id="eala_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="reversa" id="eala_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>

        <div class="form-group col-md-3">
        <label>Carga de batería</label>
        <input type="text" value="" class="form-control" id="evolts" placeholder="Volts"/>
        </div>
        <div class="form-group col-md-3">
        '.$this->getCombustible("e").'
        </div>
        <div class="form-group col-md-3">
        <label>Kilometraje</label>
        <input type="text" class="form-control" id="ekilometraje"/>
        </div>        
        <div class="form-group col-md-3">
        <label>Otro</label>
        <input type="text" class="form-control" id="eotro"/>
        </div>
        <div class="form-group col-md-3">
        <label>Observaciones</label>
        <input type="text" class="form-control" id="eobservaciones"/>
        </div>
        </form>
        </div>
        </div>
        </div>

        <div class="col-md-12 fondo-blanco chasis">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target=".controlChasis">
        <h3 class="box-title">Medidas de Chasis</h3>
        </div>
        <div class="box-body controlChasis collapse in">
        <form role="form" id="" class="form-inline">


        <div class="row">
        <div class="col-md-12">
        <div class="form-group">
        <label for="rodado">Tipo de chasis</label>
        <select name="rodado" id="rodado" class="form-control">   
        <option value="1">Chasis Rodado Simple</option>
        <option value="2">Chasis Rodado Doble</option>     
        </select>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Largo Carrozable</label></div>
        <input type="text" name="lCarrozable" id="lCarrozable" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div> 
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Altura a piso a Larguero</label></div>
        <input type="text" name="aPLarguero" id="aPLarguero" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Apertura de Largueros</label></div>        
        <input type="text" name="aLarguero" id="aLarguero" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"> <label>Altura de Larguero</label></div>           
        <input type="text" name="alturaLar" id="alturaLar" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Peralte de Larguero</label></div>
        <input type="text" name="pLarguero" id="pLarguero" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Altura Larguero a techo Cabina</label></div>    
        
        <input type="text" name="altCabina" id="altCabina" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Distancia entre ejes</label></div>    
        
        <input type="text" name="dEjes" id="dEjes" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>  

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Distancia de cabina a Centro de Eje Trasero</label></div>    
        
        <input type="text" name="diCabCenEjeTras" id="diCabCenEjeTras" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>        
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Distancia de cabina a Centro de Eje Delantero</label></div>    
        
        <input type="text" name="diCabCenEjeDelan" id="diCabCenEjeDelan" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label>Volado trasero</label></div>    

        <input type="text" name="volTras" id="volTras" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="form-group">
        <div class="input-group">
        <div class="input-group-addon"><label class="control-label">Largo total de chasis</label></div>    

        <input type="text" name="lTotalChas" id="lTotalChas" class="form-control"/>
        <div class="input-group-addon">mm</div>
        </div>
        </div>
        </div>

        </div>

        <div class="row">
        <div class="col-sm-12">
        <div class="text-muted text-left" >*Nota:Las unidades de medida para el chasis son en (mm).</div>
        </div>
        </div>

        </form>
        </div>
        </div>
        </div>

        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target=".estatus-imagenes">
        <h3 class="box-title">Imágenes de seguimiento y entrega</h3>
        </div>
        <div class="box-body estatus-imagenes collapse in">

        <div class="tab-wrapper">
        <ul class="nav nav-pills tabs">
        <li class="active"><a data-toggle="pill" href="#seguimiento">Imágenes de recepcion</a></li>
        <li><a data-toggle="pill" href="#entrega">Imágenes de entrega</a></li>                            
        </ul>
        </div>
        <div class="tab-content ">
        <div id="seguimiento" class="tab-pane fade in active">
        <form role="form" id="uploadPictures">';
        if($this->level != 5){
            $dato .= '
            <div class="form-group col-md-4">
            <label>Fotos Frente</label>
            <input type="file" class="form-control" id="subirFrente" name="subirdelantera"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos izquierda</label>
            <input type="file" class="form-control" id="subirIzquierda" name="subirizquierda"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos Derecha</label>
            <input type="file" class="form-control" id="subirDerecha" name="subirderecha"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos traseras</label>
            <input type="file" class="form-control" id="subirTrasera" name="subirtrasera"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos tablero y número de serie</label>
            <input type="file" class="form-control" id="subirIfe" name="subirife"/>
            </div>
            <div class="form-group col-md-4">
            <label>Otras  motor, batería y otros</label>
            <input type="file" class="form-control" id="subirOtro" name="subirotro"/>
            </div>
            <div class="form-group col-md-4 col-md-push-4">
            <label>Fotos INE</label>
            <input type="file" class="form-control" id="subirIne" name="subirine"/>
            </div>';
        }
        $dato .= '
        </form>
        </div>

        <div id="entrega" class="tab-pane fade">
        <form role="form" id="uploadPicturesEntrega">';
        if($this->level != 5){
            $dato .= '
            <div class="form-group col-md-4">
            <label>Fotos Frente</label>
            <input type="file" class="form-control" id="subirFrenteEntrada" name="subirdelanteraEntrada"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos izquierda</label>
            <input type="file" class="form-control" id="subirIzquierdaEntrada" name="subirizquierdaEntrada"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos Derecha</label>
            <input type="file" class="form-control" id="subirDerechaEntrada" name="subirderechaEntrada"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos traseras</label>
            <input type="file" class="form-control" id="subirTraseraEntrada" name="subirtraseraEntrada"/>
            </div>
            <div class="form-group col-md-4">
            <label>Fotos Tablero y Numero de serie</label>
            <input type="file" class="form-control" id="subirIfeEntrada" name="subirifeEntrada"/>
            </div>
            <div class="form-group col-md-4">
            <label>Otras motor, batería y otros</label>
            <input type="file" class="form-control" id="subirOtroEntrada" name="subirotroEntrada"/>
            </div>
            <div class="form-group col-md-4 col-md-push-4">
            <label>Fotos INE</label>
            <input type="file" class="form-control" id="subirIneEntrada" name="subirineEntrada"/>
            </div>';
        }
        $dato .= '
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>



        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target=".estatus-seguimiento">
        <h3 class="box-title">Estatus de seguimiento</h3>
        </div>
        <div class="box-body estatus-seguimiento collapse in">
        <form role="form" id="">
        <div class="col-md-12 form-group text-center">
        <label for="estatusActual">Ubicación Actual</label>
        <div id="estatusActual" class="text-muted"></div>
        </div>
        <div class="form-group col-md-4">
        <label>Fecha de Terminado</label>
        <input type="date" class="form-control" id="fechaTermino" name="fechaTermino">
        </div>
        <div class="form-group col-md-4">
        <label>Ubicación</label>
        '.$this->getStatusProceso().'
        </div>
        <div class="form-group col-md-4">
        <label>Fecha de Entrega</label>
        <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" disabled="true">
        </div>
        </form>
        </div>
        </div>
        </div>



        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" title="Colapsar" data-target=".firmaRecepcion">
        <h3 class="box-title">Información de Entrega</h3>
        </div>
        <div class="box-body firmaRecepcion collapse in" style="display:none;">
        <form role="form" id="">
        <div class="form-group col-md-4 signature-component">
        <label>Firma quien recibe</label>
        <canvas id="signature-pad" width="340" height="170"></canvas>
        <div>
        <span class="btn btn-primary" id="saveRecepcion">Guardar</span>
        <span class="btn btn-danger" id="clearRecepcion">Limpiar</span> 
        <span> <input type="hidden" id="firmaDRecepcion"></span>
        <span> <input type="hidden" value="'.$this->idUser.'" id="Usuariolog"></span>        
        </div>  
        </div>
        <div class="col-md-8"> 
        <div class="form-group col-md-6">        
        <label>Nombre quien recibe</label>
        <input type="text" class="form-control" id="responsableRecibe" />
        </div>
        <div class="form-group col-md-6">        
        <label>Teléfono de quien recibe</label>
        <input type="text" class="form-control" id="telefonoRecibe" />
        </div>
        <div class="form-group col-md-6">
        <label>Entrega de compresor A/A</label><br />
        Si <input type="radio" name="ecarga" id="ecarga_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="ecarga" id="ecarga_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-6">
        <label>Entrega de Molduras</label><br />
        Si <input type="radio" name="eaire" id="eaire_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="eaire" id="eaire_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>


        <div class="col-md-12 botones-editar">
        <div class="box-footer">';
        //if($this->level == "1" OR $this->level == "2"){
        $dato .= '<a id="linkPDF" target="_blank"><button type="button" class="btn btn-primary">PDF Impresion</button></a>&nbsp;';
        $dato .= '<a id="linkPRV" target="_blank"><button type="button" class="btn btn-primary">Vista Previa</button></a>';
        //}
        $dato.= '
        <a id="linkIMG" target="_blank"><button type="button" class="btn btn-primary">Ver Imagenes</button></a>
        <button type="button" class="btn btn-primary" id="updRecepcion" name="updRecepcion">Guardar</button>
        <button type="button" class="btn btn-primary cancela-edita-recepcion" id="cancelar" name="cancelar">Cancelar</button>
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
        <th>Placa / Chasis / No. Serie</th>
        <th>Fecha Recepción</th>
        <th>Nombre Recibe</th>
        <th>Estatus Actual</th>
        <th>Status</th>
        <th>Acciones</th>
        
        </tr>';

        return $dato;
    }
    private function getSQL(){
        $sql = '
        SELECT controlRecibe.*, controlAdicional.*, controlVehiculo.*, 
        in_clientes.nombre AS nCliente, 
        CONCAT(usuarios.nombre," ",usuarios.paterno," ",usuarios.materno) AS nRecibe, 
        in_sucursales.nombre AS nSucursal, in_estatus.nombre AS nombre_estatus_actual,
        controlRecibe.id AS controlRecibe_id
        FROM controlRecibe
        LEFT JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.id
        LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id
        LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente 
        LEFT JOIN in_estatus ON controlRecibe.proceso = in_estatus.id
        LEFT JOIN in_tipo_unidad ON in_tipo_unidad.id = controlVehiculo.idTipoUnidad 
        INNER JOIN usuarios ON usuarios.id = controlRecibe.usuarioRecibe
        INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal '.$this->getFilterSucursal().$this->getFilter();

        return $sql;
    }
    private function getFilterSucursal(){
        $idSuc = parent::fetch_array(parent::query('SELECT sucursal FROM usuarios WHERE id = "'.$this->idUser.'"'));
        $idSuc = $idSuc['sucursal'];
        if($this->level != 1 AND $this->level != 2){
            $sql = ' AND in_sucursales.id = "'.$idSuc.'"';
        }
        else{
            $sql = '';
        }
        return $sql;
    }
    private function getFilter(){
        $sql = '';
        $whereCliente = $this->filtroCliente != '' ? ' in_clientes.id = "'.$this->filtroCliente.'"' : '';
        $whereSucursal = $this->filtroSucursal != '' ? ' in_sucursales.id = "'.$this->filtroSucursal.'"' : '';
        $whereStatus = $this->filtroStatus != '' ? ' controlRecibe.proceso = "'.$this->filtroStatus.'"' : '';
        $whereTipoUnidad = $this->filtroTipoUnidad != '' ? ' in_tipo_unidad.id = "'.$this->filtroTipoUnidad.'"' : '';


        if($this->level != "1"){
            $sql .= ' WHERE controlRecibe.status <> 9 ';
            if($whereCliente != '')
                $sql .= ' AND '.$whereCliente;

            if($whereSucursal != '')
                $sql .= ' AND '.$whereSucursal;

            if($whereStatus != '')
                $sql .= ' AND '.$whereStatus;

            if($whereTipoUnidad != '')
                $sql .= ' AND '.$whereTipoUnidad;
        }
        else{

            if($whereCliente != ''){
                $sql .= ' WHERE '.$whereCliente;
                if($whereSucursal != '')
                    $sql .= ' AND '.$whereSucursal;
                if($whereStatus != '')
                    $sql .= ' AND '.$whereStatus;
                if($whereTipoUnidad != '')
                    $sql .= ' AND '.$whereTipoUnidad;
            }
            elseif($whereSucursal != ''){

                $sql .= ' WHERE '.$whereSucursal;
                if($whereStatus != '')
                    $sql .= ' AND '.$whereStatus;
                if($whereTipoUnidad != '')
                    $sql .= ' AND '.$whereTipoUnidad;
            }
            elseif($whereStatus != ''){                
                $sql .= ' WHERE '.$whereStatus;

                if($whereTipoUnidad != '')
                    $sql .= ' AND '.$whereTipoUnidad;
            }
            elseif($whereTipoUnidad != ''){
                $sql .= ' WHERE '.$whereTipoUnidad;                          
            }        
            else{
                $sql .= ' WHERE controlRecibe.proceso <> 3 ';
            }           
        }

        return $sql;
    }
    private function getStatus($tipo){
        $dato = $tipo == 1 ? "Activo" : ($tipo == 2 ? "Inactivo" : "Eliminado");

        return $dato;
    }
    private function getEstatus($tipo){
        $sql = parent::fetch_array(parent::query('SELECT nombre FROM in_estatus WHERE id = "'.$tipo.'"'));

        $dato = $sql['nombre'];

        return $dato;
    }
    private function getStatusProceso(){
        $dato = '
        <select class="form-control" name="proceso" id="proceso">
        <option value="">--Seleccione</option>';

        $sql = parent::query('SELECT * FROM in_estatus');
        while($dat = parent::fetch_array($sql)){
            $dato .= '<option value="'.$dat['id'].'">'.$dat['nombre'].'</option>';
        }
        $dato .= '
        </select>';


        return $dato;
    }
    private function getBotones($tipo, $id, $folio=""){
        $dato = '<a href="verImagenes.php?folio='.$folio.'" target="_blank"><i class="fa fa-image"></i> Ver imágenes </a><br />';

        if($this->level != 5){
            $dato .= '<a href="#" class="editRecepcion" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />';
            if($tipo == 1){    
                $dato .= '<a href="#" class="susRecepcion" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
            }
            elseif($tipo == 2){//Entra porque esta inactivo
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Activar </a><br />';
            }
            elseif($tipo == 9 AND $this->level == 1){
                $dato .= '<a href="#" class="actRecepcion" id="'.$id.'"><i class="fa fa-check"></i> Re-Activar </a><br />';
            }
//$dato .= '<a href="#" class="susRecepcion" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';
        }
        if($this->level != 4 AND $this->level != 5){
            $dato .= '<a href="#" class="elimRecepcion" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';
        }

        return $dato;



/*if($this->level == 1 OR $this->level == 2){
$dato .= '

<a href="#" class="editRecepcion" id="'.$id.'"><i class="fa fa-edit"></i> Editar </a><br />
<a href="#" class="elimRecepcion" id="'.$id.'"><i class="fa fa-trash"></i> Eliminar </a><br />';
$dato .= '
<a href="#" class="susRecepcion" id="'.$id.'"><i class="fa fa-warning"></i> Suspender </a><br />';

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
} */
}

private function getBotonesMovil($tipo, $id, $folio=""){

    $dato = '<select title="Selecciona una acción"  class="selectAccion form-control">';
    $dato = $dato.'<option value="-1">Acción</option>';
    $dato = $dato.'<option value="ver-imagenes|'.$folio.'">';
    $dato = $dato."Ver imágenes";
    $dato = $dato."</option>";
    if($this->level != 5) {
        $dato = $dato."<option value='editRecepcion|$id'>";
        $dato = $dato."Editar";
        $dato = $dato."</option>";
        if($tipo == 1){
            $dato = $dato."<option value='susRecepcion|$id'>";
            $dato = $dato."Suspender";
            $dato = $dato."</option>";
        }
        elseif($tipo == 2){
            $dato = $dato."<option value='actRecepcion|$id'>";
            $dato = $dato."Activar  ";
            $dato = $dato."</option>";
        }
        elseif($tipo == 9 AND $this->level == 1){
            $dato = $dato."<option value='actRecepcion|$id'>";
            $dato = $dato." Re-Activar ";
            $dato = $dato."</option>";
        }

        if($this->level != 4 AND $this->level != 5){
            $dato = $dato."<option value='elimRecepcion|$id'>";
            $dato = $dato."Eliminar";
            $dato = $dato."</option>";
        }
    }
    $dato = $dato.'</select>';
    return $dato;
}

private function getTitulo(){
    $dato = '
    <section class="content-header">
    <h1>
    Recepción de Unidad';
    if($this->level != 5){
        $dato .= '&nbsp;<a href="formulario.php"><small><button type="button" class="btn btn-primary" id="showPerfil">Nueva Unidad</button></small></a>';
        $dato .= '&nbsp;<small><button id="descargaLista" type="button" class="btn btn-primary">Descarga Lista CSV</button></small>';
    }

    //  if($this->level == 1 OR $this->level == 2 OR $this->level == 3 OR $this->level == 4) {
    //     $dato .= '&nbsp;<small><button id="descargaLista" type="button" class="btn btn-primary">Descarga Lista CSV</button></small>';
    // }
    // 
    $dato .= '
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

private function getTipoUnidad($tipo= ""){

    $sel = '';
    $sql = parent::query('SELECT * FROM in_tipo_unidad ORDER BY nombre');
    $dato = '
    <label>Tipo de Unidad</label>
    <select class="form-control" name="'.$tipo.'tipoUnidad" id="'.$tipo.'tipoUnidad">
    <option value="">--Seleccione</option>';
    while($dat = parent::fetch_array($sql)){
       $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
   }
   $dato .= '
   </select>';

   return $dato;
}

private function getMotivos($tipo= ""){
    $sel = '';
    $sql = parent::query('SELECT * FROM in_motivosIngreso ORDER BY nombre');
    $dato = '
    <label>Motivo de Ingreso</label>
    <select class="form-control" name="'.$tipo.'sucursal" id="'.$tipo.'sucursal">
    <option value="">--Seleccione</option>';
    while($dat = parent::fetch_array($sql)){
        $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['abreviacion'].' - '.utf8_encode($dat['nombre']).'</option>';
    }
    $dato .= '
    </select>';

    return $dato;
}
private function getResponsable($tipo = ""){
    $sel = '';
    $sql = parent::query('SELECT CONCAT(nombre, " ", paterno," ", materno) AS nombre, id FROM usuarios WHERE nivel=5 ORDER BY nombre ASC');
    $dato = '
    <label>Asesor Comercial</label>
    <select class="form-control" name="'.$tipo.'aresponsable" id="'.$tipo.'aresponsable">
    <option value="">--Seleccione</option>';
    while($dat = parent::fetch_array($sql)){
        $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.($dat['nombre']).'</option>';
    }
    $dato .= '
    </select>';

    return $dato;
}
private function getCombustible($tipo=''){
    $dato = '
    <label>Nivel de Combustible</label>
    <select class="form-control" name="'.$tipo.'combustible" id="'.$tipo.'combustible">
    <option value="">--Seleccione</option>
    <option value="0">Vacio</option>
    <option value="1"> 1/8 </option>
    <option value="2"> 1/4 </option>
    <option value="3"> 3/8 </option>
    <option value="4"> 1/2 </option>
    <option value="5"> 5/8 </option>
    <option value="6"> 3/4 </option>
    <option value="7"> 7/8 </option>
    <option value="8"> Lleno </option>
    </select>';

    return $dato;   
}
private function createFolio(){
    $sel = parent::fetch_array(parent::query('SELECT in_sucursales.clave, usuarios.sucursal 
        FROM usuarios 
        INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal
        WHERE usuarios.id = "'.$this->idUser.'"'));

    $inc = parent::fetch_array(parent::query('SELECT consecutivo FROM in_folios WHERE idSucursal = "'.$sel['sucursal'].'" ORDER BY consecutivo DESC LIMIT 1'));

    $dig = $this->cuatroDigitos($inc['consecutivo']+1);
    $folio = $sel['clave']."-".$dig;

    return $folio;
}
private function cuatroDigitos($dato){
    $dat = $dato;
    $in = strlen($dato);
    for($x=$in;$x<4;$x++){
        $dat = "0".$dat;
    }

    return $dat;
}
private function filtros(){
    $dato = '';
    $dato = $dato.'<form action="recepcion.php" method="POST">';
    $dato = $dato.'<div class="col-xs-12 col-md-3 form-group">';
    $dato = $dato.'Clientes <br />';
    $dato = $dato.$this->getSQLfiltro("C");
    $dato = $dato.'</div>';
    $dato = $dato.'<div class="col-xs-12 col-md-2 form-group">';
    $dato = $dato.'Estatus <br />';
    $dato = $dato.$this->getSQLfiltro("E");
    $dato = $dato.'</div>';
    $dato = $dato.'<div class="col-xs-12 col-md-2 form-group">';
    $dato = $dato.'Tipo Vehiculo <br />';
    $dato = $dato.$this->getSQLfiltro("T");
    $dato = $dato.'</div>';
    if($this->level != 3){
        $dato = $dato.'<div class="col-xs-12 col-md-2 form-group">';
        $dato = $dato.'Sucursales <br />';
        $dato = $dato.$this->getSQLfiltro("S");
        $dato = $dato.'</div>';
    }
    $dato = $dato.'<div class="col-xs-12 col-md-3 form-group"><br>';
    $dato = $dato.'<input type="submit" class="btn btn-primary form-control" value="Filtrar">';
    $dato = $dato.'</div>';
    $dato = $dato.'</form>';
    return $dato;
}
private function getSQLfiltro($inf){
    $tabla = $inf == "C" ? "in_clientes" : ($inf == "E" ? "in_estatus" : ($inf == "S" ? "in_sucursales" : "in_tipo_unidad"));
    $idSel = $inf == "C" ? "filtroCliente" : ($inf == "E" ? "filtroStatus" : ($inf == "S" ? "filtroSucursal" : "filtroTipoUnidad"));
    $idCmp = $inf == "C" ? $this->filtroCliente : ($inf == "E" ? $this->filtroStatus : ($inf == "S" ? $this->filtroSucursal : $this->filtroTipoUnidad));

    $sql = parent::query('SELECT id, nombre FROM '.$tabla);

    $dato = '<select class="form-control" id="'.$idSel.'" name="'.$idSel.'">';
    $dato = $dato.'<option value="">-- Seleccione</option>';

    while($dat = parent::fetch_array($sql)){
        $sel = $idCmp == $dat['id'] ? "selected" : "";
        $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['nombre'].'</option>';
    }
    $dato .= '</select>';

    return $dato;
}
}

$pagina = new recepcion($section, $subsection);