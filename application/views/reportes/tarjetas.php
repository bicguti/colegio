<h1 class="text-center">Generación de Tarjetas de Calificación</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('tarjetas/exportar_tarjetas', array('class'=>'form-horizontal', 'role'=>'form', 'target'=>'_blank')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">TARJETAS POR NIVEL Y GRADO</h3>
    </div>
    <div class="panel-body">
<div class="form-group">
		<?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="nivel" id="nivelRC" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($nivel as $value): ?>
					<option value="<?php echo $value['id_nivel'] ?>"><?php echo mb_strtoupper($value['nombre_nivel']) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	
	<div class="form-group" id="fg-carrera" style="display: none;">
		<?php echo form_label('Carrera*', 'carrera', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="carrera" id="carreraRC" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Grado*', 'grado', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="grado" id="gradoRC" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Bloque*', 'bloque', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="bloque" id="" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($bloque as $value): ?>
					<option value="<?php echo $value['id_bloque'] ?>"><?php echo mb_strtoupper($value['nombre_bloque']) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button class="btn btn-danger">Crear PDF <span class="icon-file-pdf"></span></button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>