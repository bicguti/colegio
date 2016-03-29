<h1 class="text-center">Eliminar un Puesto</h1>
<p class="text-danger">Advertencia: La eliminación es unicamente de manera lógica, esto es solo para que no pueda
ser usado en alguna operación. Cuando se desee puede ser nuevamente habilitado o deshabilitado segun sea el caso.</p>
<p class="text-info">Nota: Todos los campos con (*) son obligatorios.</p>

<?php echo form_open('puesto/guardar_estado_puesto', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">DESHABILITAR/HABILITAR PUESTO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Puesto*', 'puesto', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="puesto" id="eliminarPuesto" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($puesto as $value): ?>
					<option value="<?php echo $value['id_puesto'] ?>"> <?php echo mb_strtoupper($value['nombre_puesto']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo form_label('Estado Puesto*', 'estadopuesto', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
		<label for="estado"> <input type="checkbox" name="estadopuesto" id="estadopuesto"> <label for=""  id="labelEstado">Indefinido</label></label>	
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 text-danger">
			<?php echo validation_errors(); ?>
		</div>
	</div>	

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default">Cambiar Estado</button>
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