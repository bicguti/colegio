<h1 class="text-center">Editar Nivel</h1>
<p class="text-info">Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('nivelplan/guardar_edicion_nivel', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS NIVEL</h3>
    </div>
    <div class="panel-body">	
	<div class="form-group">
		<?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="nivel" id="editarNivel" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($nivel as $value): ?>
					<option value="<?php echo $value['id_nivel'] ?>"><?php echo mb_strtoupper($value['nombre_nivel']) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Nombre*', 'nombre', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'nombre', 'class'=>'form-control', 'id'=>'nombreNivel', 'required'=>'required', 'maxlength'=>'20', 'value'=>set_value('nombre'))); ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors() ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Editar Nivel</button>
		</div>
	</div>
</div>
</div>
<?php echo  form_close(); ?>