<h1 class="text-center">Editar Asignación Docente</h1>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('url', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS DE ASIGNACIÓN: ÁREAS - DOCENTE</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Docente*', 'docente', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-8">
			<?php echo form_input(array('name'=>'docente', 'class'=>'form-control', 'maxlength'=>'3', 'autocomplete'=>'off', 'placeholder'=>'Apellidos Docente')); ?>
		</div>
		<div class="col-sm-2">
			<button class="btn btn-primary">Buscar <span class="icon-search"></span></button>
		</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>