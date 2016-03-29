<h2 class="text-center">Fechas Disponibilidad de Bloques</h2>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<form action="<?=site_url()?>/fechadisponible/nueva_fechadisponible" method="POST" class="form-horizontal" role="form">
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">ESTABLECER FECHAS CALENDARIO</h3>
    </div>
    <div class="panel-body">
	<div class="form-group">
		<div class="col-sm-12">
		<div class="table-responsive">
		<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Bloque*</th>
				<th>Fecha Inicio*</th>
				<th>Fecha Fin*</th>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
			</tr>
		</thead>
			<tbody>

				<?php $cont=1; foreach ($fechaDisponible as $value): ?>
					<tr>
						<?php if ($cont == 1): ?>
							<td class="text-info">BLOQUE I</td>	
						<?php endif; ?>
						<?php if ($cont == 2): ?>
							<td class="text-info">BLOQUE II</td>	
						<?php endif ?>
						<?php if ($cont == 3): ?>
							<td class="text-info">BLOQUE III</td>	
						<?php endif ?>
						<?php if ($cont == 4): ?>
							<td class="text-info">BLOQUE IV</td>	
						<?php endif ?>
						<?php if ($cont == 5): ?>
							<td class="text-info">BLOQUE V</td>	
						<?php endif ?>
						<td> <input type="text" class="form-control datepicker" name="fechainicio[]" required="required" placeholder="Fecha de Inicio" value="<?php echo $value['fecha_inicio'] ?>"> </td>
						<td> <input type="text" class="form-control datepicker" name="fechafin[]" required="required" placeholder="Fecha de Inicio" value="<?php echo $value['fecha_final'] ?>"> </td>
					</tr>
					<?php $cont++; ?>
				<?php endforeach ?>
			</tbody>
		</table>
		</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			 <?php echo validation_errors(); ?>
		</div>	
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-default" type="submit">Guardar</button>
		</div>
	</div>
</div>
</div>
</form>