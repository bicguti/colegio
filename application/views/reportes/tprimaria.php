<?php if ($permiso == true): ?>
	<h1 class="text-center">Generación de Tarjetas de Calificaciones</h1>
	<h2 class="text-center">Nivel Pre-Primaria y Primaria</h2>
	<p class="text-info">Nota todos los campos con (*) son obligatorios</p>

	<?php echo form_open('reportesdocentes/exportar_tarjetas', array('class'=>'form-horizontal', 'role'=>'form', 'target'=>'_blank')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">GENERACIÓN DE TARJETAS DEL NIVEL PRIMARIO</h3>
    </div>
    <div class="panel-body">
		<div class="form-group">
			<div class="col-sm-12 text-right ext3">
				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Bloque*', 'bloque', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<select name="bloque" id="" class="form-control" required="required">
					<option value="">&lt;seleccione&gt;</option>
					<?php foreach ($bloque as $value): ?>
						<option value="<?php echo $value['id_bloque']?>"> <?php echo mb_strtoupper($value['nombre_bloque']) ?> </option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10 text-danger">
				<?php echo validation_errors() ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-danger" name="tipo" value="v">Visualizar PDF <span class="icon-file-pdf"></span>	</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-danger" name="tipo" value="d">Descargar PDF <span class="icon-file-pdf"></span>	</button>
			</div>
		</div>
	</div>
	</div>
	<?php echo form_close(); ?>

<?php else: ?>
	<p class="text-warning">Lo siento no tienes los privilegiós para utilizar este modulo, debes ser docente titular de
	algun grado de Pre-Primaria o Primaria para poder poder trabajar este modulo.</p>
	<p class="text-warning">Si esto es un error consulta en secretaria!!!.</p>
<?php endif ?>
