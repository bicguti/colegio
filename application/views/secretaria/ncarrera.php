<h2 class="text-center">Nueva Carrera</h2>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/carrera/nueva_carrera" method="POST" class="form-horizontal" role="form">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS CARRERA</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="nombre" class="col-sm-2 control-label">Nombre*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nombre" required="required" placeholder="Nombre de la carrera" maxlength="70" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="plan" class="col-sm-2 control-label">Plan*</label>
		<div class="col-sm-offset-2 col-sm-10">
			<?php 
				foreach($plan as $value):
			 ?>
				<label for="plan">
					<input type="radio" name="plan" required="required" value="<?php echo $value['id_plan']; ?>"> <?php echo ucfirst($value['nombre_plan']); ?>
				</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo validation_errors(); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default" type="submit">Guardar</button>
		</div>
	</div>
</div>
</div>
</form>