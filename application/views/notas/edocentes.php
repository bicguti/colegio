<h1 class="text-center">Listado de Areas</h1>
<p class="text-info">Nota: En el listado de la parte inferior
se le presentan las areas y grados en los que puede agregar notas de evaluaciones del bloque actual,
 seleccione el area donde desea ingresar notas.</p>
<?php if (count($areas) == 0 && count($areasD) == 0): ?>

 						<p class="text-danger"><?php echo 'Ups!!! Lo lamento, No tienes areas asignadas aun, pide al administrador que te asigne las areas correspondientes' ?></p>


 			<?php else: ?>
 <form action="<?=site_url()?>/cuadros/buscar_estudiantes" method="POST" class="form-horizontal" role="form">
 <div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">NOTAS DE EVALUACIÓN</h3>
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
 				<th>Agregar Nota</th>
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
							<input type="radio" name="area" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_area'] ?>">
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
							<input type="radio" name="area" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_areac'] ?>">
						</td>
					</tr>
				<?php endforeach ?>

 			</tbody>
 	</table>
	</div>
 </div>
 </div>
 <div class="form-group">
 	<div class=" col-sm-offset-10 col-sm-2">
 		<button class="btn btn-primary">Asignar Notas</button>
 	</div>
 </div>
 </div>
 </div>
 </form>
  <?php endif ?>
