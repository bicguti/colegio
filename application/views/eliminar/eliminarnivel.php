<h1 class="text-center">Eliminar Nivel</h1>
<p class="text-danger">Advertencia: La eliminación es unicamente lógica, solo se cambia el estado del nivel de habilitado
a deshabilitado o viceversa segun sea el caso. Esto es para que el nivel no se pueda utilizar en una operación donde
se necesite, si desea volver a utilizar un nivel, simplemente deberá habilitarlo.</p>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('nivelplan/guardar_eliminar_nivel', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">DESHABILITAR/HABILITAR NIVEL</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="nivel" id="eliminarNivel" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($nivel as $value): ?>
					<option value="<?php echo $value['id_nivel'] ?>"> <?php echo mb_strtoupper($value['nombre_nivel']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Estado', 'estado', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-offset-2 col-sm-10">
			<label for="estado"><input type="checkbox" name="estado" id="estadoNivel"><label for="nombrestado" id="nombreEstado">Indefinido</label></label>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button class="btn btn-default">Eliminar Nivel</button>
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