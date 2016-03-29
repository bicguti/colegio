<h1 class="text-center">Exportar Archivo de Datos</h1>
<p class="text-warning">Advertencia: Este módulo es para subir archivos de hoja de calculo con la extencion .xlsx o .xls
no se permiten otro tipo de archivos, tenga muy en cuenta las recomendaciónes ya indicadas.</p>
<p class="text-warning">Algunos datos de los estudiantes que son obligatorios, seran llenado por defecto por el sistema, usted
debera de editar esta información después, para cada estudiante, para que la información que muestre el sistema sea veridico</p>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open_multipart('estudiante/subir_archivo', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">FORMULARIO DE CARGA</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo $error;?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="nivel" id="nivelExpoExc" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($nivel as $value): ?>
					<option value="<?php echo $value['id_nivel'] ?>"> <?php echo mb_strtoupper($value['nombre_nivel']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="form-group" id="carreraUpload" style="display:none">
		<?php echo form_label('Carrera*', 'carrera', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="carrera" id="carreraExpoExc" class="form-control">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Grado*', 'grado', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="grado" id="gradoExpoExc" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Archivo*', 'archivo', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo form_upload(array('name'=>'archivo', 'class'=>'form-control', 'required'=>'required')); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors() ?>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-primary">Subir Archivo</button>
		</div>
	</div>
 </div>
 </div>
<?php echo form_close(); ?>
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