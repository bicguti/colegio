<h2 class="text-center">Nuevo Estudiante de Carrera</h2>
<p>Nota: Todos lo campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/estudiante/nuevo_estudiantec" method="POST" class="form-horizontal" role="form">
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS ESTUDIANTE DIVERSIFICADO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="nombres" class="col-sm-2 control-label">Nombres*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" required="required" name="nombres" placeholder="Nombres del estudiante" autocomplete="off" maxlength="50">
		</div>
	</div>

	<div class="form-group">
		<label for="apellidos" class="col-sm-2 control-label">Apellidos*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" required="required" name="apellidos" placeholder="Apellidos del estudiante" autocomplete="off" maxlength="50">
		</div>
	</div>

	<div class="form-group">
		<label for="codigo" class="col-sm-2 control-label">Código</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="codigo" placeholder="Código personal" autocomplete="off" maxlength="20">
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('CUI', 'cui', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'cui', 'class'=>'form-control', 'placeholder'=>'CUI del Estudiante', 'autocomplete'=>'off', 'maxlength'=>'13')); ?>
		</div>
	</div>

	<div class="form-group">
		<label for="fechanacimiento" class="col-sm-2 control-label">Fecha Nacimiento*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control datepicker" name="fechanacimiento" required="required" placeholder="Fecha de nacimiento" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="genero" class="col-sm-2 control-label">Genero*</label>
		<div class="col-sm-offset-2 col-sm-10">
			<?php
				foreach($genero as $value):
			 ?>
				<label for="geneo">
					<input type="radio" name="genero" required="required" value="<?php echo $value['id_genero']; ?>"> <?php echo ucfirst($value['nombre_genero']); ?>
				</label>
			<?php
				endforeach;
			 ?>
		</div>
	</div>



<div class="form-group">
		<label for="carrera" class="col-sm-2 control-label">Carrera*</label>
		<div class="col-sm-10">
			<select name="carrera" id="carrera" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php
					foreach($carrera as $value):
				 ?>
					<option value="<?php echo $value['id_carrera']; ?>"><?php echo ucwords($value['nombre_carrera']); ?></option>
				<?php
					endforeach;
				 ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="grado" class="col-sm-2 control-label">Grado*</label>
		<div class="col-sm-10" id="grado">
			<select name="grado" id="grado" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>

			</select>
		</div>
	</div>



	<div class="form-group">
		<p class="text-danger"><?php echo validation_errors(); ?></p>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default" type="submit">Guardar</button>
		</div>
	</div>
</div>
</div>
</form>
