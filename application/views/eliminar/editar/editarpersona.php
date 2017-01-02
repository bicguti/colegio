<h1 class="text-center">Editar Mis Datos</h1>
<p class="text-info">Nota todos los campos con (*) son obligatorios.</p>
<?php echo form_open('url', array('class'=>'form-horizontal', 'role'=>'form')); ?>
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS PERSONALES</h3>
    </div>
    <div class="panel-body">
		<div class="form-group">
			<div class="col-sm-12 text-right">
				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Nombres*', 'nombres', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo form_input(array('name'=>'nombre', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Apellidos*', 'apellidos', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<?php echo form_input(array('name'=>'apellidos', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-control">
			<?php echo form_label('Depto. Residencia*', 'deptoresidencia', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<select name="" id="" class="form-control">
					<option value="">&lt;selecciones&gt;</option>
				</select>			
			</div>
		</div>
		<div class="form group">
			<?php echo form_label('Muni. Residencia*', 'muniresidencia', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				<select name="" id="" class="form-control">
					<option value="">&lt;seleccione&gt;</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Dirección*', 'direccion', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
				
			</div>
		</div>

	</div>
	</div>
<?php echo form_close(); ?>