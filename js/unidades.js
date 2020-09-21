/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/
$(document).ready(function () {

	$("#lista-recepcion").DataTable({	 
		"ajax": "ajax/tablaCategorias.ajax.php",		
		deferRender: true,
		processing: true,		
		searchPanes:{
			cascadePanes: true,
			layout: 'columns-3',
			clear:true,
			hideCount: true,
			orderable: false,
			columns:[2,7,6],
			emptyMessage:"<i><b>VACIO</b></i>",
			dataLength: 15,
			dtOpts: {
				select: {
					style: 'multi'
				}
			}
		},
		dom: 'Pfrtip',		
		stateSave:true,		
		responsive: true,		
		"language": {
			searchPanes:{
				title: 'Filtros activos - %d',
				Clear: 'Limpíar todo',
				count: '{total}',
				countFiltered: '{shown} / {total}',
				emptyPanes: 'No hay paneles para mostrar. :/',
			},
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

		},			

	});

});



