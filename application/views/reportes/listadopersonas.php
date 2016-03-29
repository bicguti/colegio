<h2 class="text-center">Listado de Personal</h2>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">NOMINA DE PERSONAL</h3>
    </div>
    <div class="panel-body">
<form action="<?=site_url()?>/persona/exportar_pdf" class="form-horizontal" target="_blank">
<div class="form-group">
	<div class="col-sm-12 text-center">
 		<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
	</div>
</div>
<div class="form-group">	
	<div class="col-sm-offset-10 col-sm-2" style="padding-bottom: 1em;">
		<button class="btn btn-danger"><span class="icon-file-pdf"></span> Exportar PDF</button>
	</div>
</div>

<div class="form-group">
<div class="table-responsive">
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>NOMBRES</th>
			<th>APELLIDOS</th>
			<th>DPI</th>
			<th>FECHA DE INICIO</th>
			<th>PUESTO</th>
			<th>TELEFONO</th>
			<th>NIT</th>
			<th>CORREO</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($persona as $value): ?>
			<tr>
				<td><?php echo ucwords($value['nombre_persona']) ?></td>
				<td><?php echo ucwords($value['apellidos_persona']) ?></td>
				<td><?php echo $value['cui_dpi_persona'] ?></td>
				<td><?php echo $value['fecha_inicio']?></td>
				<td><?php echo ucwords($value['nombre_puesto']) ?></td>
				<td><?php echo $value['no_telefono'] ?></td>
				<td><?php echo $value['nit_persona'] ?></td>
				<td><?php echo $value['correo_electr_persona'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
</div>
</div>
</form>

</div>
</div>
