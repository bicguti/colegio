<h2 class="text-center">Nueva Area</h2>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/area/nueva_area" method="POST" class="form-horizontal" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS DEL ÁREA</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="nombre" class="col-sm-2 control-label">Nombre*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nombre" required="required" placeholder="Nombre del area" maxlength="60" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="tipoarea" class="col-sm-2 control-label">Tipo de Area*</label>
		<div class="col-sm-offset-2 col-sm-10">
			<?php 
				foreach($tipoarea as $value):
			 ?>
				<label for="tipoarea">
					<input type="radio" required="required"  name="tipoarea" value="<?php echo $value['id_tipo_area']; ?>"> <?php echo ucfirst($value['nombre_tipo_area']); ?>
				</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>
	
	<div class="form-group text-danger">
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