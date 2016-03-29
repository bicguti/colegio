<h1 class="text-center">Editar Contraseña</h1>
<p class="text-warning">Nota: Todos los campos con (*) son obligatorios.</p>
<?php echo form_open('editarpass/guardar_edicion_contrasena', array('class'=>'form-horizontal', 'role'=>'form')); ?>
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">NUEVA CONTRASEÑA</h3>
    </div>
    <div class="panel-body">
    <div class="form-group">
					<div class="col-sm-12 text-right">
						<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
					</div>
				</div>
    	<div class="form-group">
    		<?php echo form_label('Mi Usuario*', 'usuario', array('class'=>'col-sm-2 control-label')); ?>
    		<div class="col-sm-8">
    			<?php echo form_input(array('name'=>'usuario', 'class'=>'form-control', 'disabled'=>'disabled', 'value'=>$nusuario)); ?>
    		</div>
    	</div>
		
	<!--	<div class="form-group">
			<?php echo form_label('Contraseña Actual*', 'contraseña', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-8">
				<?php echo form_input(array('type'=>'password','name'=>'passant', 'class'=>'form-control', 'required'=>'required', 'maxlength'=>'15', 'placeholder'=>'Su contraseña actual')); ?>
			</div>
		</div>-->
		
		<div class="form-group">
			<?php echo form_label('Nueva Contraseña*', 'contraseña', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-8">
				<?php echo form_input(array('type'=>'password','name'=>'npass', 'class'=>'form-control', 'required'=>'required', 'maxlenght'=>'15', 'placeholder'=>'su nueva contraseña', 'id'=>'contra', 'value'=>set_value('npass'))); ?>
			</div>
		</div>
		
		<div class="form-group">
			<?php echo form_label('Repetir Contraseña', 'contraseña', array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-8">
				<?php echo form_input(array('type'=>'password','name'=>'rnpass','class'=>'form-control', 'required'=>'required', 'maxlength'=>'15', 'placeholder'=>'Repetir su nueva contraseña', 'id'=>'repetircontra', 'value'=>set_value('rnpass'))); ?>
			</div>
			<div class="col-sm-2">
			<span id="contravalida" style="font-size: 25px;"></span>
		</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10 text-danger">
				<p><?php echo $error ?></p>
				<?php echo validation_errors() ?>	
			</div>
			
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary"><span class="icon-floppy-disk"></span> Guardar</button>
			</div>
		</div>	

    </div>
    </div>

<?php echo form_close(); ?>