<h1 class="text-center">Editar Cuadros</h1>
<h2 class="text-center">Ciclo Académico Actual</h2>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">SELECCIONAR GRADO</h3>
    </div>
    <div class="panel-body">
      <?php echo form_open('cuadros/notas_cuadros', $attributes = array('class'=>'form-horizontal')); ?>

      <?php
      $bloques = array('1'=>'bloque i', '2'=>'bloque ii', '3'=>'bloque iii', '4'=>'bloque iv', '5'=>'bloque v');
       ?>
        <div class="form-group">
          <?php echo form_label('Bloque*', 'bloque', array('class'=>'col-sm-2 control-label')); ?>
          <div class="col-sm-10">
            <select name="bloque" class="form-control" required="required">
              <option value="">&lt;seleccione&gt;</option>
              <?php foreach ($bloques as $key => $value): ?>
                <option value="<?php echo $key?>"> <?php echo mb_strtoupper($value) ?> </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

      <div class="form-group">
        <?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
          <select name="nivel" id="nivelEditCuadro" class="form-control" required="required">
            <option value="">&lt;seleccione&gt;</option>
            <?php foreach ($nivel as $value): ?>
              <option value="<?php echo $value['id_nivel'] ?>"> <?php echo mb_strtoupper($value['nombre_nivel']) ?> </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="form-group" id="carrera" style="display:none">
        <?php echo form_label('Carrera*', 'carrera', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
          <select name="carrera" id="carreraEditCuadro" class="form-control">
            <option value="">&lt;seleccione&gt;</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Grado*', 'grado', array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
          <select name="grado" id="gradoEditCuadro" class="form-control" required="required">
            <option value="">&lt;seleccione&gt;</option>
          </select>
        </div>
      </div>


    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10 text-danger">
        <?php echo validation_errors(); ?>
      </div>
    </div>

    <div class="form-group" id="tabla" style="display: none">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  NO
                </th>
                <th>
                  AREA
                </th>
                <th>
                  SELECCIONAR
                </th>
              </tr>
            </thead>
            <tbody id="pensumGrado">

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="button" class="btn btn-primary">Buscar Notas</button>
      </div>
    </div>

  <?php echo form_close() ?>




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
