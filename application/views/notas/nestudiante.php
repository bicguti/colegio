
<div class="col-sm-12">
	<?php if ($bandera == false): ?>
		<h1 class="text-center">Asignacion de Acreditaciones</h1>
		<p class="text-info">Nota: Todavia no tienes asignadas las acreditaciones al bloque, asigna las acreditaciones,
		de este bloque, de lo contrario no podras agregar notas.</p>
		<p class="text-success">Nota: Todos los campos con * son obligatorios.</p>
		<?php echo form_open('notas/nuevas_acreditaciones', array('class'=>'form-horizontal', 'role'=>'form')); ?>
			<div class="panel panel-primary">
		    <div class="panel-heading">
		        <h3 class="panel-title">PUNTOS DE ACREDITACIONES</h3>
		    </div>
		    <div class="panel-body">

					<div class="form-group">
	        <div class="col-sm-12 text-right ext3">
	          <img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
	        </div>
	        </div>
				<div class="form-group">
					<?php echo form_label('1*', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'uno', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', 'required'=>'required', set_value('uno'))); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label('2', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'dos', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', set_value('dos'))); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label('3', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'tres', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', set_value('tres'))); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label('4', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'cuatro', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', set_value('cuatro'))); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label('5', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'cinco', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', set_value('cinco'))); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo form_label('6', 'username', array('class'=>'col-sm-2 control-label')); ?>
					<div class="col-sm-10">
						<?php echo form_input(array('name'=>'seis', 'class'=>'form-control', 'placeholder'=>'Nombre de la Acreditación', set_value('seis'))); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo validation_errors(); ?>
					</div>
				</div>
				<div class="fom-control">
					<div class="col-sm-offset-2 col-sm-10">
						<button class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</div>
			</div>
		<?php echo form_close(); ?>
	<?php else: ?>

<h1 class="text-center">Nomina Estudiantes</h1>
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
				Agregar Nota
				</th>
				<th class="text-center">
					Edita Nota
				</th>
			</tr>
		</thead>
		<tbody>
		<!--	<?php
				$array = array();
				foreach ($estudiante as $key => $value) {
					if (isset($value['id_asignacion_area'])) {
						$temp = array('nombres'=>$value['apellidos_estudiante'].', '.$value['nombre_estudiante'],
						'nombre_area'=>$value['nombre_area'],
						'nombre_bloque'=>$value['nombre_bloque'],
						'id_bloque'=>$value['id_bloque'],
						'id_asignacion_area'=>$value['id_asignacion_area'],
						'id_estudiante'=>$value['id_estudiante'],
						'id_nivel'=>$value['id_nivel']);
					} else {
						$temp = array('nombres'=>$value['apellidos_estudiante'].', '.$value['nombre_estudiante'],
						'nombre_area'=>$value['nombre_area'],
						'nombre_bloque'=>$value['nombre_bloque'],
						'id_bloque'=>$value['id_bloque'],
						'id_asignacion_areac'=>$value['id_asignacion_areac'],
						'id_estudiante'=>$value['id_estudiante'],
						'id_nivel'=>$value['id_nivel']);
					}


					array_push($array, $temp);
				}
				sort($array);
			 ?>-->
			<?php $cont = 1;  foreach ($estudiante as $value): ?>
				<tr>
					<td>
						<?php echo $cont; $cont++; ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['apellidos_estudiante'].','.$value['nombre_estudiante']) ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['nombre_area']) ?>
					</td>
					<td>
						<?php echo mb_strtoupper($value['nombre_bloque']) ?>
					</td>
					<td class="text-center">
						<?php if (isset($value['id_asignacion_area'])): ?>
							<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_area'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="nota btn btn-success" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">NUEVO</button>
						<?php else: ?>
							<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_areac'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="nota btn btn-success" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">NUEVO</button>
						<?php endif ?>

					</td>
					<td class="text-center">
						<?php if (isset($value['id_asignacion_area'])): ?>
							<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_area'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="nota btn btn-warning" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">EDITAR</button>
						<?php else: ?>
							<button value="<?php echo $value['id_bloque'].','.$value['id_asignacion_areac'].','.$value['id_estudiante'].','.$value['id_nivel'] ?>" class="nota btn btn-warning" data-estudiante="<?php echo $value['apellidos_estudiante'].', '.$value['nombre_estudiante']; ?>">EDITAR</button>
						<?php endif ?>

					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
	</div>
	</div>
	<div class="ventana-modal">
			<div class="col-sm-12">
				<div action="" class="form-horizontal" role="form" id="form">
				<div class="panel panel-primary">
			    <div class="panel-heading">
			        <h3 class="panel-title">ACREDITAR PUNTOS</h3>
			    </div>
			    <div class="panel-body">
						<div class="form-group">
							<div class="col-sm-12 text-right ext3">
								<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi" style="width: 110px; height: 110px;">
							</div>
						</div>
					<div id="acreditaciones">

					</div>
	<!--				<div class="form-group">
						<div class="col-sm-6">
							<button type="button" name="anterior" class="btn btn-default">Anterior</button>
						</div>
						<div class="col-sm-6 text-right">
							<button type="button" name="siguiente" class="btn btn-default">Siguiente</button>
						</div>
					</div> -->
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button class="btn btn-success" id="guardarNotas">Guardar</button>
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button class="btn btn-danger" id="cancelarNotas">Cancelar</button>
					</div>

				</div>



				</div>
				</div>
			</div>

	</div>
	</div>
	<?php endif ?>
</div>
