var local = "true";
if(local == "true"){
	var url = "./";
	var urlSubmit = "./ajax.php";
}
else{
	var url = "./";
	var urlSubmit = "./ajax.php";
}



function nuevoAjax(){
	var xmlhttp=false;
	try {    
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

/*=============================================
=            Recorrer Radio button            =
=============================================*/
function pintarAccesorios(){
	var elementosDelForm = document.getElementsByTagName('input');    
	for(var i=0; i<elementosDelForm.length;i++) {
		if (elementosDelForm[i].type == 'radio') {
			elementosDelForm[i].addEventListener("click", actualizarDatos);

		}
	}
};

function actualizarDatos() {
	var valor = $(this).attr("name");  

	var ship30 = document.getElementsByName(valor);

	var radioButSelValue = '';
	var numberSelValue =[];
	var x=0;
	var number='';
	for (var i=0; i<ship30.length; i++) {
		if (ship30[i].checked == true) { 
			radioButSelValue = ship30[i].value;            
		}
		if(ship30[i].type == 'number'){            
			numberSelValue[x]=ship30[i].id;
			x++;
		}
	}
	if (radioButSelValue=="No") {
		$("#"+(numberSelValue[0])).val(0);
		$("#"+(numberSelValue[0])).prop("disabled", true);
		$("#"+(numberSelValue[0])).css("width", "50px");
		$("#quantity"+(numberSelValue[0])+" .quantity-nav").css("display","none");        
		var parentEls =$("#"+(numberSelValue[0])).parent().map(function() {
			return this.tagName;
		}).get().join( ", " );			
		$("#"+(numberSelValue[0]) ).append( "<strong>" + parentEls + "</strong>" );

	}else{        
		$("#"+(numberSelValue[0])).prop("disabled", false);
		$("#"+(numberSelValue[0])).css("width", "70px");
		$("#quantity"+(numberSelValue[0])+" .quantity-nav").css("display","block");
		$("#"+(numberSelValue[0])).val(1);

	}
}



/*=====  End of Recorrer Radio button  ======*/



/*==================================================
=            Funcion cancelar recepcion            =
==================================================*/
$("#cancelar").click(function(){
	window.location.href="recepcion.php";
    // setTimeout(function(){location.reload();},1000);
});


/*=====  End of Funcion cancelar recepcion  ======*/



//Funcion para cerrar sesion del sistema
$("#cerrarSesion").click(function(){
	$.ajax({
		url: url+"ajax/funciones.php",
		type: "POST",
		data: {
			"func" : "cerrarSesion",},
			success: function(data) {
				setTimeout(function(){window.location=url+"index.php"},1000);
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});

function isCanvasBlank(canva) {

	var blank = document.createElement('canvas');
	blank.width = canva.width; 
	blank.height = canva.height; 
	var blanco='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAVQAAACqCAYAAADyfbdoAAACWklEQVR4nO3UQQkAMAzAwPo3vZoIDMqdgrwyD4DE/A4AuMJQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQMRQASKGChAxVICIoQJEDBUgYqgAEUMFiBgqQGQBEfvNjgf9xi0AAAAASUVORK5CYII=';
	return blanco==canva.toDataURL('image/png'); 
} 

//Funcion para agregar usuario al sistema
$("#addUsuario").click(function () {


	var canva=document.getElementById("firmaNewUsuario");

	if(isCanvasBlank(canva)){
		var imagen=document.getElementById("firmaDigitalNew"); 
		imagen.value="";      
	}else{
		var imagen=document.getElementById("firmaDigitalNew"); 
		imagen.value=document.getElementById("firmaNewUsuario").toDataURL('image/png');
	}

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"usuario"   : $("#usuario").val(),
			"clave"     : $("#clave").val(),
			"nivel"     : $("#nivel").val(),
			"sucursal"  : $("#sucursal").val(), 
			"nombre"    : $("#nombre").val(), 
			"paterno"   : $("#paterno").val(), 
			"materno"   : $("#materno").val(), 
			"email"     : $("#email").val(), 
			"celular"   : $("#celular").val(),   
			"firma"     : $("#firmaDigitalNew").val(), 
			"func"      : "addUsuario"
		},
		success: function(data) {
			id = data == 1 ? "#exito" : (data == 2 ? "#warning" : "#error");
			$(id).css("display","block");
            //setTimeout(function(){$(id).css("display","none");},5000)
            setTimeout(function(){location.reload();},5000)

        },
        error: function() {
        	$("#error").css("display","block");
        	setTimeout(function(){$("#error").css("display","none");},5000)
        }
    });
});
function validaAddCliente(){
	var msgError = "";
	var countError = 0;
	if($("#nombre").val() == ""){
		countError = countError-(-1);
		msgError = "<br />El nombre del cliente es obligatorio";
	}
	if($("#rfc").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El RFC es  obligatorio";
	}
	if($("#razon").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />La Razón es  obligatoria";
	}
	if($("#calle").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />La calle es  obligatoria";
	}
	if($("#interior").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El numero es  obligatorio";
	}
	if($("#colonia").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />La colonia es  obligatoria";
	}
	if($("#cp").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El C.P. es  obligatorio";
	}
	if($("#ciudad").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />La ciudad  es  obligatoria";
	}
	if($("#municipio").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El minicipio es  obligatorio";
	}
	if($("#estado").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El estado es  obligatorio";
	}
	if($("#telefono").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El teléfono es  obligatorio";
	}
	if($("#email").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El email es obligatorio";
	}
	if(countError > 0){
		$("#showErrors").css("display", "block");
		$("#spcError").html(msgError);
	}

	return countError;
}
//Funcion para agregar un cliente al sistema
$("#addCliente").click(function () {
	var error = validaAddCliente();    
	if(error == 0){

		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"nombre"    : $("#nombre").val(),
				"rfc"       : $("#rfc").val(),
				"razon"     : $("#razon").val(),
				"calle"     : $("#calle").val(), 
				"interior"  : $("#interior").val(), 
				"exterior"  : $("#exterior").val(), 
				"colonia"   : $("#colonia").val(), 
				"cp"        : $("#cp").val(), 
				"ciudad"    : $("#ciudad").val(),   
				"municipio" : $("#municipio").val(),   
				"estado"    : $("#estado").val(),   
				"telefono"  : $("#telefono").val(),   
				"email"     : $("#email").val(),   
				"func"      : "addCliente"
			},
			success: function(respuesta) {                  
				id = respuesta == 1 ? "#exito" : (respuesta == 2 ? "#warning" : "#error");
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)

			},
			error: function() {
				$("#error").css("display","block");
				setTimeout(function(){$("#error").css("display","none");},5000)
			}
		});
	}
});
//Funcion para agregar un cliente al sistema
$("#editCliente").click(function () {
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {"id":$("#eid").val(),"usuario":$("#eusuario").val(),"clave":$("#eclave").val(),"nivel":$("#enivel").val(),"sucursal":$("#esucursal").val(),"nombre":$("#enombre").val(),"paterno":$("#epaterno").val(),"materno":$("#ematerno").val(),"email":$("#eemail").val(),"celular":$("#ecelular").val(),"func":"editUsuario",},
		success: function(data) {
			id = data == 1 ? "#exito" : (data == 2 ? "#warning" : "#error");
			$(id).css("display","block");
            //setTimeout(function(){$(id).css("display","none");},5000)
            //setTimeout(function(){location.reload();},5000)
            
        },
        error: function() {
        	$("#error").css("display","block");
            //setTimeout(function(){$("#error").css("display","none");},5000)
        }
    });
});
//Funcion para agregar usuario al sistema
$("#editUsuario").click(function () {

	var imagen=document.getElementById("firmaDigitalEdit"); 
	imagen.value=document.getElementById("firmaEditUsuario").toDataURL('image/png');

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id":$("#eid").val(),
			"usuario":$("#eusuario").val(),
			"clave":$("#eclave").val(),
			"nivel":$("#enivel").val(),
			"sucursal":$("#esucursal").val(),
			"nombre":$("#enombre").val(),
			"paterno":$("#epaterno").val(),
			"materno":$("#ematerno").val(),
			"email":$("#eemail").val(),
			"celular":$("#ecelular").val(),
			"firmaDigitalEdit":$("#firmaDigitalEdit").val(),
			"func":"editUsuario",},
			success: function(data) {
				var id = data == 1 ? "#exito" : (data == 2 ? "#warning" : "#error");
				$(id).css("display","block");
            //setTimeout(function(){$(id).css("display","none");},5000)
            //setTimeout(function(){location.reload();},5000)
            
        },
        error: function() {
        	$("#error").css("display","block");
            //setTimeout(function(){$("#error").css("display","none");},5000)
        }
    });
});
//Funcion para editar la informacion de un usuario específico
$(".sendEditUsuario").click(function(){
	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "sendEditUsuario",},
			success: function(data) {
				var valores = data.split("::");
				var e_id = $("#eid").val(valores[0]);

				$("#eusuario").val(valores[1]);
				$("#enivel").html(valores[7]);
				$("#esucursal").html(valores[8]); 
				$("#enombre").val(valores[2]);
				$("#epaterno").val(valores[3]); 
				$("#ematerno").val(valores[4]); 
				$("#eemail").val(valores[5]); 
				$("#ecelular").val(valores[6]);                

				$("#firmaDigitalEdit").val(valores[11]);				
				if (valores[11]!="") {  
					$("#pintarFirma1").append(
						$("<label>").text("Firma"),
						$("<img>").attr("src",valores[11]).addClass("img-responsive")
						);        
					$("#pintarFirma1").css("display", "block");
					$("#pintarFirma").css("display", "none");

				}else{
					$("#pintarFirma").css("display", "block");  
					$("#pintarFirma1").css("display", "none");                  
				}


                //$("#eclave").val(valores[10]);

                $("#formNPerfil").css("display","none");
                $("#formEUser").css("display","block");
                $("#totalclientes").css("display","none");

            },
            error: function() {
            	alert( "Ha ocurrido un error" );
            }
        });
});
//Funcion para eliminar usuarios del sistema
$(".elimUsuario").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar a este usuario?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimUsuario",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){$(id).css("display","none");},5000)

				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para editar la informacion del perfil del usuario
$("#enviarMiPerfil").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nombre" : $("#nombre").val(), "contrasena" : $("#contrasena").val(), "usuario" : $("#usuario").val(), "paterno" : $("#paterno").val(), "materno" : $("#materno").val(), "email" : $("#email").val(), "celular" : $("#celular").val(), "distribuidora" : $("#distribuidora").val(), "nivel" : $("#nivel").val(), "clave" : $("#clave").val(), "zona" : $("#zona").val(), "id" : $("#id").val(), "func" : "enviarMiPerfil",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){$(id).css("display","none");},5000)

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para eliminar un perfil de la lista
$(".elimPerfil").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar este Perfil?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimPerfil",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para suspender un perfil
$(".susPerfil").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender este Perfil?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susPerfil",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){location.reload();},5000)

				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para reactivar un perfil
$(".actPerfil").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender este Perfil?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actPerfil",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){location.reload();},5000)

				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para mostrar el formulario para un nuevo elemento de alguna lista
$("#showPerfil").click(function(){    
	$("#formNUser").css("display","block");
	$("#formEPerfil").css("display","none");
	$("#formEUser").css("display","none");
	$("#totalclientes").css("display","none");
    //$("#example1").css("display","none");

});
//Funcion para ocutar los formularios de edicion y de nuevo de las listas
$(".hideForms").click(function(){
	$("#formNUser").css("display","none");
	$("#formEPerfil").css("display","none"); 
	$("#formEUser").css("display","none"); 
	$("#totalclientes").css("display","block");
	document.getElementById("pintarFirma1").innerHTML = " "; 

});
//Funcion para mostrar el fomulario y llenarlo con la informacion correspondiente a la lista seleccionada
$(".editPerfil").click(function(){
	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "editPerfil",},
			success: function(data) {

				valores = data.split("::");
				$("#id").val(valor)
				$("#nombrePerfil").val(valores[0]);
				$("#descPerfil").val(valores[1]);
				$("#formNPerfil").css("display","none");
				$("#formEPerfil").css("display","block");

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para agregar un nuevo perfil
$("#addPerfil").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nombre" : $("#nombre").val(), "descripcion" : $("#descripcion").val(), "func" : "addPerfil",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para enviar la informacion de edicion del perfil
$("#SendEditPerfil").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : $("#id").val(), "nombre" : $("#nombrePerfil").val(), "descripcion" : $("#descPerfil").val(), "func" : "SendEditPerfil",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para eliminar una sucursal
$(".elimSucursal").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar esta sucursal?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimSucursal",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para eliminar un cliente
$(".elimCliente").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar este cliente?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimCliente",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para suspender una sucursal
$(".susSucursal").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender esta sucursal?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susSucursal",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para suspender un cliente
$(".susCliente").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender este cliente?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susCliente",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para activar o reactivar una sucursal
$(".actSucursal").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres activar esta sucursal?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actSucursal",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para activar o reactivar un cliente
$(".actCliente").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres activar este cliente?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actCliente",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para mostar el formulario lleno para editar una sucursal
$(".editSucursal").click(function(){
	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "editSucursal",},
			success: function(data) {

				valores = data.split("::");
				$("#id").val(valor)
				$("#nombreSuc").val(valores[0]);
				$("#ciudadSuc").val(valores[1]);
				$("#claveSuc").val(valores[2]);
				$("#formNPerfil").css("display","none");
				$("#formEPerfil").css("display","block");

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para mostar el formulario lleno para editar una sucursal
$(".editCliente").click(function(){

	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "editCliente",},
			success: function(data) {

				valores = data.split("::");
				$("#eid").val(valor)
				$("#enombre").val(valores[0]);
				$("#erfc").val(valores[1]);
				$("#erazon").val(valores[2]);
				$("#ecalle").val(valores[3]);
				$("#eexterior").val(valores[4]);
				$("#einterior").val(valores[5]);
				$("#ecolonia").val(valores[6]);
				$("#ecp").val(valores[7]);
				$("#eciudad").val(valores[8]);
				$("#emunicipio").val(valores[9]);
				$("#eestado").val(valores[10]);
				$("#etelefono").val(valores[11]);
				$("#eemail").val(valores[12]);
				$("#formNPerfil").css("display","none");
				$("#formEPerfil").css("display","block");    
				$("#totalclientes").css("display","none");
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para agregar una nueva sucursal
$("#addSucursal").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nombre" : $("#nombre").val(), "ciudad" : $("#ciudad").val(), "clave" : $("#clave").val(), "func" : "addSucursal",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para enviar la informacion de edicion de una sucursal
$("#SendEditSucursal").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : $("#id").val(), "nombre" : $("#nombreSuc").val(), "ciudad" : $("#ciudadSuc").val(), "clave" : $("#claveSuc").val(), "func" : "SendEditSucursal",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para enviar la informacion de edicion de un cliente
$("#SendEditCliente").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id"        : $("#eid").val(), 
			"nombre"    : $("#enombre").val(), 
			"rfc"       : $("#erfc").val(), 
			"razon"     : $("#erazon").val(), 
			"calle"     : $("#ecalle").val(), 
			"exterior"  : $("#eexterior").val(), 
			"interior"  : $("#einterior").val(), 
			"colonia"   : $("#ecolonia").val(), 
			"cp"        : $("#ecp").val(), 
			"ciudad"    : $("#eciudad").val(), 
			"municipio" : $("#emunicipio").val(), 
			"estado"    : $("#eestado").val(), 
			"telefono"  : $("#etelefono").val(), 
			"email"     : $("#eemail").val(), 
			"func" : "SendEditCliente",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para carga la lista de elementos del menú seleccionados dependiendo del nivel elegido
$("#nivelRelMP").change(function(){
	var nivel = $("#nivelRelMP").val();
	$("#idPerfil").val(nivel);
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nivel" : nivel, "func" : "nivelRelMP",},
			success: function(data) {
				$("#contieneLC").html(data);
				$("#showLC").css("display","block");
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para agregar un nuevo accesorio
$("#addAccesorio").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nombre" : $("#nombre").val(), "func" : "addAccesorio",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para enviar la informacion de edicion de un accesorio
$("#SendEditAccesorio").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : $("#id").val(), "nombre" : $("#nombreAcc").val(), "func" : "SendEditAccesorio",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para mostar el formulario lleno para editar una sucursal
$(".editAccesorio").click(function(){
	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "editAccesorio",},
			success: function(data) {

				valores = data.split("::");
				$("#id").val(valor)
				$("#nombreAcc").val(valores[0]);
				$("#formNPerfil").css("display","none");
				$("#formEPerfil").css("display","block");

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para eliminar un accesorio
$(".elimAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar este accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para suspender una sucursal
$(".susAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender este accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para activar o reactivar una sucursal
$(".actAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres activar este accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para agregar un nuevo Estatus de accesorio
$("#addEstatusAccesorio").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"nombre" : $("#nombre").val(), "func" : "addEstatusAccesorio",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para mostar el formulario lleno para editar un accesorio
$(".editEstatusAccesorio").click(function(){
	var valor = $(this).attr("id");
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : valor, "func" : "editEstatusAccesorio",},
			success: function(data) {

				valores = data.split("::");
				$("#id").val(valor)
				$("#nombreEstatusAccesorio").val(valores[0]);
				$("#formNPerfil").css("display","none");
				$("#formEPerfil").css("display","block");

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para eliminar un accesorio
$(".elimEstatusAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres eliminar este estatus de accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimEstatusAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para enviar la informacion de edicion de un accesorio
$("#SendEditEstatusAccesorio").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"id" : $("#id").val(), "nombre" : $("#nombreEstatusAccesorio").val(), "func" : "SendEditEstatusAccesorio",},
			success: function(data) {
				id = data == 1 ? "#exito" : "#error";
				$(id).css("display","block");
				setTimeout(function(){location.reload();},5000)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
});
//Funcion para suspender una sucursal
$(".susEstatusAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres suspender este accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susEstatusAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
//Funcion para activar o reactivar una sucursal
$(".actEstatusAccesorio").click(function(){
	var valor = $(this).attr("id");
	if (confirm("¿Estas seguro que quieres activar este accesorio?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actEstatusAccesorio",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)                
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
});
function validaCamposRecepcion(){
	var msgError = "";
	var countError = 0;



	if($("#nombreCliente").val() == ""){
		countError = countError-(-1);
		msgError = "<br />El nombre del cliente es obligatorio";
	}
	if($("#noserie").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El número de serie es  obligatorio";
	}
	if($("#chasis").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El número de chasis es  obligatorio";
	}
	if($("#modelo").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El modelo es  obligatorio";
	}
	if($("#anio").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El año es  obligatorio";
	}
	if($("#responsableRecibe").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />El nombre de quien entrega la unidad es  obligatorio";
	}
	if($("#firmaDigital").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />La firma de quien entrega es  obligatorio";
	}
	if($("#responsableEntrega").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />Nombre de quien entrga es obligatorio";
	}
	if($("#responsableTelefono").val() == ""){
		countError = countError-(-1);
		msgError = msgError + "<br />Teléfono de quien entrga es obligatorio";
	}

	$("input[type=radio]").each(function(){
		var val = $(this).attr("name");
		if(!document.querySelector('input[name="'+val+'"]:checked')) {
			countError = countError-(-1);
			msgError =msgError + "<br>Seleccione una opcion en el accesorio "+val;
		}
	});
	if(countError > 0){
		$("#showErrors").css("display", "block");
		$("#spcError").html(msgError);
	}

	return countError;
}
//Funcion para agregar una nueva unidad a recepcion
$("#addRecepcion").click(function(){

	var imagen=document.getElementById("canvasIzq").toDataURL('image/png');    

	var imagen1=document.getElementById("canvasDer").toDataURL('image/png');    

	var imagen2=document.getElementById("canvasArriba").toDataURL('image/png');    

	var imagen3=document.getElementById("canvasSeat").toDataURL('image/png');     

	var imagen4=document.getElementById("canvasFrente").toDataURL('image/png');    

	var imagen5=document.getElementById("canvasInterior").toDataURL('image/png');    

	var acount = new Array();
	var acc = new Array();
	var adic = new Array();
	var access = new Array();
	var error = "";
	var x = 0;
	var y = 0;
	var z = 0;
	var et= $("#tipoUnidad").val()==1?0:70;

	$("input[type=radio]").each(function(){
		var valor = $(this).attr("id");    
		if(this.checked){     
			var porci=valor.split('_');
			if (porci[0]=="tab" || porci[0]=="enc" || porci[0]=="ala") {
				var canti="0";
				adic[y] = valor;
				y++;

			}else{   
				var canti = document.getElementById((et+1)+"_3").value;   
				access[z] = valor.concat('_',canti);
				z++;
				et++;
			}   

			acc[x] = valor.concat('_',canti);
			x++;
		}        
	});

	error = validaCamposRecepcion();
	if(error == 0){
		var anterior = [];

		anterior.push({
			"responsable"   :  $("#responsable").val(), 
			"fecha"         :  $("#fecha").val(), 
			"cliente"       :  $("#cliente").val(), 
			"nombreCliente" :  $("#nombreCliente").val(), 
			"folio"         :  $("#folio").val(), 
			"sucursal"      :  $("#sucursal").val(), 
			"aresponsable"  :  $("#aresponsable").val(),
			"hora"          :  $("#hora").val(), 
			"nopedido"      :  $("#nopedido").val(), 
			"nooperacion"   :  $("#nooperacion").val(), 
			"noserie"       :  $("#noserie").val(), 
			"tipoUnidad"    :  $("#tipoUnidad").val(),
			"chasis"        :  $("#chasis").val(), 
			"modelo"        :  $("#modelo").val(), 
			"anio"          :  $("#anio").val(), 
			"placa"         :  $("#placa").val(), 
			"kilometraje"   :  $("#kilometraje").val(), 
			"volts"         :  $("#volts").val(),
			"combustible"   :  $("#combustible").val(), 
			"otro"          :  $("#otro").val(), 
			"observaciones" :  $("#observaciones").val(), 
			"responsableEntrega": $("#responsableEntrega").val(),
			"responsableTelefono": $("#responsableTelefono"),
			"func"          : "addRecepcion",
			"adic"          :  adic,
			"access"        :  access,
			"cantiad"       :  acount,
			"accesorios"    :  acc
		})
		var datosAnterior=JSON.stringify(anterior);
		localStorage.setItem("anterior",datosAnterior);

		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"responsable"   :  $("#responsable").val(), 
				"fecha"         :  $("#fecha").val(), 
				"cliente"       :  $("#cliente").val(), 
				"nombreCliente" :  $("#nombreCliente").val(), 
				"folio"         :  $("#folio").val(), 
				"sucursal"      :  $("#sucursal").val(), 
				"aresponsable"  :  $("#aresponsable").val(), 
				"hora"          :  $("#hora").val(), 
				"nopedido"      :  $("#nopedido").val(), 
				"nooperacion"   :  $("#nooperacion").val(), 
				"noserie"       :  $("#noserie").val(), 
				"tipoUnidad"    :  $("#tipoUnidad").val(),
				"chasis"        :  $("#chasis").val(), 
				"modelo"        :  $("#modelo").val(), 
				"anio"          :  $("#anio").val(), 
				"placa"         :  $("#placa").val(), 
				"kilometraje"   :  $("#kilometraje").val(), 
				"combustible"   :  $("#combustible").val(),             
				"volts"         :  $("#volts").val(),
				"otro"          :  $("#otro").val(), 
				"observaciones" :  $("#observaciones").val(), 
				"firmaDigital"  :  $("#firmaDigital").val(),
				"responsableEntrega": $("#responsableEntrega").val(),
				"responsableTelefono": $("#responsableTelefono").val(),
				"imagenCanvasIzq"  :  imagen,
				"imagenCanvasDer"  :  imagen1,
				"imagenCanvasArriba"  :  imagen2,
				"imagenCanvasSeat"  :  imagen3,
				"imagenCanvasFrente"  :  imagen4,
				"imagenCanvasInterior"  : imagen5,
				"func"          :  "addRecepcion",
				"adic"          :  adic,
				"access"        :  access,
				"cantiad"       :  acount,
				"accesorios"    :  acc
			},
			success: function(data) {  

				
				if(data == 0){
					window.location.href="recepcion.php";

				}
				else{
					id = data == 1 ? "#exito" : "#error";

					$(id).css("display","block");

					window.location.href="recepcion.php";

				}
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
	}
});



//Funcion que devuelve el nombre del cliente, para colocarlo en el campo señalado
$("#nombreCliente").keyup(function(){
	var valor = $("#nombreCliente").val();
	if(valor != ""){
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"valor"   :  valor, 
				"func"    : "searchClients",
			},
			success: function(data) {                
				if(data.length > 2){     
					$("#listClient").css("position", "absolute");     
					$("#listClient").css("height", "90px");
					$("#listClient").css("background", "#ffffff");
					$("#listClient").css("z-index", "1000");
					$("#listClient").css("width", "100%");
					$("#listClient").css("border", "#dddddd solid 1px");                 
					$("#listClient").html(data);
				}
				else{
					console.log("no existe");
					$("#listClient").removeClass("invisible");
					$("#listClient").css("height", "0px");
					$("#listClient").css("border", "none");     
					$("#listClient").html("");

				}   
			},
			error: function() {
			}
		});
	}
	else{
		$("#listClient").css("height", "0px");
		$("#listClient").css("border", "none");
		$("#listClient").html("");
	}
});
function selCliente(id){
	var idC = "c_"+id;
	var nom = $("#"+idC).html();
	$("#cliente").val(id);
	$("#nombreCliente").val(nom);
	$("#listClient").css("height", "0px");
	$("#listClient").css("border", "none");
	$("#listClient").html("");
}
$(".selCliente").click(function(){
	var idC = $(this).attr("id");
	var nom = $(this).val();
	idC = (idC),split("_");
	$("#cliente").val(idC[1]);
	$("#nombreCliente").val(nom);
	$("#listClient").css("height", "0px");
	$("#listClient").css("border", "none");
	$("#listClient").html("");
});
//Funcion para suspender una orden de receppcion de unidad


function susRecepcion(elemento,id){
	var valor = false;
	if(id){
		valor = id;
	}
	else {
		valor = elemento.attr("id");
	}
	if (confirm("¿Estas seguro que quieres suspender este registro?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "susRecepcion",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
}

$(".susRecepcion").click(function(){
	susRecepcion($(this),false);
});
//Funcion para eliminar una orden de recepcion de unidad
$(".elimRecepcion").click(function(){
	elimRecepcion($(this),false);
});

function elimRecepcion(elemento,id){
	var valor = false;
	if(id){
		valor = id;
	}
	else {
		valor = elemento.attr("id");
	}
	if (confirm("¿Estas seguro que quieres eliminar este registro?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "elimRecepcion",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}
}

//Funcion para activar o reactivar una orden de recepcion de unidad
$(".actRecepcion").click(function(){
	actRecepcion($(this),false);
});

function actRecepcion(elemento,id){
	var valor = false;
	if(id){
		valor = id;
	}
	else {
		valor = elemento.attr("id");
	}

	if (confirm("¿Estas seguro que quieres activar este registro?")) {
		$.ajax({
			url: urlSubmit,
			type: "POST",
			data: {
				"id" : valor, "func" : "actRecepcion",},
				success: function(data) {
					id = data == 1 ? "#exito" : "#error";
					$(id).css("display","block");
					setTimeout(function(){
						location.reload();
					},5000)
				},
				error: function() {
					alert( "Ha ocurrido un error" );
				}
			});
	}

}
//Funcion para editar la información de una orden de recepción


function editRecepcion(elemento, id){   

	var valor = false;
	if(id){      
		valor = id;
	}
	else {
		valor = elemento.attr("id");
	}

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {"id" : valor, "func" : "editRecepcion"},
		success: function(data) {

			valores = data.split("::");
			
			f = (valores[0]).split(" ");
			$("#eid").val(valor)                    /**/
			$("#efecha").val(f[0]);                 /**/
			$("#ehora").val(f[1]);                  /**/
			$("#efolio").val(valores[1]);           /**/
			$("#enopedido").val(valores[2]);        /**/
			$("#enooperacion").val(valores[3]);     /**/
			$("#enoserie").val(valores[4]);         /**/
			$("#echasis").val(valores[5]);          /**/
			$("#emodelo").val(valores[6]);          /**/
			$("#eanio").val(valores[7]);            /**/
			$("#eplaca").val(valores[8]);           /**/  
			$("#ekilometraje").val(valores[12]);    /**/
			$("#eotro").val(valores[13]);           /**/
			$("#eobservaciones").val(valores[14]);  /**/
			$("#enombreCliente").val(valores[15]);  /**/
			$("#ecliente").val(valores[16]);        /**/
			$("#ename").val(valores[17]);           /**/
			$("#eresponsable").val(valores[18]) ;   /**/
			$("#estatusActual").html(valores[19]);  /**/
			$("#responsableEntrega").val(valores[20]);        /**/
			$("#base64image").attr("src",valores[21]);        /**/  
			$("#fechaTermino").val(valores[22]); 
			$("#eresponsableTelefono").val(valores[23]);            
			$("#evolts").val(valores[24]);          /**/          

			var tablero = valores[9] == "si" ? "#etab_1" : "#etab_2";
			$(tablero).attr("checked", true);/**/

			tablero = valores[10] == "1" ? "#eenc_1" : "#eenc_2";
			$(tablero).attr("checked", true);/**/

			tablero = valores[11] == "1" ? "#eala_1" : "#eala_2";
			$(tablero).attr("checked", true);/**/            

			tablero = valores[25] == "1" ? "#ecarga_1" : "#ecarga_2";
			$(tablero).attr("checked", true);/**/  

			tablero = valores[26] == "1" ? "#eaire_1" : "#eaire_2";
			$(tablero).attr("checked", true);/**/  

			$("#rodado").val(valores[27]);   
			$("#lCarrozable").val(valores[28]);   
			$("#aPLarguero").val(valores[29]);   
			$("#aLarguero").val(valores[30]);   
			$("#alturaLar").val(valores[31]);   
			$("#pLarguero").val(valores[32]);   
			$("#altCabina").val(valores[33]);   
			$("#dEjes").val(valores[34]);   
			$("#diCabCenEjeTras").val(valores[35]);   
			$("#diCabCenEjeDelan").val(valores[36]);   
			$("#volTras").val(valores[37]);   
			$("#lTotalChas").val(valores[38]); 

			$("#linkPDF").attr("href", "downloadPDF.php?folio="+valores[1]);
			$("#linkPRV").attr("href", "downloadPRV.php?folio="+valores[1]);
			$("#linkIMG").attr("href", "verImagenes.php?folio="+valores[1]);


			$("#formEPerfil").css("display","block");
			$(".tabla-completa").css("opacity","0");
			$("html, body").animate({ scrollTop: 0 }, 600);

			
			showMedidasChasis(valor);			
			loadMotivo(valor);
			loadTipoUnidad(valor);
			loadAsesor(valor);
			loadCombustible(valor);			
			showAccesorios(valor);
		},
		error: function() {
			alert("Ha ocurrido un error");
		}
	});


	var elementos = document.getElementsByTagName("input");  
	for(var i=0; i<elementos.length;i=i+2) {
		if (elementos[i].type == "radio") {     
			actualizarDatosEdit(elementos[i]);
		}
	}
}

$(".cancela-edita-recepcion").click(function(){
	$("#formEPerfil").css("display","none");
	$(".tabla-completa").css("opacity","1");
});


$(".editRecepcion").click(function(){

	editRecepcion($(this),false);
});

$(".imagenesPDF").click(function(){
	imagenesPDF($(this),false);
});

$(".selectAccion").change(function(){
	var valor=$(this).val();

	var valores_funcion = valor.split('|');
	var accion = valores_funcion[0];
	var id = valores_funcion[1];

	if(accion == 'ver-imagenes'){
		window.location.href = "verImagenes.php?folio="+id;
		return false;
	}

	if(accion == 'editRecepcion'){
		editRecepcion(false,id);
		$(".selectAccion").each(function(){
			$(this).val('-1');
		});
		return false;
	}
	if(accion == 'susRecepcion'){
		susRecepcion(false,id);
		$(".selectAccion").each(function(){
			$(this).val('-1');
		});
		return false;
	}
	if(accion == 'actRecepcion'){
		actRecepcion(false,id);
		$(".selectAccion").each(function(){
			$(this).val('-1');
		});
		return false;
	}
	if(accion == 'elimRecepcion'){
		elimRecepcion(false,id);
		$(".selectAccion").each(function(){
			$(this).val('-1');
		});
		return false;
	}

});


//Funcion para cargar los accesorios en la edición
function loadAccesorios(id){

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "loadAccesorios", "id" : id,},
			success: function(data) { 			
				valores = data.split("::");				
				for(x=0;x<valores.length;x++){
					if(valores[x] != ""){
						f = (valores[x]).split("_"); 						
						$("#e"+f[0]+"_"+f[1]).attr("checked", true);
						$("#e"+f[0]+"_3").val(f[2]);
					}
				}
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}
//Funcion para cargar los motivos en la edición
function loadMotivo(id){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "loadMotivo", "id" : id,},
			success: function(data) {
				$("#esucursal").html(data)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}

function showAccesorios(id){
	
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "showAccesorios", "id" : id,},
			success: function(data) {
				$("#eformAccesorios").html(data);
				pintarAccesorios();
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}

function showMedidasChasis(id){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "showMedidasChasis", "id" : id,},
			success: function(data) {             
				if(data==2){
					$(".chasis").css("display","none");
				}
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}

//Funcion para cargar el tipo de unidad en la edición
function loadTipoUnidad(id){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "loadTipoUnidad", "id" : id,},
			success: function(data) {
				$("#etipoUnidad").html(data)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}

//Funcion para cargar el asesor en la edición
function loadAsesor(id){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "loadAsesor", "id" : id,},
			success: function(data) {
				$("#earesponsable").html(data)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}
//Funcion para cargar el nivel de combustible
function loadCombustible(id){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "loadCombustible", "id" : id,},
			success: function(data) {
				$("#ecombustible").html(data)
			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}
//Funcion para actualizar la relacion de menu-perfil
function relmenper(id){
	var valor = $("#"+id).prop("checked");
	var idPerfil = $("#idPerfil").val();
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"idPerfil" : idPerfil, "id" : id, "valor" : valor, "func" : "relmenper",},
			success: function(data) {

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}
//Funcion para actualizacion una unidad que ya entro en recepcion
$("#updRecepcion").click(function(){

	var acount = new Array();
	var acc = new Array();
	var adic = new Array();
	var access = new Array();
	var error = "";
	var x = 0;
	var y = 0;
	var z = 0;
	var et= $("#etipoUnidad").val()==1?0:70;
	$("input[type=radio]").each(function(){
		var valor = $(this).attr("id");
		if(this.checked){            
			var porci=valor.split('_');
			if (porci[0]=="etab" || porci[0]=="eenc" || porci[0]=="eala" || porci[0]=="ecarga" || porci[0]=="eaire" ) {
				adic[y] = valor;
				y++;
			}else{     				
				var canti = document.getElementById("e"+(et+1)+"_3").value;       
				access[z] = valor.concat('_',canti);
				z++;
				et++;
			}       
			acc[x] = valor.concat('_',canti);
			x++;
		}        
	});


	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"eid"           :  $("#eid").val(), 
			"responsable"   :  $("#eresponsable").val(), 
			"fecha"         :  $("#efecha").val(), 
			"cliente"       :  $("#ecliente").val(), 
			"nombreCliente" :  $("#enombreCliente").val(), 
			"folio"         :  $("#efolio").val(), 
			"sucursal"      :  $("#esucursal").val(), 
			"aresponsable"  :  $("#earesponsable").val(), 
			"hora"          :  $("#ehora").val(), 
			"nopedido"      :  $("#enopedido").val(), 
			"nooperacion"   :  $("#enooperacion").val(), 
			"noserie"       :  $("#enoserie").val(), 
			"etipoUnidad"    :  $("#etipoUnidad").val(), 
			"chasis"        :  $("#echasis").val(), 
			"modelo"        :  $("#emodelo").val(), 
			"anio"          :  $("#eanio").val(), 
			"placa"         :  $("#eplaca").val(), 
			"kilometraje"   :  $("#ekilometraje").val(), 
			"combustible"   :  $("#ecombustible").val(), 
			"volts"         :  $("#evolts").val(), 
			"otro"          :  $("#eotro").val(), 
			"observaciones" :  $("#eobservaciones").val(), 
			"fechaTermino"  :  $("#fechaTermino").val(),
			"firmaDRecepcion"  :  $("#firmaDRecepcion").val(),
			"responsableRecibe": $("#responsableRecibe").val(),
			"telefonoRecibe": $("#telefonoRecibe").val(),
			"proceso"       :  $("#proceso").val(),
			"fechaEntrega"  :  $("#fechaEntrega").val(),
			"rodado"        : $("#rodado").val(),
			"lCarrozable"   : $("#lCarrozable").val(),
			"aPLarguero"    : $("#aPLarguero").val(),
			"aLarguero"     : $("#aLarguero").val(),
			"alturaLar"     : $("#alturaLar").val(),
			"pLarguero"     : $("#pLarguero").val(),
			"altCabina"     : $("#altCabina").val(),
			"dEjes"         : $("#dEjes").val(),
			"diCabCenEjeTras"   : $("#diCabCenEjeTras").val(),
			"diCabCenEjeDelan"  : $("#diCabCenEjeDelan").val(),
			"volTras"       : $("#volTras").val(),
			"lTotalChas"    : $("#lTotalChas").val(),
			"func"          : "updRecepcion",           
			"adic"          :  adic,
			"access"        :  access,
			"cantiad"       :  acount,
			"accesorios"    :  acc
		},
		success: function(data) {           
			id = data == 1 ? "#exito" : "#error";
			$(id).css("display","block");
            //setTimeout(function(){location.reload();},5000)
            $("#formEPerfil").css("display","none");
            $(".tabla-completa").css("opacity","1");
            $("html, body").animate({ scrollTop: 0 }, 600);
        },
        error: function() {
            //alert( "Ha ocurrido un error" );
        }
    });
});
//Funciones para subir fotografías al sistema


$("#subirDerecha").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","derecha");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });

});

$("#subirDerechaEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","derecha");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });

});


$("#subirIzquierda").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","izquierda");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirIzquierdaEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","izquierda");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});


$("#subirFrente").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","delantera");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirFrenteEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","delantera");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

		console.log(res);
	});
});

$("#subirTrasera").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","trasera");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirTraseraEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","trasera");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});


$("#subirIfe").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","ife");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirIfeEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","ife");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});


$("#subirOtro").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	console.log(formData);
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","otro");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirOtroEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	console.log(formData);
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","otro");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirIne").change(function(){
	id = "uploadPictures";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","ine");
	$.ajax({
		url: "recibe.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});

$("#subirIneEntrada").change(function(){
	id = "uploadPicturesEntrega";
	var idRecepcion  = $("#eid").val();
	var formData = new FormData(document.getElementById(id));
	formData.append("idRecepcion",idRecepcion);
	formData.append("lado","ine");
	$.ajax({
		url: "entrega.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(res){

        //Aqui va lo que se hace cuando se sube con éxito
    });
});



$(".elimImagen").click(function(){
	var data = $(this).attr("data"); 
	var inf = "#rutaImg_"+data;
	var formData = new FormData();
    //formData.append("func","elimImagen");
    formData.append("ruta", $(inf).val());
    
    $.ajax({
    	url: "eliminar.php",
    	type: "post",
    	dataType: "html",
    	data: formData,
    	cache: false,
    	contentType: false,
    	processData: false
    }).done(function(res){
        if(res == 1){//Eliminado correctamente
        	setTimeout(function(){location.reload();},100)
        }
        else{//Hubo un problema al eliminar

        }
    });
});


$("#proceso").change(function(){
	if($("#proceso").val() == 3){
		$("#fechaEntrega").prop( "disabled", false );
		$(".firmaRecepcion").css("display","block");

	}    
	else{

		$("#fechaEntrega").prop( "disabled", true );
		$(".firmaRecepcion").css("display","none");

	}
});

$("#btnInfoUnidad").click(function(){

	if ("anterior" in localStorage) {

		var anterior=localStorage.getItem("anterior");
		var datos=JSON.parse(anterior);

		var clienteCookie = $("#clienteCookie").val();
		var nombreClienteCookie = $("#nombreClienteCookie").val();
		var sucursalCookie = $("#sucursalCookie").val();
		var aresponsableCookie = $("#aresponsableCookie").val();
		var nopedidoCookie = $("#nopedidoCookie").val();
		var noserieCookie = $("#noserieCookie").val();
		var nooperacionCookie = $("#nooperacionCookie").val();
		var chasisCookie = $("#chasisCookie").val();
		var modeloCookie = $("#modeloCookie").val();
		var anioCookie = $("#anioCookie").val();
		var placaCookie = $("#placaCookie").val();

		$("#cliente").val(datos[0].cliente);
		$("#nombreCliente").val(datos[0].nombreCliente);
		$("#sucursal option[value="+datos[0].sucursal+"]").attr('selected','selected');
		$("#aresponsable option[value="+datos[0].aresponsable+"]").attr('selected','selected');
		$("#nopedido").val(datos[0].nopedido);
		$("#noserie").val(datos[0].noserie);
		$("#nooperacion").val(datos[0].nooperacion);
		$("#chasis").val(datos[0].chasis);
		$("#modelo").val(datos[0].modelo);
		$("#anio").val(datos[0].anio);
		$("#placa").val(datos[0].placa);
	}else{
		console.log("no existe items");
	}
});

$("#btnAccesorios").click(function(){
	if ("anterior" in localStorage) {
		var anterior=localStorage.getItem("anterior");
		var datos=JSON.parse(anterior);
		var accesorios=datos[0].access;  
		$.each(accesorios, function(i,item){
			var radio= item.split("_");
			var radio2 = radio[0].concat('_'+radio[1]);
			var cant= radio[0].concat('_3');
			$("#"+radio2).attr('checked','checked');
			$("#"+cant).val(radio[2]);
		});
	}else{
		console.log("no existe items");
	}
});

$("#btnInfAdicional").click(function(){
	if ("anterior" in localStorage) {
		var anterior=localStorage.getItem("anterior");
		var datos=JSON.parse(anterior);
		var accesorios=datos[0].adic;
		$.each(accesorios, function(i,item){
			$("#"+item).attr('checked','checked');


		});

        // var combustibleCookie = $("#combustibleCookie").val();
        // $("#combustible option[value="+combustibleCookie+"]").attr('selected','selected');

        // var kilometrajeCookie = datos[0].kilometraje;
        // $("#kilometraje").val(kilometrajeCookie);

        var otroCookie = datos[0].otro;
        $("#otro").val(otroCookie);

        var observacionesCookie = datos[0].observaciones;
        $("#observaciones").val(observacionesCookie);
    }else{
    	console.log("no existe items");
    }

});


function actualizarDatosEdit(elemento) {
	var valor = $(elemento).attr("name");      
	var ship = document.getElementsByName(valor);
	var radioButSelValue = '';
	var numberSelValue =[];
	var x=0;
	var number='';
	var nodesArray = [].slice.call(ship);    
	for (var i=0; i<nodesArray.length; i++) {        
		if (nodesArray[i].checked) { 
			radioButSelValue = nodesArray[i].value;   
		}
		if(nodesArray[i].type == 'number'){            
			numberSelValue[x]=nodesArray[i].id;
			x++;
		}
	}
	if (radioButSelValue=="No") {
		$("#"+(numberSelValue[0])).val(0);
		$("#"+(numberSelValue[0])).prop("disabled", true);
		$("#"+(numberSelValue[0])).css("width", "50px");
		$("#quantity"+(numberSelValue[0])+" .quantity-nav").css("display","none");        
		var parentEls =$("#"+(numberSelValue[0])).parent().map(function() {
			return this.tagName;
		})
		.get()
		.join( ", " );
		$("#"+(numberSelValue[0]) ).append( "<strong>" + parentEls + "</strong>" );

	}else{        
		$("#"+(numberSelValue[0])).prop("disabled", false);
		$("#"+(numberSelValue[0])).css("width", "70px");
		$("#quantity"+(numberSelValue[0])+" .quantity-nav").css("display","block");
		$("#"+(numberSelValue[0])).val(1);        
	}
}



jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');

jQuery('.quantity').each(function() {

	var spinner = jQuery(this),

	input = spinner.find('input[type="number"]'),

	btnUp = spinner.find('.quantity-up'),

	btnDown = spinner.find('.quantity-down'),

	min = input.attr('min'),

	max = input.attr('max');

	btnUp.click(function() {

		var oldValue = parseFloat(input.val());

		if (oldValue >= max) {

			var newVal = oldValue;

		} else {

			var newVal = oldValue + 1;

		}

		spinner.find("input").val(newVal);

		spinner.find("input").trigger("change");

	});

	btnDown.click(function() {

		var oldValue = parseFloat(input.val());

		if (oldValue <= min) {

			var newVal = oldValue;

		} else {

			var newVal = oldValue - 1;

		}

		spinner.find("input").val(newVal);

		spinner.find("input").trigger("change");

	});

});

$("#descargaLista").click(function(){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {            
			"func" : "actualizarFechas"},
			success: function(data) {                
				if (data=1) {
					location.href ="https://frimax.mx/recepcion/descargaLista.php";
				}            else{
					setTimeout(function(){location.reload();},5000);
				}
               // data != 0 ? location.href ="https://www.frimax.mx/descargaLista.php" : setTimeout(function(){location.reload();},5000);
                // $(id).css("display","block");
                // setTimeout(function(){location.reload();},5000)
            },
            error: function() {
            	alert( "Ha ocurrido un error" );
            }
        });
});


$("#tipoUnidad").on("change",function(e){
	$id=e.target.value;

	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {            
			"func" : "accesoriosTipo",
			"id":$id
		},
		success: function(data) {   
			var acces = document.getElementById('formAccesorios');
			acces.innerHTML=data;
			pintarAccesorios(); 
		},
		error: function() {
			alert( "Ha ocurrido un error" );
		}
	});

	var canvas = document.getElementsByName('anomalias');
	for(var i=0; i<canvas.length;i++) {        
		canvas[i].addEventListener("click", getPosition);  
		var ctx=canvas[i].getContext("2d");
		var nombre=canvas[i].getAttribute("id");
		ctx.clearRect(0, 0, canvas[i].width, canvas[i].height);
		pintar(ctx,nombre,$id);
	}

	var pointSize = 7;

	function getPosition(event){
		var id=$(this).attr("id");
		var c = document.getElementById(id);
		var rect = c.getBoundingClientRect();
		var x = event.clientX - rect.left;
		var y = event.clientY - rect.top-6;
		var ctx=c.getContext("2d")
		ctx.fillStyle = "#ff2626";
		ctx.beginPath();
		ctx.arc(x, y, pointSize, 0, Math.PI * 2, true);
		ctx.fill();

	}

	var canvasIzq = document.getElementById('canvasIzq');
	var contextIzq= canvasIzq.getContext("2d");
	document.getElementById('btnCanvasIzq').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextIzq.clearRect(0, 0, canvasIzq.width, canvasIzq.height);
		pintar(contextIzq,nombre,$id);
		reset();

	}, false);

	var canvasDer = document.getElementById('canvasDer');
	var contextDer= canvasDer.getContext("2d");
	document.getElementById('btnCanvasDer').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextDer.clearRect(0, 0, canvasDer.width, canvasDer.height);
		pintar(contextDer,nombre,$id);
		reset();



	}, false);

	var canvasArriba = document.getElementById('canvasArriba');
	var contextArriba= canvasArriba.getContext("2d");
	document.getElementById('btnCanvasArriba').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextArriba.clearRect(0, 0, canvasArriba.width, canvasArriba.height);
		pintar(contextArriba,nombre,$id);
		reset();


	}, false);

	var canvasSeat = document.getElementById('canvasSeat');
	var contextSeat= canvasSeat.getContext("2d");
	document.getElementById('btnCanvasSeat').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextSeat.clearRect(0, 0, canvasSeat.width, canvasSeat.height);
		pintar(contextSeat,nombre,$id);
		reset();


	}, false);

	var canvasFrente = document.getElementById('canvasFrente');
	var contextFrente= canvasFrente.getContext("2d");
	document.getElementById('btnCanvasFrente').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextFrente.clearRect(0, 0, canvasFrente.width, canvasFrente.height);
		pintar(contextFrente,nombre,$id);
		reset();


	}, false);
	var canvasInterior = document.getElementById('canvasInterior');
	var contextInterior= canvasInterior.getContext("2d");
	document.getElementById('btnCanvasInterior').addEventListener('click', function() {
		var nombre=this.getAttribute("name");
		contextInterior.clearRect(0, 0, canvasInterior.width, canvasInterior.height);
		pintar(contextInterior,nombre,$id);
		reset();
	}, false);

	function reset() {

	};

	function pintar(auto,nombre,$id){            
		if(auto){
			var img = new Image();
			img.src = "images/"+nombre+"-"+$id+".png";
			img.onload = function(){
				auto.drawImage(img, 10, 10, 300, 120);
			}            
		}
	}  

});