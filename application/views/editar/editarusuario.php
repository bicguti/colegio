<h1 class="text-center">Editar Permisos Usuarios</h1>
<p class="text-warning">Adveterncia: Este es el modulo para agregar nuevos permisos a un usuario o deshabilitar/habilitar los que tiene asignados.</p>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<?php if ($bandera == false): ?>


<?php echo form_open('', array('class'=>'form-horizontal', 'role'=>'form')); ?>
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">BUSCAR PERSONA</h3>
    </div>
    <div class="panel-body">
			<div class="col-sm-12 text-right">
				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
			</div>
		<div class="form-group">
			<?php echo form_label('Persona*', 'persona', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-8">
				<?php echo form_input(array('name'=>'persona', 'class'=>'form-control', 'maxlength'=>'3', 'autocomplete'=>'off', 'placeholder'=>'Iniciales apellido persona', 'id'=>'busca-persona')); ?>
			</div>
			<div class="co-sm-2">
				<button class="btn btn-primary" id="btn-buscar"><span class='icon-search'></span> Buscar</button>
			</div>
		</div>

    </div>
    </div>
<?php echo form_close(); ?>

<?php echo form_open('usuario/permisos_usuario', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">COINCIDENCIAS DE BUSQUEDA</h3>
    </div>
    <div class="panel-body">

	<div class="table-responsive">
	<div class="form-group">
		<div class="col-sm-offset-2 co-sm-10">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>NOMBRES</th>
						<th>APELLIDOS</th>
						<th>PUESTO</th>
						<th>SELECCIONAR*</th>
					</tr>
				</thead>
				<tbody id="cuerpoTabla">

				</tbody>
			</table>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm--offset-2 col-sm-10 text-danger">
			<?php echo validation_errors() ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button class="btn btn-primary">Seleccionar</button>
		</div>
	</div>
	</div>
</div>
</div>
<?php echo form_close(); ?>
<?php else: ?>
	<?php echo form_open('', array('class'=>'form-horizontal', 'role'=>'form')); ?>
		<?php
			$persona = ucwords($permisos[0]['nombre_persona'].' '.$permisos[0]['apellidos_persona']);
			$usuario = $permisos[0]['id_usuario'];
		 ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">PERMISOS ASIGNADOS</h3>
    </div>
    <div class="panel-body">
			<div class="col-sm-12 text-right">
				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
			</div>

		<div class="form-group">
			<?php echo form_label('Persona', 'persona', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-offset-2 col-sm-10">
				<p><b><?php echo $persona ?></b></p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-success agregar-permiso">AGREGAR PERMISOS</button>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Permisos', 'permisos', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th class="text-center">OPCION</th>
							<th class="text-center">PERMISO</th>
							<th class="text-center">ESTADO</th>
						</tr>
					</thead>
					<tbody id="contenido">
						<?php foreach ($permisos as $key => $value): ?>
							<tr>
								<td><?php echo mb_strtoupper($value['nombre_opcion']) ?></td>
								<td><?php echo mb_strtoupper($value['nombre_sub_opcion']) ?></td>
									<?php if ($value['estado_sub_permiso'] == true): ?>
										<td class="text-center"> <button class="btn btn-warning quitar-permiso" value="<?php echo $value['id_subpermisos_usuario'] ?>" id="<?php echo 'texto'.$value['id_subpermisos_usuario'] ?>" >DESACTIVAR</button> </td>
									<?php else: ?>
										<td class="text-center"> <button class="btn btn-warning quitar-permiso" value="<?php echo $value['id_subpermisos_usuario'] ?>" id="<?php echo 'texto'.$value['id_subpermisos_usuario'] ?>" >ACTIVAR</button> </td>
									<?php endif ?>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>

</div>
</div>
	<?php echo form_close(); ?>
<?php endif ?>
<div class="ventana-modal" id="miFormulario" style="display: none">

	<div action="" class="form-horizontal" role="form" id="form">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		        <h3 class="panel-title">ASIGNAR MÁS PERMISOS</h3>
		    </div>
		    <div class="panel-body">
		<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
		<div class="form-group">
			<label for="opcion" class="control-label col-sm-2">Opcion*</label>
			<div class="col-sm-10">
				<select name="opcion" id="addOpcion" class="form-control">
					<option value="">&lt;seleccione&gt;</option>
					<?php if (isset($opcion)): ?>
					<?php foreach ($opcion as $value): ?>
						<option value="<?php echo $value['id_opcion'] ?>"><?php echo mb_strtoupper($value['nombre_opcion']) ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="subopcion" class="control-label col-sm-2">Permiso*</label>
			<div class="col-sm-10">
				<select name="subopcion" id="addSubOp" class="form-control">
					<option value="">&lt;seleccione&gt;</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary" id="addPermiso" value="<?php echo $usuario ?>">Agregar Permiso</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-danger" id="addCancelar">Cancelar</button>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="ventana-modal" id="cargando">
	<div class="col-sm-12">
		<div action="" class="form-horizontal" role="form" id="form" style="background-color:transparent">

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<h1 style="color:#18bc9c">Cargando...</h1>

					<div align="center" class="cssload-fond">
						<div class="cssload-container-general">
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_1"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_2"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_3"> </div></div>
							<div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_4"> </div></div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>
