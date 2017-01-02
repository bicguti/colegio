<?php echo form_open_multipart('video/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
	<div class="form-group">
      <?=form_label('Titulo Video:', 'titulo', array('class'=>'col-sm-2 control-label'))?>
	<div class="col-sm-10">
      <?=form_input(array('name'=>'titulo', 'id'=>'titulo', 'class'=>'form-control','type'=>'text', 'value'=>set_value('titulo'), 'placeholder' => 'Ingrese el Titulo del Video', 'autofocus'=>'autofocus', 'size'=>'50'))?>
   </div>
</div>
      <?=form_label('Costo Video:', 'costo')?>
        <?=form_input(array('name'=>'costo', 'id'=>'costo', 'type'=>'text', 'value'=>set_value('costo'), 'placeholder' => 'Ingrese el Costo del Video', 'size'=>'50'))?>
   
      <?=form_label('Formato Video:', 'formato')?>
        <?=form_input(array('name'=>'formato', 'id'=>'formato', 'type'=>'text', 'value'=>set_value('formato'), 'placeholder' => 'Ingrese el Formato del Video', 'size'=>'50'))?>
   
       <?=form_label('Seleccione una Imagen', 'image')?>
        <?=form_input(array('name'=>'userfile', 'id'=>'userfile', 'type'=>'file', 'size'=>'20'))?>
   <?= form_submit('Guardar', 'Guardar', array('class'=>'btn btn-default'))?>
<?=form_close()?>
<?php echo form_open('url', '', $hidden); ?>