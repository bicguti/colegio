<h1 class="text-center">Editar Título Academico</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('titulo/guardar_edicion_titulo', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS TÍTULO ACADEMICO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('titulo', 'titulo', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="titulo" id="editarTitulo" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($tacademico as $value): ?>
					<option value="<?php echo $value['id_titulo'] ?>"> <?php echo ucwords($value['nombre_titulo']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Nombre Título*', 'titulo', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'nombre', 'id'=>'nuevoNombre', 'class'=>'form-control', 'required'=>'required', 'autocomplete'=>'off', 'placeholder'=>'nombre del título', 'maxlength'=>'100', 'value'=>set_value('nombre'))); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Editar</button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>