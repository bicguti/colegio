$(document).ready(function() {
	//var server='http://localhost/colegio/index.php/';//esto es la base ir del servidor
	var URLdomain = window.location.host;
	var protocolo = window.location.protocol;
	//var url = protocolo+'//'+URLdomain+'/municipio';
	var server = protocolo+'//'+URLdomain+'/colegio/index.php/';

	$('#deptoresi').change(function() {//evento change para el select con id deptoresi
		//alert($('#deptoresi').val());
			var url=server+"municipio/municipios";
			var id=$('#deptoresi').val();//obtenemos el id de la opcion seleccionada
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
			alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
			console.log("error");
			})
			.always(function(data) {
				var json=JSON.parse(data);
				//console.log(json);
				var html="";
				html+="<option value=''>&lt;seleccione&gt;</option>";
				var aux = "";
				for(muni in json)
				{
					aux = json[muni].nombre_muni.charAt(0).toUpperCase()+json[muni].nombre_muni.slice(1);
					html+="<option value="+json[muni].id_muni+">"+aux+"</option>"
				}
				$('#muniresi').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});


	});//fin del evento


	$('#deptonaci').change(function() {//evento change para el select con id deptonac
		var url=server+"municipio/municipios";
		var id=$('#deptonaci').val();
		$('.ventana-modal').animate({top: '0%'}, 500);
		$.ajax({
			url: url,
			type: 'GET',
			data: {id:id},
		})
		.done(function(data) {
			console.log("success");
		})
		.fail(function() {
			$('.ventana-modal').animate({top: '100%'}, 500);
			alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
			console.log("error");
		})
		.always(function(data) {

			var json=JSON.parse(data);
				//console.log(json);
				var html="";
				html+="<option value=''>&lt;seleccione&gt;</option>";
				var aux = "";
				for(muni in json)
				{
					aux = json[muni].nombre_muni.charAt(0).toUpperCase()+json[muni].nombre_muni.slice(1);
					html+="<option value="+json[muni].id_muni+">"+aux+"</option>"
				}

				$('#muninaci').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
		});

	});//fin del evento

	$('#nivel').change(function() {//evento change para el select con id nivel en el formulario nestudiante
		var url = server + "grado/buscar_grados";
		var id = $('#nivel').val();
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
			alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
			console.log("error");
		})
		.always(function(data) {

			var json = JSON.parse(data);
			var html = "";
			html += "<option value ''>&lt;seleccione&gt;</option>";
			var aux ="";
			for(grado in json)
			{
				aux = json[grado].nombre_grado.charAt(0).toUpperCase()+json[grado].nombre_grado.slice(1);
				html += "<option value="+json[grado].id_grado+">"+aux+"</option>";
			}
			$("#grado").html(html);
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});

	});//fin del evento change

	$('#nivelasignacion').change(function() {//evento change para el select con id nivelasignacion en el formulario nasignacionarea
		var url = server + "grado/buscar_grados";
		var id = $('#nivelasignacion').val();
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
			alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
			console.log("error");
		})
		.always(function(data) {
			console.log("complete");
			var json = JSON.parse(data);
			var html = "";
			var aux = "";
			for(grado in json)
			{
				aux = json[grado].nombre_grado.charAt(0).toUpperCase()+json[grado].nombre_grado.slice(1);
				html +="<label for='grado'><input type='checkbox' name='grados[]' class='grado' value="+json[grado].id_grado+">"+aux+"</label>";
			}
			$("#grado").html(html);
			$('.ventana-modal').animate({top: '100%'}, 500);
			console.log("complete");
		});
	});//fin del evento change.


	$('#carrera').change(function() {//evento change para el select con id carrera en el formulario nestudiantec
		var texto = $('#carrera option:selected').text();//obtenemos el texto de la opcion seleccionada
		 var expresion = new RegExp('Perito');
		 var expresion2 = new RegExp('Maestra');
		 var expresion3 = new RegExp('perito');
		$('#grado').html('');
		$('#cursos').html('');
		$('.ventana-modal').animate({top: '0%'}, 500);
		if (expresion.test(texto) == true || expresion2.test(texto) == true ||expresion3.test(texto) == true)
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
					alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = "";
					var aux = "";
					html += '<select name="grados" id="grados" class="form-control" required="required">';
					html += '<option value="">&lt;seleccione&gt;</option>';
					for(grado in json)
					{
						aux = json[grado].nombre_grado[0].toUpperCase()+json[grado].nombre_grado.slice(1);
						html += "<option value="+json[grado].id_grado+">"+aux+"</option>"
					}
					html +='</select>';
					$('#grado').html(html);
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
					alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = "";
					var aux = "";
					html += '<select name="grados" id="grados" class="form-control" required="required">';
					html += '<option value="">&lt;seleccione&gt;</option>'
					for(grado in json)
					{
						aux = json[grado].nombre_grado[0].toUpperCase()+json[grado].nombre_grado.slice(1);
						html += "<option value="+json[grado].id_grado+">"+aux+"</option>"
					}
					html +='</select>';
					$('#grado').html(html);
					$('.ventana-modal').animate({top: '100%'}, 500);
					console.log("complete");

				});
			}
	});

	$('#nivelasignacionD').change(function() {//evento change para buscar los grados correspondietes a un nivel

		var id = $('#nivelasignacionD').val();
		$('#cursos').html('');
		$('#grado').html('');

		if (id !='')
		{
			$('.ventana-modal').animate({top: '0%'}, 500);
		if (id == 4)
		{
			var url = server + 'carrera/carreras';
			$.ajax({
				url: url,
				type: 'GET'
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				$('.ventana-modal').animate({top: '100%'}, 500);
				alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
				console.log("error");
			})
			.always(function(data) {
				var json = JSON.parse(data);
				var html = '';
				var aux = '';
				html += '<label class="col-sm-2 control-label">Carrera*</label>';
				html += '<div class="col-sm-10">';
				html += '<select name="carrera" class="form-control" id="carrera" required="required">';
				html += '<option value="">&lt;seleccione&gt;</option>';
				for(carrera in json)
				{
					aux = json[carrera].nombre_carrera[0].toUpperCase()+ json[carrera].nombre_carrera.slice(1);
					html += '<option value="'+json[carrera].id_carrera+'">'+aux+'</option>';
				}
				html += '</select>';
				html +='</html>';
				$('#grado').html('<p class="text-info">No disponible aun.</p>')
				$('#carrera').html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});

		}
		else
		{
			var url = server + "grado/buscar_grados";

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
				alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
				console.log("error");
			})
			.always(function(data) {

				var json = JSON.parse(data);
				var html = "";
				var aux ="";
				html += '<select name="grados" id="grados" class="form-control" required="required">';
				html += '<option value="">&lt;selecccione&gt;</option>';
				for(grado in json)
				{
					aux = json[grado].nombre_grado.charAt(0).toUpperCase()+json[grado].nombre_grado.slice(1);
					html += "<option value="+json[grado].id_grado+">"+aux+'</option>';
				}
				html += '</select>';
				$('#carrera').html('');
				$("#grado").html(html);
				$('.ventana-modal').animate({top: '100%'}, 500);
				console.log("complete");
			});
		}
		}
	});//fin del evento change.

	$('#grado').change(function() {//evento change para el selecct con id grado del formulario nasignaciond
		var nivel = $('#nivelasignacionD').val();
		var grado = $('#grados').val();
		$('#cursos').html('');
		if (nivel == null) {nivel = 1;};
		if (grado == null) {grado = 1};
		if (nivel != '' && grado != '')
		{
			var url = '';
			$('.ventana-modal').animate({top: '0%'}, 500);
			if (nivel == 4)
			{
				var carrera = $('#carrera option:selected').val();
				url = server + 'Asignaciondocente/areas_diversificado';
				$.ajax({
					url: url,
					type: 'GET',
					data: {carrera: carrera, grado: grado}
				})
				.done(function() {
					console.log("success");
				})
				.fail(function() {
					$('.ventana-modal').animate({top: '100%'}, 500);
				    alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = '';
					html += '<table class="table table-hover table-bordered"><thead><tr>';
					html +='<th>Area</th><th>Seleccionar</th>';
					html += '</tr></thead> <tbody>';
					if (json.length == 0)
					{
						html+= '<tr><td class="text-danger">*Este grado todavia no tiene cursos asignados, se le recomienda primero asignar los cursos correspondientes y luego regresar a este modulo.</td></tr>'
					}
					else
					{
						for(areas in json)
						{
							html += '<tr><td class="texto">'+json[areas].nombre_area.toUpperCase()+'</td> <td><input type="checkbox" name="area[]" class="areas" value='+json[areas].id_asignacion_areac+'></td> </tr>';
						}
					}
					html += '</tbody></table>';
					$('#cursos').html(html);
					$('.ventana-modal').animate({top: '100%'}, 500);
					console.log("complete");
				});


			}
			else
			{
				url = server + 'Asignaciondocente/areas_primariaBasico';
				$.ajax({
					url: url,
					type: 'GET',
					data: {nivel: nivel, grado: grado}
				})
				.done(function() {
					console.log("success");
				})
				.fail(function() {
					$('.ventana-modal').animate({top: '100%'}, 500);
				    alert('Upps!!! Lo sentimos parece que a ocurrido un error al intentar recuperar la información del servidor, por favor vuelve a intentar más tarde.');
					console.log("error");
				})
				.always(function(data) {
					var json = JSON.parse(data);
					var html = '';
					html += '<table class="table table-hover table-bordered">';
					html += '<thead><tr>';
					html += '<th>Area</th> <th>Seleccionar</th>';
					html += '</tr></thead> <tbody>';
					if (json.length == 0)
					{
						html+= '<tr><td class="text-danger">*Este grado todavia no tiene cursos asignados, se le recomienda primero asignar los cursos correspondientes y luego regresar a este modulo.</td></tr>'
					}
					else
					{
						for(areas in json)
						{
							html += '<tr><td class="texto">'+json[areas].nombre_area.toUpperCase()+'</td><td><input type="checkbox" name="area[]" class="areas" value='+json[areas].id_asignacion_area+'></td></tr>'
						}
					}
					html +='</tbody></table>';
					$('#cursos').html(html);
					$('.ventana-modal').animate({top: '100%'}, 500);
					console.log("complete");
				});

			}
		}
		else
		{
			alert('Error: Debe seleccionar un nivel y un grado, para ver los cursos correspondientes.');
		}


	});




	$.datepicker.regional["es"]={//configuracion para el datepicker en idioma españo-latinoamericano
		closeText: 'Cerrar',
		prevText: 'anterior',
		nextText: 'Siguiente',
		CurrentText: 'Hoy',
		monthNames:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
		'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort:['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
		'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesShort:['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		dayNamesMin:['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		weekHeader:'Sm',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '',
		changeMonth:true,
		changeYear:true,
		yearRange: "1930:2050"
	};//fin de la configuración del datapicker

	$.datepicker.setDefaults($.datepicker.regional["es"]);//asignar las configuraciones al datapicker
	$('.datepicker').datepicker();//asignar un datapicker a los elementos que tengan una clase llamada datapicker

/*	$('.letras').keypress(function(e) {//funcion que solo admite letras en los inputs con la clase letras
		if ((e.charCode <97 || e.charCode>122 && e.charCode <130)  && (e.charCode != 32) && (e.charCode != 165))
		{
			return false;
		}
	});//fin del evento keypress

	$('.usu-pass').keypress(function(e) {//funcion que solo admite letras mayusculas, minusculas y numeros con la clase usu-pass

		if ((e.charCode <97 || e.charCode>122 && e.charCode <130) && (e.charCode < 48 || e.charCode > 57) && (e.charCode <65 || e.charCode >90))
		 {
		 	return false;
		 }

	});//fin del evento keypress
*/

});
