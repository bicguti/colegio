<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <h1 class="text-center">Tarjetas Finales</h1>
    </div>
    <div class="col-sm-12">

      <div class="panel panel-default">
      <div class="panel-heading">
        Generación de Tarjetas Finales
      </div>
      <div class="panel-body">
        <p>
          Nota: Todos los campos con (*) son requeridos.
        </p>
        <div class="text-danger">
          <?php echo validation_errors() ?>
        </div>
        <form class="form-horizontal" action="exportar_finales" method="post" target="_blank">
          <div class="form-group">
            <label for="nivel" class="col-sm-2 control-label">Nivel*</label>
            <div class="col-sm-10">
              <select class="form-control" name="nivel" id="nivelRC">
                <option value="">Seleccione nivel...</option>
                <?php foreach ($niveles as $key => $nivel): ?>
                  <option value="<?php echo $nivel['id_nivel'] ?>"><?php echo mb_strtoupper($nivel['nombre_nivel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group" id="fg-carrera" style="display: none">
            <label for="carrera" class="col-sm-2 control-label">Carrera*</label>
            <div class="col-sm-10">
              <select class="form-control" name="carrera" id="carreraRC">
                <option value="">Seleccione carrera...</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="grado" class="col-sm-2 control-label">Grado*</label>
            <div class="col-sm-10">
              <select class="form-control" name="grado" id="gradoRC">
                <option value="">Seleccione grado...</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-right">
              <button type="submit" name="button" class="btn btn-danger">Generar PDF <i class="icon-file-pdf"></i></button>
            </div>
          </div>
        </form>
      </div>
      </div>


    </div>
  </div>
</div>
