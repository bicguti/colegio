<h2 class="text-center">Crear Cuadros Ciclo - <?php echo date('Y') ?></h2>
<h3 class="text-center">Primaria y Básico</h3>
<form action="<?=site_url()?>/cuadros/crear_cuadrosPB" method="POST" class="form-horizontal" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">CREAR CUADROS</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<p class="text-info">Al presionar el boton crear, se comenzara con la creación de los cuadros de los 
			cinco bloques, correspondientes a todos los estudiantes que esten registrados en el sistema y esten 
			en los niveles de Pre-Primaria, Primaria y Básico.</p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Crear</button>
		</div>
	</div>
</div>
</div>
</form>