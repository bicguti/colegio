<h2 class="text-center">Nuevo Usuario</h2>
<p class="text-info">Todos los capos con (*) son obligatorios.</p>
<?php if (isset($_SESSION['usuario'])): ?>
	<form action="<?=site_url()?>/usuario/asignar_subopcion" method="POST" class="form-horizontal" role="form">
	<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">ASIGNAR PERMISOS AL USUARIO</h3>
    </div>
    <div class="panel-body">	
		<div class="form-group">
		<label for="persona" class="col-sm-2 control-label">Persona Seleccionada</label>
		<div class="col-sm-10">
			<?php
			$datos = $_SESSION['idPersona']; 
			foreach ($datos as $value): ?>
				<label for="persona"><?php echo ucwords($value['puesto'].': '.$value['nombres'].' '.$value['apellidos']) ?></label>
			<?php endforeach ?>
		</div>
	</div>

		<div class="form-group">
			<label for="opciones" class="col-sm-2 control-label">Opciones*</label>
			<div class="col-sm-10">
				<select name="opciones" id="opcionesmenu" class="form-control" required="required">
					<option value="">&lt;seleccione&gt;</option>
					<?php foreach ($opciones as $value): ?>
						<option value="<?php echo $value['id_opcion'] ?>" ><?php echo ucwords($value['nombre_opcion']) ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="subopciones" class="col-sm-2 control-label">Sub-Opciones*</label>
			<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Sub Opcion</th>
							<th>Seleccionar</th>
						</tr>
					</thead>
					<tbody id="subopciones">
						
					</tbody>
				</table>
			</div>
			</div>
		</div>
		
		<div class="form-group text-danger">
			<div class="col-sm-offset-2 col-sm-10">
				<?php echo validation_errors(); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button class="btn btn-primary" type="submit">Asignar</button>
			</div>
		</div>

	</form>

	<form action="<?=site_url()?>/usuario/cancelar_usuario" class="hotizontal" role="form">
		<div class="col-sm-offset-10 col-sm-2">
			<button class="btn btn-danger" type="submit">Cancelar</button>
		</div>

	</form>

	<?php if (isset($_SESSION['datosAsignacion'])): ?>
		<div class="col-sm-offset-2 col-sm-10">
			<h2 class="text-center">Datos de Asignacion</h2>
		</div>
		<div class="col-sm-offset-2 col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Opcion</th>
					<th>Permiso</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($_SESSION['datosAsignacion'] as $value): ?>
					<tr>
						<td>
							<?php echo $value['opcion'] ?>
						</td>
						<td>
							<?php echo $value['subopcion'] ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>	
		</div>
		</div>
	<?php endif ?>

	<form action="<?=site_url()?>/usuario/guardar_usuario_permisos" method="POST" class="form-horizontal" role="form">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-default">Guardar</button>
			</div>
		</div>
		</div>
		</div>
	</form>
<?php else: ?>

<?php if (isset($_SESSION['idPersona'])): ?>
	<?php echo form_open('usuario/nuevo_usuario', array('class'=>'form-horizontal', 'role'=>'form')); ?>
	<!-- <form action="<?=site_url()?>/usuario/nuevo_usuario" class="form-horizontal" method="POST" role="form"> -->
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS USUARIO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="persona" class="col-sm-2 control-label">Persona Seleccionada</label>
		<div class="col-sm-10">
			<?php
			$datos = $_SESSION['idPersona']; 
			foreach ($datos as $value): ?>
				<label for="persona"><?php echo ucwords($value['puesto'].': '.$value['nombres'].' '.$value['apellidos']) ?></label>
				<?php $correo = $value['email']; ?>
			<?php endforeach ?>
		</div>
	</div>
	
	<div class="form-group">
		<!-- <label for="usuario" class="col-sm-2 col-xs-12 control-label">Usuario*</label>
		<div class="col-sm-8 col-xs-10">
			<input type="text" name="usuario" class="form-control usu-pass" required="required" placeholder="Nombre de usuario" maxlength="40" autocomplete="off">
		</div> -->
		<?php echo form_label('Usuario*', 'usuario', array('class'=>'col-sm-2 col-xs-12 control-label')); ?>
		<div class="col-sm-8 col-xs-10">
		<?php echo form_input(array('type'=>'text','name'=>'usuario', 'value'=>$correo, 'disabled'=>'disabled', 'class'=>'form-control usu-pass', 'required'=>'required','placeholder'=>'Nombre de usuario', 'maxlength'=>'40','autocomplete'=>'off')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<!-- <label for="contraseña" class="col-sm-2 col-xs-12 control-label">Contraseña*</label>
		<div class="col-sm-8 col-xs-10">
			<input type="password" class="form-control usu-pass" name="contrasena" id="contra" required="required" placeholder="Contraseña" minlenght="5" maxlength="70" autocomplete="off">
		</div> -->
		<?php echo form_label('Contraseña*', 'contraseña', array('class'=>'col-sm-2 col-xs-12 control-label')); ?>
		<div class="col-sm-8 col-xs-10">
			<?php echo form_input(array('type'=>'password', 'class'=>'form-control usu-pass', 'name'=>'contrasena', 'value'=>set_value('contrasena'),'id'=>'contra', 'required'=>'required', 'placeholder'=>'Contraseña', 'maxlength'=>'70', 'autocomplete'=>'off')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<!-- <label for="contraseña" class="col-sm-2 col-xs-12  control-label">Repetir Contraseña*</label>
		<div class="col-sm-8 col-xs-10">
			<input type="password" class="form-control usu-pass" name="rcontrasena" id="repetircontra" required="required" placeholder="Repetir de nuevo la contraseña" minlenght="5" maxlength="70" autocomplete="off">
		</div> -->
		<?php echo form_label('Repetir Contraseña*', 'rcontraseña', array('class'=>'col-sm-2 col-xs-12 control-label')); ?>
		<div class="col-sm-8 col-xs-10">
			<?php echo form_input(array('type'=>'password', 'class'=>'form-control usu-pass', 'name'=>'rcontrasena', 'value'=>set_value('rcontrasena'), 'id'=>'repetircontra', 'required'=>'required', 'placeholder'=>'Repetir de nuevo la contraseña', 'maxlength'=>'70', 'autocomplete'=>'off')); ?>
		</div>
		<div class="col-sm-2">
			<span id="contravalida" style="font-size: 25px;"></span>
		</div>
	</div>
		
	<div class="fom-group text-danger">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo validation_errors(); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<!-- <button class="btn btn-primary">Listo</button> -->
			<?php echo form_submit('button', 'Listo', array('class'=>'btn btn-primary')); ?>
		</div>
	</div>
</div>
</div>
	<!-- </form>	 -->
<?php echo form_close(); ?>
<?php else: ?>
	
<form action="<?=site_url()?>/usuario/buscar_persona" class="form-horizontal" method="POST" role="form">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">BUSCAR PERSONA</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<label for="apellido" class="col-sm-2 control-label">Persona*</label>
		<div class="col-sm-8">
			<input type="text" name="apellido" class="form-control letras" placeholder="Iniciales del apellido" required="required" maxlength="3" autocomplete="off">
		</div>

		
		<div class="col-sm-2">
			<button class="btn btn-primary"><span class="icon-search"></span>Buscar</button>
		</div>
	</div>
	<div class="form-group text-danger">
			<div class="col-sm-offset-2 col-sm-10">
				<?php echo validation_errors(); ?>
			</div>
		</div>
	</div>
	</div>
	</form>	
	
	<?php if (isset($_SESSION['dPersona'])): ?>
		<form action="<?=site_url()?>/usuario/seleccionar_docente" method="POST" class="form-horizontal" role="form">
		<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">COINCIDENCIAS DE BUSQUEDA</h3>
    </div>
    <div class="panel-body">
			<label for="dpersona" class="col-sm-2 control-label">Datos Persona*</label>
			<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Puesto</th>
							<th>Seleccion</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$datos = $_SESSION['dPersona'];
						 foreach ($datos as $value): ?>
							<tr>
								<td><?php echo ucwords($value['nombres']) ?></td>
								<td><?php echo ucwords($value['apellidos']) ?></td>
								<td><?php echo ucwords($value['puesto']) ?></td>
								<td><input type="radio" name="persona" required="required" value="<?php echo $value['id'] ?>"></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				</div>
			</div>

			<div class="form-group text-danger">
				<div class="col-sm-offset-2 col-sm-10">
					<?php echo validation_errors(); ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-10 col-sm-2">
					<button class="btn btn-primary" type="submit">Seleccionar</button>
				</div>
			</div>
		</div>
		</div>
		</form>
	<?php endif ?><!-- fin del else -->

<?php endif ?><!-- fin del if secundario -->
<?php endif ?><!--Fin del if principal-->
<div class="ventana-modal">
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