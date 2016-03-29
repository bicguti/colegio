<h2 class="text-center">Listado Areas</h2>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ÁREAS REGISTRADAS EN EL SISTEMA</h3>
    </div>
    <div class="panel-body">
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre Area</th>
				<th>Estado Area</th>
				<th>Tipo Area</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($area as $value):
			 ?>
				<tr>
					<td> <?php echo ucwords($value['id_area']); ?> </td>
					<td> <?php echo ucwords($value['nombre_area']); ?> </td>
					<td> <?php echo ucwords($value['estado_area']); ?> </td>
					<td> <?php echo ucwords($value['nombre_tipo_area']); ?> </td>
				</tr>
			<?php 
				endforeach;
			 ?>
		</tbody>
	</table>
</div>
</div>
</div>