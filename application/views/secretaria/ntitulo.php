<h1 class="text-center">Nuevo Titulo de Persona</h1>
<p class="text-warning">Advertencia: Este Formulario es para poder agregar un nuevo título,
que posee un profesional que labora dentro de la institución.</p>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>

<?php echo form_open('titulo/guardar_titulo', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS TÍTULO ACADEMICO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Nombre Título*', 'titulo', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_input(array('name'=>'nombre', 'class'=>'form-control', 'autocomplete'=>'off', 'required'=>'required', 'maxlength'=>'100', 'placeholder'=>'Nombre del Título', 'value'=>set_value('name'))); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Guardar</button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>