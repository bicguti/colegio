<h1 class="text-center">Editar Cuadros</h1>
<h2 class="text-center">Ciclo Académico Actual</h2>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR NOTAS</h3>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="datatable">
          <thead>
            <tr>
              <th>
                NO
              </th>
              <th>
                ESTUDIANTE
              </th>
              <th>
                TOTAL
              </th>
              <th>
                HABITOS Y ORDEN
              </th>
              <th>
                PUNTUALIDAD Y ASISTENCIA
              </th>
              <th>
                EVALUACION
              </th>
              <th class="hidden">
                CUADRO
              </th>
              <th class="hidden">
                NIVEL
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($datos as $key => $row): ?>
              <tr>
                <td>
                  <?php echo $key+1 ?>
                </td>
                <td>
                  <?php echo mb_strtoupper($row['apellidos_estudiante'].', '.$row['nombre_estudiante']) ?>
                </td>
                <td>
                  <?php echo $row['total_bloque'] ?>
                </td>
                <td>
                  <?php echo $row['habitos_orden'] ?>
                </td>
                <td>
                  <?php echo $row['punt_asist'] ?>
                </td>
                <td class="miEvaluacion" data-cuadro = "<?php echo $row['id_cuadros'] ?>" data-nivel="<?php echo $nivel ?>">
                <?php echo $row['evaluacion_bloque'] ?>
                </td>
                <td class="hidden">
                  <?php echo $row['id_cuadros'] ?>
                </td>
                <td class="hidden">
                  <?php echo $nivel ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
</div>



  <div class="ventana-modal">
  	<div class="col-sm-12">
  		<div action="" class="form-horizontal" role="form" id="form" style="background-color:transparent">

  			<div class="form-group">
  				<div class="col-sm-offset-4 col-sm-8">
  					<h1 style="color:#fff">Cargando...</h1>

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




  <!-- Modal -->
  <div class="modal fade" id="modalPuntos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">  &times;   </button>
      <h4 class="modal-title" id="myModalLabel">  Modificar Notas Estudiante    </h4>
    </div>
    <div class="modal-body">
      Add some text here
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" id="editarCuadros">Guardar Cambios</button>
    </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal -->
  </div>
