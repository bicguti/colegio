<?php if ($permiso1 == false && $permiso2 == false): ?>
	<p class="text-danger">No tienes permisos para utilizar este modulo, debes ser docente titular de un
	grado de pre-primaria, primaria, guía de un grado de básico o diversificado.</p>
	<p class="text-danger">Si esto es un error, por favor comunicate a secretaria.</p>
<?php else: ?>

<h1 class="text-center">Puntualidad y Hábitos</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('notas/nomina_estudiantes', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">NOMINA DE ESTUDIANTES</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<td>No</td>
						<th>Nivel</th>
						<th>Grado</th>
						<th>Carrera</th>
						<th>Seleccionar</th>
					</tr>
				</thead>
				<tbody>
					<?php $cont = 1; ?>
					<?php if (isset($grado)): ?>
						<?php foreach ($grado as $value): ?>
							<tr>
								<td><?php echo $cont;?></td>
								<td><?php echo mb_strtoupper($value['nombre_nivel']) ?></td>
								<td><?php echo mb_strtoupper($value['nombre_grado']) ?></td>
								<td>NINGUNO</td>
								<td><input type="radio" name="grado" required="required" value="<?php echo $value['id_nivel'].','.$value['id_grado'] ?>"></td>
							</tr>
							<?php $cont++; ?>
						<?php endforeach ?>						
					<?php endif ?>

					<?php if (isset($gradoD)): ?>
						<?php foreach ($gradoD as $key => $value): ?>
							<tr>
								<td><?php echo $cont; ?></td>
								<td>DIVERSIFICADO</td>
								<td><?php echo mb_strtoupper($value['nombre_grado']) ?></td>
								<td><?php echo mb_strtoupper($value['nombre_carrera']) ?></td>
								<td><input type="radio" name="grado" required="required" value="<?php echo '4'.','.$value['id_grado'].','.$value['id_carrera'] ?>"></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>

				</tbody>
			</table>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 cols-m-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>	
	</div>

	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button class="btn btn-primary">Asignar Notas</button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>

	
<?php endif ?>

