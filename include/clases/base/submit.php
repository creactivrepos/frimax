<?php 
include_once "PHPMailer/PHPMailerAutoload.php";
include_once "MySQL.php";
class submit extends MySQL{

	public function __construct(){
		parent::__construct();
	}

	public function addUsuario($usuario="", $clave="", $nombre="", $paterno="", $materno="", $email="", $celular="", $sucursal="", $nivel="", $firma=""){
		@session_start();
		date_default_timezone_set("America/Mexico_City");
		$fecha = date("Y-m-d H:i:s");


		$cmp = parent::fetch_array(parent::query('SELECT id FROM usuarios WHERE user = "'.$usuario.'" AND status <> 9'));
		if($cmp['id'] == ''){
			//Inserta en la tabla de usuarios, la informacion que se ha enviado
			$dat = 'INSERT INTO usuarios (user, pass, nombre, paterno, materno, email, celular, sucursal, nivel, status, fechaAlta,firma, IdUsuarioAlta) VALUES ("'.$usuario.'", "'.sha1($clave).'", "'.$nombre.'", "'.$paterno.'", "'.$materno.'", "'.$email.'", "'.$celular.'", "'.$sucursal.'", "'.$nivel.'", 1, "'.$fecha.'","'.$firma.'", "'.$_SESSION['id'].'")';

			if(parent::query($dat)){
				return "1";//Agregado correctamente
			}
			else{
				return "2";//Hubo un problema al agregarre
			}
		}
		else{
			return "3";//Usuario existente en el sistema
		}
	}

	public function addCliente($POST){
		@session_start();
		date_default_timezone_set("America/Mexico_City");
		$fecha = date("Y-m-d H:i:s");
		extract($POST);	

		$cmp = parent::fetch_array(parent::query('SELECT id FROM in_clientes WHERE nombre = "'.$nombre.'"'));

		if($cmp['id'] == ''){

		 	//Inserta en la tabla de usuarios, la informacion que se ha enviado
			$dat = 'INSERT INTO in_clientes (nombre, RFC, razon, calle, numero, interior, colonia, cp, ciudad, municipio, estado, telefono,email,status) VALUES ("'.$nombre.'", "'.$rfc.'", "'.$razon.'", "'.$calle.'", "'.$interior.'", "'.$exterior.'", "'.$colonia.'", "'.$cp.'", "'.$ciudad.'", "'.$municipio.'", "'.$estado.'", "'.$telefono.'", "'.$email.'",0)';

			if(parent::query($dat)){
		 		return 1;//Agregado correctamente
		 	}
		 	else{
		 		return 2;//Hubo un problema al agregarre
		 	}
		 }
		// else{
		// 	return 3;//Usuario existente en el sistema
		// }
		}


		public function editUsuario($id, $usuario="", $clave="", $nombre="", $paterno="", $materno="", $email="", $celular="", $firmaDigitalEdit="", $sucursal="", $nivel=""){
			if($clave == "") {
				$contra = "";
			}
			else {
				$contra = 'pass = "' . sha1($clave) . '",';
			}

			$upd = '
			UPDATE usuarios SET user = "'.$usuario.'", '.$contra.' nombre = "'.$nombre.'", paterno = "'.$paterno.'", materno = "'.$materno.'", email = "'.$email.'", celular = "'.$celular.'", firma = "'.$firmaDigitalEdit.'", sucursal = "'.$sucursal.'", nivel = "'.$nivel.'" 
			WHERE id='.$id;

			if(parent::query($upd))
				return 1;
			else
				return 2;
		}
		public function elimUsuario($id){
			$upd = 'UPDATE usuarios SET status = "9" WHERE id ="'.$id.'"';

			if(parent::query($upd))
			return 1;//Eliminado exitosamente
		else
			return 0;//Hubo un problema al eliminar
	}
	public function elimPerfil($id){
		$upd = 'UPDATE in_niveles SET status = "9" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susPerfil($id){
		$upd = 'UPDATE in_niveles SET status = "2" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function actPerfil($id){
		$upd = 'UPDATE in_niveles SET status = "1" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function editPerfil($id){
		$sql = parent::fetch_array(parent::query('SELECT * FROM in_niveles WHERE id = "'.$id.'"'));

		return $sql['nivel']."::".$sql['descripcion'];
	}
	public function addPerfil($nombre, $descripcion){
		$sql = 'INSERT INTO in_niveles (nivel, descripcion, status) VALUES ("'.$nombre.'", "'.$descripcion.'", "1")';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function SendEditPerfil($id, $nombre, $descripcion){
		$upd = 'UPDATE in_niveles SET nivel = "'.$nombre.'", descripcion = "'.$descripcion.'" WHERE id = "'.$id.'"';
		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function elimSucursal($id){
		$upd = 'UPDATE in_sucursales SET status = "9" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function elimCliente($id){
		$upd = 'UPDATE in_clientes SET status = "9" WHERE id = "'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susSucursal($id){
		$upd = 'UPDATE in_sucursales SET status = "2" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susCliente($id){
		$upd = 'UPDATE in_clientes SET status = "2" WHERE id = "'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function actSucursal($id){
		$upd = 'UPDATE in_sucursales SET status = "1" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function actCliente($id){
		$upd = 'UPDATE in_clientes SET status = "1" WHERE id = "'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function editSucursal($id){
		$sql = parent::fetch_array(parent::query('SELECT * FROM in_sucursales WHERE id = "'.$id.'"'));

		return $sql['nombre']."::".$sql['ciudad']."::".$sql['clave'];
	}
	public function editCliente($id){
		
		$sql = parent::fetch_array(parent::query('SELECT * FROM in_clientes WHERE id = "'.$id.'"'));


		return $sql['nombre']."::".$sql['RFC']."::".$sql['razon']."::".$sql['calle']."::".$sql['numero']."::".$sql['interior']."::".$sql['colonia']."::".$sql['cp']."::".$sql['ciudad']."::".$sql['municipio']."::".$sql['estado']."::".$sql['telefono']."::".$sql['email'];
	}
	public function addSucursal($nombre, $ciudad, $clave){
		$sql = 'INSERT INTO in_sucursales (nombre, ciudad, clave, status) VALUES ("'.$nombre.'", "'.$ciudad.'", "'.$clave.'", 1)';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar			
	}
	public function SendEditSucursal($id, $nombre, $ciudad, $clave){
		$sql = 'UPDATE in_sucursales SET nombre = "'.$nombre.'", ciudad = "'.$ciudad.'", clave = "'.$clave.'" WHERE id = "'.$id.'"';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function SendEditCliente($POST){
		extract($POST);

		$sql = 'UPDATE in_clientes SET nombre = "'.$nombre.'", RFC = "'.$rfc.'", razon = "'.$razon.'", calle="'.$calle.'", numero="'.$exterior.'", interior="'.$interior.'", colonia="'.$colonia.'", cp="'.$cp.'", ciudad="'.$ciudad.'", municipio="'.$municipio.'", estado="'.$estado.'", telefono="'.$telefono.'", email="'.$email.'" WHERE id = "'.$id.'"';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar		
	}
	public function nivelRelMP($nivel){
		$dato = '';
		$sql = parent::query('SELECT in_menu.id, in_menu.nombre, in_menu.submenu FROM in_menu WHERE nivel = 0');

		while($dat = parent::fetch_array($sql)){
			$cmp = parent::fetch_array(parent::query('SELECT id FROM rel_menu_nivel WHERE idMenu = "'.$dat['id'].'" AND idNivel = "'.$nivel.'"'));
			$sel = $cmp['id'] != "" ? "checked" : "";
			$dato .= '<input type="checkbox" '.$sel.' onchange="javascript:relmenper('.$dat['id'].')" id="'.$dat['id'].'"> '.$dat['nombre'].'<br />';
			if($dat['submenu'] != 0){
				$sqlInter = parent::query('SELECT in_menu.id, in_menu.nombre FROM in_menu WHERE in_menu.depende = "'.$dat['id'].'"');
				while($datInter = parent::fetch_array($sqlInter)){
					$cmp = parent::fetch_array(parent::query('SELECT id FROM rel_menu_nivel WHERE idMenu = "'.$datInter['id'].'" AND idNivel = "'.$nivel.'"'));
					$sel = $cmp['id'] != "" ? "checked" : "";
					$dato .= '
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" '.$sel.' onchange="javascript:relmenper('.$datInter['id'].')" id="'.$datInter['id'].'"> '.$datInter['nombre'].'<br />';
				}
			}
		}

		return $dato;
	}
	public function relmenper($idPerfil, $id, $valor){
		$cmp = parent::fetch_array(parent::query('SELECT id FROM rel_menu_nivel WHERE idMenu = "'.$id.'" AND idNivel = "'.$idPerfil.'"'));
		if($valor == "true"){//Hay que insertar 
			if($cmp['id'] == "")
				$sql = parent::query('INSERT INTO rel_menu_nivel (idMenu, idNivel) VALUES ("'.$id.'", "'.$idPerfil.'")');
		}
		else{//Hay que eliminar
			if($cmp['id'] != "")
				$sql = parent::query('DELETE FROM rel_menu_nivel WHERE id = "'.$cmp['id'].'"');
		}
	}
	public function addAccesorio($nombre){
		$sql = 'INSERT INTO in_accesorios (nombre, status) VALUES ("'.$nombre.'", 1)';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar		
	}
	public function SendEditAccesorio($id, $nombre){
		$sql = 'UPDATE in_accesorios SET nombre = "'.$nombre.'" WHERE id = "'.$id.'"';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function editAccesorio($id){
		$sql = parent::fetch_array(parent::query('SELECT * FROM in_accesorios WHERE id = "'.$id.'"'));

		return $sql['nombre'];
	}
	public function elimAccesorio($id){
		$upd = 'UPDATE in_accesorios SET status = "9" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susAccesorio($id){
		$upd = 'UPDATE in_accesorios SET status = "2" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function actAccesorio($id){
		$upd = 'UPDATE in_accesorios SET status = "1" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function addEstatusAccesorio($nombre){
		$sql = 'INSERT INTO in_estatusAccesorios (descripcion, status) VALUES ("'.$nombre.'", 1)';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}
	public function editEstatusAccesorio($id){
		$sql = parent::fetch_array(parent::query('SELECT * FROM in_estatusAccesorios WHERE id = "'.$id.'"'));

		return $sql['descripcion'];
	}
	public function elimEstatusAccesorio($id){
		$upd = 'UPDATE in_estatusAccesorios SET status = "9" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susEstatusAccesorio($id){
		$upd = 'UPDATE in_estatusAccesorios SET status = "2" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function actEstatusAccesorio($id){
		$upd = 'UPDATE in_estatusAccesorios SET status = "1" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function SendEditEstatusAccesorio($id, $nombre){
		$sql = 'UPDATE in_estatusAccesorios SET descripcion = "'.$nombre.'" WHERE id = "'.$id.'"';

		if(parent::query($sql))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar	
	}

    /**
     * @param $POST
     * @return int
     */
    public function addRecepcion($POST){
    	session_start();
    	$responsable = false;
    	$cliente = False;
    	$sucursal = false;
    	$folio = false;
    	$nombreCliente = false;
    	$aresponsable = false;
    	$fecha = false;
    	$hora = false;
    	$nopedido = False;
    	$nooperacion = False;
    	$noserie=false;
    	$tipoUnidad=false;
    	$chasis = false;
    	$modelo = false;
    	$anio = false;
    	$placa = false;
    	$firmaDigital = false;
    	$responsableEntrega = false;
    	$kilometraje = false;
    	$combustible = false;    	
    	$volts=false;
    	$observaciones = false;
    	$otro = false;
    	$imagenCanvasIzq = false;
    	$imagenCanvasDer = false;
    	$imagenCanvasArriba = false;
    	$imagenCanvasSeat = false;
    	$imagenCanvasFrente = false;
    	$imagenCanvasInterior = false;
    	extract($POST);
    	
    	if($responsable != 0 OR $responsable != ""){

    		$cmp = parent::fetch_array(parent::query('SELECT id FROM controlRecibe WHERE folio = "'.$folio.'"'));


    		if($cmp['id'] == ""){


    			if($cliente == ""){
    				$client = parent::query('INSERT INTO in_clientes (nombre) VALUES ("'.$nombreCliente.'")');
    				$cliente = $this->getLast("in_clientes", "id");
    			}

    			$cons = explode("-", $folio);
    			$cons = $cons[1]*1;
    			$suc = parent::fetch_array(parent::query('SELECT sucursal FROM usuarios WHERE id = "'.$responsable.'"'));

    			$consulta = "INSERT INTO controlRecibe (folio, usuarioRecibe, motivoRecibe, asesorComercial, idCliente, fecha, status,usuarioEntrega, responsableTelefono, firmaEntrega,firmaUsuarioRecibe) VALUES ('$folio', '$responsable','$sucursal','$aresponsable', '$cliente','$fecha $hora',1,'$responsableEntrega','$responsableTelefono','$firmaDigital',1)";
    			$ins = parent::query($consulta);   			

    			$lastID = parent::fetch_array(parent::query('SELECT id FROM controlRecibe ORDER BY id DESC LIMIT 1'));

    			$ins = parent::query('INSERT INTO in_folios (consecutivo, idSucursal, folio) VALUES ("'.$cons.'", "'.$suc['sucursal'].'", "'.$folio.'")');

    			$ins = parent::query('INSERT INTO controlchasis (idControlRecibe) VALUES ("'.$lastID['id'].'")');

    			$ins = parent::query('INSERT INTO controlVehiculo (idControlRecibe, idTipoUnidad, noPedido, noOperacion, noSerie, chasis, modelo, anio, placa) VALUES ("'.$lastID['id'].'","'.$tipoUnidad.'", "'.$nopedido.'", "'.$nooperacion.'", "'.$noserie.'", "'.$chasis.'", "'.$modelo.'", "'.$anio.'", "'.$placa.'")');

    			$ins = parent::query('INSERT INTO controlanomalias (idRecibe, frente, arriba, ladoIzq, ladoDer, panel, asientos) VALUES ("'.$lastID['id'].'","'.$imagenCanvasFrente.'","'.$imagenCanvasArriba.'","'.$imagenCanvasIzq.'","'.$imagenCanvasDer.'","'.$imagenCanvasInterior.'","'.$imagenCanvasSeat.'")');

    			$cmp2 = parent::fetch_array(parent::query('SELECT id FROM controlAdicional WHERE idControlRecibe = "'.$lastID['id'].'"'));

    			if($cmp2['id'] == ""){
    				$ins = parent::query('INSERT INTO controlAdicional (idControlRecibe, kilometraje, combustible, volts, otro, observaciones) VALUES ("'. $lastID['id'].'", "'.$kilometraje.'", "'.$combustible.'", "'.$volts.'", "'.$otro.'", "'.$observaciones.'")');
    			}else{
    				$ins = parent::query('UPDATE controlAdicional SET idControlRecibe = "'.$cmp2['id'].'", kilometraje = "'.$kilometraje.'", combustible = "'.$combustible.'", volts= "'.$volts.'", otro = "'.$otro.'", observaciones = "'.$observaciones.'" WHERE id = "'.$cmp2['id'].'"');	
    			}

    			if(isset($_POST['accesorios'])) {

    				foreach ($POST['accesorios'] AS $accesorio) {
    					
    					$sep = explode("_", $accesorio);
    					if ($sep[0] != "tab" && $sep[0] != "enc" && $sep[0] != "ala" && $sep[0]) {

    						$cmp = parent::query('INSERT INTO controlAccesorios (idControlRecibe, idAccesorio, idEstatus, cantidad) VALUES ("' . $lastID['id'] . '", "' . $sep[0] . '", "' . $sep[1] . '","' . $sep[2] . '")');
    					}else{    					
    						$cmp3 = parent::fetch_array(parent::query('SELECT id FROM controlAdicional WHERE idControlRecibe = "' . $lastID['id'] . '"'));
    						if ($cmp3['id'] == "") {    							

    							if($sep[0]=='tab'){
    								$cons = ' tablero ';
    								$val = $sep[1] == "1" ? "si" : "no";
    							}
    							elseif ($sep[0]=='enc'){
    								$cons = ' alarma ';
    								$val = $sep[1] == "1" ? "1" : "0";
    							}
    							elseif ($sep[0]=='ala'){
    								$cons = ' reversa ';
    								$val = $sep[1] == "1" ? "1" : "0";
    							}

    							$ins = parent::query('INSERT INTO controlAdicional (idControlRecibe, ' . $cons . ') VALUES ("' . $lastID['id'] . '", "' . $val . '")');
    						} else {

    							if($sep[0]=='tab'){
    								$cons = ' tablero ';
    								$val = $sep[1] == "1" ? "si" : "no";
    							}
    							elseif ($sep[0]=='enc'){
    								$cons = ' alarma ';
    								$val = $sep[1] == "1" ? "1" : "0";
    							}
    							elseif ($sep[0]=='ala'){
    								$cons = ' reversa ';
    								$val = $sep[1] == "1" ? "1" : "0";
    							}
    							

    							$ins = parent::query('UPDATE controlAdicional SET ' . $cons . ' = "' . $val . '" WHERE idControlRecibe = "' . $cmp3['id'] . '"');
    						}
    					}
    				}
    			}    		
    			return 1;
    		}


    	}else{
    		@session_destroy();
    		return 0;
    		header("Location: recepcion.php");
    	}		
    }

    public function updRecepcion($POST){
    	@session_start();
    	$dato = '';
    	extract($POST);
    	$id = $eid;

    	$sql_proceso = ' ';
    	$sql_fecha_entrega = ' ';
    	$sql_fecha_terminado = ' ';
    	$sql_firma_recibe = ' ';
    	$sql_nombre_recibe = ' ';
    	$sql_telefono_recibe = " ";
    	

    	$coma = ' ';
    	$coma_intermedia = ' ';

    	$comaTerminado = ' ';
    	$comaRecibe = ' ';
    	$comaRecibe_intermedio = ' ';
    	$comaTelefono= ' ';
    	


    	$existe_proceso = false;
    	$existe_fecha_entrega = false;
    	$existe_fecha_Terminado = false;

    	$existe_nombre_recibe = false;
    	$existe_telefono_recibe = false;
    	$existe_firma_recibe = false;

    	if(isset($proceso)&&$proceso!=''){
    		$sql_proceso = " proceso = '$proceso' ";
    		$existe_proceso = true;
    	}


    	if(isset($fechaEntrega)&&$fechaEntrega!=''){
    		$sql_fecha_entrega = " fechaEntrega = '$fechaEntrega' ";
    		$existe_fecha_entrega = true;
    	}

    	if(isset($fechaTermino)&&$fechaTermino!=''){
    		$sql_fecha_terminado = "fechaTerminado = '$fechaTermino' ";
    		$existe_fecha_Terminado = true;
    	}


    	if(isset($firmaDRecepcion)&&$firmaDRecepcion!=''){
    		$sql_firma_recibe = "firmaRecibe = '$firmaDRecepcion' ";
    		$existe_firma_recibe = true;
    	}


    	if(isset($responsableRecibe)&&$responsableRecibe!=''){    		
    		$sql_nombre_recibe = "responsableRecibe = '$responsableRecibe' ";
    		$existe_nombre_recibe = true;
    	}

    	if(isset($telefonoRecibe)&&$telefonoRecibe!=''){    		
    		$sql_telefono_recibe = "telefonoRecibe = '$telefonoRecibe' ";
    		$existe_telefono_recibe = true;
    	}

    	if($existe_nombre_recibe || $existe_firma_recibe){
    		$comaRecibe = ' , ';
    	}
    	if($existe_telefono_recibe){
    		$comaTelefono =' , ';
    	}

    	if($existe_nombre_recibe && $existe_firma_recibe){
    		$comaRecibe_intermedio = ' , ';
    	}

    	if($existe_fecha_entrega || $existe_proceso){
    		$coma = ' , ';
    	}

    	if($existe_fecha_Terminado){
    		$comaTerminado = ' , ';
    	}

    	if($existe_proceso && $existe_fecha_entrega){
    		$coma_intermedia = ' , ';
    	}  	

    	$consulta_control_recibe = "UPDATE controlRecibe SET usuarioRecibe = '$responsable', motivoRecibe = '$sucursal', asesorComercial = '$aresponsable', idCliente = '$cliente' $comaTerminado $sql_fecha_terminado $comaRecibe $sql_nombre_recibe $comaRecibe_intermedio $sql_firma_recibe  $coma $sql_proceso $coma_intermedia $sql_fecha_entrega $comaTelefono $sql_telefono_recibe WHERE id = $id";

    	$upd = parent::query($consulta_control_recibe);

    	$updIns = parent::query('UPDATE controlVehiculo SET idTipoUnidad = "'.$etipoUnidad.'", noPedido = "'.$nopedido.'", noOperacion = "'.$nooperacion.'", noSerie = "'.$noserie.'", chasis = "'.$chasis.'", modelo = "'.$modelo.'", anio = "'.$anio.'", placa = "'.$placa.'" WHERE idControlRecibe = "'.$id.'"');

    	$del = parent::query('DELETE FROM controlAccesorios WHERE idControlRecibe = "'.$id.'"');

    	foreach($POST['accesorios'] AS $accesorio){
    		$sep = explode("_", $accesorio);
    		if($sep[0] != "tab" && $sep[0] != "etab" &&$sep[0] != "eenc" &&$sep[0] != "eala" && $sep[0] != "enc" && $sep[0] != "ala" && $sep[0] != "ecarga" && $sep[0] != "carga" && $sep[0] != "eaire" && $sep[0] != "aire"){

    			$resultado = str_replace("e", "", $sep[0]);
    			$cmp = parent::query('INSERT INTO controlAccesorios (idControlRecibe, idAccesorio, idEstatus, cantidad) VALUES ("'.$id.'", "'.$resultado.'", "'.$sep[1].'","'.$sep[2].'")');
    		}
    		else{
    			$cons = $sep[0] == "etab" ? "tablero" : ($sep[0] == "eenc" ? "alarma" : ($sep[0] == "eala" ? "reversa" : ($sep[0] == "ecarga" ? "carga" : "aire")));

    			if($sep[0] =='etab'){
    				$val = $sep[1] == "1" ? "si" : "no";
    			}else if($sep[0] =='eenc'){
    				$val = $sep[1] == "1" ? "1" : "0";
    			}else if($sep[0] =='eala'){
    				$val = $sep[1] == "1" ? "1" : "0";
    			}else if($sep[0] =='ecarga'){
    				$val = $sep[1] == "1" ? "1" : "0";
    			}else if($sep[0] =='eaire'){
    				$val = $sep[1] == "1" ? "1" : "0";
    			}

    			$ins = parent::query('UPDATE controlAdicional SET '.$cons.' = "'.$val.'" WHERE idControlRecibe = "'.$id.'"');	
    		}
    	}

    	$ins = parent::query('UPDATE controlAdicional SET kilometraje = "'.$kilometraje.'", combustible = "'.$combustible.'",  volts = "'.$volts.'", otro = "'.$otro.'", observaciones = "'.$observaciones.'" WHERE id = "'.$id.'"');

    	$actual = parent::query('UPDATE controlchasis SET rodado = "'.$rodado.'", lCarrozable = "'.$lCarrozable.'",  aPLarguero = "'.$aPLarguero.'", aLarguero = "'.$aLarguero.'", alturaLar = "'.$alturaLar.'", pLarguero = "'.$pLarguero.'", altCabina = "'.$altCabina.'", dEjes = "'.$dEjes.'", diCabCenEjeTras = "'.$diCabCenEjeTras.'", diCabCenEjeDelan = "'.$diCabCenEjeDelan.'", volTras = "'.$volTras.'", lTotalChas = "'.$lTotalChas.'" WHERE idControlRecibe = "'.$id.'"');

    	return 1;
    }

    public function searchClients($valor){
    	$dat = '';
    	$sql = parent::query('SELECT id, nombre FROM in_clientes WHERE nombre LIKE "'.$valor.'%" LIMIT 4');
    	while($dato = parent::fetch_array($sql)){
    		$dat .= '<div onclick="javascript:selCliente('.$dato['id'].')" id="c_'.$dato['id'].'">'.$dato['nombre'].'</div>';
    	}


    	return $dat;
    }
    public function elimRecepcion($id){
    	$upd = 'UPDATE controlRecibe SET status = "9" WHERE id ="'.$id.'"';

    	if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function susRecepcion($id){
		$upd = 'UPDATE controlRecibe SET status = "2" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function actRecepcion($id){
		$upd = 'UPDATE controlRecibe SET status = "1" WHERE id ="'.$id.'"';

		if(parent::query($upd))
			return 1;//Re-Activado exitosamente
		else
			return 0;//Hubo un problema al re-activar
	}
	public function editRecepcion($id){
		$sql = parent::fetch_array(parent::query('
			SELECT controlRecibe.fecha, controlRecibe.folio, controlRecibe.usuarioEntrega, controlRecibe.responsableTelefono,controlRecibe.firmaEntrega, controlRecibe.fechaTerminado, controlVehiculo.noPedido, controlVehiculo.noOperacion, controlVehiculo.noSerie, controlVehiculo.idTipoUnidad, controlVehiculo.chasis, controlVehiculo.modelo, controlVehiculo.anio, controlVehiculo.placa, controlAdicional.tablero, controlAdicional.alarma, controlAdicional.reversa, controlAdicional.kilometraje, controlAdicional.volts,controlAdicional.carga,controlAdicional.aire, controlAdicional.otro, controlAdicional.observaciones, controlRecibe.idCliente, in_clientes.nombre, CONCAT(userRecibe.nombre, " ", userRecibe.paterno," ",userRecibe.materno) AS usuarioRec, controlRecibe.motivoRecibe, controlRecibe.usuarioRecibe, in_estatus.nombre AS nombreEstatus, controlchasis.rodado, controlchasis.lCarrozable, controlchasis.aPLarguero, controlchasis.aLarguero, controlchasis.alturaLar, controlchasis.pLarguero, controlchasis.altCabina, controlchasis.dEjes, controlchasis.diCabCenEjeTras, controlchasis.diCabCenEjeDelan, controlchasis.volTras, controlchasis.lTotalChas
			FROM controlRecibe
			LEFT JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.id
			LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id
			LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente
			INNER JOIN usuarios AS userRecibe ON userRecibe.id = controlRecibe.usuarioRecibe
			LEFT JOIN in_estatus ON in_estatus.id = controlRecibe.proceso 
			LEFT JOIN controlchasis ON controlchasis.idControlRecibe = controlRecibe.id
			WHERE controlRecibe.id = "'.$id.'"'));


		return 
		$sql['fecha']."::".			//0
		$sql['folio']."::".			//1
		$sql['noPedido']."::".		//2
		$sql['noOperacion']."::".	//3
		$sql['noSerie']."::".		//4
		$sql['chasis']."::".		//5
		$sql['modelo']."::".		//6
		$sql['anio']."::".			//7
		$sql['placa']."::".			//8
		$sql['tablero']."::".		//9
		$sql['alarma']."::".		//10
		$sql['reversa']."::".		//11
		$sql['kilometraje']."::".	//12
		$sql['otro']."::".			//13
		$sql['observaciones']."::".	//14
		$sql['nombre']."::".		//15
		$sql['idCliente']."::".		//16
		$sql['usuarioRec']."::".	//17
		$sql['usuarioRecibe']."::". //18
		$sql['nombreEstatus']."::". //19
		$sql['usuarioEntrega']."::".  //20
		$sql['firmaEntrega']."::".   //21
		$sql['fechaTerminado']."::". //22
		$sql['responsableTelefono']."::". //23	
		$sql['volts']."::".		//24
		$sql['carga']."::".		//25
		$sql['aire']."::".		//26
		$sql['rodado']."::". //27
		$sql['lCarrozable']."::". //28
		$sql['aPLarguero']."::". //29
		$sql['aLarguero']."::". //30
		$sql['alturaLar']."::". //31
		$sql['pLarguero']."::". //32 
		$sql['altCabina']."::". //33
		$sql['dEjes']."::".  //34
		$sql['diCabCenEjeTras']."::". //35
		$sql['diCabCenEjeDelan']."::". //36
		$sql['volTras']."::". //37
		$sql['lTotalChas']."::".//38
		$sql['idTipoUnidad'];  //39
	}
	
	public function loadAccesorios($id){
		$sql = parent::query('SELECT idEstatus, idAccesorio, cantidad FROM controlAccesorios WHERE idControlRecibe = "'.$id.'"');
		$ret = "";
		while($dat = parent::fetch_array($sql)){
			$ret .= "::".$dat['idAccesorio']."_".$dat['idEstatus']."_".$dat['cantidad'];
		}

		return $ret;
	}
	public function loadMotivo($id){
		$inf = parent::fetch_array(parent::query('SELECT motivoRecibe FROM controlRecibe WHERE id = "'.$id.'"'));
		$sql = parent::query('SELECT * FROM in_motivosIngreso');

		$dato = '';

		while($dat = parent::fetch_array($sql)){
			$sel = $dat['id'] == $inf['motivoRecibe'] ? "selected" : "";
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['abreviacion'].' - '.utf8_encode($dat['nombre']).'</option>';
		}

		return $dato;
	}
	public function loadAsesor($id){
		$inf = parent::fetch_array(parent::query('SELECT asesorComercial FROM controlRecibe WHERE id = "'.$id.'"'));
		$sql = parent::query('SELECT CONCAT(nombre, " ", paterno, " ", materno) AS nombre, id FROM usuarios WHERE nivel=5 ORDER BY nombre ASC');

		$dato = '';

		while($dat = parent::fetch_array($sql)){
			$sel = $dat['id'] == $inf['asesorComercial'] ? "selected" : "";
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
		}

		return $dato;
	}

	public function loadTipoUnidad($id){
		$inf = parent::fetch_array(parent::query('SELECT idTipoUnidad FROM controlVehiculo WHERE idControlRecibe = "'.$id.'"'));
		$sql = parent::query('SELECT * FROM in_tipo_unidad');

		$dato = '';

		while($dat = parent::fetch_array($sql)){
			$sel = $dat['id'] == $inf['idTipoUnidad'] ? "selected" : "";
			$dato .= '<option value="'.$dat['id'].'" '.$sel.'>'.utf8_encode($dat['nombre']).'</option>';
		}

		return $dato;
	}

	public function showMedidasChasis($id){
		$inf = parent::fetch_array(parent::query('SELECT idTipoUnidad FROM controlVehiculo WHERE idControlRecibe = "'.$id.'"'));		
		return $inf['idTipoUnidad'];
	}

	public function showAccesorios($id){
		$sql = parent::query('SELECT in_accesorios.id,in_accesorios.nombre,controlaccesorios.idAccesorio,controlaccesorios.idEstatus,controlaccesorios.cantidad  FROM in_accesorios RIGHT JOIN controlaccesorios ON in_accesorios.id= controlaccesorios.idAccesorio INNER JOIN controlvehiculo ON in_accesorios.idTipoUnidad = controlvehiculo.idTipoUnidad LEFT JOIN controlrecibe ON controlvehiculo.idControlRecibe = controlrecibe.id  WHERE controlrecibe.id="'.$id.'" AND controlaccesorios.idControlRecibe=controlrecibe.id');
		$dato='';
		$sel='';
		while($dat= parent::fetch_array($sql)){
			$sel=$dat['idEstatus']==1?'checked':'';
			$sel2=$dat['idEstatus']==2?'checked':'';

			$dato .= '
			<div class="form-group col-md-4 col-sm- 4">
			<label>'.$dat['nombre'].'</label><br />        
			Si <input type="radio" name="'.$dat['nombre'].'" id="e'.$dat['id'].'_1" value="Si" '.$sel.'/ >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			No <input type="radio" name="'.$dat['nombre'].'" id="e'.$dat['id'].'_2" value="No" '.$sel2.'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Cnt. <div class="quantity" id="quantitye'.$dat['id'].'_3">
			<input type="number" min="0" max="9" class="form-control" value="'.$dat['cantidad'].'" name="'.$dat['nombre'].'" id="e'.$dat['id'].'_3">
			</div>
			</div>';
			
		}

		return $dato;
	}
	

	public function loadCombustible($id){
		$inf = parent::fetch_array(parent::query('SELECT combustible FROM controlAdicional WHERE idControlRecibe = "'.$id.'"'));

		$s0 = $inf['combustible'] == 0 ? "selected" : "";
		$s1 = $inf['combustible'] == 1 ? "selected" : "";
		$s2 = $inf['combustible'] == 2 ? "selected" : "";
		$s3 = $inf['combustible'] == 3 ? "selected" : "";
		$s4 = $inf['combustible'] == 4 ? "selected" : "";
		$s5 = $inf['combustible'] == 5 ? "selected" : "";
		$s6 = $inf['combustible'] == 6 ? "selected" : "";
		$s7 = $inf['combustible'] == 7 ? "selected" : "";
		$s8 = $inf['combustible'] == 8 ? "selected" : "";

		$dato = '
		<option value="0" '.$s0.'>Vacio</option>
		<option value="1" '.$s1.'> 1/8 </option>
		<option value="2" '.$s2.'> 1/4 </option>
		<option value="3" '.$s3.'> 3/8 </option>
		<option value="4" '.$s4.'> 1/2 </option>
		<option value="5" '.$s5.'> 5/8 </option>
		<option value="6" '.$s6.'> 3/4 </option>
		<option value="7" '.$s7.'> 7/8 </option>
		<option value="8" '.$s8.'> Lleno </option>';


		return $dato;
	}
	public function sendEditUsuario($id){
		$sql = parent::fetch_array(parent::query('SELECT usuarios.* FROM usuarios WHERE usuarios.id = "'.$id.'"'));

		$sqlsuc = parent::query('SELECT id, nombre FROM in_sucursales ORDER BY id');
		$datoSucursal = '';
		$datoNivel = '';
		while($dat = parent::fetch_array($sqlsuc)){
			$sel = $dat['id'] == $sql['sucursal'] ? "selected" : "";
			$datoSucursal .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['nombre'].'</option>';
		}
		$sqlniv = parent::query('SELECT id, descripcion FROM in_niveles ORDER BY id');
		while($dat = parent::fetch_array($sqlniv)){
			$sel = $dat['id'] == $sql['nivel'] ? "selected" : "";
			$datoNivel .= '<option value="'.$dat['id'].'" '.$sel.'>'.$dat['descripcion'].'</option>';
		}

		return $sql['id']."::".$sql['user']."::".$sql['nombre']."::".$sql['paterno']."::".$sql['materno']."::".$sql['email']."::".$sql['celular']."::".$datoNivel."::".$datoSucursal."::".$sql['status']."::".$sql['pass']."::".$sql['firma'];
	}


	private function getLast($tabla, $id){
		$sql = parent::fetch_array(parent::query('SELECT '.$id.' FROM '.$tabla.' ORDER BY '.$id.' DESC LIMIT 1'));

		return $sql[$id];
	}

	public function cambiarcontrasena($email){
		if($email!=""){
			if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)){

				function generarPassword($long){
					$key ="";
					$pattern="1234567890abcdefghijklmnopqrstuvwxyz";
					$max=strlen($pattern)-1;
					for ($i=0; $i < $long ; $i++) { 
						$key .= $pattern{mt_rand(0,$max)};
						
					}
					return $key;
				}

				$newPassword= generarPassword(11);
				$encriptar= sha1($newPassword);
				$tabla="usuarios";
				$item="email";
				$valor=$email;
				
				$sql = parent::fetch_array(parent::query('SELECT id FROM usuarios WHERE email = "' .$valor. '"'));			
				if ($sql['id'] != "") {					
					$id=$sql["id"];
					$item2="password";					
					$updIns = parent::query('UPDATE usuarios SET pass = "'.$encriptar.'" WHERE id = "'.$id.'"');	
					if ($updIns) {
						date_default_timezone_get("America/Mexico_City");
						
						$mail = new PHPMailer;

						$mail->CharSet = 'UTF-8';

						$mail->isMail();
						$mail->setFrom('info@frimax.mx');				
						$mail->Subject="Nueva contraseña";
						$mail->addAddress($email);
						$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

							<center>

							<img style="padding:20px; width:30%" src="https://frimax.mx/wp-content/uploads/2017/05/logo-frimax.png">

							</center>

							<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">

							<center>

							<img style="padding:20px; width:15%" src="https://www.frimax.mx/images/icon-pass.png">

							<h3 style="font-weight:100; color:#999">Nueva Contraseña</h3>

							<hr style="border:1px solid #ccc; width:80%">

							<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Your new password: </strong>'.$newPassword.'</h4>
							
							<br>

							<hr style="border:1px solid #ccc; width:80%">

							<h5 style="font-weight:100; color:#999">Si no está inscrito en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

							</center>

							</div>

							</div>');
						$envio =$mail->send();

						if($envio){
							echo "1";
						}else{
							echo 'Error intentelo más tarde';	
						}
						

					}


				}else{
					echo "Correo Electronico No Existe";
				}
			}else{
				echo "Correo mal escrito";
			}
		}else{
			echo "Escriba un correo";
		}
	}

	public function actualizarFechas(){
		$fechas = array();
		$sql =parent::query('SELECT * FROM controlRecibe where fechaEntrega is null');
		foreach ($sql as $value) {			
			$datetime1 = new DateTime($value["fecha"]);
			$datetime2 = new DateTime("now");			
			$interval = $datetime1->diff($datetime2);			
			$diasEstadia=$interval->format('%a');			
			
			if ($value["fechaTerminado"]!=null) {
				$datetime3 = new DateTime($value["fechaTerminado"]);
				$interval2 = $datetime3->diff($datetime2);
				$diasTerminado=$interval2->format('%a');
				$upd = 'UPDATE controlRecibe SET diasTerminado = '.$diasTerminado.', diasEstadia='.$diasEstadia.' where id="'.$value["id"].'"';
				if(parent::query($upd))
					$fechas[]=$diasEstadia;//Re-Activado exitosamente
				else
					return 0;//Hubo un problema al re-activar
			}else{
				$upd = 'UPDATE controlRecibe SET diasEstadia='.$diasEstadia.' where id="'.$value["id"].'"';
				if(parent::query($upd))
					$fechas[]=$diasEstadia;//Re-Activado exitosamente
				else
					return 0;//Hubo un problema al re-activar

			}

		}		
		if($fechas!=""){
			return 1;
		}

	}


	public function usuarioEntrega($POST){
		@session_start();
		
		extract($POST);
		$id = $eid;
		$respon = $responsable;
		$consulta_udpdate_entrega = "UPDATE controlRecibe SET 
		firmaUsuarioRecibe = '$respon' WHERE id = '$id'";


		$upd = parent::query($consulta_udpdate_entrega);
		return 1;
	}

	public function accesoriosTipo($id){
		$sql = parent::query('SELECT id, nombre FROM in_accesorios WHERE idTipoUnidad = "'.$id.'"');
		$dato='';
		while($dat= parent::fetch_array($sql)){
			$dato .= '
			<div class="form-group col-md-4">
			<label>'.$dat['nombre'].'</label><br />
			Si <input type="radio" class="'.$dat['id'].'_1" name="'.$dat['nombre'].'" id="'.$dat['id'].'_1" value="Si"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			No <input type="radio" class="'.$dat['id'].'_2" name="'.$dat['nombre'].'" id="'.$dat['id'].'_2" value="No"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			Cnt. <div class="quantity" id="quantity'.$dat['id'].'_3">
			<input type="number" min="0" max="9" class="form-control" value="" name="'.$dat['nombre'].'" id="'.$dat['id'].'_3">
			</div>
			</div>';
			
		}

		return $dato;
	}
}
?>