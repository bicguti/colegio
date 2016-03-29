<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">RESULTADOS DE LA CARGA DEL ARCHIVO</h3>
    </div>
    <div class="panel-body">
<div class="col-sm-12">
	<h1 class="text-center text-success">Registro de Resultados</h1>
</div>
<div class="col-sm-12">
	<?php foreach ($msg as $key => $value): ?>
		<p><?php echo ($key+1).') '.$value['msg'] ?></p>
	<?php endforeach ?>
</div>
</div>
</div>