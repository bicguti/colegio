<h1 class="text-center">Generacion de Cuadros De Bloque</h1>
<p class="text-info">Nota: En esta area se encuentra la generación de reportes en formato PDF, que posteriormente
podra imprimir,tenga en cuenta que unicamente podra generar el cuadro del bloque actual.</p>
<p class="text-success">Para generar un reporte en PDF, seleccione una o varias para poder ser generadas.</p>
<?php echo form_open('reportesdocentes/crear_cuadros', array('class'=>'form-horizontal', 'role'=>'form', 'target'=>'_blank')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">GENERACIÓN DE CUADROS DE BLOQUE POR ÁREA ASIGNADA</h3>
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
 				<th>
 					Nivel
 				</th>
 				<th>
 					Grado
 				</th>
 				<th>
 					Carrera
 				</th>
 				<th>
 					Area
 				</th>
 				<th>Seleccionar</th>
 			</tr>
 		</thead>
 		<tbody>

				<?php foreach ($areas as $value): ?>
					<tr>
						<td>
							<?php echo  mb_strtoupper($value['nombre_nivel'],'utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper($value['nombre_grado'],'utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper('ninguno','utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper($value['nombre_area'],'utf-8') ?>
						</td>
						<td>
							<input type="checkbox" name="area[]" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_area'] ?>">
						</td>
					</tr>
				<?php endforeach ?>

				<?php foreach ($areasD as $value): ?>
					<tr>
						<td>
							<?php echo mb_strtoupper($value['nombre_nivel'],'utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper($value['nombre_grado'],'utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper($value['nombre_carrera'],'utf-8') ?>
						</td>
						<td>
							<?php echo mb_strtoupper($value['nombre_area'],'utf-8') ?>
						</td>
						<td>
							<input type="checkbox" name="area[]" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_areac'] ?>">
						</td>
					</tr>
				<?php endforeach ?>

 			</tbody>
 	</table>
 	</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>
  <div class="form-group">
    <div class="col-sm-12 text-right">
      <button class="btn btn-danger" name="tipo" value="v">Visualizar PDF <span class="icon-file-pdf"></span></button>
    </div>
  </div>
  <div class="form-group">
		<div class="col-sm-12 text-right">
			<button class="btn btn-danger" name="tipo" value="d">Descargar PDF <span class="icon-file-pdf"></span></button>
		</div>
	</div>

</div>
</div>
<?php echo form_close(); ?>
