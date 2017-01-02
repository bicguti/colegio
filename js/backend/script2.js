
jQuery(document).ready(function() {
	//toggle `popup` / `inline` mode
	$.fn.editable.defaults.mode = 'inline';

	//make username editable
//	$('.username').editable();

	//make status editable
//	$('.username').editable({
			/*type: 'select',
			title: 'Select status',
			placement: 'right',
			value: 2,
			source: [
					{value: 1, text: 'status 1'},
					{value: 2, text: 'status 2'},
					{value: 3, text: 'status 3'}
			]*/
			/*
			//uncomment these lines to send data on server
			,pk: 1
			,url: '/post'
			*/
	//});


	//var server="http://localhost/colegio/index.php/";//esto es la base ir del servidor
	var URLdomain = window.location.host;
	var protocolo = window.location.protocol;
	//var url = protocolo+'//'+URLdomain+'/municipio';
	var server = protocolo+'//'+URLdomain+'/colegio/index.php/';
	var cuadro = '';
	var nivel = '';
$('.miEvaluacion').click(function(event) {
	//console.log($(this).data('cuadro'));
	cuadro = $(this).data('cuadro');
	nivel = $(this).data('nivel');
});
	$('.miEvaluacion').on('click', '.editable-submit', function(event) {
		//event.preventDefault();
		var valor = $('.input-sm').val();
		//var cuadro = $('.miEvaluacion').data('cuadro');
		//alert(cuadro);
		//console.log(cuadro);
		var url = server + 'cuadros/editar_evaluacion';
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'POST',
			data: {nota: valor, cuadro: cuadro, nivel: nivel}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function(error) {
			alert('Lo sentimos parece que ha ocurrido un error al intentar actualizar la información, por favor vueva a intentarlo más tarde!!!');
			console.log("error");
			console.log(error);
		})
		.always(function(data) {
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});//fin del evento ajax

	});//fin del evento on click

	$('.editable-submit').click(function(event) {
		event.preventDefault();
		alert('click');
	});

	$('#repetircontra').keyup(function(e) {


		var rcontra = $(this).val();
		var contra = $('#contra').val();
		console.log(contra+' '+rcontra);
		if (contra == rcontra)
			{
				$('#contravalida').removeClass('icon-cross text-danger');
				$('#contravalida').addClass('icon-checkmark text-success');
			}
		else
			{
				$('#contravalida').removeClass('icon-checkmark text-success')
				$('#contravalida').addClass('icon-cross text-danger');
			}
	});//fin del evento keyup

	$('#opcionesmenu').change(function() {
		var menu = $(this).val();

		if (menu == '')
		{
			alert('seleccione una opcion valida');
		}
		else
		{

			var url = server + 'usuario/buscar_subopciones';
			$('.ventana-modal').animate({top: '0%'}, 500);
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: menu}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				for(opcion in json)
				{
					html +='<tr>';
					html +=' <td>'+json[opcion].nombre_sub_opcion.toUpperCase()+'</td>';
					html +='<td><input type="checkbox" name="subopcion[]"  value="'+json[opcion].id_sub_opcion+'"/></td></tr>';
				}
				$('#subopciones').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}

	});//fin del evento change

	$('.nota').click(function(e) {
		var dato = $(this).val();
		var url = server + 'notas/buscar_acreditacion';
		var nEstudiante = $(this).data('estudiante');
		$('#acreditaciones').html('<h2 class="text-center text-danger">Cargando...</h2>');
		$('.ventana-modal').animate({top: '0%'}, 500);
		var cont = 1;
		$.ajax({
			url: url,
			type: 'GET',
			data: {dato: dato},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = '';
			var temp = 0;
			var html = '';
			//html = '<h2 class="text-center">Puntos para Acreditar</h2>';
			html = '<p><strong>'+nEstudiante.toUpperCase()+'</strong></p>';
			for(acred in json)
			{
				if (json[acred].nombre_acreditacion != '')
				{
					aux +=json[acred].id_puntos+',';
				html += '<div class="form-group">';
				html += '<label for="" class="col-sm-4 control-label">'+ json[acred].nombre_acreditacion.toUpperCase() +'</label>';
				html += '<div class="col-sm-8">';
				html += '<input type="text" class="form-control numero" required="required" id="'+cont+'" value="'+json[acred].puntos_acreditacion+'"/>'
				html += '</div>';
				html += '</div>';
				}
				else
				{
					aux +=json[acred].id_puntos+',';
				html += '<div class="form-group">';
				html += '<label for="" class="col-sm-4 control-label">'+ json[acred].nombre_acreditacion.toUpperCase() +'</label>';
				html += '<div class="col-sm-8">';
				html += '<input type="text" class="form-control numero" required="required" disabled id="'+cont+'"/>'
				html += '</div>';
				html += '</div>';
				}
				cont++;
				temp = json[acred].id_nivel;
			}

			// html += '<div class="form-group">';
			// html += '<div class="col-sm-offset-4 col-sm-8">';
			// html += '<button class="btn btn-success" value="'+aux+'" id="guardarNotas">Guardar</button>';
			// html += '</div>';
			// html += '</div>';
			aux += temp;
			$('#guardarNotas').val(aux);
			$('#acreditaciones').html(html);

			console.log("complete");
		});

	});

	$('#guardarNotas').click(function() {
		//obtenemos los valores de cada input
		var uno = $('#1').val();
		var dos = $('#2').val();
		var tres = $('#3').val();
		var cuatro = $('#4').val();
		var cinco = $('#5').val();
		var seis = $('#6').val();
		var identificador = $(this).val();
		var puntos = uno+','+dos+','+tres+','+cuatro+','+cinco+','+seis;
		//deshabilitamos todos los inputs
		$('#1').attr('disabled', 'disabled');
		$('#2').attr('disabled', 'disabled');
		$('#3').attr('disabled', 'disabled');
		$('#4').attr('disabled', 'disabled');
		$('#5').attr('disabled', 'disabled');
		$('#6').attr('disabled', 'disabled');
		var url = server + 'notas/agregar_nota'
		$.ajax({
			url: url,
			type: 'POST',
			data: {puntos: puntos, datos: identificador},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Lo sentimos parece que se produjo un error al intentar almacenar los datos en el servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});


	});

	$('#cancelarNotas').click(function() {
		$('.ventana-modal').animate({top: '100%'}, 500);
		$('#mCampos').css({display:'none'});
		$('#mMensaje').css({display:'block'});
	});

	$('.notaExamen').click(function(event) {
		var dato = $(this).val();
		var url = server + 'cuadros/buscar_nexamen';
		var nEstudiante = $(this).data('estudiante');
		$('#acreditaciones').html('<h2 class="text-center text-danger">Cargando...</h2>');
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {dato: dato},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Lo sentimos parece que se produjo un error al intentar recuperar los datos del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = '';
			var temp = 0;
			var html = '';
			//html = '<h2 class="text-center">Evaluacion Bloque</h2>';
			html = '<p><strong>'+nEstudiante.toUpperCase()+'</strong></p>';
			for(acred in json)
			{

				aux +=json[acred].id_cuadros+',';
				html += '<div class="form-group">';
				html += '<label for="" class="col-sm-4 control-label">Nota:</label>';
				html += '<div class="col-sm-8">';
				html += '<input type="text" class="form-control numero" required="required" id="punteoExamen" value="'+json[acred].evaluacion_bloque+'"/>'
				html += '</div>';
				html += '</div>';

				temp = json[acred].id_nivel;
			}
			aux += temp;
			$('#guardarExamen').val(aux);
			$('#acreditaciones').html(html);

			console.log("complete");
		});
	});//fin del evento click

	$('#guardarExamen').click(function() {
		var nota = $('#punteoExamen').val();
		var datos = $(this).val();
		var url = server + 'cuadros/guardar_examen';
		$.ajax({
			url: url,
			type: 'POST',
			data: {nota: nota, dato: datos}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Lo sentimos, pero ha ocurrido un error al intentar guardar la nota del examen, vuelve a intentarlo mas tarde.');
			console.log("error");
		})
		.always(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});
	});//fin del evento click

	$('#cancelarExamen').click(function() {
		$('.ventana-modal').animate({top: '100%'}, 500);
	});//fin del evento

	$('.numero').keypress(function(e) {
		if (e.charCode < 48 || e.charCode > 57)
		{
			return false;
		}
	});

	$('#nivelRC').change(function() {
		var valor = $(this).val();
		var url = server + 'grado/buscar_grados';
		$('#gradoRC').html('<option value="">&lt;seleccione&gt;</option>');
		$('.ventana-modal').animate({top: '0%'}, 500);
		if (valor == 4)
		{
			url = server + 'carrera/carreras';
			$.ajax({
				url: url,
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
		        alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';

				html = '<option value="">&lt;seleccione&gt;</option>';
				for(carrera in json)
				{
					html += '<option value="'+json[carrera].id_carrera+'">'+json[carrera].nombre_carrera.toUpperCase()+'</option>';
				}

				$('#carreraRC').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});


			$('#fg-carrera').css('display', 'block');

		}
		else
		{
			$('#fg-carrera').css('display', 'none');
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: valor}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
		        alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
					html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoRC').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
	});//fin del evento change

	$('#carreraRC').change(function() {
		var texto = $('#carreraRC option:selected').text();//obtenemos el texto de la opcion seleccionada
		 var expresion = new RegExp('PERITO');
		 var expresion2 = new RegExp('MAESTRA');

		 if (texto == '<seleccione>')
		 	{
		 		$('#gradoRC').html('<option value="">&lt;seleccione&gt;</option>');
		 		alert('Por favor seleccione una opción valida');
		 	}
		 	else{
		 		$('.ventana-modal').animate({top: '0%'}, 500);
		if (expresion.test(texto) == true || expresion2.test(texto) == true )
			{
				var url = server + 'grado/buscar_grados';
				var id = 4;
				$.ajax({
					url: url,
					type: 'GET',
					data: {id: id},
				})
				.done(function() {
					console.log("success");
				})
				.fail(function() {
					$('.ventana-modal').animate({top: '100%'}, 500);
			        alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = "";
					var aux = "";
					html += '<option value="">&lt;seleccione&gt;</option>';
					for(grado in json)
					{
						//aux = json[grado].nombre_grado[0].toUpperCase()+json[grado].nombre_grado.slice(1);
						html += "<option value="+json[grado].id_grado+">"+json[grado].nombre_grado.toUpperCase()+"</option>";
					}
					$('#gradoRC').html(html);
					$('.ventana-modal').animate({top: '100%'}, 500);
					console.log("complete");

				});

			}
			else
			{
				var url = server + 'grado/buscar_grados';
				var id = 6;
				$.ajax({
					url: url,
					type: 'GET',
					data: {id: id},
				})
				.done(function() {
					console.log("success");
				})
				.fail(function() {
					$('.ventana-modal').animate({top: '100%'}, 500);
			        alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = "";
					var aux = "";
					html += '<option value="">&lt;seleccione&gt;</option>';
					for(grado in json)
					{
						//aux = json[grado].nombre_grado[0].toUpperCase()+json[grado].nombre_grado.slice(1);
						html += "<option value="+json[grado].id_grado+">"+json[grado].nombre_grado.toUpperCase()+"</option>";
					}
					$('#gradoRC').html(html);
					$('.ventana-modal').animate({top: '100%'}, 500);
					console.log("complete");

				});
			}
		}

	});//fin del evento change

	$('#btn-buscar').click(function(event) {
		event.preventDefault();
		var valor = $('#busca-persona').val();
		//var url = server +'docentes/buscar_docente';
		var url = server + 'usuario/buscar_persona_ajax';
		//$('.ventana-modal').animate({param1: top, '0'}, 500);
		//$('.fg-carrera').css('display', 'block');
		if (valor == '')
		{
			alert('Por favor llene el campo de Persona, es requerido');
		} else
		{
		$('.ventana-modal').animate({top: '0%'}, 500);

		$.ajax({
			url: url,
			type: 'GET',
			data: {apellido: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var html = '';

			for(per in json)
			{
				html += '<tr>';
				html += '<td>'+json[per].nombres.toUpperCase()+'</td>';
				html += '<td>'+json[per].apellidos.toUpperCase()+'</td>';
				html += '<td>'+json[per].puesto.toUpperCase()+'</td>';
				html += '<td><input type="radio" value="'+json[per].id+'" required="required" name="seleccion" /></td>';
				html += '</tr>';
			}
			$('#cuerpoTabla').html(html);
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});
		}

	});//fin del evento click

	$('.btn-notas').click(function(event) {
		event.preventDefault();
		var valor = $(this).val();
		var nEstudiante = $(this).data('estudiante');
		$('.ventana-modal').animate({top: '0%'}, 500);
		//var loc = window.location;
    //var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    //loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));


		var url = server + 'estudiante/buscar_punt_habit';
		$.ajax({
			url: url,
			type: 'GET',
			data: {estudiante: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = valor;
			var puntualidad = '';
			var habitos = '';
			for(cuadros in json)
			{
				aux = aux + ',' + json[cuadros].id_cuadros;
				puntualidad = json[cuadros].punt_asist;
				habitos = json[cuadros].habitos_orden;
			}
			if (puntualidad != null) {puntualidad = puntualidad.toUpperCase();};
			if (habitos != null) {habitos = habitos.toUpperCase()};
			$('#nEstudiante').text(nEstudiante);
			$('#puntualidad').val(puntualidad);
			$('#habitos').val(habitos);
			$('#guardarPH').val(aux);
			$('#mCampos').css({display:'block'});
			$('#mMensaje').css({display:'none'});
			console.log("complete");
		});

	});//fin del evento click

	$('#guardarPH').click(function(event) {
		event.preventDefault();
		var valor = $(this).val();
		var puntualidad = $('#puntualidad').val();
		var habitos = $('#habitos').val();
		var url = server + 'notas/nueva_puntualidad';
		$('#mCampos').css({display:'none'});
		$('#mMensaje').css({display:'block'});
		$.ajax({
			url: url,
			type: 'POST',
			data: {estudiante: valor, puntualidad: puntualidad, habitos: habitos},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			alert('Upps!!! Lo sentimos a ocurrido un error al intentar guardar la información en el sistema, por favor vuele a intentarlo en un momento.');
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("error");
		})
		.always(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento click

	$('#epuesto').change(function() {
		var valor = $('#epuesto option:selected').text();
		$('#nnombre').val(valor);
	});

	$('#eliminarPuesto').change(function() {
		 //alert(marcado);
		 var dato = $(this).val();
		 $('.ventana-modal').animate({top: '0%'}, 500);
		 var url = server + 'puesto/buscar_estado_puesto';

		 $.ajax({
		 	url: url,
		 	type: 'GET',
		 	data: {puesto: dato},
		 })
		 .done(function() {
		 	console.log("success");
		 })
		 .fail(function() {
		 	$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
		 	console.log("error");
		 })
		 .always(function(data) {
		 	var json = JSON.parse(data);
		 	var aux = false;
		 	for(puesto in json)
		 	{
		 		aux = json[puesto].estado_puesto;
		 	}

		 	if (aux == true)
		 	{
		 		$('#labelEstado').text('Habilitado');
		 		$('#estadopuesto').val(1);
		 		$('#estadopuesto').prop('checked', true);
		 	}
		 	else
		 	{
		 		$('#labelEstado').text('Deshabilitado');
		 		$('#estadopuesto').val(0);
		 		$('#estadopuesto').prop('checked', false);
		 	}
		 $('.ventana-modal').animate({top: '100%'}, 500);

		 	console.log("complete");
		 });

	});//fin del evento change

	$('#estadopuesto').change(function() {
		var estado = $(this).prop('checked')
		if (estado == false) { $('#labelEstado').text('Deshabilitado'); $('#estadopuesto').val(0); } else{ $('#labelEstado').text('Habilitado'); $('#estadopuesto').val(1);};
	});//fin del evento change

	$('#editarArea').change(function() {
		var nombre = $('#editarArea option:selected').text();
		var valor = $(this).val();
		$('#nombreArea').val(nombre);
		//$('#complementario').prop('checked', true);
		$('.ventana-modal').animate({top: '0%'}, 500);
		var url = server + 'area/buscar_area';
		$.ajax({
			url: url,
			type: 'GET',
			data: {area: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upps!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, vuelve a intentar más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = 0;

			for(area in json)
			{
				aux = json[area].id_tipo_area;
			}
			$('#pensum').val(1);
			$('#complementario').val(2);
			if (aux == 1) {$('#pensum').prop('checked', true); } else{$('#complementario').prop('checked', true); };

			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});


	});//fin del evento change

	$('#eliminarArea').change(function() {
		var valor = $(this).val();
		var url = server + 'area/buscar_area';
		$('.ventana-modal').animate({top: '0%'}, 500);

		$.ajax({
			url: url,
			type: 'GET',
			data: {area: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			alert('Upps!!! A ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = false;
			for(area in json)
			{
				aux = json[area].estado_area;
			}
			if (aux == true)
			{
				$('#estadoArea').prop('checked', true);
				$('#nombreEstado').text('Habilitado');
				$('#estadoArea').val(true);
			}
			else
			{
				$('#estadoArea').prop('checked', false);
				$('#nombreEstado').text('Deshabilitado');
				$('#estadoArea').val(false);
			}

			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#estadoArea').change(function() {
		var estado = $(this).prop('checked');
		if (estado == true)
		{
			$('#nombreEstado').text('Habilitado');
			$('#estadoArea').val(true);
		}
		else
		{
			$('#nombreEstado').text('Deshabilitado');
			$('#estadoArea').val(false);
		}
	});//fin del evento change

	$('#editarNivel').change(function() {
		var texto = $('#editarNivel option:selected').text();
		$('#nombreNivel').val(texto);
	});//fin del evento change

	$('#eliminarNivel').change(function() {
		var valor = $(this).val();
		var url = server + 'nivelplan/buscar_nivel';
		$('.ventana-modal').animate({top: '0%'}, 500);

		$.ajax({
			url: url,
			type: 'GET',
			data: {nivel: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, pr favor vuelve a intentarlo mas tarde');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var aux = false;
			for(nivel in json)
			{
				aux = json[nivel].estado_nivel;
			}
			if (aux == true)
			{
				$('#estadoNivel').prop('checked', true);
				$('#estadoNivel').val(true);
				$('#nombreEstado').text('Habilitado');
			}
			else
			{
				$('#estadoNivel').prop('checked', false);
				$('#estadoNivel').val(false);
				$('#nombreEstado').text('Deshabilitado');
			}
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});


	});//fin del evento change

	$('#estadoNivel').change(function() {
		var estado = $(this).prop('checked');
		if (estado == true)
		{
			$(this).val(true);
			$('#nombreEstado').text('Habilitado');
		}
		else
		{
			$(this).val(false);
			$('#nombreEstado').text('Deshabilitado');
		}

	});//fin del evento change

	$('#editarCarrera').change(function() {

		var valor = $(this).val();
		$('.ventana-modal').animate({top: '0%'}, 500);

		var url = server + 'carrera/buscar_carrera';
		$.ajax({
			url: url,
			type: 'GET',
			data: {carrera: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upps!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var plan = 0;
			var texto = '';
			for(carrera in json)
			{
				plan = json[carrera].id_plan;
				texto = json[carrera].nombre_carrera;
			}
			$('#nombreCarrera').val(texto);
			$('#sabado').val(6);
			$('#diario').val(5);
			if (plan == 1)
			{
				$('#diario').prop('checked', true);

			}
			else
			{
				$('#sabado').prop('checked', true);

			}
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#eliminarCarrera').change(function() {
		var valor = $(this).val();
		$('.ventana-modal').animate({top: '0%'}, 500);
		var url = server + 'carrera/buscar_carrera';
		$.ajax({
			url: url,
			type: 'GET',
			data: {carrera: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upps!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = $.parseJSON(data);
			var aux = false;
			for(carrera in json)
			{
				aux = json[carrera].estado_carrera;
			}

			if (aux == true)
			{
				$('#estadoCarrera').prop('checked', true);
				$('#nombreEstado').text('Habilitado');
				$('#estadoCarrera').val(true);
			}
			else
			{
				$('#estadoCarrera').prop('checked', false);
				$('#nombreEstado').text('Deshabilitado');
				$('#estadoCarrera').val(false);
			}
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#estadoCarrera').change(function() {
		var estado = $(this).prop('checked');
		if (estado == true)
		{
			$('#nombreEstado').text('Habilitado');
			$('#estadoCarrera').val(true);
		}
		else
		{
			$('#nombreEstado').text('Deshabilitado');
			$('#estadoCarrera').val(false);
		}
	});//fin del evento change

	$('#nivelEditEst').change(function() {
		var valor = $(this).val();
		var url = server + 'grado/buscar_grados';
		$('.ventana-modal').animate({top: '0%'}, 500);

		$.ajax({
			url: url,
			type: 'GET',
			data: {id: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = $.parseJSON(data);
			var html = '';
			html +='<option value="">&lt;seleccione&gt;</option>';
			for(grado in json)
			{
				html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
			}
			$('#gradoEditEst').html(html);
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#gradoEditEst').change(function() {
		var valor = $(this).val();
		var nivel = $('#nivelEditEst').val();
		var url = server + 'estudiante/buscar_estudiantes';
		var nuevosElementos = '';
		$('.ventana-modal').animate({top: '0%'}, 500);

		$.ajax({
			url: url,
			type: 'GET',
			data: {nivel: nivel, grado: valor},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = $.parseJSON(data);
			var html = '';
			var cont = 1;
			for(estudiante in json)
			{
				html += '<tr>';
				html += '<td class="text-center">'+cont+'</td>';
				html += '<td>'+json[estudiante].apellidos_estudiante.toUpperCase()+', '+json[estudiante].nombre_estudiante.toUpperCase()+'</td>';
				html += '<td class="text-center"><button class="btn btn-success btn-sm btn-editarEst" value="'+json[estudiante].id_estudiante+'">Editar</button></td>';
				html += '</tr>';
				cont++;
			}
			//$('#nominaEst').html(html);
			$('#tabla').css('display', 'block');
			nuevosElementos = $(html);
			//nuevosElementos.appendTo('td');
			//nuevosElementos.append('hello');
			//nuevosElementos.appendTo('selector');
			//html.appendTo("#nominaEst");
			$('#nominaEst').html(nuevosElementos);

			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});
		//$('#nominaEst').html(nuevosElementos);
		//nuevosElementos = $('<tr><td>Hello</td></tr>');
		//nuevosElementos.appendTo("#nominaEst");
	});//fin del evento change

$('tbody').on('click', '.btn-editarEst', function(event) {
		event.preventDefault();
		var idEstudiante = $(this).val();
		var url = server +'estudiante/buscar_estudianteId';
		$('.ventana-modal').animate({top:'0'}, 500);//mostrar el mensaje de carga
		$.ajax({
			url: url,
			type: 'GET',
			data: {id: idEstudiante}
		}).error(function(error) {
			console.log('error');
			console.log(error);
		}).success(function(data) {
			var json = JSON.parse(data);
			var nombre = '';
			var apellidos = '';
			var fechaNacimiento = '';
			var genero = '';
			var cui = '';
			var codigo = '';
			var idEst = '';
			for (est in json) {
				nombre = json[est].nombre_estudiante;
				apellidos = json[est].apellidos_estudiante;
				fechaNacimiento = json[est].fecha_nac_estudiante;
				genero = json[est].id_genero;
				cui = json[est].cui_estudiante;
				codigo = json[est].codigo_personal_estudiante;
				idEst = json[est].id_estudiante;
			}
			$('input[name="nombres"]').val(nombre);
			$('input[name="apellidos"]').val(apellidos);
			//$('input[name="nombres"]').val(nombre);
			$('input[name="codigo"]').val(codigo);
			$('input[name="CUI"]').val(cui);
			$('input[name="fecha_nacimiento"]').val(fechaNacimiento);
			//$('input[name="genero"]').val(genero);
			if (genero == 1) {
					$('#Masculino').prop('checked', true);
			}else {
				$('#Femenino').prop('checked', true);
			}//fin del if else
			$('#idEst').html('<input type="hidden" name="id" value="'+idEst+'">');
		});
		//alert($(this).val());
		$('#frm-editEst').modal('show');//mostrar el formulario modal con los datos del estudiante
		$('.ventana-modal').animate({top:'100%'}, 500);//ocultar el mensaje de carga
	});//fin del evento on

	$('#save-editEst').click(function(event) {
		event.preventDefault();
		var url = server +'estudiante/actualizar_estudianteId';
		var id = $('input[name="id"]').val();
		var nombre = $('input[name="nombres"]').val();
		var apellidos = $('input[name="apellidos"]').val();
		var codigo = $('input[name="codigo"]').val();
		var cui = $('input[name="CUI"]').val();
		var nacimiento = $('input[name="fecha_nacimiento"]').val();
		var genero = $('input:radio[name=genero]:checked').val();
		console.log(genero);
		$('.ventana-modal').animate({top:'0'}, 500);//mostrar el mensaje de carga
		$.ajax({
			url: url,
			type: 'POST',
			data: {id: id, nombre: nombre, apellidos: apellidos, codigo: codigo, cui: cui, nacimiento: nacimiento, genero: genero}
		}).error(function(error) {
			console.log('error');
			console.log(error);
		}).success(function(data) {
			console.log(data);
		});
		$('.ventana-modal').animate({top:'100%'}, 500);//Ocultar el mensaje de carga
		$('#frm-editEst').modal('hide');//ocultamos el formulario modal
	});//fin del evento click

	$('#editarTitulo').change(function() {
		var valor = $('#editarTitulo option:selected').text();
		$('#nuevoNombre').val(valor);


	});//fin del evento change

	$('#nivelExpoExc').change(function() {
		var valor = $(this).val();
		$('.ventana-modal').animate({top: '0%'}, 500);
		$('#gradoExpoExc').html('<option value="">&lt;seleccione&gt;</option>');
		if (valor == 4)
		{
			var url = server + 'carrera/carreras';
			$('#carreraUpload').css('display', 'block');
			$.ajax({
				url: url,
				type: 'GET',
				data: {},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html += '<option value="">&lt;seleccione&gt;</option>';
				for(carrera in json)
				{
					html += '<option value="'+json[carrera].id_carrera+'">'+json[carrera].nombre_carrera.toUpperCase()+'</option>';
				}
				$('#carreraExpoExc').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
		else
		{
			var url = server + 'grado/buscar_grados';
			$('#carreraUpload').css('display', 'none');
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: valor},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html += '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoExpoExc').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else
	});//fin del evento change

	$('#carreraExpoExc').change(function() {
		var texto = $('#carreraExpoExc option:selected').text();
		var url = server + 'grado/buscar_grados';
		var expresion = new RegExp('PERITO');
		var expresion2 = new RegExp('MAESTRA');

		if (texto == '<seleccione>')
		{
			$('#gradoExpoExc').html('<option value="">&lt;seleccione&gt;</option>');
		}
		else
		{
			var id = 0;
			if (expresion.test(texto) == true || expresion2.test(texto))
			{
				id = 4
			}
			else
			{
				id = 5;
			}
			$('.ventana-modal').animate({top: '0%'}, 500);
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: id},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarder.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoExpoExc').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else
	});//fin del evento change

	$('#nivelNomina').change(function() {
		var valor = $(this).val();
		$('.ventana-modal').animate({top: '0%'}, 500);
		$('#gradoNomina').html('<option value="">&lt;seleccione&gt;</option>');
		$('#carrera').css('display', 'none');
		if (valor == 4)
		{
			var url = server + 'carrera/carreras';
			$.ajax({
				url: url,
				type: 'GET',
				data: {},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(carrera in json)
				{
					html += '<option value="'+json[carrera].id_carrera+'">'+json[carrera].nombre_carrera.toUpperCase()+'</option>';
				}
				$('#carreraNomina').html(html);
				$('#carrera').css('display', 'block');
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
		else
		{
			var url = server + 'grado/buscar_grados';
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: valor},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoNomina').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
	});//fin del evento change

	$('#carreraNomina').change(function() {
		var texto = $('#carreraNomina option:selected').text();
		var url = server + 'grado/buscar_grados';
		var expresion = new RegExp('PERITO');
		var expresion2 = new RegExp('MAESTRA');

		if (texto == '<seleccione>')
		{
			$('#gradoNomina').html('<option value="">&lt;seleccione&gt;</option>');
		}
		else
		{
			var id = 0;
			if (expresion.test(texto) == true || expresion2.test(texto))
			{
				id = 4
			}
			else
			{
				id = 6;
			}
			$('.ventana-modal').animate({top: '0%'}, 500);
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: id},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarder.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoNomina').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else

	});//fin del evento change

	$('#gradoNomina').change(function() {
		var nivel = $('#nivelNomina').val();
		var carrera = $('#carreraNomina').val();
		var grado = $(this).val();
		var url = server + 'estudiante/listado_estudiantes';
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {nivel: nivel, carrera: carrera, grado: grado},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos, parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var html = '';
			var cont = 1;
			for(estudiante in json)
			{
				html += '<tr>';
				html += '<td>'+cont+'</td>';
				html += '<td>'+json[estudiante].apellidos_estudiante.toUpperCase()+', '+json[estudiante].nombre_estudiante.toUpperCase()+'</td>';
				html += '</tr>';
				cont++;
			}
			$('#miNomina').html(html);
			$('#tabla').css('display', 'block');
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change


	$('#nivelEditCuadro').change(function() {
		var valor = $(this).val();
		$('.ventana-modal').animate({top: '0%'}, 500);
		$('#gradoEditCuadro').html('<option value="">&lt;seleccione&gt;</option>');
		$('#carrera').css('display', 'none');
		if (valor == 4)
		{
			var url = server + 'carrera/carreras';
			$.ajax({
				url: url,
				type: 'GET',
				data: {},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(carrera in json)
				{
					html += '<option value="'+json[carrera].id_carrera+'">'+json[carrera].nombre_carrera.toUpperCase()+'</option>';
				}
				$('#carreraEditCuadro').html(html);
				$('#carrera').css('display', 'block');
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
		else
		{
			var url = server + 'grado/buscar_grados';
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: valor},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoEditCuadro').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
	});//fin del evento change

	$('#carreraEditCuadro').change(function() {
		var texto = $('#carreraEditCuadro option:selected').text();
		var url = server + 'grado/buscar_grados';
		var expresion = new RegExp('PERITO');
		var expresion2 = new RegExp('MAESTRA');

		if (texto == '<seleccione>')
		{
			$('#gradoEditCuadro').html('<option value="">&lt;seleccione&gt;</option>');
		}
		else
		{
			var id = 0;
			if (expresion.test(texto) == true || expresion2.test(texto))
			{
				id = 4
			}
			else
			{
				id = 6;
			}
			$('.ventana-modal').animate({top: '0%'}, 500);
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: id},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarder.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoEditCuadro').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else

	});//fin del evento change


	$('#gradoEditCuadro').change(function() {
		var nivel = $('#nivelEditCuadro').val();
		var carrera = $('#carreraEditCuadro').val();
		var grado = $(this).val();
		var url = server + 'asignacionarea/pensum_grado';
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {nivel: nivel, carrera: carrera, grado: grado},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos, parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var html = '';
			var cont = 1;
			for(area in json)
			{
				html += '<tr>';
				html += '<td>'+cont+'</td>';
				html += '<td>'+json[area].nombre_area.toUpperCase()+'</td>';
				html += '<td> <input type="radio" name="area" required="required" value="'+json[area].id_asignacion_area.toUpperCase()+'"> </td>';
				html += '</tr>';
				cont++;
			}
			$('#pensumGrado').html(html);
			$('#tabla').css('display', 'block');
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#carreraEditEst').change(function() {
		var texto = $('#carreraEditEst option:selected').text();
		var url = server + 'grado/buscar_grados';
		var expresion = new RegExp('PERITO');
		var expresion2 = new RegExp('MAESTRA');

		if (texto == '<seleccione>')
		{
			$('#gradoEditEst').html('<option value="">&lt;seleccione&gt;</option>');
		}
		else
		{
			var id = 0;
			if (expresion.test(texto) == true || expresion2.test(texto))
			{
				id = 4
			}
			else
			{
				id = 6;
			}
			$('.ventana-modal').animate({top: '0%'}, 500);
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: id},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upss!!! Lo sentimos a ocurrido un error al intentar recuperar la información del servidor, por favor vuelva a intentarlo más tarder.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				html = '<option value="">&lt;seleccione&gt;</option>';
				for(grado in json)
				{
					html += '<option value="'+json[grado].id_grado+'">'+json[grado].nombre_grado.toUpperCase()+'</option>';
				}
				$('#gradoEditEstC').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else

	});//fin del evento change

	$('#gradoEditEstC').change(function() {
		var carrera = $('#carreraEditEst').val();
		var grado = $(this).val();
		var url = server + 'estudiante/nomina_estudiantesc';
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {carrera: carrera, grado: grado},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos, parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(data) {
			var json = JSON.parse(data);
			var html = '';
			var cont = 1;
			for(estudiante in json)
			{
				html += '<tr>';
				html += '<td>'+cont+'</td>';
				html += '<td>'+json[estudiante].apellidos_estudiante.toUpperCase()+', '+json[estudiante].nombre_estudiante.toUpperCase()+'</td>';
				html += '<td> <button type="button" name="button" class="btn btn-success btn-sm btn-editarEst" value="'+json[estudiante].id_estudiante+'">EDITAR</button></td>';
				html += '</tr>';
				cont++;
			}
			$('#nominaEst').html(html);
			$('#tabla').css('display', 'block');
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('tbody').on('click', '.quitar-permiso', function(event) {
		event.preventDefault();
		var valor = $(this).val();
		var estado = false;
		var msg;
		if ($(this).text() == 'ACTIVAR') {
					estado = true;
		}else {
				estado = false;
		}

		var url = server + 'usuario/editar_permiso';
		$('#cargando').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {dato: valor, estado: estado}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upss!!! Lo sentimos, parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
			console.log("error");
		})
		.always(function(msg) {
				$('#texto'+valor).text(msg);
			$('#cargando').animate({top: '100%'}, 500);
			console.log("complete");
		});
	});//fin del evento click


	$('.agregar-permiso').click(function(event) {
		event.preventDefault();
		$('#miFormulario').css({display: 'block'});
		$('#miFormulario').animate({top: '0%'}, 500);
	});//fin del evento click

	$('#addOpcion').change(function(event) {//evento change para el select que esta en el formulario editarusuario
		var valor = $(this).val();

		if (valor == '') {
			alert('Por favor seleccione una opción valida');
		} else {
			$('#cargando').animate({top: '0%'}, 500);
			var url = server + 'usuario/buscar_subopciones';
			$.ajax({
				url: url,
				type: 'GET',
				data: {id: valor}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentarlo más tarde.');
				$('#cargando').animate({top: '100%'}, 500);
				console.log("error");
			})
			.always(function(data) {
				var json =JSON.parse(data);
				var html = '';
				html = '<option>&lt;seleccione&gt;</option>';
				for(sub in json)
				{
					html += '<option value="'+json[sub].id_sub_opcion+'">'+json[sub].nombre_sub_opcion.toUpperCase()+'</option>';
				}
				$('#addSubOp').html(html);
				$('#cargando').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}//fin del if else
	});//fin del evento change

	$('#addPermiso').click(function(event) {
		event.preventDefault();
		var opcion = $('#addOpcion').val();
		var sub = $('#addSubOp').val();
		var valor = $(this).val();
		if (opcion == '' || sub == '') {
			alert('Error. Por favor seleccione una opción valida');
		} else {
				var url = server + 'usuario/agregar_permiso';
				$('#cargando').animate({top: '0%'}, 500);
				$.ajax({
					url: url,
					type: 'GET',
					data: {opcion: opcion, sub: sub, usuario: valor}
				})
				.done(function() {
					console.log("success");
				})
				.fail(function() {
					alert('Upss!!! Lo sentimos parece que a ocurrido un error al intentar almacenar la información en el servidor, por favor vuelve a intentarlo más tarde.');
					$('#cargando').animate({top: '100%'}, 500);
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = '';
					for(permiso in json)
					{
						html += '<tr>';
						html += '<td>'+json[permiso].nombre_opcion.toUpperCase()+'</td>';
						html += '<td>'+json[permiso].nombre_sub_opcion.toUpperCase()+'</td>';
						if (json[permiso].estado_sub_permiso == true) {
							html += '<td><button class="btn btn-warning quitar-permiso" value="'+json[permiso].id_subpermisos_usuario+'" id="texto'+json[permiso].id_subpermisos_usuario+'" >DESACTIVAR</button></td>';
						} else {
							html += '<td><button class="btn btn-warning quitar-permiso" value="'+json[permiso].id_subpermisos_usuario+'" id="texto'+json[permiso].id_subpermisos_usuario+'" >ACTIVAR</button></td>';
						}
						html += '</tr>';
					}
					$('#contenido').html(html);
					$('#miFormulario').animate({top: '100%'}, 500);
					$('#cargando').animate({top: '100%'}, 500);
					console.log(html);
					console.log("complete");
				});

		}//fin del if else
	});//fin del evento click

	$('#addCancelar').click(function(event) {//evento click para el botton cancelar que se encuantra en el formulario editarusuario
		event.preventDefault();
		$('#miFormulario').animate({top: '100%'}, 500);
	});//fin del evento click

	$('#btn-destinatario').click(function(event) {
		event.preventDefault();
		var busca = $('#busqueda').val();
		var url = server + 'docentes/buscar_docente_correo';
		$.ajax({
			url: url,
			type: 'GET',
			data: {persona: busca}
		}).error(function(error) {
			console.log(error);
			console.log('Error');
		}).success(function(data) {
			var json = JSON.parse(data);
			var html = '';
			for(el in json)
			{
				html += '<tr id="'+json[el].id_persona +'">';
				html += '<td>'+json[el].nombre_persona.toUpperCase() + ' ' + json[el].apellidos_persona.toUpperCase()+'</td>';
				html += '<td>'+json[el].nombre_puesto.toUpperCase() +'</td>';
				html += '<td> <button type="button" class="btn btn-default btn-sm agr-dest" data-id="'+json[el].id_persona +'" value="'+json[el].correo_electr_persona +'" data-nombre="'+json[el].nombre_persona.toUpperCase() + ' ' + json[el].apellidos_persona.toUpperCase()+'">Agregar Destinatario</button></td>';
				html += '</tr>';
			}
			$('#coincidencias').html(html);
		});

	});//fin del evento click

$('.form-group').on('click', '.agr-dest', function(event) {
	event.preventDefault();
	var nombre = $(this).data('nombre');
	var correo = $(this).val();
	var id = $(this).data('id');
	$('#'+id).empty();
	var html = '<div class="col-sm-3">';
	html += '<div class="alert alert-success alert-dismissible" role="alert" style="padding: 6px; padding-right: 30px">';
	html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	html += '<strong>'+nombre+'</strong>';
	html += '<input type="hidden" name="correos[]" value="'+correo+'">';
	html += '</div>';
	html += '</div>';
	var aux =	$('#destinatarios');
	aux.append(html);
});//fin del evento on para agregar un destinatario en especifico para enviarle el correo

	$('#all-dest').change(function(event) {//evento para ocultar o mostrar la opcion de busqueda de destinatarios para envio de correos
		event.preventDefault();
		if ($(this).is(':checked')) {
			$('#busqueda-destinatario').css({'display': 'none'});
		}else{
			$('#busqueda-destinatario').css({'display': 'block'})
		}//fin del if else
	});//fin del evento change

	$('#btn-modal').click(function(event) {
		event.preventDefault();
		$('#frm-editEst').modal('show');
	});//fin del evento click



});//fin del document ready
