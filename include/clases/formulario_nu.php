<?php
include "base/pagina.php";
class recepcion extends pagina{
    public $getID;
    public $seccion;
    public $subseccion;
    public $level;

    public $hora;
    public $filtroCliente;
    public $filtroStatus;
    public $filtroSucursal;
    public $info;
    public $folio;

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

        $this->seccion = $section;
        $this->subseccion = $subsection;

        if(isset($_SESSION['nivel'])) {
            $this->level = $_SESSION['nivel'];
        }
        if(isset($_SESSION['id'])) {
            $this->idUser = $_SESSION['id'];

        }
        $this->fecha = date('Y-m-d');
        $this->hora = date("h:i:s");
        $this->filtroCliente    = $_POST['filtroCliente'];
        $this->filtroStatus     = $_POST['filtroStatus'];
        $this->filtroSucursal   = $_POST['filtroSucursal'];

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
        $dato = '
        <div class="content-wrapper">
        '.$this->getAlerts().'
        <section class="content">
        <div class="row">
        <div class="col-xs-12"> 
        </div>
        '.$this->getFormNPerfil().'
        </div>
        </section>
        </div>';

        return $dato;
    }
    private function getFormNPerfil(){
        $dato = '';
        $nombreCliente = false;
        $cliente = false;
        if(isset($_COOKIE['nombreCliente'])){
            $nombreCliente = $_COOKIE['nombreCliente'];

            $dato = $dato.'<input type="hidden" id="nombreClienteCookie"  value="'.$nombreCliente.'">';
        }
        if(isset($_COOKIE['cliente'])){
            $cliente = $_COOKIE['cliente'];
            $dato = $dato.'<input type="hidden" id="clienteCookie"  value="'.$cliente.'">';
        }
        if(isset($_COOKIE['sucursal'])){
            $sucursal = $_COOKIE['sucursal'];
            $dato = $dato.'<input type="hidden" id="sucursalCookie"  value="'.$sucursal.'">';
        }
        if(isset($_COOKIE['aresponsable'])){
            $aresponsable = $_COOKIE['aresponsable'];
            $dato = $dato.'<input type="hidden" id="aresponsableCookie"  value="'.$aresponsable.'">';
        }
        if(isset($_COOKIE['nopedido'])){
            $nopedido = $_COOKIE['nopedido'];
            $dato = $dato.'<input type="hidden" id="nopedidoCookie"  value="'.$nopedido.'">';
        }
        if(isset($_COOKIE['nooperacion'])){
            $nooperacion = $_COOKIE['nooperacion'];
            $dato = $dato.'<input type="hidden" id="nooperacionCookie"  value="'.$nooperacion.'">';
        }
        if(isset($_COOKIE['noserie'])){
            $noserie = $_COOKIE['noserie'];
            $dato = $dato.'<input type="hidden" id="noserieCookie"  value="'.$noserie.'">';
        }
        if(isset($_COOKIE['nooperacion'])){
            $nooperacion = $_COOKIE['nooperacion'];
            $dato = $dato.'<input type="hidden" id="nooperacionCookie"  value="'.$nooperacion.'">';
        }
        if(isset($_COOKIE['chasis'])){
            $chasis = $_COOKIE['chasis'];
            $dato = $dato.'<input type="hidden" id="chasisCookie"  value="'.$chasis.'">';
        }
        if(isset($_COOKIE['modelo'])){
            $modelo = $_COOKIE['modelo'];
            $dato = $dato.'<input type="hidden" id="modeloCookie"  value="'.$modelo.'">';
        }
        if(isset($_COOKIE['anio'])){
            $anio = $_COOKIE['anio'];
            $dato = $dato.'<input type="hidden" id="anioCookie"  value="'.$anio.'">';
        }
        if(isset($_COOKIE['placa'])){
            $placa = $_COOKIE['placa'];
            $dato = $dato.'<input type="hidden" id="placaCookie"  value="'.$placa.'">';
        }
        if(isset($_COOKIE['accesorios'])){
            $accesorios = unserialize($_COOKIE['accesorios']);


            foreach ($accesorios as $accesorio){
                $accesoriosSplit = explode('_',$accesorio);
                if($accesoriosSplit[0] == 'tab') {
                    $dato = $dato . '<input type="hidden" id="tabCookie"   value="' . $accesorio . '">';
                }
                if($accesoriosSplit[0] == 'enc') {
                    $dato = $dato . '<input type="hidden" id="encCookie"   value="' . $accesorio . '">';
                }
                if($accesoriosSplit[0] == 'ala') {
                    $dato = $dato . '<input type="hidden" id="alaCookie"   value="' . $accesorio . '">';
                }
            }

        }

        if(isset($_COOKIE['combustible'])){
            $combustible = $_COOKIE['combustible'];
            $dato = $dato.'<input type="hidden" id="combustibleCookie"  value="'.$combustible.'">';
        }

        if(isset($_COOKIE['kilometraje'])){
            $kilometraje = $_COOKIE['kilometraje'];
            $dato = $dato.'<input type="hidden" id="kilometrajeCookie"  value="'.$kilometraje.'">';
        }

        if(isset($_COOKIE['otro'])){
            $otro = $_COOKIE['otro'];
            $dato = $dato.'<input type="hidden" id="otroCookie"  value="'.$otro.'">';
        }

        if(isset($_COOKIE['observaciones'])){
            $observaciones = $_COOKIE['observaciones'];
            $dato = $dato.'<input type="hidden" id="observacionesCookie"  value="'.$observaciones.'">';
        }


        $dato = $dato.'
        <div  id="formNPerfil" >
        <input type="hidden" id="id" name="id" value="'.$this->getID.'">
        <div class="col-md-12">
        <div class="box box-warning">
        <div class="box-header">
        <h3 class="box-title">Información de Unidad</h3>
        <button type="button" id="btnInfoUnidad" class="btn btn-primary">Carga Información de Unidad Anterior</button>
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
        <input type="tehiddenxt" class="form-control" id="fecha" value="'.$this->fecha.'" readonly/>
        </div>
        <div class="form-group col-md-9">
        <label>Cliente</label>
        <input type="hidden" id="cliente">
        <input type="text" class="form-control" placeholder="Cliente" id="nombreCliente"/>
        <div style="" id="listClient">
        </div>
        </div>
        <div class="form-group col-md-3">
        <label>Folio</label>
        <input type="text" class="form-control" id="folio" value="'.$this->folio.'" readonly/>
        </div>
        <div class="form-group col-md-5">
        '.$this->getMotivos().'
        </div>
        <div class="form-group col-md-4">
        '.$this->getResponsable().'
        </div>
        <div class="form-group col-md-3">
        <label>Hora de Ingreso</label>
        <input type="text" class="form-control" id="hora" value="'.$this->hora.'" readonly/>
        </div>

        <div class="col-md-9" style="padding:0px;">
        <div class="form-group col-md-3">
        <label>No. de pedido</label>
        <input type="text" class="form-control" id="nopedido" />
        </div>
        <div class="form-group col-md-3">
        <label>No. Orden de Producción</label>
        <input type="text" class="form-control" id="nooperacion" />
        </div>
        <div class="form-group col-md-3">
        <label>No. Serie del Chasis</label>
        <input type="text" class="form-control" id="noserie" />
        </div>
        <div class="form-group col-md-3">
        '.$this->getTipoUnidad().'
        </div>
        <div class="form-group col-md-3">
        <label>Marca</label>
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
        <div class="form-group col-md-6">
        <label>Nombre quien entrega</label>
        <input type="text" class="form-control" id="responsableEntrega" />
        </div>
        <div class="form-group col-md-6">
        <label>Teléfono quien entrega</label>
        <input type="text" class="form-control" id="responsableTelefono" />
        </div>
        </div>

        <div class=" col-md-3 col-sm-12 signature-component form-group">   

        <label>Firma de conformidad con políticas de recepción y entrega de vehículo <span><a href="politicas.php" target="_blank">Ver aqui</a></span></label>
        <canvas id="signature-pad" width="340" height="170"></canvas>
        <div>
        <span class="btn btn-primary" id="save">Guardar</span>
        <span class="btn btn-danger" id="clear">Limpiar</span> 
        <span> <input type="hidden" id="firmaDigital"></span>
        </div>                                
        </div>
        </form>
        </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="box box-warning">
        <div class="box-header">
        <h3 class="box-title">Accesorios</h3><br />
        <button type="button" id="btnAccesorios" class="btn btn-primary">Carga Información de Accesorios Anterior</button><br>
        <small>Cant. = Cantidad por cada accesorio</small>
        </div>
        <div class="box-body">
        <form role="form" id="formAccesorios">

        </form>
        </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="box box-warning">
        <div class="box-header">
        <h3 class="box-title">Información Adicional</h3><br>
        <button type="button" id="btnInfAdicional" class="btn btn-primary">Carga Información de Adicional Anterior</button><br>
        </div>
        <div class="box-body">
        <form role="form">
        <div class="form-group col-md-3">
        <label>Enciende el tablero</label><br />
        Si <input type="radio" name="tablero" class="tablero" id="tab_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="tablero" class="tablero" id="tab_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-3">
        <label>Enciende la alarma</label><br />
        Si <input type="radio" name="alarma" id="enc_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="alarma" id="enc_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-3">
        <label>Alarma de reversa</label><br />
        Si <input type="radio" name="reversa" id="ala_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="reversa" id="ala_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>

        <div class="form-group col-md-3">
        <label>Carga de batería</label>
        <input type="text" value="" class="form-control" id="volts" placeholder="Volts"/>
        </div>
        <div class="form-group col-md-3">
        '.$this->getCombustible().'
        </div>        

        <div class="form-group col-md-3">
        <label>Kilometraje</label>
        <input type="text" value="" class="form-control" id="kilometraje" placeholder="Kilometraje"/>
        </div>

        <div class="form-group col-md-3">
        <label>Otro</label>
        <input type="text" value="" class="form-control" id="otro"/>
        </div>
        <div class="form-group col-md-3">
        <label>Observaciones</label>
        <input type="text" placeholder="Observaciones" class="form-control" id="observaciones"/>
        </div>
        </form>
        </div>
        </div>
        </div>
        <div class="col-md-12 fondo-blanco">
        <div class="box box-warning">
        <div class="box-header titulo-collapse" data-toggle="collapse" data-target="#anomalias-vehiculo">
        <h3 class="box-title">Anomalias del vehiculo</h3>
        </div>
        <div class="box-body collapse in" id="anomalias-vehiculo" ">
        <form id="canvasAnomalias" method="POST" action="#" ENCTYPE="multipart/form-data" role="form">
        '.$this->getAnomalias().'
        </form>
        </div>
        </div>
        </div>


        <div class="col-md-12" style="display:none" id="showErrors"><div class="box-footer" id="spcError" style="color:red"></div></div>

        <div class="col-md-12">
        <div class="box-footer">

        <button type="button" class="btn btn-primary" id="addRecepcion" name="addRecepcion" >Finalizar</button>

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

        <th>Acciones</th>
        <th>Folio</th>
        <th>Pedido</th>
        <th>Cliente</th>
        <th>Placa / Chasis / No. Serie</th>
        <th>Fecha Recepción</th>
        <th>Nombre Recibe</th>
        <th>Estatus Actual</th>
        <th>Status</th>
        </tr>';

        return $dato;
    }
    private function getSQL(){
        $sql = '
        SELECT controlRecibe.*, controlAdicional.*, controlVehiculo.*, in_clientes.nombre AS nCliente, CONCAT(usuarios.nombre," ",usuarios.paterno," ",usuarios.materno) AS nRecibe, in_sucursales.nombre AS nSucursal
        FROM controlRecibe
        LEFT JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.id
        LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id
        LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente 
        INNER JOIN usuarios ON usuarios.id = controlRecibe.usuarioRecibe
        INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal'.$this->getFilterSucursal().$this->getFilter();

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


        if($this->level != "1"){
            $sql .= ' WHERE controlRecibe.status <> 9 ';
            if($whereCliente != '')
                $sql .= ' AND '.$whereCliente;

            if($whereSucursal != '')
                $sql .= ' AND '.$whereSucursal;

            if($whereStatus != '')
                $sql .= ' AND '.$whereStatus;
        }
        else{
            if($whereCliente != ''){
                $sql .= ' WHERE '.$whereCliente;
                if($whereSucursal != '')
                    $sql .= ' AND '.$whereSucursal;

                if($whereStatus != '')
                    $sql .= ' AND '.$whereStatus;
            }
            elseif($whereSucursal != ''){
                $sql .= ' WHERE '.$whereSucursal;
                if($whereStatus != '')
                    $sql .= ' AND '.$whereStatus;
            }
            elseif($whereStatus != '')
                $sql .= ' WHERE '.$whereStatus;
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
            if($tipo == 1){//Entra porque esta activo
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

    private function getAnomalias(){
        $dato = '
        <div class="row">
        <div class="form-group col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Lateral Izquierdo</label><br />
        <canvas id="canvasIzq" name="anomalias"></canvas>
        <input type="hidden" name="imagenCanvasIzq" id="imagenCanvasIzq" />
        <span type="button" name="canvasIzq" class="btn btn-xs btn-danger" id="btnCanvasIzq">Clear</span>
        </div>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Lateral Derecho</label><br />
        <canvas id="canvasDer" name="anomalias"></canvas>
        <input type="hidden" name="imagenCanvasDer" id="imagenCanvasDer" />
        <span type="button" name="canvasDer" class="btn btn-xs btn-danger" id="btnCanvasDer">Clear</span>

        </div>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Arriba</label><br />
        <canvas id="canvasArriba" name="anomalias"></canvas> 
        <input type="hidden" name="imagenCanvasArriba" id="imagenCanvasArriba" />
        <span type="button" name="canvasArriba" class="btn btn-xs btn-danger" id="btnCanvasArriba">Clear</span>       
        </div>
        </div>
        <div class="row">
        <div class="form-group  col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Asientos</label><br />
        <canvas id="canvasSeat" name="anomalias"></canvas>
        <input type="hidden" name="imagenCanvasSeat" id="imagenCanvasSeat" />
        <span type="button" name="canvasSeat" class="btn btn-xs btn-danger" id="btnCanvasSeat">Clear</span>
        </div> 
        <div class="form-group  col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Frente</label><br />
        <canvas id="canvasFrente" name="anomalias"></canvas>
        <input type="hidden" name="imagenCanvasFrente" id="imagenCanvasFrente" />
        <span type="button" name="canvasFrente" class="btn btn-xs btn-danger" id="btnCanvasFrente">Clear</span>
        </div> 
        <div class="form-group  col-md-4 col-sm-6 col-xs-12 centrado">
        <label>Tablero</label><br />
        <canvas id="canvasInterior" name="anomalias"></canvas>
        <input type="hidden" name="imagenCanvasInterior" id="imagenCanvasInterior" />
        <span type="button" name="canvasInterior" class="btn btn-xs btn-danger" id="btnCanvasInterior">Clear</span>
        </div> 
        </div>                        
        ';

        return $dato;
    }


    private function getTitulo(){
        $dato = '
        <section class="content-header" >
        <h1>
        Recepción de Unidad';
        if($this->level != 5){
            $dato .= '<small><button type="button" class="btn btn-primary" id="showPerfil">Nueva Unidad</button></small>';
            $dato .= '&nbsp;<a href="formulario.php"><small><button type="button" class="btn btn-primary" id="showPerfil">Prueba</button></small>';
        }
        if($this->level == 1 OR $this->level == 2){
            $dato .= '&nbsp;<a href="descargaLista.php"><small><button type="button" class="btn btn-primary">Descarga Lista CSV</button></small></a>';
        }
        $dato .= '
        </h1>
        '.$this->getTimeLine().'
        </section>';

        return $dato;
    }
    private function getTimeLine(){
        $dato = '
        <ol class="breadcrumb" >
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
    private function getAccesorios($tipo=""){
        $sql = parent::query('SELECT * FROM in_accesorios WHERE idTipoUnidad=1 AND status <> 9');
        $dato = '';
        while($dat = parent::fetch_array($sql)){
            if($tipo == ''){
                if(isset($_COOKIE['accesorios'])) {                
                    $accesoriosCookies = unserialize($_COOKIE['accesorios']);
                    foreach ($accesoriosCookies as $accesorioCookie) {
                        $accesorioSplit = explode('_', $accesorioCookie);
                        $id_seleccionado = $accesorioSplit[0];
                        $valor_seleccionado = $accesorioSplit[1];
                        if ($id_seleccionado == $dat['id']) {
                            $idContainer = $tipo . $dat['id'] . '_' . $valor_seleccionado;
                            $dato = $dato."<input type='hidden' class='accesoriosCookies' value='$idContainer'>";
                        }
                    }
                }
            }


            $dato .= '
            <div class="form-group col-md-4">
            <label>'.$dat['nombre'].'</label><br />
            Si <input type="radio" class="'.$tipo.$dat['id'].'_1" name="'.$dat['nombre'].'" id="'.$tipo.$dat['id'].'_1" value="Si"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            No <input type="radio" class="'.$tipo.$dat['id'].'_2" name="'.$dat['nombre'].'" id="'.$tipo.$dat['id'].'_2" value="No"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            Cnt. <div class="quantity" id="quantity'.$tipo.$dat['id'].'_3">
            <input type="number" min="0" max="9" class="form-control" value="0" name="'.$dat['nombre'].'" id="'.$tipo.$dat['id'].'_3">
            </div>
            </div>';

        }

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
        $dato = '
        <form action="recepcion.php" method="POST">
        <div class="col-xs-12 col-md-3">
        Clientes <br />
        '.$this->getSQLfiltro("C").'
        </div>
        <div class="col-xs-12 col-md-3">
        Estatus <br />
        '.$this->getSQLfiltro("E").'
        </div>';
        if($this->level != 3){
            $dato .= '
            <div class="col-xs-12 col-md-3">
            Sucursales <br />
            '.$this->getSQLfiltro("S").'
            </div>';
        }
        $dato .= '
        <div class="col-xs-12 col-md-3">
        <input type="submit" value="Filtrar">
        </div>
        </form>';



        return $dato;
    }
    private function getSQLfiltro($inf){
        $tabla = $inf == "C" ? "in_clientes" : ($inf == "E" ? "in_estatus" : "in_sucursales");
        $idSel = $inf == "C" ? "filtroCliente" : ($inf == "E" ? "filtroStatus" : "filtroSucursal");
        $idCmp = $inf == "C" ? $this->filtroCliente : ($inf == "E" ? $this->filtroStatus : $this->filtroSucursal);
        $sql = parent::query('SELECT id, nombre FROM '.$tabla);

        $dato = '<select id="'.$idSel.'" name="'.$idSel.'">
        <option value="">-- Seleccione</option>';

        while($dat = parent::fetch_array($sql)){
            $sel = $idCmp == $dat['id'] ? "selected" : "";
            $dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['nombre'].'</option>';
        }
        $dato .= '</select>';

        return $dato;
    }
}
$pagina = new recepcion($section, $subsection);