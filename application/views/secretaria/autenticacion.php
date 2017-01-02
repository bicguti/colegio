<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?=base_url()?>css/paper-bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url()?>css/iconos.css">
	<link rel="apple-touch-icon" sizes="60x60" href="<?=base_url()?>/img/favicon-colegio/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>/img/favicon-colegio/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>/img/favicon-colegio/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>/img/favicon-colegio/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>/img/favicon-colegio/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>/img/favicon-colegio/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>/img/favicon-colegio/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>/img/favicon-colegio/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?=base_url()?>/img/favicon-colegio/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>/img/favicon-colegio/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?=base_url()?>/img/favicon-colegio/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/img/favicon-colegio/favicon-16x16.png">
	<link rel="manifest" href="<?=base_url()?>/img/favicon-colegio/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?=base_url()?>/img/favicon-colegio/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<style type="text/css">
		body{
			background-color: #EEEEEE;
		}
		.panel-primary>.panel-heading{
			background-color: #009688;

		}
		.icon-user, .icon-key{
			font-size: 20px;
			color: #009688;
		}
		.btn-default{
	background-color: #009688;
	color: #EEEEEE;
}
		textarea:focus, textarea.form-control:focus, input.form-control:focus, input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=number]:focus, [type=text].form-control:focus, [type=password].form-control:focus, [type=email].form-control:focus, [type=tel].form-control:focus, [contenteditable].form-control:focus{
			webkit-box-shadow: inset 0 -2px 0 #009688;
    box-shadow: inset 0 -2px 0 #009688;
		}
		.contenedor{
			max-width: 420px;
			margin: auto;
			padding-top: 5%;
		}
		img{
			max-width: 130px;
			max-height: 130px;
		}
		.ext3 img:hover{
			-webkit-transform: rotate(-14deg);
-moz-transform: rotate(-14deg);
-ms-transform: rotate(-14deg);
transform: rotate(-14deg);
		}
	</style>
	<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/
html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/
respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="contenedor">
<div class="container-fluid">
	<div class="row">

		<div class="col-sm-12">
			<?php echo form_open('autenticacion/autenticar_usuario', array('class'=>'form-horizontal', 'role'=>'form')); ?>
				<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">AUTENTICACIÓN DE USUARIO</h3>
            </div>
            <div class="panel-body">
            <div class="form-group">
					<div class="col-sm-12 text-center ext3">
						<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
					</div>
				</div>
              <div class="form-group">
					<div class="col-sm-12">
							<div class="input-group">
							<span class="input-group-addon icon-user"></span>

						<?php echo form_input(array('name'=>'usuario', 'value'=>set_value('usuario'), 'required'=>'required', 'placeholder'=>'Nombre de usuario', 'class'=>'form-control')); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<div class="input-group">
							<span class="input-group-addon icon-key"></span>
							<?php echo form_password(array('name'=>'contrasena', 'value'=>set_value('contrasena'), 'required'=>'required', 'placeholder'=>'Contraseña', 'class'=>'form-control')); ?>
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-sm-12 text-danger">
						<?php echo validation_errors(); ?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-12 text-danger">
						<?php echo $msg; ?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-12">
						<button class="btn btn-default">Ingresar</button>
					</div>
				</div>

            </div>
          </div>

			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</div>
	<div class="col-sm-12 col-lg-12">
		<p class="text-warning">ADVERTENCIA DE COMPATIBILIDAD: Se le recomienda utilizar este sistema con los navegadores Google Chrome 48 o Posterior, Firefox 43 o posterior, para obtener el maximo rendimiento, en otros navegadores algunas funcionalidades del sistema podrian no funcionar correctamente o dejar de funcionar totalmente.</p>
	</div>
<div class="col-sm-12 col-lg-12">
	<footer class="text-center">
		<p style="color: #009688">Colegio Cristiano Pre-U Pestalozzi CopyRight&copy; 2016</p>
	</footer>
</div>
</body>
</html>
