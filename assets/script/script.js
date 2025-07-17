/*
Author: Ing. Ruben D. Chirinos R.
URL: http://asesoramientopc.hol.es/
*/

function set_salas_mesas(element) {
	$.get('funciones.php', { 'salas_mesas': true })
		.done(function (response) {
			$(element).html(response);
		})
}


function BuscaMasVendidos() {
    var codsucursal = $('#codsucursal').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var top_n = $('select#top_n').val();

    console.log("📦 codsucursal:", codsucursal); // <- NUEVO

    if (codsucursal == "" || desde == "" || hasta == "" || top_n == "") {
        Swal.fire({
            title: "¡ADVERTENCIA!",
            text: "PARA REALIZAR LA BÚSQUEDA DEBES SELECCIONAR LA SUCURSAL, FECHAS Y EL NÚMERO DE PRODUCTOS A MOSTRAR.",
            type: "warning",
            confirmButtonClass: "btn btn-blue",
            confirmButtonText: "¡Entendido!"
        });
        return false;
    }

    var dataString = 'BuscaMasVendidos=si&codsucursal=' + codsucursal + '&desde=' + desde + '&hasta=' + hasta + '&top_n=' + top_n;

    $.ajax({
        type: "GET",
        url: "busquedas.php",
        data: dataString,
        success: function(response) {
            $('#muestramasvendidos').html(response);
        }
    });
}

/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function () {

	/*set_salas_mesas($('#salas-mesas'));
	setTimeout(function run() {
		set_salas_mesas($('#salas-mesas'));
		setTimeout(run, 2000);
	}, 2000);*/

	$("#loginform").validate({
		rules:
		{
			usuario: { required: true, },
			password: { required: true, },
		},
		messages:
		{
			usuario: { required: "Por favor ingrese su Usuario de Acceso" },
			password: { required: "Por favor ingrese su Clave de Acceso" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* login submit */
	function submitForm() {
		var data = $("#loginform").serialize();

		$.ajax({

			type: 'POST',
			url: 'index.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (response) {
				//console.log(response);
				if (response == "ok") {

					$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
					setTimeout(' window.location.href = "panel.php"; ', 4000);
				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + response + ' </center>');
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
					});
				}
			}
		});
		return false;
	}
	/* login submit */
});




/* FUNCION JQUERY PARA VALIDAR DESBLOQUEAR CUENTA DE ACCESO*/
$('document').ready(function () {

	$("#lockscreen").validate({
		rules:
		{
			usuario: { required: true, },
			password: { required: true, },
		},
		messages:
		{
			usuario: { required: "Por favor ingrese su Usuario de Acceso" },
			password: { required: "Por favor ingrese su Clave de Acceso" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* login submit */
	function submitForm() {
		var data = $("#lockscreen").serialize();

		$.ajax({

			type: 'POST',
			url: 'lockscreen.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (response) {
				if (response == "ok") {

					$("#btn-login").html('<i class="fa"></i> Acceder');
					setTimeout(' window.location.href = "panel.php"; ', 4000);
				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + response + ' </center>');
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
					});
				}
			}
		});
		return false;
	}
	/* login submit */
});



















/* FUNCION JQUERY PARA RECUPERAR CONTRASE�A DE USUARIOS */

$('document').ready(function () {

	/* validation */
	$("#recuperarpassword").validate({
		rules:
		{
			email: { required: true, email: true },
		},
		messages:
		{
			email: { required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
		},
		errorElement: "span",
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#recuperarpassword").serialize();

		$.ajax({

			type: 'POST',
			url: 'index.php',
			data: data,
			beforeSend: function () {
				$("#errorr").fadeOut();
				$("#btn-recuperar").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error2").fadeIn(1000, function () {


						$("#errorr").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');

					});

				}
				else if (data == 2) {

					$("#errorr").fadeIn(1000, function () {


						$("#errorr").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL CORREO INGRESADO NO FUE ENCONTRADO ACTUALMENTE !</div></center>');

						$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');

					});
				}
				else {

					$("#errorr").fadeIn(1000, function () {

						$("#errorr").html('<center> ' + data + ' </center>');
						$("#recuperarpassword")[0].reset();
						setTimeout(function () { $("#errorr").html(""); }, 5000);
						$('#btn-recuperar').attr("disabled", true);
						$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');

					});

				}
			}
		});
		return false;
	}
	/* form submit */


});

/*  FIN DE FUNCION PARA RECUPERAR CONTRASE�A DE USUARIOS */




/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASE�A */

$('document').ready(function () {

	/* validation */
	$("#updatepassword").validate({
		rules:
		{
			usuario: { required: true },
			password: { required: true, minlength: 8 },
			password2: { required: true, minlength: 8, equalTo: "#password" },
		},
		messages:
		{
			usuario: { required: "Ingrese Usuario de Acceso" },
			password: { required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como m&iacute;nimo" },
			password2: { required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como m&iacute;nimo", equalTo: "Este Password no coincide" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatepassword").serialize();
		var id = $("#updatepassword").attr("data-id");
		var codigo = id;

		$.ajax({

			type: 'POST',
			url: 'password.php?codigo=' + codigo,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}

				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#updatepassword")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					});
				}
			}
		});
		return false;
	}
	/* form submit */
});

/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASE�A */



















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */

$('document').ready(function () {

	/* validation */
	$("#usuario").validate({
		rules:
		{
			cedula: { required: true, digits: true, minlength: 1 },
			nombres: { required: true, lettersonly: true },
			genero: { required: true, },
			fnac: { required: true, },
			lugnac: { required: true, },
			direcdomic: { required: true, },
			nrotelefono: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			usuario: { required: true, },
			password: { required: true, minlength: 8 },
			password2: { required: true, minlength: 8, equalTo: "#password" },
			nivel: { required: true, },
			codsucursal: { required: true, },
			status: { required: true, },
		},
		messages:
		{
			cedula: { required: "Ingrese Ruc de Usuario", digits: "Ingrese solo digitos para Ruc/Dni", minlength: "Ingrese 1 digitos como minimo" },
			nombres: { required: "Ingrese Nombre Completo de Usuario", lettersonly: "Ingrese solo letras para Nombre de Usuario" },
			genero: { required: "Seleccione Genero de Usuario" },
			fnac: { required: "Ingrese Fecha de Nacimiento de Usuario" },
			lugnac: { required: "Ingrese Lugar de Nacimiento de Usuario" },
			direcdomic: { required: "Ingrese Direcci&oacute;n de Usuario" },
			nrotelefono: { required: "Ingrese N&deg; de Telefono de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email: { required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			usuario: { required: "Ingrese Usuario de Acceso" },
			password: { required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
			password2: { required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel: { required: "Seleccione Nivel de Acceso" },
			codsucursal: { required: "Seleccione Sucursal Asignada" },
			status: { required: "Seleccione Status de Usuario" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#usuario").serialize();
		var formData = new FormData($("#usuario")[0]);

		$.ajax({
			type: 'POST',
			url: 'forusuario.php',
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> DEBE DE ASIGNARLE UNA SUCURSAL A LOS USUARIOS CON NIVELES DISTINTOS A ADMINISTRADOR, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 4) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 5) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#usuario")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */


});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE USUARIOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */

$('document').ready(function () {
	/* validation */
	$("#updateusuario").validate({
		rules:
		{
			cedula: { required: true, digits: true, minlength: 1 },
			nombres: { required: true, lettersonly: true },
			genero: { required: true, },
			fnac: { required: true, },
			lugnac: { required: true, },
			direcdomic: { required: true, },
			nrotelefono: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			usuario: { required: true, },
			password: { required: true, minlength: 8 },
			password2: { required: true, minlength: 8, equalTo: "#password" },
			nivel: { required: true, },
			codsucursal: { required: true, },
			status: { required: true, },
		},
		messages:
		{
			cedula: { required: "Ingrese Ruc/Dni de Usuario", digits: "Ingrese solo digitos para Ruc/Dni", minlength: "Ingrese 1 digitos como minimo" },
			nombres: { required: "Ingrese Nombre Completo de Usuario", lettersonly: "Ingrese solo letras para Nombre de Usuario" },
			genero: { required: "Seleccione Genero de Usuario" },
			fnac: { required: "Ingrese Fecha de Nacimiento de Usuario" },
			lugnac: { required: "Ingrese Lugar de Nacimiento de Usuario" },
			direcdomic: { required: "Ingrese Direcci&oacute;n de Usuario" },
			nrotelefono: { required: "Ingrese N&deg; de Telefono de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email: { required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			usuario: { required: "Ingrese Usuario de Acceso" },
			password: { required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
			password2: { required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel: { required: "Seleccione Nivel de Acceso" },
			codsucursal: { required: "Seleccione Sucursal Asignada" },
			status: { required: "Seleccione Status de Usuario" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateusuario").serialize();
		var formData = new FormData($("#updateusuario")[0]);
		var id = $("#updateusuario").attr("data-id");
		var codigo = id;

		$.ajax({
			type: 'POST',
			url: 'forusuario.php?codigo=' + codigo,
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> DEBE DE ASIGNARLE UNA SUCURSAL A LOS USUARIOS CON NIVELES DISTINTOS A ADMINISTRADOR, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-save"></span> Actualizar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 4) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 5) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='usuarios.php'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */

});

/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */































/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION */

$('document').ready(function () {
	/* validation */
	$("#configuracion").validate({
		rules:
		{
			cedresponsable: { required: true, digits: true, minlength: 10, maxlength: 13 },
			nomresponsable: { required: true, lettersonly: true },
			celresponsable: { required: true, },
			rucsucursal: { required: true, digits: true, minlength: 10, maxlength: 13 },
			razonsocial: { required: true, },
			tlfsucursal: { required: true, },
			celsucursal: { required: true, },
			emailsucursal: { required: true, email: true },
			direcsucursal: { required: true, },
			ivacsucursal: { required: true, number: true },
			ivavsucursal: { required: true, number: true },
			simbolo: { required: false, },
		},
		messages:
		{
			cedresponsable: { required: "Ingrese Dni o Ruc de Responsable", digits: "Ingrese solo digitos para Dni o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			nomresponsable: { required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre de Responsable" },
			celresponsable: { required: "Ingrese N&deg; de Celular de Responsable" },
			rucsucursal: { required: "Ingrese Ruc de Sucursal", digits: "Ingrese solo digitos para Dni o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			razonsocial: { required: "Ingrese Raz&oacute;n Social" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Sucursal" },
			celsucursal: { required: "Ingrese N&deg; de Celular de Sucursal" },
			emailsucursal: { required: "Ingrese Email de Sucursal", email: "Ingrese un Email Valido" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n completa de Sucursal" },
			ivacsucursal: { required: "Ingrese Iva para Compras de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Compras" },
			ivavsucursal: { required: "Ingrese Iva para Ventas de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			simbolo: { required: "Ingrese Simbolo para Precios" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#configuracion").serialize();
		var id = $("#configuracion").attr("data-id");
		var id = id;

		$.ajax({

			type: 'POST',
			url: 'configuracion.php?id=' + id,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				} else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */

});

/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION */






































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SUCURSALES */

$('document').ready(function () {

	/* validation */
	$("#sucursal").validate({
		rules:
		{
			nrosucursal: { required: true, },
			cedresponsable: { required: true, digits: true, minlength: 10, maxlength: 13 },
			nomresponsable: { required: true, lettersonly: true },
			celresponsable: { required: true, },
			rucsucursal: { required: true, digits: true, minlength: 10, maxlength: 13 },
			razonsocial: { required: true, },
			tlfsucursal: { required: true, },
			celsucursal: { required: true, },
			emailsucursal: { required: true, email: true },
			direcsucursal: { required: true, },
			nroactividadsucursal: { required: true, },
			nroiniciofactura: { required: true, digits: true, minlength: 9, maxlength: 9 },
			fechaautorsucursal: { required: true, },
			ivacsucursal: { required: true, number: true },
			ivavsucursal: { required: true, number: true },
			descsucursal: { required: true, number: true },
			llevacontabilidad: { required: true, },
			simbolo: { required: false, },
		},
		messages:
		{
			nrosucursal: { required: "Ingrese N&deg; de Sucursal" },
			cedresponsable: { required: "Ingrese C&eacute;dula o Ruc de Responsable", digits: "Ingrese solo digitos para C&eacute;dula o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			nomresponsable: { required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre de Responsable" },
			celresponsable: { required: "Ingrese N&deg; de Celular de Responsable" },
			rucsucursal: { required: "Ingrese Ruc de Sucursal", digits: "Ingrese solo digitos para C&eacute;dula o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			razonsocial: { required: "Ingrese Raz&oacute;n Social" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Sucursal" },
			celsucursal: { required: "Ingrese N&deg; de Celular de Sucursal" },
			emailsucursal: { required: "Ingrese Email de Sucursal", email: "Ingrese un Email Valido" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n completa de Sucursal" },
			nroactividadsucursal: { required: "Ingrese N&deg; de Actividad de Sucursal" },
			nroiniciofactura: { required: "Ingrese N&deg; Inicio de Factura", digits: "Ingrese solo digitos para N&deg; de Inicio", minlength: "Ingrese 9 digitos como minimo", maxlength: "Ingrese 9 digitos como minimo" },
			fechaautorsucursal: { required: "Ingrese Fecha de Autorizaci&oacute;n de Sucursal" },
			ivacsucursal: { required: "Ingrese Iva para Compras de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Compras" },
			ivavsucursal: { required: "Ingrese Iva para Ventas de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			descsucursal: { required: "Ingrese Dcto para Ventas de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			llevacontabilidad: { required: "Seleccione si lleva Contabilidad" },
			simbolo: { required: "Ingrese Simbolo para Precios" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#sucursal").serialize();
		var formData = new FormData($("#sucursal")[0]);

		$.ajax({
			type: 'POST',
			url: 'forsucursal.php',
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UNA SUCURSAL CON ESTE N&deg; DE C&Eacute;DULA O RUC, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 4) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg; DE FACTURA YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 5) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA SUCURSAL YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#sucursal")[0].reset();
						$("#numerosucursal").load("funciones.php?muestranumerosucursal=si");
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */

});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE SUCURSALES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE SUCURSALES */

$('document').ready(function () {
	/* validation */
	$("#updatesucursal").validate({
		rules:
		{
			codsucursal: { required: true, },
			cedresponsable: { required: true, digits: true, minlength: 10, maxlength: 13 },
			nomresponsable: { required: true, lettersonly: true },
			celresponsable: { required: true, },
			rucsucursal: { required: true, digits: true, minlength: 10, maxlength: 13 },
			razonsocial: { required: true, },
			tlfsucursal: { required: true, },
			celsucursal: { required: true, },
			emailsucursal: { required: true, email: true },
			direcsucursal: { required: true, },
			nroactividadsucursal: { required: true, },
			nroiniciofactura: { required: true, digits: true, minlength: 9, maxlength: 9 },
			fechaautorsucursal: { required: true, },
			ivacsucursal: { required: true, number: true },
			ivavsucursal: { required: true, number: true },
			descsucursal: { required: true, number: true },
			llevacontabilidad: { required: true, },
			simbolo: { required: false, },
		},
		messages:
		{
			codsucursal: { required: "Ingrese C&oacute;digo" },
			cedresponsable: { required: "Ingrese C&eacute;dula o Ruc de Responsable", digits: "Ingrese solo digitos para C&eacute;dula o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			nomresponsable: { required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre de Responsable" },
			celresponsable: { required: "Ingrese N&deg; de Celular de Responsable" },
			rucsucursal: { required: "Ingrese Ruc de Sucursal", digits: "Ingrese solo digitos para C&eacute;dula o Ruc", minlength: "Ingrese 10 digitos como minimo", maxlength: "Ingrese 13 digitos como minimo" },
			razonsocial: { required: "Ingrese Raz&oacute;n Social" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Sucursal" },
			celsucursal: { required: "Ingrese N&deg; de Celular de Sucursal" },
			emailsucursal: { required: "Ingrese Email de Sucursal", email: "Ingrese un Email Valido" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n completa de Sucursal" },
			nroactividadsucursal: { required: "Ingrese N&deg; de Actividad de Sucursal" },
			nroiniciofactura: { required: "Ingrese N&deg; Inicio de Factura", digits: "Ingrese solo digitos para N&deg; de Inicio", minlength: "Ingrese 9 digitos como minimo", maxlength: "Ingrese 9 digitos como minimo" },
			fechaautorsucursal: { required: "Ingrese Fecha de Autorizaci&oacute;n de Sucursal" },
			ivacsucursal: { required: "Ingrese Iva para Compras de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Compras" },
			ivavsucursal: { required: "Ingrese Iva para Ventas de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			descsucursal: { required: "Ingrese Dcto para Ventas de Sucursal", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			llevacontabilidad: { required: "Seleccione si lleva Contabilidad" },
			simbolo: { required: "Ingrese Simbolo para Precios" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatesucursal").serialize();
		var formData = new FormData($("#updatesucursal")[0]);
		var id = $("#updatesucursal").attr("data-id");
		var codsucursal = id;

		$.ajax({
			type: 'POST',
			url: 'forsucursal.php?codsucursal=' + codsucursal,
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UNA SUCURSAL CON ESTE N&deg; DE C&Eacute;DULA O RUC, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 4) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg; DE FACTURA YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else if (data == 5) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg; DE AUTORIZACI&oacute;N YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else if (data == 6) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA SUCURSAL YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='sucursales'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */

});

/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE SUCURSALES */








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */
$('document').ready(function () {
	/* validation */
	$("#mediopago").validate({
		rules:
		{
			mediopago: { required: true, },
		},
		messages:
		{
			mediopago: { required: "Ingrese Medio de Pago" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#mediopago").serialize();

		$.ajax({

			type: 'POST',
			url: 'formediopago.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE MEDIO DE PAGO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#mediopago")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MEDIOS DE PAGOS */
$('document').ready(function () {
	/* validation */
	$("#updatemediopago").validate({
		rules:
		{
			mediopago: { required: true, },
		},
		messages:
		{
			mediopago: { required: "Ingrese Medio de Pago" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatemediopago").serialize();
		var id = $("#updatemediopago").attr("data-id");
		var codmediopago = id;

		$.ajax({

			type: 'POST',
			url: 'formediopago.php?codmediopago=' + codmediopago,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE MEDIO DE PAGO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='mediospagos'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MEDIOS DE PAGOS */








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ENTIDADES BANCARIAS */
$('document').ready(function () {
	/* validation */
	$("#bancos").validate({
		rules:
		{
			nombanco: { required: true, },
		},
		messages:
		{
			nombanco: { required: "Ingrese Nombre de Entidad Bancaria" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#bancos").serialize();

		$.ajax({

			type: 'POST',
			url: 'forbanco.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA ENTIDAD BANCARIA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#bancos")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ENTIDADES BANCARIAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ENTIDADES BANCARIAS */
$('document').ready(function () {
	/* validation */
	$("#updatebanco").validate({
		rules:
		{
			nombanco: { required: true, },
		},
		messages:
		{
			nombanco: { required: "Ingrese Nombre de Entidad Bancaria" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatebanco").serialize();
		var id = $("#updatebanco").attr("data-id");
		var codbanco = id;

		$.ajax({

			type: 'POST',
			url: 'forbanco.php?codbanco=' + codbanco,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA ENTIDAD BANCARIA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='bancos'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ENTIDADES BANCARIAS */








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE TARJETAS */
$('document').ready(function () {
	/* validation */
	$("#tarjetas").validate({
		rules:
		{
			codbanco: { required: true, },
			nomtarjeta: { required: true, },
			tipotarjeta: { required: true, },
		},
		messages:
		{
			codbanco: { required: "Seleccione Entidad Bancaria" },
			nomtarjeta: { required: "Ingrese Nombre de Tarjeta" },
			tipotarjeta: { required: "Seleccione Tipo de Tarjeta" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#tarjetas").serialize();

		$.ajax({

			type: 'POST',
			url: 'fortarjeta.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE TARJETA YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#tarjetas")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE TARJETAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TIPOS DE TARJETAS */
$('document').ready(function () {
	/* validation */
	$("#updatetarjeta").validate({
		rules:
		{
			codbanco: { required: true, },
			nomtarjeta: { required: true, },
			tipotarjeta: { required: true, },
		},
		messages:
		{
			codbanco: { required: "Seleccione Entidad Bancaria" },
			nomtarjeta: { required: "Ingrese Nombre de Tarjeta" },
			tipotarjeta: { required: "Seleccione Tipo de Tarjeta" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatetarjeta").serialize();
		var id = $("#updatetarjeta").attr("data-id");
		var codtarjeta = id;

		$.ajax({

			type: 'POST',
			url: 'fortarjeta.php?codtarjeta=' + codtarjeta,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE TARJETA YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='tarjetas'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TIPOS DE TARJETAS */






































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE INTERES EN TARJETAS */
$('document').ready(function () {
	/* validation */
	$("#intereses").validate({
		rules:
		{
			tipotarjeta: { required: true, },
			codbanco: { required: true, },
			codtarjeta: { required: true, },
			meses: { required: true, digits: true },
			tasasi: { required: true, number: true },
			tasano: { required: true, number: true },
		},
		messages:
		{
			tipotarjeta: { required: "Seleccione Tipo de Tarjeta" },
			codbanco: { required: "Seleccione Entidad Bancaria" },
			codtarjeta: { required: "Seleccione Nombre de Tarjeta" },
			meses: { required: "Ingrese N&deg; de Meses", digits: "Ingrese solo digitos" },
			tasasi: { required: "Ingrese Diferido con Intereses", number: "Ingrese solo numeros con dos decimales" },
			tasano: { required: "Ingrese Diferido sin Intereses", number: "Ingrese solo numeros con dos decimales" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#intereses").serialize();

		$.ajax({

			type: 'POST',
			url: 'forinteres.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA TASA DE INTERES YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA Y TARJETA DE DEBITO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA TASA DE INTERES YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA Y TARJETA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#intereses")[0].reset();
						$("#codbanco").attr('disabled', true);
						$("#codtarjeta").attr('disabled', true);
						$("#meses").attr('disabled', true);
						$("#tasasi").attr('disabled', true);
						$("#tasano").attr('disabled', true);
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE INTERES EN TARJETAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE INTERES EN TARJETAS */
$('document').ready(function () {
	/* validation */
	$("#updateintereses").validate({
		rules:
		{
			tipotarjeta: { required: true, },
			codbanco: { required: true, },
			codtarjeta: { required: true, },
			meses: { required: true, digits: true },
			tasasi: { required: true, number: true },
			tasano: { required: true, number: true },
		},
		messages:
		{
			tipotarjeta: { required: "Seleccione Tipo de Tarjeta" },
			codbanco: { required: "Seleccione Entidad Bancaria" },
			codtarjeta: { required: "Seleccione Nombre de Tarjeta" },
			meses: { required: "Ingrese N&deg; de Meses", digits: "Ingrese solo digitos" },
			tasasi: { required: "Ingrese Diferido con Intereses", number: "Ingrese solo numeros con dos decimales" },
			tasano: { required: "Ingrese Diferido sin Intereses", number: "Ingrese solo numeros con dos decimales" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateintereses").serialize();
		var id = $("#updateintereses").attr("data-id");
		var codinteres = id;

		$.ajax({

			type: 'POST',
			url: 'forinteres.php?codinteres=' + codinteres,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA TASA DE INTERES YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA Y TARJETA DE DEBITO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA TASA DE INTERES YA SE ENCUENTRA ASIGNADA A ESTA ENTIDAD BANCARIA Y TARJETA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='intereses'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE INTERES EN TARJETAS */


































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CATEGORIAS */
$('document').ready(function () {
	/* validation */
	$("#medidas").validate({
		rules:
		{
			nommedida: { required: true, },
		},
		messages:
		{
			nommedida: { required: "Ingrese Nombre de Unidad de Medida" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#medidas").serialize();

		$.ajax({

			type: 'POST',
			url: 'formedida.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE UNIDAD DE MEDIDA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#medidas")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CATEGORIAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CATEGORIAS */
$('document').ready(function () {
	/* validation */
	$("#updatemedida").validate({
		rules:
		{
			codmedida: { required: true, },
			nommedida: { required: true, },
		},
		messages:
		{
			codmedida: { required: "Ingrese C&oacute;digo de Unidad de Medida" },
			nommedida: { required: "Ingrese Nombre de Unidad de Medida" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatemedida").serialize();
		var id = $("#updatemedida").attr("data-id");
		var codmedida = id;

		$.ajax({

			type: 'POST',
			url: 'formedida.php?codmedida=' + codmedida,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE UNIDAD DE MEDIDA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='medidas'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CATEGORIAS */




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRESENTACIONES */
$('document').ready(function () {
	/* validation */
	$("#presentaciones").validate({
		rules:
		{
			nompresentacion: { required: true, },
		},
		messages:
		{
			nompresentacion: { required: "Ingrese Nombre de Presentaci&oacute;n" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#presentaciones").serialize();

		$.ajax({

			type: 'POST',
			url: 'forpresentacion.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE PRESENTACION YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#presentaciones")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRESENTACIONES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRESENTACIONES */
$('document').ready(function () {
	/* validation */
	$("#updatepresentacion").validate({
		rules:
		{
			codpresentacion: { required: true, },
			nompresentacion: { required: true, },
		},
		messages:
		{
			codpresentacion: { required: "Ingrese C&oacute;digo de Presentaci&oacute;n" },
			nompresentacion: { required: "Ingrese Nombre de Presentaci&oacute;n" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatepresentacion").serialize();
		var id = $("#updatepresentacion").attr("data-id");
		var codpresentacion = id;

		$.ajax({

			type: 'POST',
			url: 'forpresentacion.php?codpresentacion=' + codpresentacion,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE PRESENTACION YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='presentaciones'", 5000);


					});

				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRESENTACIONES */


































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */
$('document').ready(function () {
	/* validation */
	$("#cajas").validate({
		rules:
		{
			nrocaja: { required: true, },
			nombrecaja: { required: true, },
			codigo: { required: false, },
		},
		messages:
		{
			nrocaja: { required: "Ingrese Numero de Caja" },
			nombrecaja: { required: "Ingrese Nombre de Caja" },
			codigo: { required: "Seleccione Responsable de Caja" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#cajas").serialize();

		$.ajax({

			type: 'POST',
			url: 'forcaja.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg; DE CAJA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$("#cajas")[0].reset();
						$("#codigocaja").load("funciones.php?muestracodigocaja=si");
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJA DE VENTAS */
$('document').ready(function () {
	/* validation */
	$("#updatecajas").validate({
		rules:
		{
			nrocaja: { required: true, },
			nombrecaja: { required: true, },
			codigo: { required: false, },
		},
		messages:
		{
			nrocaja: { required: "Ingrese Numero de Caja" },
			nombrecaja: { required: "Ingrese Nombre de Caja" },
			codigo: { required: "Seleccione Responsable de Caja" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatecajas").serialize();
		var id = $("#updatecajas").attr("data-id");
		var codcaja = id;

		$.ajax({

			type: 'POST',
			url: 'forcaja.php?codcaja=' + codcaja,
			data: data,

			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg; DE CAJA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='cajas'", 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJAS DE VENTAS */







































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE LABORATORIOS */
$('document').ready(function () {
	/* validation */
	$("#laboratorios").validate({
		rules:
		{
			nomlaboratorio: { required: true, },
			aplicadescuento: { required: true, },
			desclaboratorio: { required: true, number: true },
			recargotc: { required: true, number: true },
		},
		messages:
		{
			nomlaboratorio: { required: "Ingrese Nombre de Laboratorio" },
			aplicadescuento: { required: "Seleccione Si Aplica Descuento %" },
			desclaboratorio: { required: "Ingrese Descuento %", number: "Ingrese solo digitos con 2 decimales" },
			recargotc: { required: "Ingrese Recarga de TDC", number: "Ingrese solo digitos con 2 decimales" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#laboratorios").serialize();

		$.ajax({

			type: 'POST',
			url: 'forlaboratorio.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE LABORATORIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#laboratorios")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE LABORATORIOS */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE LABORATORIOS */
$('document').ready(function () {
	/* validation */
	$("#updatelaboratorios").validate({
		rules:
		{
			nomlaboratorio: { required: true, },
			aplicadescuento: { required: true, },
			desclaboratorio: { required: true, number: true },
			recargotc: { required: true, number: true },
		},
		messages:
		{
			nomlaboratorio: { required: "Ingrese Nombre de Laboratorio" },
			aplicadescuento: { required: "Seleccione Si Aplica Descuento %" },
			desclaboratorio: { required: "Ingrese Descuento %", number: "Ingrese solo digitos con 2 decimales" },
			recargotc: { required: "Ingrese Recarga de TDC", number: "Ingrese solo digitos con 2 decimales" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatelaboratorios").serialize();
		var id = $("#updatelaboratorios").attr("data-id");
		var codlaboratorio = id;

		$.ajax({

			type: 'POST',
			url: 'forlaboratorio.php?codlaboratorio=' + codlaboratorio,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE LABORATORIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='laboratorios'", 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE LABORATORIOS */



































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */
$('document').ready(function () {
	/* validation */
	$("#proveedores").validate({
		rules:
		{
			rucproveedor: { required: true, digits: true },
			nomproveedor: { lettersonly: true, lettersonly: true },
			/*direcproveedor: { required: true, },
			tlfproveedor: { required: true, digits : false  },
			celproveedor: { required: true, digits : false  },
			emailproveedor: { required: true, email: true },
			contactoproveedor: { required: true, lettersonly: true },*/
		},
		messages:
		{
			rucproveedor: { required: "Ingrese C.I/RUC de Proveedor", digits: "Ingrese solo digitos para C.I/RUC" },
			nomproveedor: { required: "Ingrese Nombre de Proveedor", lettersonly: "Ingrese solo letras para Nombre de Proveedor" },
			/*direcproveedor:{ required: "Ingrese Direcci&oacute;n de Proveedor" },
			tlfproveedor: { required: "Ingrese N&deg; de Tel&eacute;fono de Proveedor", digits: "Ingrese solo digitos" },
			celproveedor: { required: "Ingrese N&deg; de Celular de Proveedor", digits: "Ingrese solo digitos" },
			emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
			contactoproveedor:{ required: "Ingrese Nombre de Persona de Contacto", lettersonly: "Ingrese solo letras para Persona de Contacto" },*/
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#proveedores").serialize();

		$.ajax({

			type: 'POST',
			url: 'forproveedor.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#proveedores")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */
$('document').ready(function () {
	/* validation */
	$("#updateproveedores").validate({
		rules:
		{
			rucproveedor: { required: true, digits: true },
			nomproveedor: { lettersonly: true, lettersonly: true },
			/*direcproveedor: { required: true, },
			tlfproveedor: { required: true, digits : false  },
			celproveedor: { required: true, digits : false  },
			emailproveedor: { required: true, email: true },
			contactoproveedor: { required: true, lettersonly: true },*/
		},
		messages:
		{
			rucproveedor: { required: "Ingrese C.I/RUC de Proveedor", digits: "Ingrese solo digitos para C.I/RUC" },
			nomproveedor: { required: "Ingrese Nombre de Proveedor", lettersonly: "Ingrese solo letras para Nombre de Proveedor" },
			/* direcproveedor:{ required: "Ingrese Direcci&oacute;n de Proveedor" },
			 tlfproveedor: { required: "Ingrese N&deg; de Tel&eacute;fono de Proveedor", digits: "Ingrese solo digitos" },
			 celproveedor: { required: "Ingrese N&deg; de Celular de Proveedor", digits: "Ingrese solo digitos" },
			 emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
			 contactoproveedor:{ required: "Ingrese Nombre de Persona de Contacto", lettersonly: "Ingrese solo letras para Persona de Contacto" },*/
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateproveedores").serialize();
		var id = $("#updateproveedores").attr("data-id");
		var codproveedor = id;

		$.ajax({

			type: 'POST',
			url: 'forproveedor.php?codproveedor=' + codproveedor,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='proveedores'", 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */


















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */
$('document').ready(function () {
	/* validation */
	$("#clientes").validate({
		rules:
		{
			cedcliente: { required: true, digits: true },
			nomcliente: { lettersonly: true, lettersonly: true },
			/*direccliente: { required: true, },
			tlfcliente: { required: true, digits : false  },
			celcliente: { required: true, digits : false  },
			emailcliente: { required: false, email: true },*/
		},
		messages:
		{
			cedcliente: { required: "Ingrese C.I/RUC de Cliente", digits: "Ingrese solo digitos para C.I/RUC" },
			nomcliente: { required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombre de Cliente" },
			/* direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			 tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono de Cliente", digits: "Ingrese solo digitos" },
			 celcliente: { required: "Ingrese N&deg; de Celular de Cliente", digits: "Ingrese solo digitos" },
			 emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },*/
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#clientes").serialize();
		$.ajax({
			type: 'POST',
			url: 'clientes.php',
			data: data,
			beforeSend: function () {
				$("#read").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#read").fadeIn(1000, function () {


						$("#read").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 2) {

					$("#read").fadeIn(1000, function () {


						$("#read").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#read").fadeIn(1000, function () {
						$("#read").html('<center> ' + data + ' </center>');
						$("#clientes")[0].reset();
						setTimeout(function () { $("#read").html(""); window.location.reload(true); }, 3000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */
$('document').ready(function () {
	/* validation */
	$("#updateclientes").validate({
		rules:
		{
			cedcliente: { required: true, digits: true },
			nomcliente: { lettersonly: true, lettersonly: true },
			/*direccliente: { required: true, },
			tlfcliente: { required: true, digits : false  },
			celcliente: { required: true, digits : false  },
			emailcliente: { required: false, email: true },*/
		},
		messages:
		{
			cedcliente: { required: "Ingrese C.I/RUC de Cliente", digits: "Ingrese solo digitos para C.I/RUC" },
			nomcliente: { required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombre de Cliente" },
			/* direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			 tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono de Cliente", digits: "Ingrese solo digitos" },
			 celcliente: { required: "Ingrese N&deg; de Celular de Cliente", digits: "Ingrese solo digitos" },
			 emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },*/
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateclientes").serialize();
		var codcliente = $('input#codcliente').val();
		var busqueda = $('input#busqueda').val();

		$.ajax({
			type: 'POST',
			url: 'clientes.php?codcliente=' + codcliente,
			data: data,
			beforeSend: function () {
				$("#update").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#update").fadeIn(1000, function () {


						$("#update").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#update").fadeIn(1000, function () {


						$("#update").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#update").fadeIn(1000, function () {

						$("#update").html('<center> ' + data + ' </center>');
						//$("#resultadocliente").load("funciones.php?BusquedaClientes=si&buscacliente="+busqueda);

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout(function () { $("#update").html(""); window.location.reload(true); }, 3000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */


















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TRANSPORTE DE GUIA */
$('document').ready(function () {
	/* validation */
	$("#transporte").validate({
		rules:
		{
			rucchofer: { required: true, digits: true },
			nomchofer: { lettersonly: true, lettersonly: true },
			tlfchofer: { required: true, digits: false },
			numbultos: { required: true, digits: false },
			ruta: { required: true, },
			ciudadruta: { required: true, },
			placavehiculo: { required: true, },
			llegada: { required: true, },
			motivotraslado: { required: true, },
			desde: { required: true, },
			hasta: { required: true, },
			statuschofer: { required: true, },
		},
		messages:
		{
			rucchofer: { required: "Ingrese C.I/RUC de Chofer", digits: "Ingrese solo digitos para C.I/RUC" },
			nomchofer: { required: "Ingrese Nombre de Chofer", lettersonly: "Ingrese solo letras para Nombre de Chofer" },
			tlfchofer: { required: "Ingrese N&deg; de Tel&eacute;fono de Chofer", digits: "Ingrese solo digitos" },
			numbultos: { required: "Ingrese N&deg; de Bultos", digits: "Ingrese solo digitos" },
			ruta: { required: "Ingrese Direcci&oacute;n de Ruta" },
			ciudadruta: { required: "Ingrese Ciudad de Ruta" },
			placavehiculo: { required: "Ingrese N&deg; de Placa de Vehiculo" },
			llegada: { required: "Ingrese Punto de Llegada de Transporte" },
			motivotraslado: { required: "Ingrese Motivo de Traslado de Transporte" },
			desde: { required: "Ingrese Fecha de Inicio de Partida" },
			hasta: { required: "Ingrese Fecha Fin de Transporte" },
			statuschofer: { required: "Seleccione Status de Chofer" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#transporte").serialize();
		$.ajax({
			type: 'POST',
			url: 'fortransporte.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN CHOFER ACTIVO PARA TRANSPORTE DE GUIAS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CHOFER YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#transporte")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TRANSPORTE DE GUIA */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRANSPORTE DE GUIA */
$('document').ready(function () {
	/* validation */
	$("#updatetransporte").validate({
		rules:
		{
			rucchofer: { required: true, digits: true },
			nomchofer: { lettersonly: true, lettersonly: true },
			tlfchofer: { required: true, digits: false },
			numbultos: { required: true, digits: false },
			ruta: { required: true, },
			ciudadruta: { required: true, },
			placavehiculo: { required: true, },
			llegada: { required: true, },
			motivotraslado: { required: true, },
			desde: { required: true, },
			hasta: { required: true, },
			statuschofer: { required: true, },
		},
		messages:
		{
			rucchofer: { required: "Ingrese C.I/RUC de Chofer", digits: "Ingrese solo digitos para C.I/RUC" },
			nomchofer: { required: "Ingrese Nombre de Chofer", lettersonly: "Ingrese solo letras para Nombre de Chofer" },
			tlfchofer: { required: "Ingrese N&deg; de Tel&eacute;fono de Chofer", digits: "Ingrese solo digitos" },
			numbultos: { required: "Ingrese N&deg; de Bultos", digits: "Ingrese solo digitos" },
			ruta: { required: "Ingrese Direcci&oacute;n de Ruta" },
			ciudadruta: { required: "Ingrese Ciudad de Ruta" },
			placavehiculo: { required: "Ingrese N&deg; de Placa de Vehiculo" },
			llegada: { required: "Ingrese Punto de Llegada de Transporte" },
			motivotraslado: { required: "Ingrese Motivo de Traslado de Transporte" },
			desde: { required: "Ingrese Fecha de Inicio de Partida" },
			hasta: { required: "Ingrese Fecha Fin de Transporte" },
			statuschofer: { required: "Seleccione Status de Chofer" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatetransporte").serialize();
		var id = $("#updatetransporte").attr("data-id");
		var codcliente = id;

		$.ajax({
			type: 'POST',
			url: 'fortransporte.php?codcliente=' + codcliente,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN CHOFER ACTIVO PARA TRANSPORTE DE GUIAS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CHOFER YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout("location.href='transporte'", 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRANSPORTE DE GUIA */

















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */
$('document').ready(function () {
	/* validation */
	$("#productos").validate({
		rules:
		{
			codproducto: { required: true, },
			producto: { required: true, },
			/*principioactivo: { required: true,},
			descripcion: { required: true,},*/
			codpresentacion: { required: true, },
			/*codmedida: { required: true, },
			preciocompra: { required: true, number : true },
			precioventaunidad: { required: true, number : true },
			precioventacaja: { required: true, number : true },
			stockcajas: { required: true, digits : true },
			stockunidad: { required: true, digits : true },
			unidades: { required: true, digits : true },
			stockminimo: { required: false, digits : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			fechaelaboracion: { required: true, },
			fechaexpiracion: { required: true, },
			codigobarra: { required: true, },
			codlaboratorio: { required: true, },
			codproveedor: { required: true, },
			loteproducto: { required: true, },
			ubicacion: { required: true, },
			codsucursal: { required: true, },
			statusp: { required: true, },*/
		},
		messages:
		{
			codproducto: { required: "Ingrese C&oacute;digo" },
			producto: { required: "Ingrese Nombre de Producto" },
			principioactivo: { required: "Ingrese Principio Activo" },
			descripcion: { required: "Ingrese Descripci&oacute;n de Producto" },
			codpresentacion: { required: "Seleccione Presentaci&oacute;n de Producto" },
			codmedida: { required: "Seleccione Unidad de Medida" },
			preciocompra: { required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventaunidad: { required: "Ingrese Precio por Unidad de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventacaja: { required: "Ingrese Precio por Caja de Producto", number: "Ingrese solo digitos con 2 decimales" },
			stockcajas: { required: "Ingrese Stock por Cajas", digits: "Ingrese solo digitos" },
			stockunidad: { required: "Ingrese Stock por Unidad", digits: "Ingrese solo digitos" },
			unidades: { required: "Ingrese Unidades por Cajas", digits: "Ingrese solo digitos" },
			//stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
			ivaproducto: { required: "Seleccione Iva de Producto" },
			descproducto: { required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			codlaboratorio: { required: "Seleccione Laboratorio" },
			codproveedor: { required: "Seleccione Proveedor de Producto" },
			loteproducto: { required: "Ingrese Lote de Producto" },
			ubicacion: { required: "Ingrese Ubicaci&oacute;n en Estanteria" },
			codsucursal: { required: "Seleccione Sucursal de Asignaci&oacute;n" },
			statusp: { required: "Seleccione Status de Producto" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {

		var data = $("#productos").serialize();
		var formData = new FormData($("#productos")[0]);

		var cant = $('#existencia').val();
		var precioventacaja = $('#precioventacaja').val();
		cant = parseInt(cant);

		$.ajax({
			type: 'POST',
			url: 'productos.php',
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#read").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {

				if (data == 1) {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> INGRESE PRECIO VENTA DE CAJA CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 3) {

					$("#read").fadeIn(1000, function () {


						$("#read").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN PRODUCTO CON ESTE C&Oacute;DIGO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center> ' + data + ' </center>');
						$("#productos")[0].reset();
						$("#codigoproducto").load("funciones.php?muestracodigoproducto=si");
						setTimeout(function () { $("#read").html(""); window.location.reload(true); }, 3000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */
$('document').ready(function () {
	/* validation */
	$("#updateproducto").validate({
		rules:
		{
			codproducto: { required: true, },
			producto: { required: true, },
			/*	principioactivo: { required: true,},
				descripcion: { required: true,},*/
			codpresentacion: { required: true, },
			/*codmedida: { required: true, },
			preciocompra: { required: true, number : true },
			precioventaunidad: { required: true, number : true },
			precioventacaja: { required: true, number : true },
			stockcajas: { required: true, digits : true },
			stockunidad: { required: true, digits : true },
			unidades: { required: true, digits : true },
			stockminimo: { required: false, digits : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			fechaelaboracion: { required: true, },
			fechaexpiracion: { required: true, },
			codigobarra: { required: true, },
			codlaboratorio: { required: true, },
			codproveedor: { required: true, },
			loteproducto: { required: true, },
			ubicacion: { required: true, },
			codsucursal: { required: true, },
			statusp: { required: true, },*/
		},
		messages:
		{
			codproducto: { required: "Ingrese C&oacute;digo" },
			producto: { required: "Ingrese Nombre de Producto" },
			/*principioactivo:{  required: "Ingrese Principio Activo" },
			descripcion:{  required: "Ingrese Descripci&oacute;n de Producto" },*/
			codpresentacion: { required: "Seleccione Presentaci&oacute;n de Producto" },
			/*codmedida:{ required: "Seleccione Unidad de Medida" },
		preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
		precioventaunidad:{ required: "Ingrese Precio por Unidad de Producto", number: "Ingrese solo digitos con 2 decimales" },
		precioventacaja:{ required: "Ingrese Precio por Caja de Producto", number: "Ingrese solo digitos con 2 decimales" },
		stockcajas:{ required: "Ingrese Stock por Cajas", digits: "Ingrese solo digitos" },
		stockunidad:{ required: "Ingrese Stock por Unidad", digits: "Ingrese solo digitos" },
		unidades:{ required: "Ingrese Unidades por Cajas", digits: "Ingrese solo digitos" },
		stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
		ivaproducto:{ required: "Seleccione Iva de Producto" },
		descproducto: { required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
		fechaelaboracion:{ required: "Ingrese Fecha de Elaboraci&oacute;n" },
		fechaexpiracion:{ required: "Ingrese Fecha de Expiraci&oacute;n" },
		codigobarra:{ required: "Ingrese C&oacute;digo de Barra" },
		codlaboratorio:{ required: "Seleccione Laboratorio" },
		codproveedor:{ required: "Seleccione Proveedor de Producto" },
		loteproducto:{ required: "Ingrese Lote de Producto" },
		ubicacion:{ required: "Ingrese Ubicaci&oacute;n en Estanteria" },
		codsucursal:{ required: "Seleccione Sucursal de Asignaci&oacute;n" },
		statusp:{ required: "Seleccione Status de Producto" },*/
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateproducto").serialize();
		var formData = new FormData($("#updateproducto")[0]);
		var codalmacen = $('input#codalmacen').val();
		var busqueda = $('input#busqueda').val();

		var cant = $('#existencia').val();
		var precioventacaja = $('#precioventacaja').val();
		cant = parseInt(cant);

		$.ajax({
			type: 'POST',
			url: 'productos.php?codalmacen=' + codalmacen,
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#update").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#update").fadeIn(1000, function () {
						$("#update").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#update").fadeIn(1000, function () {

						$("#update").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> INGRESE PRECIO VENTA DE CAJA CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else if (data == 3) {

					$("#update").fadeIn(1000, function () {

						$("#update").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN PRODUCTO CON ESTE C&Oacute;DIGO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				} else {

					$("#update").fadeIn(1000, function () {

						$("#update").html('<center> ' + data + ' </center>');
						//$("#resultadoproducto").load("funciones.php?BusquedaProductos=si&buscaproducto="+busqueda);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout(function () { $("#update").html(""); window.location.reload(true); }, 3000);
					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */


/* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#cargarproductos").validate({
		rules:
		{
			sel_file: { required: true, },
		},
		messages:
		{
			sel_file: { required: "Por favor Seleccione Archivo para Cargar" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#cargarproductos").serialize();
		var formData = new FormData($("#cargarproductos")[0]);

		$.ajax({
			type: 'POST',
			url: 'cargamasiva.php',
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-cargar").html('<i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ....');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR !</div></center>');

						$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS</div></center>');

						$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#cargarproductos")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 35000);
						$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');
						//window.location.reload("productos.php"); }, 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});

/*  FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS */















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TRASPASO DE PRODUCTOS */
$('document').ready(function () {
	/* validation */
	$("#traspasoproductos").validate({
		rules:
		{
			envio: { required: true, },
			recibe: { required: true, },
		},
		messages:
		{
			envio: { required: "Seleccione Sucursal de Emisi&oacute;n" },
			recibe: { required: "Seleccione Sucursal para Recepci&oacute;n" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#traspasoproductos").serialize();
		var nuevaFila = "<tr>" + "<td colspan=9><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>" + "</tr>";

		$.ajax({

			type: 'POST',
			url: 'fortraspaso.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Traspasar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO A AGREGADO PRODUCTOS A LA SUCURSAL DE RECEPCION !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Traspasar');

					});
				}
				else if (data == 3) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA CANTIDAD PARA TRASPASO NO EXISTE EN ALGUNOS PRODUCTOS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Traspasar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#traspasoproductos")[0].reset();
						$("#carrito tbody").html("");
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function () { $("#error").html(""); }, 15000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Traspasar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TRASPASO DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRASPASO DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#updatetraspaso").validate({
		rules:
		{
			codpedido: { required: true, },
			codproveedor: { required: true, },
			codsucursal: { required: true, },
			fecharegistro: { required: true, },
		},
		messages:
		{
			codpedido: { required: "Ingrese N&deg; de Pedido" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
			fecharegistro: { required: "Ingrese Fecha de Pedido" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatetraspaso").serialize();
		var id = $("#updatetraspaso").attr("data-id");
		var codpedido = id;

		var cant = $('#cantpedido').val();
		cant = parseInt(cant);

		if (cant == 0) {

			$("#cantpedido").focus();
			$('#cantpedido').val("");
			$('#cantpedido').css('border-color', '#2b4049');
			alert('Por favor ingrese una Cantidad valida para Pedido de Productos.');

			return false;

		} else {
			$.ajax({
				type: 'POST',
				url: 'editpedidos.php?codpedido=' + codpedido,
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {

							("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS PRODUCTOS ASOCIADOS AL PEDIDO NO PUEDEN REPETIRSE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$('#btn-update').attr("disabled", true);
							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
							setTimeout("location.href='pedidos'", 5000);
						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRASPASO DE PRODUCTOS */













































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */
$('document').ready(function () {
	/* validation */
	$("#pedidos").validate({
		rules:
		{
			codpedido: { required: true, },
			codproveedor: { required: true, },
			codsucursal: { required: true, },
			fecharegistro: { required: true, },
		},
		messages:
		{
			codpedido: { required: "Ingrese N&deg; de Pedido" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
			fecharegistro: { required: "Ingrese Fecha de Pedido" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#pedidos").serialize();
		var nuevaFila = "<tr>" + "<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>" + "</tr>";

		$.ajax({

			type: 'POST',
			url: 'forpedido.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA PEDIDOS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#pedidos")[0].reset();
						$("#carrito tbody").html("");
						$(nuevaFila).appendTo("#carrito tbody");
						$("#codigopedido").load("funciones.php?muestracodigopedido=si");
						setTimeout(function () { $("#error").html(""); }, 15000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#updatepedidos").validate({
		rules:
		{
			codpedido: { required: true, },
			codproveedor: { required: true, },
			codsucursal: { required: true, },
			fecharegistro: { required: true, },
		},
		messages:
		{
			codpedido: { required: "Ingrese N&deg; de Pedido" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
			fecharegistro: { required: "Ingrese Fecha de Pedido" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatepedidos").serialize();
		var id = $("#updatepedidos").attr("data-id");
		var codpedido = id;

		var cant = $('#cantpedido').val();
		cant = parseInt(cant);

		if (cant == 0) {

			$("#cantpedido").focus();
			$('#cantpedido').val("");
			$('#cantpedido').css('border-color', '#2b4049');
			alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA PEDIDO DE PRODUCTOS');

			return false;

		} else {
			$.ajax({
				type: 'POST',
				url: 'editpedidos.php?codpedido=' + codpedido,
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {

							("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS PRODUCTOS ASOCIADOS AL PEDIDO NO PUEDEN REPETIRSE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$('#btn-update').attr("disabled", true);
							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
							setTimeout("location.href='pedidos'", 5000);
						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS DE PRODUCTOS */














































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#compras").validate({
		rules:
		{
			codcompra: { required: true, },
			//codproveedor: { required: true, },
			//codsucursal: { required: true, },
			tipocompra: { required: true, },
			formacompra: { required: true, },
			fechavencecredito: { required: true, },
			//fechaemision: { required: true, },
			//fecharecepcion: { required: true, },
			fechacompra: { required: true, },
		},
		messages:
		{
			codcompra: { required: "Ingrese N&deg; Compra" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
			tipocompra: { required: "	Seleccione Tipo Compra" },
			formacompra: { required: "Seleccione Medio Compra" },
			fechavencecredito: { required: "Ingrese Fecha de Vencimiento de Cr&eacute;dito" },
			fechaemision: { required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion: { required: "Ingrese Fecha de Recepci&oacute;n" },
			fechacompra: { required: "Ingrese Fecha de Compra" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {

		var data = $("#compras").serialize();
		var nuevaFila = "<tr>" + "<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>" + "</tr>";
		var total = $('#txtTotal').val();

		if (total == 0.00) {

			$("#producto").focus();
			$('#producto').css('border-color', '#f0ad4e');
			alert('POR FAVOR AGREGUE PRODUCTOS PARA CONTINUAR CON LA COMPRA');

			return false;

		} else {
			$.ajax({

				type: 'POST',
				url: 'forcompra.php',
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 3) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA COMPRAS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 4) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO DE COMPRA YA SE ENCUENTRA REGISTRADO, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$("#compras")[0].reset();
							$("#carrito tbody").html("");
							$("#lbldescuento").text("0.00");
							$("#lbldescbonif").text("0.00");
							$("#lblsubtotal").text("0.00");
							$("#lblimpuestos").text("0.00");
							$("#lbltarifano").text("0.00");
							$("#lbltarifasi").text("0.00");
							$("#lbliva").text("0.00");
							$("#lbltotal").text("0.00");
							$("#lblGrande").text("0.00");
							$("#txtDescuento").val("0.00");
							$("#txtDescbonif").val("0.00");
							$("#txtsubtotal").val("0.00");
							$("#txtimpuestos").val("0.00");
							$("#txttarifano").val("0.00");
							$("#txttarifasi").val("0.00");
							$("#txtIva").val("0.00");
							$("#txtTotal").val("0.00");
							$(nuevaFila).appendTo("#carrito tbody");
							setTimeout(function () { $("#error").html(""); }, 15000);
							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#updatedetallescompras").validate({
		rules:
		{
			codcompra: { required: true, },
			codproducto: { required: true, },
			producto: { required: true, },
			principioactivo: { required: true, },
			descripcion: { required: true, },
			codpresentacion: { required: true, },
			codmedida: { required: true, },
			cantcompra: { required: true, digits: true },
			preciocompra: { required: true, number: true },
			precioventaunidad: { required: true, number: true },
			precioventacaja: { required: true, number: true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number: true },
			fechaelaboracion: { required: true, },
			fechaexpiracion: { required: true, },
			lote: { required: true, },
		},
		messages:
		{
			codcompra: { required: "Ingrese C&oacute;digo de Compra" },
			codproducto: { required: "Ingrese C&oacute;digo Producto" },
			producto: { required: "Ingrese Nombre de Producto" },
			principioactivo: { required: "Ingrese Principio Activo" },
			descripcion: { required: "Ingrese Descripci&oacute;n de Producto" },
			codpresentacion: { required: "Seleccione Presentaci&oacute;n de Producto" },
			codmedida: { required: "Seleccione Unidad Medida de Producto" },
			cantcompra: { required: "Ingrese Cantidad de Compra", digits: "Ingrese solo digitos" },
			preciocompra: { required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventaunidad: { required: "Ingrese Precio por Unidad de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventacaja: { required: "Ingrese Precio por Caja de Producto", number: "Ingrese solo digitos con 2 decimales" },
			ivaproducto: { required: "Seleccione Iva de Producto" },
			descproducto: { required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			lote: { required: "Ingrese N&deg; de Lote" },

		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatedetallescompras").serialize();
		var id = $("#updatedetallescompras").attr("data-id");
		var coddetallecompra = id;

		var cant = $('#cantcompra').val();
		var compra = $('#preciocompra').val();
		var venta = $('#precioventacaja').val();
		cant = parseInt(cant);

		if (compra == 0.00 || compra == 0) {

			$("#preciocompra").focus();
			$('#preciocompra').val("");
			$('#preciocompra').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UN COSTO VALIDO PARA PRECIO DE COMPRA');

			return false;

		} else if (venta == 0.00 || venta == 0) {

			$("#precioventacaja").focus();
			$('#precioventacaja').val("");
			$('#precioventacaja').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UN COSTO VALIDO PARA PRECIO VENTA DE CAJA');

			return false;

		} else if (parseFloat(compra) > parseFloat(venta)) {

			$("#precioventacaja").focus();
			$("#preciocompra").focus();
			$('#precioventacaja').css('border-color', '#f0ad4e');
			$('#preciocompra').css('border-color', '#f0ad4e');
			alert('EL PRECIO DE COMPRA NO PUEDE SER MAYOR AL PRECIO VENTA DE CAJA');

			return false;

		} else if (cant == 0) {

			$("#cantcompra").focus();
			$('#cantcompra').val("");
			$('#cantcompra').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA COMPRA');

			return false;

		} else {
			$.ajax({
				type: 'POST',
				url: 'editdetallecompras.php?coddetallecompra=' + coddetallecompra,
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {

							("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE DETALLE DE COMPRA NO PUEDE SER ACTUALIZADO, SE ENCUENTRA INACTIVO PARA ACTUALIZAR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$('#btn-update').attr("disabled", true);
							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
							$("#cargacomprainput").load("funciones.php?muestracantcompradb=si&coddetallecompra=" + btoa(coddetallecompra));
							$("#cargabonifinput").load("funciones.php?muestrabonifdb=si&coddetallecompra=" + btoa(coddetallecompra));
							setTimeout("location.href='detallescompras'", 5000);
						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE COMPRAS DE PRODUCTOS */




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ARQUEO DE CAJA */
$('document').ready(function () {
	/* validation */
	$("#arqueocaja").validate({
		rules:
		{
			codcaja: { required: true, },
			montoinicial: { required: true, number: true },
		},
		messages:
		{
			codcaja: { required: "Seleccione Caja para Arqueo" },
			montoinicial: { required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },

		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#arqueocaja").serialize();

		$.ajax({

			type: 'POST',
			url: 'forarqueo.php',
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

					});

				}
				else if (data == 2) {

					$("#error").fadeIn(1000, function () {


						$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN ARQUEO ABIERTO DE ESTA CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center> ' + data + ' </center>');
						$("#arqueocaja")[0].reset();
						setTimeout(function () { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ARQUEO DE CAJA */

/* FUNCION JQUERY PARA VALIDAR CIERRE DE CAJA */
$('document').ready(function () {

	/* validation */
	$("#cierrecaja").validate({
		rules:
		{
			codcaja: { required: true, },
			montoinicial: { required: true, number: true },

			comentarios: { required: false, },
		},
		messages:
		{
			codcaja: { required: "Seleccione Caja para Atqueo" },
			montoinicial: { required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },

			comentarios: { required: "Ingrese Comentario de Cierre" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#cierrecaja").serialize();
		var id = $("#cierrecaja").attr("data-id");
		var dineroefectivo = $('#dineroefectivo').val();
		var codarqueo = id;


		$.ajax({

			type: 'POST',
			url: 'forcierrearqueo.php?codarqueo=' + codarqueo,
			data: data,
			beforeSend: function () {
				$("#error").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#error").fadeIn(1000, function () {

						$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Cerrar Caja');

					});

				}
				else {

					$("#error").fadeIn(1000, function () {
						$("#error").html('<center> ' + data + ' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Cerrar Caja');
						setTimeout("location.href='arqueoscajas'", 5000);

					});
				}
			}
		});
		return false;

	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR CIERRE DE CAJA */

















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJA */
$('document').ready(function () {
	/* validation */
	$("#movimientocaja").validate({
		rules:
		{
			tipomovimientocaja: { required: true, },
			montomovimientocaja: { required: true, number: true },
			mediopagomovimientocaja: { required: true, },
			codcaja: { required: true, },
			descripcionmovimientocaja: { required: true, },
		},
		messages:
		{
			tipomovimientocaja: { required: "Seleccione Tipo de Movimiento" },
			montomovimientocaja: { required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediopagomovimientocaja: { required: "Seleccione Medio de Pago" },
			codcaja: { required: "Seleccione Caja" },
			descripcionmovimientocaja: { required: "Ingrese descripci&oacute;n de Movimiento" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#movimientocaja").serialize();
		var cant = $('#montomovimientocaja').val();

		if (cant == 0.00 || cant == 0) {

			$("#montomovimientocaja").focus();
			$('#montomovimientocaja').val("");
			$('#montomovimientocaja').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA');

			return false;

		} else {

			$.ajax({

				type: 'POST',
				url: 'formovimientocaja.php',
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> DEBE DE REALIZAR EL ARQUEO DE CAJA PARA REGISTRAR MOVIMIENTOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

						});
					}
					else if (data == 3) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO A RETIRAR NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

						});
					}

					else if (data == 4) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO DE CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$("#movimientocaja")[0].reset();
							setTimeout(function () { $("#error").html(""); }, 5000);
							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE FUNCION PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJA */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MOVIMIENTOS EN CAJA */
$('document').ready(function () {
	/* validation */
	$("#updatemovimientocaja").validate({
		rules:
		{
			tipomovimientocaja: { required: true, },
			montomovimientocaja: { required: true, number: true },
			mediopagomovimientocaja: { required: true, },
			codcaja: { required: true, },
			descripcionmovimientocaja: { required: true, },
		},
		messages:
		{
			tipomovimientocaja: { required: "Seleccione Tipo de Movimiento" },
			montomovimientocaja: { required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediopagomovimientocaja: { required: "Seleccione Medio de Pago" },
			codcaja: { required: "Seleccione Caja" },
			descripcionmovimientocaja: { required: "Ingrese descripci&oacute;n de Movimiento" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatemovimientocaja").serialize();
		var id = $("#updatemovimientocaja").attr("data-id");
		var codmovimientocaja = id;
		var cant = $('#montomovimientocaja').val();

		if (cant == 0.00 || cant == 0) {

			$("#montomovimientocaja").focus();
			$('#montomovimientocaja').val("");
			$('#montomovimientocaja').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA');

			return false;

		} else {
			$.ajax({

				type: 'POST',
				url: 'formovimientocaja.php?codmovimientocaja=' + codmovimientocaja,
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO A RETIRAR NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});
					}

					else if (data == 3) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO DE CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});
					}
					else {
						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							//$('#btn-update').attr("disabled", true);
							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
							$("#cargamovimientoinput").load("funciones.php?muestramovimeintodb=si&codmovimientocaja=" + btoa(codmovimientocaja));
							// setTimeout("location.href='movimientoscajas'", 5000);
						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MOVIMIENTOS EN CAJA */




















































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR VENTAS */
$('document').ready(function () {
	/* validation */
	$("#ventaclientes").validate({
		rules:
		{
			cedcliente: { required: true, digits: true },
			nomcliente: { lettersonly: true, lettersonly: true },
			direccliente: { required: true, },
			tlfcliente: { required: true, digits: false },
			celcliente: { required: true, digits: false },
			emailcliente: { required: false, email: true },
		},
		messages:
		{
			cedcliente: { required: "Ingrese C.I/RUC de Cliente", digits: "Ingrese solo digitos para C.I/RUC" },
			nomcliente: { required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombre de Cliente" },
			direccliente: { required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono de Cliente", digits: "Ingrese solo digitos" },
			celcliente: { required: "Ingrese N&deg; de Celular de Cliente", digits: "Ingrese solo digitos" },
			emailcliente: { required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#ventaclientes").serialize();
		$.ajax({
			type: 'POST',
			url: 'forventa.php',
			data: data,
			beforeSend: function () {
				$("#read").fadeOut();
				$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success: function (data) {
				if (data == 1) {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else if (data == 2) {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');

					});
				}
				else {

					$("#read").fadeIn(1000, function () {

						$("#read").html('<center> ' + data + ' </center>');
						$("#ventaclientes")[0].reset();
						setTimeout(function () { $("#read").html(""); }, 5000);
						$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR VENTAS*/

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */
$('document').ready(function () {
	/* validation */
	$("#updateventaclientes").validate({
		rules:
		{
			cedcliente: { required: true, digits: true },
			nomcliente: { lettersonly: true, lettersonly: true },
			direccliente: { required: true, },
			tlfcliente: { required: true, digits: false },
			celcliente: { required: true, digits: false },
			emailcliente: { required: false, email: true },
		},
		messages:
		{
			cedcliente: { required: "Ingrese C.I/RUC de Cliente", digits: "Ingrese solo digitos para C.I/RUC" },
			nomcliente: { required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombre de Cliente" },
			direccliente: { required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono de Cliente", digits: "Ingrese solo digitos" },
			celcliente: { required: "Ingrese N&deg; de Celular de Cliente", digits: "Ingrese solo digitos" },
			emailcliente: { required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updateventaclientes").serialize();
		//var id= $("#updateclientes").attr("data-id");
		var codcliente = $('input#codcliente').val();
		var busqueda = $('input#busqueda').val();

		$.ajax({
			type: 'POST',
			url: 'forventa.php?codcliente=' + codcliente,
			data: data,
			beforeSend: function () {
				$("#update").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
			},
			success: function (data) {
				if (data == 1) {

					$("#update").fadeIn(1000, function () {


						$("#update").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});

				}
				else if (data == 2) {

					$("#update").fadeIn(1000, function () {


						$("#update").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

					});
				}
				else {

					$("#update").fadeIn(1000, function () {

						$("#update").html('<center> ' + data + ' </center>');
						$("#resultado").load("funciones.php?BuscaClientes=si&buscacliente=" + busqueda);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						setTimeout(function () { $("#update").html(""); }, 5000);

					});
				}
			}
		});
		return false;
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */


/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */
$('document').ready(function () {
	/* validation */
	$("#ventas").validate({
		rules:
		{
			busqueda: { required: false, },
			codsucursal: { required: false, },
			tipopagove: { required: true, },
			codmediopago: { required: true, },
			fechavencecredito: { required: true, },
			montoabono: { required: true, },
			montopagado: { required: true, },
			montodevuelto: { required: true, },
			nombanco: { required: true, },
			codtarjeta: { required: true, },
			meses: { required: true, },
		},
		messages:
		{
			busqueda: { required: "Realice la B&uacute;squeda del Cliente" },
			codsucursal: { required: "Seleccione Sucursal" },
			tipopagove: { required: "Seleccione Tipo de Pago" },
			codmediopago: { required: "Seleccione Medio de Pago" },
			fechavencecredito: { required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono: { required: "Ingrese Monto de Abono" },
			montopagado: { required: "Ingrese Monto Pagado" },
			montodevuelto: { required: "Ingrese Monto Devuelto" },
			nombanco: { required: "Seleccione Nombre de Banco" },
			codtarjeta: { required: "Seleccione Tipo de Tarjeta" },
			meses: { required: "Seleccione Mes de Interes" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {

		var data = $("#ventas").serialize();
		var nuevaFila = "<tr>" + "<td colspan=10><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>" + "</tr>";
		var total = $('#txtTotal').val();
		var montopagado = $('#montopagado').val();
		var tipopago = $('#tipopagove').val();
		totalpago = parseFloat(total);
		montopago = parseFloat(montopagado);

		if(!window.terminoDeBuscar) return false;
		else if (total == 0.00) {

			$("#busquedaproductov").focus();
			$('#busquedaproductov').css('border-color', '#f0ad4e');
			alert('NO HA AGREGADO PRODUCTOS PARA VENTAS, VERIFIQUE POR FAVOR');

			return false;

		} else if (tipopago == "CONTADO" && totalpago > montopago) {

			$("#montopagado").focus();
			$('#montopagado').css('border-color', '#f0ad4e');
			alert('EL MONTO A PAGAR EN EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL DE VENTA, VERIFIQUE POR FAVOR');

			return false;

		} else {
			$.ajax({

				type: 'POST',
				url: 'forventa.php',
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA FECHA DE VENCIMIENTO DE VENTA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 3) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 4) {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA VENTAS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 5) {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> SI EL ABONO DE CREDITO ES MAYOR O IGUAL AL TOTAL DE PAGO DE VENTA, POR FAVOR MODIFIQUE EL TIPO DE PAGO A CONTADO !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else if (data == 6) {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$("#ventas")[0].reset();
							$("#cliente").val("0");
							$('label[id*="cedcliente"]').text('SIN ASIGNAR');
							$('label[id*="nomcliente"]').text('SIN ASIGNAR');
							$('label[id*="direccliente"]').text('SIN ASIGNAR');
							//$('label[id*="cedcliente"]').empty();
							$("#buscaclientes")[0].reset();
							$("#carrito tbody").html("");
							$("#lbldescuento").text("0.00");
							$("#lbldescbonif").text("0.00");
							$("#lblsubtotal").text("0.00");
							$("#lblimpuestos").text("0.00");
							$("#lbltarifano").text("0.00");
							$("#lbltarifasi").text("0.00");
							$("#lbliva").text("0.00");
							$("#lbltotal").text("0.00");
							$("#lblGrande").text("0.00");
							$("#txtDescuento").val("0.00");
							$("#txtDescbonif").val("0.00");
							$("#txtsubtotal").val("0.00");
							$("#txtimpuestos").val("0.00");
							$("#txttarifano").val("0.00");
							$("#txttarifasi").val("0.00");
							$("#txtIva").val("0.00");
							$("#txtTotal").val("0.00");
							$(nuevaFila).appendTo("#carrito tbody");
							/*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
							$("#tipodocumento").attr('disabled', true);
							$("#tipopagove").attr('disabled', true);
							$("#codmediopago").attr('disabled', true);
							$("#montopagado").attr('disabled', true);
							$("#montodevuelto").attr('disabled', true);
							$("#muestracambiospagos").load("funciones.php?CargaCampos=si");
							setTimeout(function () { $("#error").html(""); }, 15000);
							$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS DE PRODUCTOS */

$('document').ready(function () {
	/* validation */
	$("#updatedetallesventas").validate({
		rules:
		{
			codventa: { required: true, },
			cantventa: { required: true, digits: true },
			cantbonificv: { required: true, digits: true },
		},
		messages:
		{
			codventa: { required: "Ingrese C&oacute;digo de Venta" },
			cantventa: { required: "Ingrese Cantidad de Venta", digits: "Ingrese solo digitos" },
			cantbonificv: { required: "Ingrese Cantidad de Bonificaci&oacute;n", digits: "Ingrese solo digitos" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#updatedetallesventas").serialize();
		var coddetalleventa = $('input#coddetalleventa').val();
		var tipobusquedad = $('input#tipobusquedad2').val();
		var codventa = $('input#codigoventa').val();
		var codcaja = $('input#codcaja2').val();
		var fecha = $('input#fecha2').val();

		var cant = $('#cantventa').val();
		var compra = $('#preciocompra').val();
		var venta = $('#precioventacaja').val();
		cant = parseInt(cant);

		if (cant == 0.00 || cant == 0) {

			$("#cantventa").focus();
			$('#cantventa').val("");
			$('#cantventa').css('border-color', '#f0ad4e');
			alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA VENTA DE PRODUCTOS');

			return false;

		} else {
			$.ajax({

				type: 'POST',
				url: 'editdetalleventas.php?coddetalleventa=' + coddetalleventa,
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

						});

					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							//$('#btn-update').attr("disabled", true);
							$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
							$("#cargaventainput").load("funciones.php?muestracantventadb=si&coddetalleventa=" + btoa(coddetalleventa));
							$("#cargabonifventainput").load("funciones.php?muestrabonifventadb=si&coddetalleventa=" + btoa(coddetalleventa));
							$("#muestradetallesventas").load("funciones.php?BuscarDetallesVentas=si&tipobusquedad=" + tipobusquedad + '&codventa=' + codventa + '&codcaja=' + codcaja + '&fecha=' + fecha);
							setTimeout(function () { $("#error").html(""); }, 15000);

						});
					}
					// document.querySelector("#myModal .close").click();
					document.location.reload();
				}
			});
			return false;
		}
	}
	/* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE VENTAS DE PRODUCTOS */








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */

$('document').ready(function () {
	/* validation */
	$("#abonoscreditos").validate({
		rules:
		{
			montoabono: { required: true, },
		},
		messages:
		{
			montoabono: { required: "Ingrese Monto de Abono" },
		},
		submitHandler: submitForm
	});
	/* validation */

	/* form submit */
	function submitForm() {
		var data = $("#abonoscreditos").serialize();
		var totaldebe = $('#totaldebe').val();
		var montoabono = $('#montoabono').val();
		totaldebe1 = parseFloat(totaldebe);
		montoabono1 = parseFloat(montoabono);

		if (montoabono == 0.00 || montoabono == "") {

			$("#montoabono").focus();
			$('#montoabono').css('border-color', '#f0ad4e');
			alert('DEBE DE INGRESAR UN MONTO VALIDO PARA PAGO A CREDITOS');

			return false;

		} else if (montoabono1 > totaldebe) {

			$("#montoabono").focus();
			$("#montoabono").val("");
			$('#montoabono').css('border-color', '#f0ad4e');
			alert('EL MONTO A PAGAR ES MAYOR AL QUE DEBE \n EN LA VENTA A CREDITO, VERIFIQUE POR FAVOR');

			return false;

		} else {
			$.ajax({

				type: 'POST',
				url: 'forcartera.php',
				data: data,
				beforeSend: function () {
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success: function (data) {
					if (data == 1) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Pago');

						});

					}
					else if (data == 2) {

						$("#error").fadeIn(1000, function () {


							$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR EL MONTO ABONADO ES MAYOR AL QUE DEBE EN ESTA FACTURA DE CREDITO, VERIFIQUE EL MONTO POR FAVOR !</div></center>');

							$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Pago');

						});
					}
					else {

						$("#error").fadeIn(1000, function () {

							$("#error").html('<center> ' + data + ' </center>');
							$("#abonoscreditos")[0].reset();
							$("#muestraclientesabonos").html("");
							$("#muestraformularioabonos").html("");
							setTimeout(function () { $("#error").html(""); }, 80000);
							$("#btn-submit").html('<span class="fa fa-search"></span> Realizar Busqueda');

						});
					}
				}
			});
			return false;
		}
	}
	/* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */

