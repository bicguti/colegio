<div class="contenedor">
<h2 class="text-center">Nueva Asignación</h2>
<h3 class="text-center">Docente - Area</h3>
<p>Nota: Todas las areas con (*) son obligatorias.</p>

<?php if (!isset($iddocente) && !isset($_SESSION['IdPersona'])): ?>

	<form action="<?=site_url()?>/asignaciondocente/buscar_docente" class="form-horizontal" role="form" method="POST">
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">BUSCAR DOCENTE</h3>
    </div>
    <div class="panel-body">
		<div class="form-group">
			<label for="buscar" class="col-sm-2 control-label">Apellido*</label>
			<div class="col-sm-10">
				<input type="text" class="form-control letras" name="apellido" placeholder="Iniciales del apellido a buscar" maxlength="3" autocomplete="off" required="required">
			</div>
		</div>
		
		<div class="form-group text-danger">
			<div class="col-sm-offset-2 col-sm-10">
				<?php echo validation_errors(); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button class="btn btn-primary"><span class="icon-search"></span>Buscar</button>
			</div>
		</div>
	</div>
	</div>
	</form>
	
<?php endif ?>

<?php if (isset($ddocente)): ?>
	
	<form action="<?=site_url()?>/asignaciondocente/agregar_persona" class="form-horizontal" role="form" method="POST">
	<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">COINCIDENCIAS DE BUSQUEDA</h3>
    </div>
    <div class="panel-body">
		<div class="form-group">
			<label for="datos" class="col-sm-2 control-label">Docente*</label>
			<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Puesto</th>
							<th>Seleccionar</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($ddocente as $value): ?>
							<tr>
								<td><?php echo ucwords($value['nombre_persona']) ?></td>
								<td><?php echo ucwords($value['apellidos_persona']) ?></td>
								<td><?php echo ucwords($value['nombre_puesto']) ?></td>
								<td><input type="radio" name="persona" required="required" value="<?php echo $value['id_persona'] ?>"></td>
							</tr>
						<?php endforeach ?>
					</tbody>

				</table>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button class="btn btn-primary">Seleccionar Docente</button>
			</div>
		</div>
	</div>
	</div>
	</form>

<?php endif ?>

<?php if (isset($_SESSION['IdPersona'])): ?>
	
	<form action="<?=site_url()?>/asignaciondocente/mi_asignacion" class="form-horizontal" role="form" method="POST">
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ASIGNAR ÁREAS AL DOCENTE</h3>
    </div>
    <div class="panel-body">
		<div class="form-group">
			<label for="nivel" class="col-sm-2 control-label">Nivel*</label>
			<div class="col-sm-10">
				<select name="nivel" id="nivelasignacionD" class="form-control">
					<option value="">&lt;seleccione&gt;</option>
					<?php foreach ($nivel as $value): ?>
						<option value="<?php echo $value['id_nivel'] ?>"> <?php echo ucfirst($value['nombre_nivel']) ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		
		<div class="form-group" id="carrera">
			
		</div>

		<div class="form-group">
			<label for="grado" class="col-sm-2 control-label">Grado*</label>
			<div class="col-sm-10" id="grado">
				<p class="text-info">No disponible aun.</p>
			</div>
		</div>

		<div class="form-group">
			<label for="curso" class="col-sm-2 control-label">Areas*</label>
			<div class="col-sm-10" id="cursos">
				<p class="text-info">No disponibel aun.</p>
			</div>
		</div>
		<div class="form-group text-danger">
			<div class="col-sm-offset-2 col-sm-10">
				<?php echo validation_errors(); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button class="btn btn-primary">Asignar</button>
			</div>
		</div>
		
		<div class="form-group">
			<label for="docente" class="col-sm-2 control-label">Docente Seleccionado</label>
			<div class="col-sm-10">
				<h4><?php 
					$docente = $_SESSION['docente'];
					echo ucwords($docente[0]).' '.ucwords($docente[1]);
				 ?></h4>
			</div>
		</div>
		<div class="form-group">
			<label for="asignacion" class="col-sm-2 control-label">Asignacion:</label>
			<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Curso</th>
							<th>Grado</th>
							<th>Nivel</th>
							<th>Carrera</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(isset($_SESSION['dasignacion']))
						{
							$aux = $_SESSION['dasignacion'];	
						
						

						for ($i=0; $i < count($aux); $i++) 
						{ ?>
						  
							<tr>
								<td><?php echo ucwords($aux[$i]['area'] )?></td>
								<td><?php echo ucwords($aux[$i]['grado'] )?></td>
								<td><?php echo ucwords($aux[$i]['nivel'] )?></td>
								<td><?php echo ucwords($aux[$i]['carrera']) ?></td>
							</tr>
						<?php 

						}
						} ?>
					</tbody>
				</table>
				</div>
			</div>
		
	</form>
	
	<form action="<?=site_url()?>/asignaciondocente/cancelar_asignacion" class="form-horizontal" role="form" method="POST">
		
		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button class="btn btn-danger">Cancelar</button>
			</div>	
		</div>

	</form>

	<form action="<?=site_url()?>/asignaciondocente/nueva_asignacion" class="form-horizontal" method="POST" role="form">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-primary">Guardar</button>
		</div>
	</form>
	</div>
	</div>
<?php endif ?>
	
</div>

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