<h1 class="text-center">Calendario de Entrega de Cuadros</h1>
<?php echo form_open('calendariocuadros/editar_calendarios', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
  <div class="panel-heading">
      <h3 class="panel-title">CALENDARIO DE ENTREGAS CICLO <?php echo date('Y') ?></h3>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>NIVEL</th>
                <th>TIPO AREA</th>
                <th>EDITAR</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Pre-Primaria y Primaria</td>
                <td>Áreas Complementarias</td>
                <td class="text-center"><button name="calendario" class="btn btn-primary" value="1">EDITAR</button></td>
              </tr>
              <tr>
                <td>Pre-Primaria y Primaria</td>
                <td>Áreas Principales</td>
                <td class="text-center"><button name="calendario" class="btn btn-primary" value="2">EDITAR</button></td>
              </tr>
              <tr>
                <td>Básico y Diversificado</td>
                <td>Todas las áreas</td>
                <td class="text-center"><button name="calendario" class="btn btn-primary" value="3">EDITAR</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
</div>
<?php echo form_close(); ?>
