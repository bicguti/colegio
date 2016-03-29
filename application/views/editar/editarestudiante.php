<h1 class="text-center">Editar Estudiante</h1>
<p class="text-info">Todos los campos con (*) son obligatorios</p>
<?php echo form_open('', array('class'=>'form-horizontal', 'role'=>'form')); ?>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">EDITAR DATOS ESTUDIANTE</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<?php echo form_label('Nivel*', 'nivel', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="nivel" id="nivelEditEst" class="form-control" required="required">
				<option value="">&lt;seleccione&gt;</option>
				<?php foreach ($nivel as $value): ?>
					<option value="<?php echo $value['id_nivel'] ?>"> <?php echo mb_strtoupper($value['nombre_nivel']) ?> </option>
				<?php endforeach ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Grado*', 'grado', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<select name="grado" id="gradoEditEst" class="form-control">
				<option value="">&lt;seleccione&gt;</option>

			</select>
		</div>
	</div>

	<div class="form-group" style="display:none" id="tabla">
		<div class="col-sm-12">
			<table class="table table-hover table-bordered" >
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Estudiante</th>
						<th class="text-center">Editar</th>
					</tr>
				</thead>
				<tbody id="nominaEst">

				</tbody>
			</table>
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
