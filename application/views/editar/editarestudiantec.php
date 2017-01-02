<h1 class="text-center">Editar Estudiante</h1>
<h2 class="text-center">Diversificado</h2>
<p class="text-info">Todos los campos con (*) son obligatorios</p>
<?php echo form_open('', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">SELECCIONAR NOMINA</h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
      		<?php echo form_label('Carrera*', 'carrera', array('class'=>'col-sm-2 control-label')); ?>
      		<div class="col-sm-10">
      			<select name="carrera" id="carreraEditEst" class="form-control" required="required">
      				<option value="">&lt;seleccione&gt;</option>
      				<?php
      					foreach($carrera as $value):
      				 ?>
      					<option value="<?php echo $value['id_carrera']; ?>"><?php echo mb_strtoupper($value['nombre_carrera']); ?></option>
      				<?php
      					endforeach;
      				 ?>
      			</select>
      		</div>
      	</div>
        <div class="form-group">
      		<?php echo form_label('Grado*', 'grado', array('class'=>'col-sm-2 control-label')); ?>
      		<div class="col-sm-10">
      			<select name="grado" id="gradoEditEstC" class="form-control" required="required">
      				<option value="">&lt;seleccione&gt;</option>
      			</select>
      		</div>
      	</div>

        <div class="form-group" style="display:none" id="tabla">
      		<div class="col-sm-12">
      			<table class="table table-hover table-bordered" >
      				<thead>
      					<tr>
      						<th class="text-center">No</th>
      						<th class="text-center">Estudiante</th>
      						<th class="text-center">Editar</th>
      					</tr>
      				</thead>
      				<tbody id="nominaEst">

      				</tbody>
      			</table>
      		</div>
      	</div>
</div>
</div>
<?php echo form_close(); ?>
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


<!-- Modal -->
<div class="modal fade" id="frm-editEst" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">EDITAR DATOS ESTUDIANTE</h4>
      </div>
      <div class="modal-body">
        <!-- Contenido del cuerpo de la ventana modal -->
        <!-- ######################################## -->

        <form class="form-horizontal" action="" method="put">
          <p class="text-info">
            Nota: todos los campos con (*) son obligatorios.
          </p>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">Nombres*</label>
          <div class="col-sm-10">
              <?php echo form_input('nombres', '', array('class'=>'form-control', 'required')); ?>
          </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Apellidos*</label>
            <div class="col-sm-10">
                <?php echo form_input('apellidos', '', array('class'=>'form-control', 'required')); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Código</label>
            <div class="col-sm-10">
                <?php echo form_input('codigo', '', array('class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">CUI Estudiante</label>
            <div class="col-sm-10">
                <?php echo form_input('CUI', '', array('class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Fecha Nacimiento*</label>
            <div class="col-sm-10">
                <?php echo form_input('fecha_nacimiento', '', array('class'=>'form-control datepicker', 'required')); ?>
            </div>
        </div>

        <div class="form-group">
          <label for="genero" class="col-sm-2 control-label">Genero*</label>
          <div class="col-sm-offset-2 col-sm-10">

              <label for="geneo">
                <input type="radio" name="genero" required="required" value="1" id="Masculino"> Masculino
              </label>
              <label for="geneo">
                <input type="radio" name="genero" required="required" value="2" id="Femenino"> Femenino
              </label>
          </div>
        </div>
        <div id="idEst">

        </div>
        </form>
        <!-- Fin del Contenido del cuerpo de la ventana modal -->
        <!-- ######################################## -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="save-editEst"> Guardar Cambios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal -->
</div>
