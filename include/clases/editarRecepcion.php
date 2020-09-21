<?php 
include "base/pagina.php";
class editarRecepcion extends pagina{

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
        $dato = '<div class="content-wrapper contenido">'.$this->getAlerts().'
        <section class="content">
        <div class="row">
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
        <form role="form">
        '.$this->getAccesorios("e").'
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
        Si <input type="radio" name="carga" id="carga_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="carga" id="carga_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group col-md-6">
        <label>Entrega de Molduras</label><br />
        Si <input type="radio" name="aire" id="aire_1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No <input type="radio" name="aire" id="aire_2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
}

$editar = new editarRecepcion($section, $subsection);