<h2 class="text-center">Nuevo Nivel-Plan</h2>
<p>Nota: Los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/nivelplan/nuevo_nivelplan" method="POST" class="form-horizontal" role="form">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS DEL NIVEL</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="nivel" class="col-sm-2 control-label">Nivel*</label>
		<div class="col-sm-10">
			<select name="nivel" id="" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($nivel as $value):
				 ?>
					<option value="<?php echo $value['id_nivel']; ?>"><?php echo ucwords($value['nombre_nivel']); ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="plan" class="col-sm-2 control-label">Plan*</label>
		<div class="col-sm-10">
			<select name="plan" id="" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($plan as $value):
				 ?>
					<option value="<?php echo $value['id_plan']; ?>"><?php echo ucwords($value['nombre_plan']); ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<p class="text-danger">	<?php echo validation_errors(); ?> </p>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Guardar</button>
		</div>
	</div>
</div>
</div>
</form>