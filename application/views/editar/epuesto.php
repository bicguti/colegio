<h1 class="text-center">Editar un Puesto</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('puesto/guardar_edicion_puesto', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS PUESTO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Puesto*', 'puesto', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="puesto" id="epuesto" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($puesto as$value): ?>
					<option value="<?php echo $value['id_puesto'] ?>"> <?php echo mb_strtoupper($value['nombre_puesto']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo form_label('Nombre*', 'nombre', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'nnombre', 'required'=>'required', 'class'=>'form-control', 'id'=>'nnombre', 'maxlength'=>'15', 'value'=>set_value('nnombre'))); ?>
			
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