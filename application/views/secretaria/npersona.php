<h2 class="text-center">Nuevo Registro de Personal</h2>
<p>Nota: Los datos con (*) son obligatorios</p>
<form method="POST" action="<?=base_url()?>index.php/persona/nueva_persona"class="form-horizontal" role="form">
<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">DATOS PERSONA</h3>
            </div>
            <div class="panel-body">
            <div class="form-group">
					<div class="col-sm-12 text-right">
						<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
					</div>
				</div>
	<div class="form-group">
		<label for="nombres" class="col-sm-2 control-label">Nombres*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control letras" name="nombres" placeholder="Ingrese nombres" required="required" autocomplete="off">
		</div>
	</div>
	<div class="form-group">
		<label for="apellidos" class="col-sm-2 control-label">Apellidos*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control letras" name="apellidos" placeholder="Ingrese apellidos" required="required" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group">
		<label for="deptoresidencia" class="col-sm-2 control-label">Depto. Residencia*</label>
		<div class="col-sm-10">
			<select name="deptoresidencia" id="deptoresi" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
				foreach($depto as $value): 
				?>
					<option value="<?php echo $value['id_depto']?>"><?php echo ucwords($value['nombre_depto']); ?></option>
				<?php
				endforeach;
				?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="muniresidencia" class="col-sm-2 control-label">Muni. Residencia*</label>
		<div class="col-sm-10">
			<select name="muniresidencia" id="muniresi" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="direccion" class="col-sm-2 control-label">Dirección*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="direccion" placeholder="Dirección actual" required="required" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="nacionalidad" class="col-sm-2 control-label">Nacionalidad*</label>
		<div class="radio col-sm-offset-2 col-sm-10">
			<?php 
				foreach($nacionalidad as $value):
			?>
			<label for="nacionalidad">
				<input type="radio" name="nacionalidad" required="required" value="<?php echo $value['id_nacionalidad']; ?>"><?php echo ucfirst($value['nombre_nacionalida']); ?>
			</label>
		<?php
		endforeach;
			 ?>
		</div>
	</div>

	<div class="form-group">
		<label for="deptonaci" class="col-sm-2 control-label">Depto. Nacimiento*</label>
		<div class="col-sm-10">
			<select name="deptonaci" id="deptonaci" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($depto as $value):
				 ?>
					<option value="<?php echo $value['id_depto']; ?>"><?php echo ucwords($value['nombre_depto']); ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="muninaci" class="col-sm-2 control-label">Muni. Nacimiento*</label>
		<div class="col-sm-10">
			<select name="muninaci" id="muninaci" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="fechanaci" class="col-sm-2 control-label">Fecha Nacimiento*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control datepicker" placeholder="Elija fecha de nacimiento" name="fechanaci" required="required" autocomplete="off">
		</div>	
	</div>
	
	<div class="form-group">
		<label for="genero" class="col-sm-2 control-label">Genero*</label>
		<div class="radio col-sm-offset-2 col-sm-10">
			<?php 
				foreach($genero as $value):
			 ?>
			<label for="Genero">
				<input type="radio" required="required" name="genero" value="<?php echo $value['id_genero']; ?>"><?php echo ucfirst($value['nombre_genero']); ?>
			</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>

	<div class="form-group">
		<label for="lateralidad" class="col-sm-2 control-label">Lateralidad*</label>
		<div class="radio col-sm-offset-2 col-sm-10">
			<?php 
				foreach($lateralidad as $value):
			 ?>
			<label for="lateralidad">
				<input type="radio" required="required" name="lateralidad" value="<?php echo $value['id_lateralidad']; ?>"><?php echo ucfirst($value['nombre_lateralidad']); ?>
			</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>
	
	<div class="form-group">
		<label for="estadocivil" class="col-sm-2 control-label">Estado Civil*</label>
		<div class="radio col-sm-offset-2 col-sm-10">
			<?php 
				foreach($estadocivil as $value):
			 ?>
			<label for="estadocivil">
				<input type="radio" name="estadocivil" required="required" value="<?php echo $value['id_estado_civil']; ?>"><?php echo ucfirst($value['nom_estado_civil']); ?>
			</label>
			<?php 
				endforeach;
			 ?>
		</div>
	</div>

	<div class="form-group">
		<label for="dpi" class="col-sm-2 control-label">CUI/DPI*</label>
		<div class="col-sm-10">
			<input type="text" name="dpi" placeholder="Su numero de DPI" required="required" class="form-control" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="tel1" class="col-sm-2 control-label">No. Telefono*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="tel1" placeholder="Su numero principal" required="required" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="tel2" class="col-sm-2 control-label">No. Telefono Emergencias</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="tel2" placeholder="Numero secundario para emergencias" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="nit" class="col-sm-2 control-label">No. Nit</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nit" placeholder="Su numero de nit" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label for="correo" class="col-sm-2 control-label">Email*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="correo" placeholder="Su correo electronico" required="required" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group">
		<label for="fechainicio" class="col-sm-2 control-label">Fecha de Incio*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control datepicker" placeholder="seleccione" name="fechainicio" reuqired="required" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group">
		<label for="puesto" class="col-sm-2 control-label">Puesto que Ocupa*</label>
		<div class="col-sm-10">
			<select name="puesto" id="" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($puesto as $value):
				 ?>
					<option value="<?php echo $value['id_puesto']; ?>"><?php echo ucwords($value['nombre_puesto']) ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="titulo" class="col-sm-2 control-label">Titulo Actual*</label>
		<div class="col-sm-10">
			<select name="titulo" id="" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php 
					foreach($titulo as $value):
				 ?>
				 <option value="<?php echo $value['id_titulo']; ?>"><?php echo ucwords($value['nombre_titulo']); ?></option>
				<?php 
					endforeach;
				 ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="institucion" class="col-sm-2 control-label">Institucion*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control letras" name="institucion" required="required" placeholder="Institución donde obtuvo el titulo" autocomplete="off">
		</div>
	</div>
	<div class="form-group">
		<p class="text-danger">
		<?php 
			echo validation_errors();
		 ?>
		 </p>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-save-file">Guardar </button>
		</div>
	</div>
	 </div>
          </div>
</form>
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