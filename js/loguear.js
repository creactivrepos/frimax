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
function loguear(){
	var user = document.getElementById('usuario');
	var pass = document.getElementById('pass');
	var mensaje = document.getElementById('cont_error');
	if(user.value == ''){
		mensaje.innerHTML = 'El usuario no puede estar vacio';
		mensaje.className ="red";
	}
	else if(pass.value == ''){
		mensaje.innerHTML = 'El password no puede estar vacio';
		mensaje.className ="red";
	}
	else{
		
		ajax=nuevoAjax();
		ajax.open("POST", url+"ajax/login.php",true);
		ajax.onreadystatechange=function() {
			//alert(ajax.readyState);
			if (ajax.readyState<4) {
				mensaje.innerHTML = "Iniciando session ...";
			}
			else{
				//alert(ajax.responseText);
				if(ajax.responseText == 1){				
					mensaje.innerHTML = "Usuario incorrecto";						
					mensaje.className ="red";
				}
				else if(ajax.responseText == 2){
					mensaje.innerHTML = "Password incorrecto";						
					mensaje.className ="red";
				}
				else if(ajax.responseText == 3){
					mensaje.innerHTML = "Sesion iniciado correctamente";						
					mensaje.className ="green";
					setTimeout(function(){window.location=url+"index.php"},1000);
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("user="+user.value+"&pass="+pass.value)
	}
}

function cambiarContraseña(email){
	$.ajax({
		url: urlSubmit,
		type: "POST",
		data: {
			"func" : "cambiarcontrasena", "email" : email,},
			success: function(data) {         			
				if (data==1) {
					$("#passEmail").parent().before('<div class="alert alert-warning"><strong>Exito:</strong>Revisa tu correo</div>');
					 window.location.href ="https://frimax.mx/recepcion";
				}else{
					$("#passEmail").parent().before('<div class="alert alert-warning"><strong>Error:</strong>' +data+ '</div>');
				}

			},
			error: function() {
				alert( "Ha ocurrido un error" );
			}
		});
}


$("#cambiarContraseña").click(function(){
	var email=$("#passEmail").val();
	cambiarContraseña(email);
});

$("#passEmail").focus(function(){

	$(".alert").remove();
});
