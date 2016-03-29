<h1 class="text-center">Observaciones Docente</h1>

<?php if ($bandera == false): ?>
  <p class="text-danger">Upss!!! Lo siento, pero no tienes los permisos para poder utilizar este modulo. Necesitas ser docente titular de un grado de primaria, sí esto
  es un error por favor comunicate con secretaría.</p>
<?php else: ?>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
  <div class="panel-heading">
      <h3 class="panel-title">NOMINA DE ESTUDIANTES</h3>
  </div>
  <div class="panel-body">
  <div class="form-group">
    <div class="col-sm-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Estudiante</th>
            <th>Observación</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($estudiantes as $key => $value): ?>
            <tr>
              <td><?php echo $key+1 ?></td>
              <td><?php echo ucwords($value['apellidos_estudiante'].', '.$value['nombre_estudiante']) ?></td>
              <td><button class="btn btn-success" value="<?php echo $value['id_estudiante'] ?>">Agregar</button></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
<?php echo form_close(); ?>

<?php endif; ?>
<div class="ventana-modal" id="cargando">
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
