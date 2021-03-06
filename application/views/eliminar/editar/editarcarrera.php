<h1 class="text-center">Editar Carrera</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('carrera/guardar_edicion_carrera', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS CARRERA</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Carrera*', 'carrera', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">				
			<select name="carrera" id="editarCarrera" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($carrera as $value): ?>
					<option value="<?php echo $value['id_carrera'] ?>"> <?php echo mb_strtoupper($value['nombre_carrera']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Nombre*', 'nombre', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'nombre', 'class'=>'form-control', 'id'=>'nombreCarrera', 'required'=>'required', 'maxlength'=>'70', 'autocomplete'=>'off', 'value'=>set_value('nombre'))); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Plan*', 'plan', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-offset-2 col-sm-10">
		<label for="diario"><?php echo form_input(array('name'=>'plan', 'type'=>'radio', 'required'=>'required', 'id'=>'diario', 'value'=>set_value('plan'))); ?><?php echo ucwords($plan[0]['nombre_plan']) ?></label>
		<label for="sabatino"><?php echo form_input(array('name'=>'plan', 'type'=>'radio', 'required'=>'required', 'id'=>'sabado', 'value'=>set_value('plan'))); ?><?php echo ucwords($plan[1]['nombre_plan']) ?></label>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Editar Carrera</button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>

<div class="ventana-modal">
	<div class="col-sm-12">
		<div action="" class="form-horizontal" role="form" id="form" style="background-color:transparent">
				
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<h1 style="color:#18bc9c">Cargando...</h1>

					<div align="center" class="cssload-fond">
						<div class="cssload-container-general">
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_1"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_2"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_3"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_4"> </div></div>
						</div>
					</div>
				</div>
				
			</div>								
		</div>			

	</div>
</div>