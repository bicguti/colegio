<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?=base_url()?>css/paper-bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url()?>css/mis_estilos.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery-ui.min.css">
	<link rel="stylesheet" href="<?=base_url()?>css/iconos.css">
	<link rel="stylesheet" href="<?=base_url()?>css/bootstrap-editable.css">

	<link rel="apple-touch-icon" sizes="57x57" href="<?=base_url()?>/img/favicon-colegio/apple-icon-57x57.png">
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

	<!-- DataTables -->
	<link rel="stylesheet" href="<?=base_url()?>css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=base_url()?>css/select.bootstrap.css">
	<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/
html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/
respond.min.js"></script>
<![endif]-->
</head>
<body>
<?php if (isset($_SESSION['nombreautenticado'])): ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
			<a href="<?=site_url()?>bienvenida" class="navbar-brand">Pestalozzi</a>
	</div>
	<div class="collapse navbar-collapse" id="example-navbar-collapse">
		<ul class="nav navbar-nav navbar-right">
		<!--	<li class="dropdown">
				<a href="#" id="tiempoConect">Tiempo Conectado: 00:00:00</a>
			</li> -->
		<!--	<?php if (isset($_SESSION['autenticado'])): ?>
			<?php
				$datos = $_SESSION['autenticado'];
				$bandera = false;
				$aux = false;
				$aux2 = false;
				$cierre = false;
				$temp = $temp2 = '';
				//$url = site_url().'/municipio';
				?>
				<?php endif ?>
					<?php $temp2 = $datos[0]['opcion'];  ?>

					<?php foreach ($datos as $value): ?>
						<?php if ($bandera == false): ?>
						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($value['opcion']) ?> <span class="caret" style="margin-top: 10px;"></span></a>
							<ul class="dropdown-menu">
						<?php  $bandera = true; ?>

						<?php  endif ?>

						<?php $temp = $value['opcion']; ?>

							<?php if ($temp != $temp2): ?>

								</ul>
						</li>

						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($value['opcion']) ?> <span class="caret" style="margin-top: 10px;"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url().'/'.$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?></a></li>

						<?php $temp2 = $temp; ?>
							<?php else: ?>
								<li><a href="<?php echo site_url().'/'.$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?></a></li>

							<?php endif ?>


					<?php endforeach ?>
						</ul>
						</li>-->

		<!--	<li <?php if($activo == 'persona'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Persona <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/persona">Nueva Persona</a></li>
					<li><a href="#">Editar Persona</a></li>
					<li><a href="#">Eliminar Persona</a></li>
					<li><a href="<?=site_url()?>/persona/listado_personas">Listado Personas</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/usuario">Nuevo Usuario</a></li>
					<li><a href="#">Editar Usuario</a></li>
					<li><a href="#">Eliminar Usuario</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/titulo">Nuevo Título Persona</a></li>
					<li><a href="<?=site_url()?>/titulo/editar_titulo">Editar Título Persona</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'puesto'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Puesto <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/puesto">Nuevo Puesto</a></li>
					<li><a href="<?=site_url()?>/puesto/editar_puesto">Editar Puesto</a></li>
					<li><a href="<?=site_url()?>/puesto/eliminar_puesto">Eliminar Puesto</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Area <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/area">Nueva Area</a></li>
					<li><a href="<?=site_url()?>/area/editar_area">Editar Area</a></li>
					<li><a href="<?=site_url()?>/area/eliminar_area">Eliminar Area</a></li>
					<li><a href="<?=site_url()?>/area/listado">Listado Areas</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'asignacion area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Asignación Areas <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Primaria - Basico</li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/asignacionarea">Nueva Asignación</a></li>
					<li><a href="#">Editar Asignación</a></li>
					<li><a href="#">Eliminar Asignación</a></li>
					<li class="dropdown-header">Diversificado</li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/asignacionarea/asignacionc">Nueva Asignación Carrera</a></li>
					<li><a href="#">Editar Asignación Carrera</a></li>
					<li><a href="#">Eliminar Asignación Carrera</a></li>

				</ul>
			</li>

			<li <?php if($activo == 'carrera'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Carrera <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/carrera">Nueva Carrera</a></li>
					<li><a href="<?=site_url()?>/carrera/editar_carrera">Editar Carrera</a></li>
					<li><a href="<?=site_url()?>/carrera/eliminar_carrera">Eliminar Carrera</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'estudiante'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Estudiante <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Primaria - Básico</li>
					<li><a href="<?=base_url()?>index.php/estudiante">Nuevo Estudiante</a></li>
					<li><a href="<?=site_url()?>/estudiante/editar_estudiante">Editar Estudiante</a></li>
					<li><a href="#">Eliminar Estudiante</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Carreras</li>
					<li><a href="<?=base_url()?>index.php/estudiante/estudiante_carrera">Nuevo Estudiante Carrera</a></li>
					<li><a href="#">Editar Estudiante Carrera</a></li>
					<li><a href="#">Eliminar Estudiante Carrera</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/estudiante/nomina_estudiantes">Nominas de Estudiantes</a></li>
					<li><a href="<?=site_url()?>/estudiante/cargar_archivo">Exportar Excel</a></li>

				</ul>
			</li>
			<li <?php if($activo == 'docente'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Docente <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/Asignaciondocente">Asignación de Areas</a></li>
					<li><a href="<?=site_url()?>/asignaciondocente/editar_asignacion">Editar asignación de Areas</a></li>
					<li><a href="<?=site_url()?>/docentes">Docentes Guías</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'cuadros'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuadros <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Crear Cuadros</li>
						<li><a href="<?=site_url()?>/cuadros">Primaria - Básico</a></li>
						<li><a href="<?=site_url()?>/cuadros/cuadros_diversificado">Diversificado
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/fechadisponible">Fecha Disponiblidad</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'notas'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Notas <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Zona</li>
					<li><a href="<?=site_url()?>/asignaciondocente/areas_asignadas"> Nueva Zona </a></li>
					<li><a href="#"> Editar Zona</a></li>
					<li class="divider"></li>
											<li class="dropdown-header">Examen</li>
					<li><a href="<?=site_url()?>/cuadros/notas_evaluacion">Nueva Nota Examen</a></li>

					<li><a href="#">Editar Nota Examen</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/notas/puntualidad_habitos">Puntualidad y Hábitos</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'reportes'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Reportes Generales</li> -->
				<!--	<li><a href="#">Cuadros Por Area</a></li>
					<li><a href="#">Cuadros Diversificado</a></li> -->
				<!--	<li><a href="<?=site_url()?>/consolidados">Consolidado Bloque</a></li>
					<li><a href="<?=site_url()?>/consolidados/consolidado_anual">Consolidado Anual</a></li>
					<li><a href="<?=site_url()?>/tarjetas">Tarjetas de Calificaciones</a></li>

					<li><a href="#">M-H po Grado</a></li>
					<li><a href="#">Abanderados y Escoltas</a></li>
					<li><a href="#">Cuadro de Honor</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Reportes Docentes</li>
					<li><a href="<?=site_url()?>/reportesdocentes">Cuadros Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/anual_areas">Anual Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/tarjetas">Tarjetas de Calificaciones</a></li>
				</ul>
			</li> -->
			<?php if (isset($_SESSION['autenticado'])): ?>
				<?php
				$datos = $_SESSION['autenticado'];
				$bandera = false;
				$aux = false;
				$aux2 = false;
				$cierre = false;

				?>
					<?php

		$temp = array();
		$aux = array('opcion'=>'nueva persona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar persona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar persona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'listado personas');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nuevo usuario');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar usuario');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar usuario');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nuevo titulo persona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar titulo persona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nuevo puesto');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar puesto');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar puesto');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva area');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar area');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar area');
		array_push($temp, $aux);
		$aux = array('opcion'=>'listado areas');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva asignación');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar asignación');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar asignación');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva asignación carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar asignación carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar asignación carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nuevo estudiante');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar estudiante');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar estudiante');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nuevo estudiante carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar estudiante carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'eliminar estudiante carrera');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nomina estudiantes');
		array_push($temp, $aux);
		$aux = array('opcion'=>'exportar excel');
		array_push($temp, $aux);
		$aux = array('opcion'=>'asignación de areas');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar asignación de areas');
		array_push($temp, $aux);
		$aux = array('opcion'=>'docente guía');
		array_push($temp, $aux);
		$aux = array('opcion'=>'enviar correos');
		array_push($temp, $aux);
		$aux = array('opcion'=>'primaria - básico');
		array_push($temp, $aux);
		$aux = array('opcion'=>'diversificado');
		array_push($temp, $aux);
		$aux = array('opcion'=>'fecha disponibilidad');
		array_push($temp, $aux);
		$aux = array('opcion'=>'calendario cuadros');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar cuadros');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva zona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar zona');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar acreditación');
		array_push($temp, $aux);
		$aux = array('opcion'=>'nueva nota examen');
		array_push($temp, $aux);
		$aux = array('opcion'=>'editar nota examen');
		array_push($temp, $aux);
		$aux = array('opcion'=>'puntualidad y hábitos');
		array_push($temp, $aux);
		$aux = array('opcion'=>'consolidado bloque');
		array_push($temp, $aux);
		$aux = array('opcion'=>'consolidado anual');
		array_push($temp, $aux);
		$aux = array('opcion'=>'tarjetas de calificaciones');
		array_push($temp, $aux);
		$aux = array('opcion'=>'tarjetas finales');
		array_push($temp, $aux);
		$aux = array('opcion'=>'abanderados y escoltas');
		array_push($temp, $aux);
		$aux = array('opcion'=>'cuadro de honor');
		array_push($temp, $aux);
		$aux = array('opcion'=>'cuadros areas - bloque');
		array_push($temp, $aux);
		$aux = array('opcion'=>'anual areas - bloque');
		array_push($temp, $aux);
		$aux = array('opcion'=>'tarjetas primaria');
		array_push($temp, $aux);
		$aux2 = '';
		$menu = array();
		foreach ($temp as $key => $value) {
			$aux2 = $value['opcion'];
			foreach ($datos as $key => $value2) {
				 	if ($aux2 == $value2['subopcion']) {
				 		//echo $value2['opcion'].' '.$value2['subopcion'].'<br>';
				 		$temp2 = array('opcion'=>$value2['opcion'], 'subopcion'=>$value2['subopcion'], 'url'=>$value2['url']);
				 		array_push($menu, $temp2);
				 	}

				 }
		}

	 ?>
<?php $temp2 = $menu[0]['opcion'];  ?>
	<?php foreach ($menu as $value): ?>
						<?php if ($bandera == false): ?>
						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($value['opcion']) ?> <span class="caret" style="margin-top: 10px;"></span></a>
							<ul class="dropdown-menu">
						<?php  $bandera = true; ?>

						<?php  endif ?>

						<?php $temp = $value['opcion']; ?>

							<?php if ($temp != $temp2): ?>

								</ul>
						</li>

						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($value['opcion']) ?> <span class="caret" style="margin-top: 10px;"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url().$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?></a></li>
								<li class="divider"></li>
						<?php $temp2 = $temp; ?>
							<?php else: ?>
								<li><a href="<?php echo site_url().$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?> </a></li>
								<li class="divider"></li>
							<?php endif ?>


					<?php endforeach ?>

</ul>
						</li>

<!--			<li <?php if($activo == 'persona'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Persona <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/persona">Nueva Persona</a></li>
					<li><a href="#">Editar Persona</a></li>
					<li><a href="#">Eliminar Persona</a></li>
					<li><a href="<?=site_url()?>/persona/listado_personas">Listado Personas</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/usuario">Nuevo Usuario</a></li>
					<li><a href="#">Editar Usuario</a></li>
					<li><a href="#">Eliminar Usuario</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/titulo">Nuevo Título Persona</a></li>
					<li><a href="<?=site_url()?>/titulo/editar_titulo">Editar Título Persona</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'puesto'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Puesto <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/puesto">Nuevo Puesto</a></li>
					<li><a href="<?=site_url()?>/puesto/editar_puesto">Editar Puesto</a></li>
					<li><a href="<?=site_url()?>/puesto/eliminar_puesto">Eliminar Puesto</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Area <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/area">Nueva Area</a></li>
					<li><a href="<?=site_url()?>/area/editar_area">Editar Area</a></li>
					<li><a href="<?=site_url()?>/area/eliminar_area">Eliminar Area</a></li>
					<li><a href="<?=site_url()?>/area/listado">Listado Areas</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'asignacion area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Asignación Areas <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Primaria - Basico</li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/asignacionarea">Nueva Asignación</a></li>
					<li><a href="#">Editar Asignación</a></li>
					<li><a href="#">Eliminar Asignación</a></li>
					<li class="dropdown-header">Diversificado</li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/asignacionarea/asignacionc">Nueva Asignación Carrera</a></li>
					<li><a href="#">Editar Asignación Carrera</a></li>
					<li><a href="#">Eliminar Asignación Carrera</a></li>

				</ul>
			</li>

			<li <?php if($activo == 'carrera'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Carrera <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/carrera">Nueva Carrera</a></li>
					<li><a href="<?=site_url()?>/carrera/editar_carrera">Editar Carrera</a></li>
					<li><a href="<?=site_url()?>/carrera/eliminar_carrera">Eliminar Carrera</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'estudiante'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Estudiante <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Primaria - Básico</li>
					<li><a href="<?=base_url()?>index.php/estudiante">Nuevo Estudiante</a></li>
					<li><a href="<?=site_url()?>/estudiante/editar_estudiante">Editar Estudiante</a></li>
					<li><a href="#">Eliminar Estudiante</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Carreras</li>
					<li><a href="<?=base_url()?>index.php/estudiante/estudiante_carrera">Nuevo Estudiante Carrera</a></li>
					<li><a href="#">Editar Estudiante Carrera</a></li>
					<li><a href="#">Eliminar Estudiante Carrera</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/estudiante/nomina_estudiantes">Nominas de Estudiantes</a></li>
					<li><a href="<?=site_url()?>/estudiante/cargar_archivo">Exportar Excel</a></li>

				</ul>
			</li>
			<li <?php if($activo == 'docente'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Docente <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?=site_url()?>/Asignaciondocente">Asignación de Areas</a></li>
					<li><a href="<?=site_url()?>/asignaciondocente/editar_asignacion">Editar asignación de Areas</a></li>
					<li><a href="<?=site_url()?>/docentes">Docentes Guías</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'cuadros'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuadros <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Crear Cuadros</li>
						<li><a href="<?=site_url()?>/cuadros">Primaria - Básico</a></li>
						<li><a href="<?=site_url()?>/cuadros/cuadros_diversificado">Diversificado
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/fechadisponible">Fecha Disponiblidad</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'notas'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Notas <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Zona</li>
					<li><a href="<?=site_url()?>/asignaciondocente/areas_asignadas"> Nueva Zona </a></li>
					<li><a href="#"> Editar Zona</a></li>
					<li class="divider"></li>
											<li class="dropdown-header">Examen</li>
					<li><a href="<?=site_url()?>/cuadros/notas_evaluacion">Nueva Nota Examen</a></li>

					<li><a href="#">Editar Nota Examen</a></li>
					<li class="divider"></li>
					<li><a href="<?=site_url()?>/notas/puntualidad_habitos">Puntualidad y Hábitos</a></li>
				</ul>
			</li>
			<li <?php if($activo == 'reportes'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <span class="caret" style="margin-top: 10px;"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Reportes Generales</li> -->
				<!--	<li><a href="#">Cuadros Por Area</a></li>
					<li><a href="#">Cuadros Diversificado</a></li> -->
			<!--		<li><a href="<?=site_url()?>/consolidados">Consolidado Bloque</a></li>
					<li><a href="<?=site_url()?>/consolidados/consolidado_anual">Consolidado Anual</a></li>
					<li><a href="<?=site_url()?>/tarjetas">Tarjetas de Calificaciones</a></li>

					<li><a href="#">M-H po Grado</a></li>
					<li><a href="#">Abanderados y Escoltas</a></li>
					<li><a href="#">Cuadro de Honor</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Reportes Docentes</li>
					<li><a href="<?=site_url()?>/reportesdocentes">Cuadros Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/anual_areas">Anual Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/tarjetas">Tarjetas de Calificaciones</a></li>
				</ul>
			</li> -->



			<li class="dropdown">
				<a href="#" class="navbar-link dropdown-toggle" data-toggle="dropdown">


						<?php
							$datos = $_SESSION['nombreautenticado'];
						 	$nombre = $datos[0]['nombre'];
						 	$apellido = $datos[0]['apellidos'];
						 	$aux = '';
						 	for ($i=0; $i < strlen($nombre); $i++) {
						 		if ($nombre[$i] != ' ') {
						 			$aux .= $nombre[$i];
						 		}
						 		else{
						 			break;
						 		}
						 	}
						 	$nombre = $aux;
						 	$aux = '';
						 	for ($i=0; $i < strlen($apellido); $i++) {
						 		if ($apellido[$i] != ' ') {
						 			$aux .= $apellido[$i];
						 		} else {
						 			break;
						 		}

						 	}
						 	$apellido = $aux;
						 ?>
						<?php echo mb_strtoupper($nombre.' '.$apellido); ?>
					<b class="icon-cog"></b>
				</a>
					<ul class="dropdown-menu">
						<li><a href="<?=site_url()?>persona/editar_persona">Modificar Datos</a></li>
						<li><a href="<?=site_url()?>Editarpass">Modificar Contraseña</a></li>
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/autenticacion/cerrar_sistema">Salir del Sistema</a></li>
					</ul>
				</li>
		</ul>

		<?php endif ?> <!-- Fin de la condicion-->
	</div>
</nav>

<div class="row" >
<!--		<div class="col-sm-4 col-md-2 col-lg-2" id="menu"> -->
			<!--	<?php if (isset($_SESSION['autenticado'])): ?>

				<?php
				$datos = $_SESSION['autenticado'];
				$bandera = false;
				$aux = false;
				$aux2 = false;
				$cierre = false;
				$temp = $temp2 = '';
				//$url = site_url().'/municipio';
				?>
				<?php endif ?>
				<ul class="nav nav-pills nav-stacked">
					<li><h4 style="margin:0" class="text-center">Menu Principal</h4></li>
					<?php $temp2 = $datos[0]['opcion'];  ?>

					<?php foreach ($datos as $value): ?>
						<?php if ($bandera == false): ?>
						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo mb_strtoupper($value['opcion']) ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
						<?php  $bandera = true; ?>

						<?php  endif ?>

						<?php $temp = $value['opcion']; ?>

							<?php if ($temp != $temp2): ?>

								</ul>
						</li>

						<li <?php if($activo == $value['opcion']){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo mb_strtoupper($value['opcion']) ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url().'/'.$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?></a></li>
								<li class="divider"></li>
						<?php $temp2 = $temp; ?>
							<?php else: ?>
								<li><a href="<?php echo site_url().'/'.$value['url'] ?>"><?php echo ucwords($value['subopcion']) ?></a></li>
								<li class="divider"></li>
							<?php endif ?>


					<?php endforeach ?>
				</ul>
			-->

	<!--	<ul class="nav nav-pills nav-stacked" >
			<li><h4 style="margin:0;" class="text-center">Menu Principal</h4></li>

			<?php if (isset($_SESSION['autenticado'])): ?>

				<?php
				$datos = $_SESSION['autenticado'];
				$bandera = false;
				$aux = false;
				$aux2 = false;
				$cierre = false;
				?>

			<li class="divider"></li>


			<li <?php if($activo == 'municipio'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php foreach ($datos as $value): ?>

					<?php if ($bandera == false && $value['opcion'] == 'municipio'): ?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Municipio <span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php $bandera = true; $cierre =true;?>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'nuevo municipio'): ?>
						<li><a href="<?=site_url()?>/municipio">Nuevo Municipio</a></li>
					<?php endif; ?>
					<?php if ($value['subopcion'] === 'editar municipio'): ?>
						<li><a href="#">Editar Municipio</a></li>
					<?php endif; ?>
					<?php if ($value['subopcion'] === 'eliminar municipio'): ?>
						<li><a href="#">Eliminar Municipio</a></li>
					<?php endif; ?>
				<?php endforeach ?>
				<?php if ($cierre == true): ?>
					</ul>
				<?php endif ?>

			</li>

			<li <?php if($activo == 'persona'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = false; $cierre = false; ?>
				<?php foreach ($datos as $value): ?>

					<?php if ($bandera == false && $value['opcion'] ==='persona'): ?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Persona<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php $bandera = true; $cierre = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'nueva persona'): ?>
							<li><a href="<?=site_url()?>/persona">Nueva Persona</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'editar persona'): ?>
							<li><a href="#">Editar Persona</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'eliminar persona'): ?>
						<li><a href="#">Eliminar Persona</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'listado personas'): ?>
							<li><a href="<?=site_url()?>/persona/listado_personas">Listado Personas</a></li>
					<?php endif ?>
					<?php if (($value['subopcion'] === 'nuevo usuario' || $value['subopcion'] == 'editar usuario' || $value['subopcion'] == 'eliminar usuario') && $aux == false): ?>
						<li class="divider"></li>
						<li class="dropdown-header">Usuarios</li>
						<?php $aux = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'nuevo usuario'): ?>
						<li><a href="<?=site_url()?>/usuario">Nuevo Usuario</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'editar usuario'): ?>
						<li><a href="#">Editar Usuario</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] === 'eliminar usuario'): ?>
						<li><a href="#">Eliminar Usuario</a></li>
					<?php endif ?>
				<?php endforeach ?>
				<?php if ($cierre == true): ?>
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/titulo">Nuevo Título Persona</a></li>
						<li><a href="<?=site_url()?>/titulo/editar_titulo">Editar Título Persona</a></li>

					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'puesto'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = false; $cierre =false?>
				<?php foreach ($datos as $value): ?>
				<?php if ($bandera == false && $value['opcion'] === 'puesto'): ?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Puesto<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php $bandera = true; $cierre =true;?>
				<?php endif ?>
				<?php if ($value['subopcion'] === 'nuevo puesto'): ?>
					<li><a href="<?=site_url()?>/puesto">Nuevo Puesto</a></li>
				<?php endif ?>

				<?php if ($value['subopcion'] === 'editar puesto'): ?>
					<li><a href="<?=site_url()?>/puesto/editar_puesto">Editar Puesto</a></li>
				<?php endif ?>

				<?php if ($value['subopcion'] === 'eliminar puesto'): ?>
					<li><a href="<?=site_url()?>/puesto/eliminar_puesto">Eliminar Puesto</a></li>
				<?php endif ?>

				<?php endforeach ?>
				<?php if ($cierre == true): ?>
					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >
				<?php $bandera =false; $aux = false; $cierre =false;?>
				<?php foreach ($datos as $key => $value): ?>

					<?php if ($value['opcion'] == 'area' && $bandera == false): ?>
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Area<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php $bandera = true; $cierre =true;?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nueva area'): ?>
						<li><a href="<?=site_url()?>/area">Nueva Area</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar area'): ?>
						<li><a href="<?=site_url()?>/area/editar_area">Editar Area</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar area'): ?>
						<li><a href="<?=site_url()?>/area/eliminar_area">Eliminar Area</a></li>
					<?php endif ?>

					<?php if ($aux == false && $value['subopcion'] == 'listado areas'): ?>
						<li class="divider"></li>
						<?php $aux = false; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'listado areas'): ?>
						<li><a href="<?=site_url()?>/area/listado">Listado Areas</a></li>
					<?php endif ?>

				<?php endforeach ?>

				<?php if ($cierre == true): ?>
					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'asignacion area'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = $aux = $aux2 = false;?>
				<?php foreach ($datos as $value): ?>

				<?php if ($bandera == false && $value['opcion'] == 'asignación areas'): ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Asignación Areas <span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php $bandera = true; $cierre = true; ?>
				<?php endif ?>

					<?php if ($aux == false && ($value['subopcion'] == 'nueva asignación' || $value['subopcion'] == 'editar asignación' || $value['subopcion'] == 'eliminar asignación')): ?>
						<li class="dropdown-header">Primaria - Basico</li>
						<?php $aux = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nueva asignación'): ?>
						<li><a href="<?=site_url()?>/asignacionarea">Nueva Asignación</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar asignación'): ?>
						<li><a href="#">Editar Asignación</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar asignación'): ?>
						<li><a href="#">Eliminar Asignación</a></li>
					<?php endif ?>

					<?php if ($aux2 == false && ($value['subopcion'] == 'nueva asignación carrera' || $value['subopcion'] == 'editar asignación carrera' || $value['subopcion'] == 'eliminar asignación carrera')): ?>
						<li class="divider"></li>
						<li class="dropdown-header">Diversificado</li>
						<?php $aux2 = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nueva asignación carrera'): ?>
						<li><a href="<?=site_url()?>/asignacionarea/asignacionc">Nueva Asignación Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar asignación carrera'): ?>
						<li><a href="#">Editar Asignación Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar asignación carrera'): ?>
						<li><a href="#">Eliminar Asignación Carrera</a></li>
					<?php endif ?>
				<?php endforeach ?>

				<?php if ($cierre == true): ?>
					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'nivel'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = false; $cierre = false;?>

				<?php foreach ($datos as $value): ?>

					<?php if ($bandera == false && $value['opcion'] == 'nivel'): ?>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Nivel<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera = true; $cierre = true?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nuevo nivel'): ?>
						<li><a href="<?=site_url()?>/Nivelplan">Nuevo Nivel</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar nivel'): ?>
						<li><a href="<?=site_url()?>/nivelplan/editar_nivel">Editar Nivel</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar nivel'): ?>
						<li><a href="<?=site_url()?>/nivelplan/eliminar_nivel">Eliminar Nivel</a></li>
					<?php endif ?>

				<?php endforeach ?>

				<?php if ($cierre == true): ?>
					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'carrera'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>

				<?php $bandera = false; $cierre = false;?>

				<?php foreach ($datos as $value): ?>

					<?php if ($bandera == false && $value['opcion'] == 'carrera'): ?>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Carrera<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera = true; $cierre = true;?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nueva carrera'): ?>
						<li><a href="<?=site_url()?>/carrera">Nueva Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar carrera'): ?>
						<li><a href="<?=site_url()?>/carrera/editar_carrera">Editar Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar carrera'): ?>
						<li><a href="<?=site_url()?>/carrera/eliminar_carrera">Eliminar Carrera</a></li>
					<?php endif ?>
				<?php endforeach ?>
				<?php if ($cierre ==true): ?>
					</ul>
				<?php endif ?>

			</li>
			<li <?php if($activo == 'estudiante'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = $aux = $aux2 = false; $cierre = false;?>
				<?php foreach ($datos as $value): ?>
					<?php if ($value['opcion'] == 'estudiante' && $bandera == false): ?>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Estudiante <span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera = true; $cierre =true;?>
					<?php endif ?>

					<?php if ($aux == false && ($value['subopcion'] == 'nuevo estudiante' || $value['subopcion'] == 'editar estudiante' || $value['subopcion'] == 'eliminar estudiante')): ?>
						<li class="dropdown-header">Primaria - Básico</li>
						<?php $aux = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nuevo estudiante'): ?>
						<li><a href="<?=base_url()?>index.php/estudiante">Nuevo Estudiante</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar estudiante'): ?>
						<li><a href="<?=site_url()?>/estudiante/editar_estudiante">Editar Estudiante</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar estudiante'): ?>
						<li><a href="#">Eliminar Estudiante</a></li>
					<?php endif ?>

					<?php if ($aux2 == false && ($value['subopcion'] == 'nuevo estudiante carrera' || $value['subopcion'] == 'editar estudiante carrera' || $value['subopcion'] == 'eliminar estudiante carrera')): ?>
						<li class="divider"></li>
						<li class="dropdown-header">Carreras</li>
						<?php $aux2 = true ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nuevo estudiante carrera'): ?>
						<li><a href="<?=base_url()?>index.php/estudiante/estudiante_carrera">Nuevo Estudiante Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar estudiante carrera'): ?>
						<li><a href="#">Editar Estudiante Carrera</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'eliminar estudiante carrera'): ?>
						<li><a href="#">Eliminar Estudiante Carrera</a></li>
					<?php endif ?>


				<?php endforeach ?>
				<?php if ($cierre == true): ?>
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/estudiante/nomina_estudiantes">Nominas de Estudiantes</a></li>
						<li><a href="<?=site_url()?>/estudiante/cargar_archivo">Exportar Excel</a></li>
					</ul>
				<?php endif ?>

			</li>

			<li <?php if($activo == 'docente'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = false; $cierre = false;?>
				<?php foreach ($datos as $value): ?>

					<?php if ($bandera == false && $value['opcion'] == 'docente'): ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Docente<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera =true; $cierre = true;?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'asignación de areas'): ?>
						<li><a href="<?=site_url()?>/Asignaciondocente">Asignación de Areas</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar asignación de areas'): ?>
						<li><a href="<?=site_url()?>/asignaciondocente/editar_asignacion">Editar asignación de Areas</a></li>
					<?php endif ?>



				<?php endforeach ?>
				<?php if ($cierre == true): ?>
					<li><a href="<?=site_url()?>/docentes">Docentes Guías</a></li>
					</ul>
				<?php endif ?>

			</li>

			<li <?php if($activo == 'cuadros'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?> >

				<?php $bandera = $aux = $aux2 = false; $cierre =false; ?>
				<?php foreach ($datos as $value): ?>
					<?php if ($bandera == false && $value['opcion'] == 'cuadros'): ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuadros<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera = true; $cierre = true;?>
					<?php endif ?>

					<?php if ($aux == false && ($value['subopcion'] == 'primaria - básico' || $value['subopcion'] == 'diversificado')): ?>
						<li class="dropdown-header">Crear Cuadros</li>
						<?php $aux = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'primaria - básico'): ?>
						<li><a href="<?=site_url()?>/cuadros">Primaria - Básico</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'diversificado'): ?>
						<li><a href="<?=site_url()?>/cuadros/cuadros_diversificado">Diversificado</a></li>
					<?php endif ?>

					<?php if ($aux2 == false && $value['subopcion'] == 'fecha disponibilidad' ): ?>
						<li class="divider"></li>

						<?php $aux2 = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'fecha disponibilidad'): ?>
						<li><a href="<?=site_url()?>/fechadisponible">Fecha Disponiblidad</a></li>
					<?php endif ?>

				<?php endforeach ?>
					<?php if ($cierre == true): ?>
						</ul>
					<?php endif ?>

			</li>

			<li <?php if($activo == 'notas'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<?php $bandera = $aux = $aux2 = false; $cierre = false; ?>

				<?php foreach ($datos as $value): ?>
					<?php if ($bandera == false && $value['opcion'] == 'notas'): ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Notas <span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php $bandera = true; $cierre = true;?>
					<?php endif ?>

					<?php if ($aux == false && ($value['subopcion'] == 'nueva zona' || $value['subopcion'] == 'editar zona')): ?>
						<li class="dropdown-header">Zona</li>
						<?php $aux =true; ?>
					<?php endif ?>
					<?php if ($value['subopcion'] == 'nueva zona'): ?>
						<li><a href="<?=site_url()?>/asignaciondocente/areas_asignadas"> Nueva Zona </a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar zona'): ?>
						<li><a href="#"> Editar Zona</a></li>
					<?php endif ?>

					<?php if ($aux2 == false && ($value['subopcion'] == 'nueva nota examen' || $value['subopcion'] == 'editar nota examen')): ?>
						<li class="divider"></li>
						<li class="dropdown-header">Examen</li>
						<?php $aux2 = true; ?>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'nueva nota examen'): ?>
						<li><a href="<?=site_url()?>/cuadros/notas_evaluacion">Nueva Nota Examen</a></li>
					<?php endif ?>

					<?php if ($value['subopcion'] == 'editar nota examen'): ?>
						<li><a href="#">Editar Nota Examen</a></li>
					<?php endif ?>

				<?php endforeach ?>

					<?php if ($cierre == true): ?>
						<li class="divider"></li>
						<li><a href="<?=site_url()?>/notas/puntualidad_habitos">Puntualidad y Hábitos</a></li>
						</ul>
					<?php endif ?>

			</li>

			<li <?php if($activo == 'reportes'){echo 'class="dropdown active"';}else{ echo 'class="dropdown"';} ?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li class="dropdown-header">Reportes Generales</li>
					<li><a href="#">Cuadros Por Area</a></li>
					<li><a href="#">Cuadros Diversificado</a></li>
					<li><a href="<?=site_url()?>/consolidados">Consolidado Bloque</a></li>
					<li><a href="<?=site_url()?>/consolidados/consolidado_anual">Consolidado Anual</a></li>
					<li><a href="<?=site_url()?>/tarjetas">Tarjetas de Calificaciones</a></li>

					<li><a href="#">M-H po Grado</a></li>
					<li><a href="#">Abanderados y Escoltas</a></li>
					<li><a href="#">Cuadro de Honor</a></li>
					<li></li>
					<li class="divider"></li>
					<li class="dropdown-header">Reportes Docentes</li>
					<li><a href="<?=site_url()?>/reportesdocentes">Cuadros Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/anual_areas">Anual Areas - Bloque</a></li>
					<li><a href="<?=site_url()?>/reportesdocentes/tarjetas">Tarjetas de Calificaciones</a></li>
				</ul>
			</li>



		<?php endif ?>

		</ul>

	</div>	-->

	<!--	<div class="col-sm-8 col-md-2 col-lg-10" id="miContenido"> -->
	<div class="col-sm-12 col-md-12 col-lg-12" id="miContenido">

	<?php else: ?>
		<?php redirect('autenticacion','refresh') ?>
	<?php endif ?>
