<h1 class="text-center">Editar Nombres de las Acreditaciónes</h1>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<?php if ($bandera == false): ?>

<?php echo form_open('notas/buscar_acreditaciones', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ÁREAS ASIGNADAS</h3>
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
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>NIVEL</th>
                <th>GRADO</th>
                <th>CARRERA</th>
                <th>ÁREA</th>
                <th>EDITAR NOMBRE ACREDITACIÓN</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($areas) == 0 && count($areasD) == 0): ?>
                <tr>
                  <td class="text-danger">
                    Upps!!! Lo sentimos pero parece que aun no tienes áreas asignadas, por lo tanto no puedes utilizar este modulo.
                  </td>
                </tr>
              <?php else: ?>

              <?php foreach ($areas as $value): ?>
                  <tr>
                    <td><?php echo mb_strtoupper($value['nombre_nivel']) ?></td>
                    <td><?php echo mb_strtoupper($value['nombre_grado']) ?></td>
                    <td>NINGUNO</td>
                    <td><?php echo mb_strtoupper($value['nombre_area']) ?></td>
                    <td class="text-center"> <input type="radio" name="seleccion" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_area'] ?>"> </td>
                  </tr>
              <?php endforeach; ?>

              <?php foreach ($areasD as $value): ?>
                <tr>
                  <td><?php echo mb_strtoupper($value['nombre_nivel']) ?></td>
                  <td><?php echo mb_strtoupper($value['nombre_grado']) ?></td>
                  <td><?php echo mb_strtoupper($value['nombre_carrera']) ?></td>
                  <td><?php echo mb_strtoupper($value['nombre_area']) ?></td>
                  <td class="text-center"> <input type="radio" name="seleccion" value="<?php echo $value['nombre_nivel'].','.$value['id_asignacion_areac'] ?>"> </td>
                </tr>
              <?php endforeach; ?>

              <?php endif; ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-10 col-sm-2 text-danger">
          <?php echo validation_errors(); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-10 col-sm-2">
          <button class="btn btn-primary">Editar</button>
        </div>
      </div>
    </div>
</div>
<?php echo form_close(); ?>

<?php else: ?>
<?php echo form_open('notas/guardar_edicion_acreditacion', array('class'=>'form-horizontal', 'role'=>'form')); ?>
  <div class="panel panel-success">
      <div class="panel-heading">
          <h3 class="panel-title">EDITAR NOMBRES ACREDITACIONES</h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
        <div class="col-sm-12 text-right ext3">
          <img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
        </div>
        </div>
        <?php $valores = ''; ?>
        <?php foreach ($acredita as $key => $value): ?>
          <div class="form-group">
            <?php if ($key == 0): ?>
              <?php echo form_label('ACREDITACIÓN '.($key+1).'*', 'auno', array('class'=>'col-sm-2 control-label')); ?>
              <div class="col-sm-10">
                <?php echo form_input(array('name' => 'acred'.$key, 'class'=>'form-control', 'maxlength'=>'40', 'placeholder'=>'nombre de la acreditación', 'autocomplete'=>'off', 'value'=>$value['nombre_acreditacion'], 'required'=>'required')); ?>
              </div>
            <?php else: ?>
              <?php echo form_label('ACREDITACIÓN '.($key+1), 'auno', array('class'=>'col-sm-2 control-label')); ?>
              <div class="col-sm-10">
                <?php echo form_input(array('name' => 'acred'.$key, 'class'=>'form-control', 'maxlength'=>'40', 'placeholder'=>'nombre de la acreditación', 'autocomplete'=>'off', 'value'=>$value['nombre_acreditacion'])); ?>
              </div>
            <?php endif; ?>
          </div>
          <?php $valores .= $value['id_acreditacion'].','; ?>
        <?php endforeach; ?>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10 text-danger">
            <?php echo validation_errors(); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" name="keys" value="<?php echo $valores ?>"><span class="icon-floppy-disk"></span> Guardar</button>
          </div>
        </div>
      </div>
  </div>
<?php echo form_close(); ?>
<?php endif; ?>
