<h1 class="text-center">Nomina de Estudiantes</h1>
<p class="text-info">En la parte inferior podra ver la nomina de estudiantes a los que podra agregar su nota de:</p>
<p class="text-info"> -Puntualidad y Asistencia a Clases </p>
<p class="text-info"> -Hábitos de Orden y Limpieza</p>

<div class="col-sm-12">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ESTUDIANTES</h3>
    </div>
    <div class="panel-body">
    <div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Estudiante</th>
				<th class="text-center">Bloque</th>
				<th class="text-center">Agregar Nota</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($estudiantes as $key => $value): ?>
				<tr>
					<td class="text-center"><?php echo $key+1 ?></td>
					<td><?php echo mb_strtoupper($value['apellidos_estudiante'].', '.$value['nombre_estudiante']) ?></td>
					<td class="text-center"><?php echo mb_strtoupper($value['nombre_bloque']) ?></td>
					<td class="text-center"><button class="btn btn-success btn-notas" value="<?php echo $value['id_estudiante'].','.$nivel ?>" data-estudiante="<?php echo mb_strtoupper($value['apellidos_estudiante'].', '.$value['nombre_estudiante']) ?>">Nota</button></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
	</div>
	</div>
</div>

<div class="ventana-modal">
			<div class="col-sm-12">
				<div action="" class="form-horizontal" role="form" id="form">
					<div class="panel panel-primary">
				    <div class="panel-heading">
				        <h3 class="panel-title">AGREGAR ACREDITACIÓNES</h3>
				    </div>
				    <div class="panel-body">
					<div class="form-group" id="mMensaje">
						<h2 class="text-warning text-center">Cargando...</h2>
					</div>
					<div id="mCampos" style="display:none">

						<div class="form-group">
							<div class="col-sm-12">
								<h4 class="text-center">Agregar Nueva Nota</h4>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<p class="text-info">Nota: Todos los campos con (*) son obligatorios</p>
							</div>
						</div>
						<div class="form-group">
							<p><strong id="nEstudiante"></strong></p>
						</div>
						<div class="form-group">
							<label for="puntualidad" class="col-sm-8 control-label">Puntualidad y Asistencia a Clases*</label>
							<div class="col-sm-4">
								<input type="text" required="required" id="puntualidad" maxlength="2" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="habitos" class="col-sm-8 control-label">Hábitos de Orden y Limpieza*</label>
							<div class="col-sm-4">
								<input type="text" required="required" id="habitos" maxlength="2" class="form-control" transform="uppercase">
							</div>
						</div>
					<div class="form-group">
						<div class="col-sm-offset-8 col-sm-4">
							<button class="btn btn-success" id="guardarPH">Guardar</button>
						</div>

					</div>
					<div class="form-group">
						<div class="col-sm-offset-8 col-sm-4">
							<button class="btn btn-danger" id="cancelarNotas">Cancelar</button>
						</div>

					</div>
					</div>

				</div>
				</div>
				</div>

			</div>
</div>
