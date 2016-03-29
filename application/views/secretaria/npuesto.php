<h2 class="text-center">Nuevo Puesto</h2>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=base_url()?>index.php/puesto/nuevo_puesto" method="POST" class="form-horizontal" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS DEL NUEVO PUESTO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="nombre" class="col-sm-2 control-label">Nombre*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nombre" required="required" maxlength="15" placeholder="Nombre del nuevo puesto" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<p class="text-danger"><?php echo validation_errors(); ?></p>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default" type="submit">Guardar</button>
		</div>
	</div>
</div>
</div>
</form>