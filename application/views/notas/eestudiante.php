<div class="col-sm-12">
	<h1 class="text-center">Nomina de Estudiantes</h1>
	<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">ESTUDIANTES</h3>
    </div>
    <div class="panel-body">
			<div class="form-group">
				<div class="col-sm-12 text-right ext3">
					<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
    <div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center">
					No
				</th>
				<th class="text-center">
					Estudiante
				</th>
				<th class="text-center">
					Area
				</th>
				<th class="text-center">
					Bloque
				</th>
				<th class="text-center">
				Agregar Evaluación
				</th>
				<th class="text-center">
				Editar Evaluación
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $cont = 1; foreach ($estudiante as $value): ?>
				<tr>
					<td>
						<?php echo $cont; $cont++; ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['apellidos_estudiante'].', '.$value['nombre_estudiante']) ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['nombre_area']) ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['nombre_bloque']) ?>
					</td>
					<td class="text-center">
						<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_area'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="notaExamen btn btn-success" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">Nuevo</button>
					</td>
					<td class="text-center">
						<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_area'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="notaExamen btn btn-warning" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">Editar</button>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
	</div>
	</div>
	</div>
	</div>

	<div class="ventana-modal">
			<div class="col-sm-12">
				<div action="" class="form-horizontal" role="form" id="form">
					<div class="panel panel-primary">
				    <div class="panel-heading">
				        <h3 class="panel-title">EVALUACIÓN BLOQUE</h3>
				    </div>
				    <div class="panel-body">
							<div class="form-group">
				  			<div class="col-sm-12 text-right ext3">
				  				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi" style="width: 110px; height: 110px;">
				  			</div>
				  		</div>
					<div id="acreditaciones">

					</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button class="btn btn-success" id="guardarExamen">Guardar</button>
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button class="btn btn-danger" id="cancelarExamen">Cancelar</button>
					</div>

				</div>
				</div>
				</div>
			</div>

	</div>
	</div>

</div>
