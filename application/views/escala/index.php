<div class="col-sm-12">
  <h1 class="text-center">Escala de Valores Humanos</h1>
  <?php echo form_open('escala_valores/guardar_escala', array('class'=>'form-horizontal', 'role'=>'form')); ?>
  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Abanderados y Escoltas</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>
                NO
              </th>
            </tr>
          </thead>
        </table>
        <?php echo form_input('name', 'value', $attributes = array()); ?>
    </div>
  </div>
  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Cuadro de Honor</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>
                NO
              </th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
  <?php echo form_close() ?>
</div>
