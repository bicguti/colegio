<h2 class="text-center">Nuevo Municipio</h2>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/municipio/nuevo_municipio" method="POST" class="form-horizontal" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS DEL NUEVO MUNICIPIO</h3>
    </div>
    <div class="panel-body">	
	<div class="form-group">
		<label for="departamento" class="col-sm-2 control-label">Departamento*</label>
		<div class="col-sm-10">
			<select name="departamento" id="" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($departamento as $value):
				 ?>
					<option value="<?php echo $value['id_depto']; ?>"><?php echo ucwords($value['nombre_depto']); ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>	
	</div>

	<div class="form-group">
		<label for="municipio" class="col-sm-2 control-label">Municipio*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="municipio" required="required" placeholder="Nombre del municipio">
		</div>
	</div>

	<div class="form group">
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