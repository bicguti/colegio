<h1 class="text-center">Envio de Correos</h1>
<?php echo form_open('correos/enviar', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">ENVIAR CORREOS A DOCENTES</h3>
    </div>
    <div class="panel-body">

      <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">DESTINATARIO(S)</h3>
        </div>
        <div class="panel-body">
        <p>
          Nota: Seleccione un docente o elija a todos para enviarle una notificación a su correo.
        </p>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <label for="todos"><input type="checkbox" name="todos" value="1" id="all-dest"> Enviar a Todos los docentes</label>
        </div>
      </div>
  <div class="cols-m-12" id="busqueda-destinatario">

    <div class="form-group">
      <label for="" class="col-sm-2 control-label">Buscar Destinatario:</label>
      <div class="col-sm-10">
          <?php echo form_input(array('name'=>'buscar', 'class'=>'form-control', 'id'=>'busqueda', 'placeholder'=>'Iniciales apellidos docente a buscar')); ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-10 col-sm-2">
        <button type="button" name="butto" id="btn-destinatario" class="btn btn-default"><span class="icon-search"></span>  Buscar</button>
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-sm-2 control-label">Resultados Busqueda</label>
      <div class="col-sm-10">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>
                Nombres
              </th>
              <th>
                PUESTO
              </th>
              <th>
                SELECCIONAR
              </th>
            </tr>
          </thead>
          <tbody id="coincidencias">

          </tbody>
        </table>
      </div>
    </div>

    <div class="form-group">
      <label for="" class="col-sm-2 control-label">Destinatario(s)*</label>
      <div class="col-sm-10">
        <div id="destinatarios">

        </div>
        <?php echo form_error('correos[]'); ?>
      </div>


    </div>


  </div>

</div>
</div>

  <div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EL CONTENIDO DEL MENSAJE</h3>
    </div>
    <div class="panel-body">
    <p>
      Nota: Todos los campos con (*) son obligatios.
    </p>

  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Asunto*</label>
    <div class="col-sm-10">
      <?php echo form_input(array('name'=>'asunto', 'class'=>'form-control', 'placeholder'=>'El asunto del mensaje', 'value'=>set_value('asunto'))); ?>
        <?php echo form_error('asunto'); ?>
    </div>
  </div>

  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Mensaje*</label>
    <div class="col-sm-10">
      <?php echo form_textarea(array('name'=>'mensaje', 'class'=>'form-control', 'placeholder'=>'El contenido del mensaje', 'value'=>set_value('mensaje'))); ?>
      <?php echo form_error('mensaje'); ?>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-10 col-sm-2">
      <button type="submit" name="button" class="btn btn-primary">Enviar Correo</button>
    </div>
  </div>

</div>
</div>

</div>
</div>
<?php echo form_close(); ?>
