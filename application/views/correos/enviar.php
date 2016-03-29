<h1 class="text-center">Envio de Correos</h1>
<?php echo form_open('correos/enviar', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">NOMINA</h3>
    </div>
    <div class="panel-body">
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Destinariario</label>
    <div class="col-sm-10">
        <?php echo form_input(array('name'=>'destino', 'class'=>'form-control')); ?>
    </div>

  </div>

  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Mensaje</label>
    <div class="col-sm-10">
      <?php echo form_textarea(array('name'=>'mensaje', 'class'=>'form-control')); ?>
    </div>

  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="button" class="btn btn-primary">Enviar Email</button>
    </div>
  </div>

</div>
</div>
<?php echo form_close(); ?>
