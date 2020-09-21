<?php 
include "MySQL.php";
class pagina extends MySQL{
	public $seccion;
	public $subseccion;
	public $level;
	public $idUser;
	public $subSeccionId;
	public function __construct($section, $subsection=""){
		@session_start();
		parent::__construct($section);
		$this->seccion = $section;
		$this->subseccion = $subsection;
		if(isset($_SESSION['nivel'])){
			$this->level = $_SESSION['nivel'];
			$this->idUser = $_SESSION['id'];

			$cnx = new MySQL();

			$consulta = "SELECT *FROM 
			in_menu AS A 
			INNER JOIN rel_menu_nivel AS B ON B.idMenu = A.id
			WHERE A.seccion = '$this->subseccion' AND B.idNivel = $this->level";
			
			$result = $cnx->link->query($consulta);

			$n_registros = $result->num_rows;

			if($this->subseccion != '') {

				if ($n_registros <= 0) {
					header('Location: index.php?mensaje=Sin Permiso&tipo_mensaje=error');
					exit;
				}
			}

		}


	}
	public function showLogin(){
		$dato = '
		<!DOCTYPE html>
		<html class="no-js" lang="es">
		<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
		<title>Bienvenido a Recepcion Frimax Carrocerias</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
		<meta name="description" content="Recepcion logistica Frimax Carrocerias" />
		<meta name="keywords" content="Recepcion logistica de unidades Servicio Frimax Carrocerias" />
		<meta name="author" content="Daniel Huerta" />
		<link rel="shortcut icon" href="favicon.ico"> 
		<link rel="stylesheet" type="text/css" href="'.parent::getPath().'css/demo.css" />

		<link rel="stylesheet" href="'.parent::getPath().'css/styles.css">
		<link rel="stylesheet" href="'.parent::getPath().'bootstrap/css/bootstrap.css">

		
		</head>
		<body id="page">
		<div style="position:relative;margin-top:20px;width:100%"></div>
		<div id="container">
		<label for="name">Usuario:</label><input type="name" id="usuario">
		<label for="username">Contraseña:</label><input type="password" id="pass">
		<div id="lower">
		<div class="password">
		<a data-toggle="modal" href="#modalContra">¿Olvidaste tu contraseña?</a>
		</div>

		<input type="button" value="Entrar" onClick="loguear()">
		<div id="cont_error"></div>
		</div>
		</div>
		<div id="contenido"></div>	


		<div class="modal fade" id="modalContra" role="dialog">
		<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Recuperar contraseña</h4>
		</div>
		<div class="modal-body">
		<form method="post">

		<label class="text-muted leyenda">Introduzca su dirección de correo electrónico para restablecer:</label>

		<div class="form-group">

		<div class="input-group">

		<span class="input-group-addon">

		<i class="glyphicon glyphicon-envelope"></i>

		</span>

		<input type="email" class="form-control" id="passEmail" name="passEmail" placeholder="Email" required>

		</div>

		</div>	

		</form>
		</div>
		<div class="modal-footer">
		<input type="submit" class="btn btn-default" id="cambiarContraseña" value="Enviar">
		</div>
		</div>

		</div>
		</div>


		<script src="'.parent::getPath().'plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<script type="text/javascript" src="'.parent::getPath().'js/loguear.js"></script>
		<script src="'.parent::getPath().'bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		</body>
		</html>';

		return $dato;
	}
	//Devuelve el contenido del encabezado de la pagina, carga las metas y el CSS
	private function getContentHeader(){
		$dato = '
		<head>'.
		$this->getMetas().
		$this->getCSS().'
		</head>';

		return $dato;
	}
	//Devuelve las metas de la pagina
	private function getMetas(){
		$dato = '
		<meta charset="utf-8" />
		<title>'.parent::getTitle().'</title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta content="Preview page of Metronic Admin Theme #1 for statistics, charts, recent events and reports" name="description" />
		<meta content="" name="author" />';

		return $dato;
	}
	//Devuelve todos los archivos css que usara el administrador
	private function getCSS(){

		if($this->subseccion == "adminUsers" || $this->subseccion == "perfiles" || $this->subseccion == "sucursales" || $this->subseccion == "recepcion" || $this->subseccion == "accesorios"  || $this->subseccion == "clientes" || $this->subseccion == "usuarios"){
			$dato = '
			<link href="'.parent::getPath().'bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
			<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
			
			<link href="'.parent::getPath().'dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'css/style_form.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'css/estilos.css" rel="stylesheet" type="text/css" />

			<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
			<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
			';
		}
		else{
			$dato = '
			<link href="'.parent::getPath().'bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
			<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
			<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
			<link href="'.parent::getPath().'dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/morris/morris.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
			<link href="'.parent::getPath().'css/style_form.css" rel="stylesheet" type="text/css" />	
			<link href="'.parent::getPath(true).'favicon.ico" rel="shortcut icon"  /> ';	
		}
		

		return $dato;
	}
	//Devuelve todos los llamados a los archivos JS de la pagina 	
	private function getJS(){
		$dato = '
		<script src="'.parent::getPath().'plugins/jQuery/jQuery-2.1.4.min.js"></script>

		<script src="'.parent::getPath().'bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

		<script src="'.parent::getPath().'js/funciones.js"  type="text/javascript"></script>';


		
		if($this->subseccion == "adminUsers" || $this->subseccion == "perfiles" || $this->subseccion == "sucursales" || $this->subseccion == "recepcion" || $this->subseccion == "accesorios" || $this->subseccion == "clientes" || $this->subseccion == "usuarios"){
			$dato .= '
			<script src="'.parent::getPath().'plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
			<script src="'.parent::getPath().'plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
			<script src="'.parent::getPath().'plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
			<script src="'.parent::getPath().'plugins/fastclick/fastclick.min.js"></script>
			<script src="'.parent::getPath().'dist/js/app.min.js" type="text/javascript"></script>	

			<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
			<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js" type="text/javascript"></script>


			<script type="text/javascript">
			$(function () {
				$("#example1").dataTable({});
				$("#lista-recepcion").dataTable({"aaSorting":[[5,"desc"]],
				"language": {			
					"sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_ registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
					"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Último",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de meanera ascendnte",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}

						},});
						$("#example2").dataTable({"bPaginate": true,"bLengthChange": false,"bFilter": false,"bSort": false,"bInfo": true,"bAutoWidth": false });
						});

						</script>

						<script src="'.parent::getPath().'js/underscore-min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'js/funcion_form.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'js/firmaUsuario.js" type="text/javascript"></script>';
					}
					else{
						$dato .= '
						<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
						<script>
						$.widget.bridge("uibutton", $.ui.button);
						</script>

						<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
						<script src="'.parent::getPath().'plugins/morris/morris.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/knob/jquery.knob.js" type="text/javascript"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'plugins/fastclick/fastclick.min.js"></script>
						<script src="'.parent::getPath().'dist/js/app.min.js" type="text/javascript"></script>    
						<script src="'.parent::getPath().'dist/js/pages/dashboard.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'js/underscore-min.js" type="text/javascript"></script>
						<script src="'.parent::getPath().'js/funcion_Nform.js" type="text/javascript"></script>
						';
					}

					$dato .= '
					<script src="'.parent::getPath().'dist/js/demo.js" type="text/javascript"></script>						
					';


					return $dato;
				}
	//Devuelve el menu superior del administrador()
				private function getTopBar(){
					$nombre = parent::getNameUsuario($this->idUser);
					$nivel = parent::getNivelUsuario($this->level);
					$sucursal = parent::getSucursalUsuario($this->idUser);
					$dato = '
					<header class="main-header">
					<a href="'.parent::getPath().'" class="logo">
					<span class="logo-mini"><b>R</b>FR</span>
					<span class="logo-lg"><b>Recepción</b>FRIMAX</span>
					</a>
					<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="'.parent::getPath().'dist/img/logoFrimax.jpg" class="user-image" alt="User Image"/>
					<span class="hidden-xs">'.$nombre.'</span>
					</a>
					<ul class="dropdown-menu">
					<li class="user-header">
					<img src="'.parent::getPath().'dist/img/logoFrimax.jpg" class="img-circle" alt="User Image" />
					<p>
					'.$nombre.' <br />'.$nivel.'
					<small>'.$sucursal.'</small>
					</p>
					</li>
					<li class="user-footer">
					<div class="pull-left">
					<a href="#" class="btn btn-default btn-flat">Perfil</a>
					</div>
					<div class="pull-right">
					<a href="#" id="cerrarSesion" class="btn btn-default btn-flat">Cerrar Sesion</a>
					</div>
					</li>
					</ul>
					</li>
					</ul>
					</div>
					</nav>
					</header>';

					return $dato;
				}
	//Devuelve el sideMenuBar
				private function getSideMenu(){
					$dato = '
					<aside class="main-sidebar">
					<section class="sidebar">
					<ul class="sidebar-menu">
					<li class="header">Menú Principal</li>';

					$sql = parent::query('
						SELECT in_menu.nombre, in_menu.url, in_menu.submenu, in_menu.id, in_menu.seccion, in_menu.icono FROM rel_menu_nivel
						INNER JOIN in_menu ON in_menu.id = rel_menu_nivel.idMenu AND in_menu.nivel = 0
						WHERE rel_menu_nivel.idNivel = "'.$_SESSION['nivel'].'"
						ORDER BY rel_menu_nivel.idMenu ASC');

					while($inf = parent::fetch_array($sql)){
						if($inf['submenu'] > 0){
							$active = $inf['seccion'] == $this->seccion ? 'treeview active' : '';
							$sup = parent::query('
								SELECT in_menu.nombre, in_menu.url, in_menu.submenu, in_menu.seccion FROM rel_menu_nivel
								INNER JOIN in_menu ON in_menu.id = rel_menu_nivel.idMenu AND in_menu.nivel = 1 AND in_menu.depende = "'.$inf['id'].'"
								WHERE rel_menu_nivel.idNivel = "'.$_SESSION['nivel'].'"
								ORDER BY rel_menu_nivel.idMenu ASC');
							$dato .= '
							<li class="'.$active.'">
							<a href="#">
							'.$inf['icono'].' 
							<span>'.$inf['nombre'].'</span> 
							<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">';
							while($supinf = parent::fetch_array($sup)){
								$supactive = $supinf['seccion'] == $this->subseccion ? 'active' : '';
								$dato .= '
								<li class="'.$supactive.'"><a href="'.$supinf['url'].'"><i class="fa fa-circle-o"></i>'.$supinf['nombre'].'</a></li>';
							}
							$dato .= '	
							</ul>
							</li>';
						}
						else{
							$active = $inf['seccion'] == $this->section ? 'active' : '';
							$dato .= '
							<li class="'.$active.'">
							<a href="'.$inf['url'].'">
							'.$inf['icono'].' <span>'.$inf['nombre'].'</span>
							</a>
							</li>';	
						}
					}

					$dato .= '
					</ul>
					</section>
					</aside>';

					return $dato;
				}
	//Devuelve el resultado de si está activo o no el menú, para activarlo
	//Sec, obtiene el nombre de seccion si $tip == 1, 2, 3 o de subseccion si $tip < 3
	//Tip, Es para identificar la posicion y el tipo de texto que devolverla el método
	//Sub, Es para identificar si existe un submenu o no, 0-> no hay, 1->si hay
				private function getActiveMenu($sec, $tip, $sub=0){
					if($tip == 1)
						$dato = $this->seccion != $sec ? 'nav-item' : ($sub == 0 ? "start active" : "start active open");
					elseif($tip == 2)
						$dato = $this->seccion == $sec ? '<span class="selected"></span>' : '';
					elseif($tip == 3)
						$dato = $this->seccion == $sec ? '<span class="arrow open"></span>' : '<span class="arrow"></span>';
					elseif($tip == 4)
						$dato = $this->subseccion == $sec ? "active" : "";

					return $dato;
				}
	//Devuelve el contenido del quick side bar
				private function getQuickSideBar(){
					$dato = '
					<a href="javascript:;" class="page-quick-sidebar-toggler">
					<i class="icon-login"></i>
					</a>';

					return $dato;
				}
	//Devuelve el footer de la pagina
				private function getFooter(){
					$dato = '
					<footer class="main-footer">
					<div class="pull-right hidden-xs">
					<b>Version</b> 1.0
					</div>
					<strong>Copyright &copy; 2020 <a href="frimax.mx">Frimax</a></strong> Todos los derechos reservados.
					</footer>';

					return $dato;
				}
	//Devuelve la mitad superior del contenido de la pagina
				public function supHalfPage(){
					$dato = '
					<!DOCTYPE html>
					<html lang="es-MX">'.
					$this->getContentHeader().'
					<body class="skin-blue sidebar-mini">
					<div class="wrapper">'.
					$this->getTopBar().'
					<div class="page-container">'.
					$this->getSideMenu();

					return $dato;
				}
	//Devuelve la mitad del contenido inferior de la pagina
				public function infHalfPage(){
					$dato = 
					$this->getQuickSideBar().'
					</div>'.
					$this->getFooter().'
					</div>'.
					$this->getJS().'
					</body>
					</html>';

					return $dato;
				}
			}