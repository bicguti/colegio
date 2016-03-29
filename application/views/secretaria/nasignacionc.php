<h2 class="text-center">Nueva Asignacion de Area</h2>
<h3 class="text-center">Diversificado</h3>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/asignacionarea/nueva_asignacionc" method="POST" class="form-horizontal" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ASIGNAR ÁREAS A CARRERAS</h3>
    </div>
    <div class="panel-body">	

	<div class="form-group">
		<label for="Carrera" class="col-sm-2 control-label">Carrera*</label>
		<div class="col-sm-10">
			<select name="carrera" required="required" id="carrera" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($carrera as $value):
				 ?>
					<option value="<?php echo $value['id_carrera']; ?>"> <?php echo ucwords($value['nombre_carrera']); ?>	</option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="grado" class="col-sm-2 control-label">Grado*</label>
		<div class="col-sm-10" id="grado">
			<p class="text-info">No disponible aun.</p>
		</div>
	</div>

	<div class="form-group">
		<label for="area" class="col-sm-2 control-label">Area*</label>
		<div class="col-sm-10">
			<?php 
				foreach($area as $value):
			 ?>
				<label for="area" class="col-sm-6 col-xs-12">
					<input type="checkbox" name="areas[]" value="<?php echo $value['id_area']; ?>"> <?php echo ucwords($value['nombre_area']); ?>
				</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
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