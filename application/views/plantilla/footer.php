</div>
	</div>
	<script type="text/javascript" src="<?=base_url()?>js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src= "<?=base_url()?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src= "<?=base_url()?>js/bootstrap-editable.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
	<!-- Datatables -->
	<script type="text/javascript" src="<?=base_url()?>js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/dataTables.select.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/backend/script.js"></script>
	<script type="text/javascript" src= "<?=base_url()?>js/backend/script2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		var tabla =	$('#datatable').DataTable({
				select: true,
				"language": {
					"search": "Buscar",
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"zeroRecords": "Ninguno encontrado - disculpe",
					"info": "Mostrando página _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrado de un total _MAX_ de registros)",
					"paginate":{
						"next": "Siguiente",
						"previous": "Anterior"
					},
					buttons: {
						copy: 'Copiar',
						print: 'Imprimir',
						copyTitle: 'Copiado a su papelera',
							copySuccess: {
									_: 'Copiado %d registros',
									1: 'Copiado 1 registro'
							}

					}

			}
		});

	tabla.on('select', function(e, dt, type, indexes) {
		//event.preventDefault();
		/* Act on the event */
		var rowData = tabla.rows(indexes).data().toArray();
		/*var aux = $('.selected').find('td').toArray();
		var cont = 0;
		$(aux).each(function(index, el) {
			console.log($(this).text());
			switch (cont) {
				case 1:
					$(this).text('Byron Castro');
					break;
				default:

			}
			cont++;
		});*/

	var html = '<p>Estudiante: <b><i>'+rowData[0][1]+'</i></b></p>';
	html += '<p>Total Bloque: <b><i>'+rowData[0][2]+'</i></b></p>'
	html += '<form class="form-horizontal">';
	html += '<div class="form-group">';
	html += '<label for="total" class="control-label col-sm-2">Zona</label>';
	html += '<div class="col-sm-10">';
	html += '<input type="text" value="'+(rowData[0][2] - rowData[0][5])+'" placeholder="Total del Bloque" name="zona" class="form-control"/>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label for="habitos" class="control-label col-sm-2">Habitos Orden</label>';
	html += '<div class="col-sm-10">';
	html += '<input type="text" value="'+rowData[0][3]+'" placeholder="Habitos de orden" name="habitos" class="form-control"/>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label for="puntualidad" class="control-label col-sm-2">Puntualidad y asistencia</label>';
	html += '<div class="col-sm-10">';
	html += '<input type="text" value="'+rowData[0][4]+'" placeholder="Puntualiadad y asistencia del estudiante" name="puntualidad" class="form-control"/>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label for="evaluacion" class="control-label col-sm-2">Evaluación</label>';
	html += '<div class="col-sm-10">';
	html += '<input type="text" value="'+rowData[0][5]+'" placeholder="Evaluación de bloque" name="evaluacion" class="form-control"/>';
	html += '</div>';
	html += '</div>';
	html += '<input type="hidden" name="cuadro" value="'+rowData[0][6]+'" />';
	html += '<input type="hidden" name="nivel" value="'+rowData[0][7]+'"/>';
	html += '</form>';
$('.modal-body').html(html);
$('#modalPuntos').modal('show');
	});//fin del evento

		$('#editarCuadros').click(function(event) {
			var cuadro = $('input[name="cuadro"]').val();
			var nivel = $('input[name="nivel"]').val();
			var zona = $('input[name="zona"]').val();
			var habitos = $('input[name="habitos"]').val();
			var puntualidad = $('input[name="puntualidad"]').val();
			var evaluacion = $('input[name="evaluacion"]').val();
			/*console.log(cuadro);
			console.log(nivel);
			console.log(zona);
			console.log(habitos);
			console.log(puntualidad);
			console.log(evaluacion);
			console.log(window.location.host);
			console.log(window.location.protocol);*/
			var url = window.location.protocol+'//'+window.location.host+'/colegio/index.php/cuadros/actualizar_cuadro';
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: {cuadro: cuadro, nivel: nivel, zona: zona, habitos: habitos.toUpperCase(), puntualidad: puntualidad.toUpperCase(), evaluacion: evaluacion}
			})
			.done(function(data) {
				console.log(data);
				var aux = $('.selected').find('td').toArray();
				var cont = 0;
				$(aux).each(function(index, el) {
					//console.log($(this).text());
					switch (cont) {
						case 2:
						var total = parseFloat(zona) + parseFloat(evaluacion);
							$(this).text(total);
							break;
						case 3:
							$(this).text(habitos.toUpperCase());
							break;
						case 4:
							$(this).text(puntualidad.toUpperCase());
							break;
						case 5:
							$(this).text(evaluacion);
							break;
					}
					cont++;
				});
				console.log("success");
				$('#modalPuntos').modal('hide');
			})
			.fail(function() {
				alert('Lo sentimos parece que ha ocurrido un error al procesar la solicitud en el servidor!!!');
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});//fin del evento click

		});
	</script>
</body>
</html>
