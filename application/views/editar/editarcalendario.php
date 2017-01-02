<h1 class="text-center">Calendario de Entrega de Cuadros</h1>
<p>Nota: Todos los campos con (*) son obligatorios.</p>
<?php
  $b1 = $datos[0]['buno_complementario'];
  $b2 = $datos[0]['bdos_complementario'];
  $b3 = $datos[0]['btres_complementario'];
  $b4 = $datos[0]['bcuatro_complementario'];
  $b1p = $datos[0]['buno_primaria'];
  $b2p = $datos[0]['bdos_primaria'];
  $b3p = $datos[0]['btres_primaria'];
  $b4p = $datos[0]['bcuatro_primaria'];
  $b1c = $datos[0]['buno_bc'];
  $b2c = $datos[0]['bdos_bc'];
  $b3c = $datos[0]['btres_bc'];
  $b4c = $datos[0]['bcuatro_bc'];
 ?>
 <?php if ($opcion == 1): ?>
  <?php echo form_open('calendariocuadros/guardar_fechas', array('class'=>'form-horizontal', 'role'=>'form')); ?>
   <div class="panel panel-success">
     <div class="panel-heading">
         <h3 class="panel-title">Pre-Primaria y Primaria; Áreas Complementarias</h3>
     </div>
     <div class="panel-body">
       <div class="form-group">
         <div class="col-sm-12 text-right ext3">
   				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
   			</div>
       </div>
       <div class="form-group">
         <div class="col-sm-12">
         <div class="table-responsive">
           <table class="table table-bordered table-hover">
             <thead>
               <tr>
                 <th class="text-center">BLOQUE</th>
                 <th class="text-center">FECHA DE ENTREGA</th>
               </tr>
             </thead>
             <tbody>
                 <tr>
                   <td class="text-center">
                     I BLOQUE*
                   </td>
                   <td>
                     <?php echo form_input(array('name'=>'uno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'30', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1)); ?>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                     II BLOQUE*
                   </td>
                   <td>
                     <?php echo form_input(array('name'=>'dos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'30', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2)); ?>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                     III BLOQUE*
                   </td>
                   <td>
                     <?php echo form_input(array('name'=>'tres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'30', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3)); ?>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                     IV BLOQUE*
                   </td>
                   <td>
                     <?php echo form_input(array('name'=>'cuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'30', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4)); ?>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                     V BLOQUE
                   </td>
                   <td>
                     <?php echo form_input(array('name'=>'cinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                   </td>
                 </tr>
             </tbody>
           </table>
         </div>
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10 text-danger">
           <?php echo validation_errors(); ?>
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-12 text-right">
           <button type="submit" name="opcion" class="btn btn-primary" value="<?php echo $opcion ?>"><span class="icon-floppy-disk"></span>  GUARDAR</button>
         </div>
       </div>
  </div>
  </div>
  <?php echo form_close(); ?>
 <?php endif; ?>

 <?php if ($opcion == 2): ?>
   <?php echo form_open('calendariocuadros/guardar_fechas', array('class'=>'form-horizontal', 'role'=>'form')); ?>
    <div class="panel panel-success">
      <div class="panel-heading">
          <h3 class="panel-title">Pre-Primaria y Primaria: Áreas Principales</h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <div class="col-sm-12 text-right ext3">
    				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
    			</div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">BLOQUE</th>
                  <th class="text-center">FECHA DE ENTREGA</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td class="text-center">
                      I BLOQUE*
                    </td>
                    <td>
                      <?php echo form_input(array('name'=>'uno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1p)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      II BLOQUE*
                    </td>
                    <td>
                      <?php echo form_input(array('name'=>'dos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2p)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      III BLOQUE*
                    </td>
                    <td>
                      <?php echo form_input(array('name'=>'tres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3p)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      IV BLOQUE*
                    </td>
                    <td>
                      <?php echo form_input(array('name'=>'cuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4p)); ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      V BLOQUE
                    </td>
                    <td>
                      <?php echo form_input(array('name'=>'cinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10 text-danger">
            <?php echo validation_errors(); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12 text-right">
            <button type="submit" name="opcion" class="btn btn-primary" value="<?php echo $opcion ?>"><span class="icon-floppy-disk"></span>  GUARDAR</button>
          </div>
        </div>
   </div>
   </div>
   <?php echo form_close(); ?>
 <?php endif; ?>

<?php if ($opcion == 3): ?>

 <?php echo form_open('calendariocuadros/guardar_fechas', array('class'=>'form-horizontal', 'role'=>'form')); ?>
  <div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Básico y Diversificado; Todas las Áreas</h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <div class="col-sm-12 text-right ext3">
  				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
  			</div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Básico y Diversificado</th>
              </tr>
              <tr>
                <th class="text-center">BLOQUE</th>
                <th class="text-center">FECHA DE ENTREGA</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td class="text-center">
                    I BLOQUE*
                  </td>
                  <td>
                    <?php echo form_input(array('name'=>'uno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1c)); ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    II BLOQUE*
                  </td>
                  <td>
                    <?php echo form_input(array('name'=>'dos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2c)); ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    III BLOQUE*
                  </td>
                  <td>
                    <?php echo form_input(array('name'=>'tres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3c)); ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    IV BLOQUE*
                  </td>
                  <td>
                    <?php echo form_input(array('name'=>'cuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4c)); ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    V BLOQUE
                  </td>
                  <td>
                    <?php echo form_input(array('name'=>'cinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10 text-danger">
          <?php echo validation_errors(); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12 text-right">
          <button type="submit" name="opcion" class="btn btn-primary" value="<?php echo $opcion ?>"><span class="icon-floppy-disk"></span>  GUARDAR</button>
        </div>
      </div>
 </div>
 </div>
 <?php echo form_close(); ?>
 <?php endif; ?>
<!--
<?php echo form_open('url', array('class' =>'form-horizontal','role'=>'form' )); ?>
<div class="panel panel-success">
  <div class="panel-heading">
      <h3 class="panel-title">FECHAS DE ENTREGA CICLO <?php echo date('Y') ?></h3>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <div class="col-sm-12 text-right">
				<img src="<?=base_url()?>img/LogoNG.jpg" alt="Logo-Pestalozzi">
			</div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Pre-primaria y Primaria</th>
            </tr>
            <tr>
              <th>Áreas Complementarias</th>
            </tr>
            <tr>
              <th class="text-center">BLOQUE</th>
              <th class="text-center">FECHA DE ENTREGA</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td class="text-center">
                  I BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'compuno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  II BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'compdos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  III BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'comptres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  IV BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'compcuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  V BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'compcinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                </td>
              </tr>
          </tbody>
        </table>
      </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Pre-primaria y Primaria</th>
            </tr>
            <tr>
              <th class="text-center">BLOQUE</th>
              <th class="text-center">FECHA DE ENTREGA</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td class="text-center">
                  I BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'puno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1p)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  II BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'pdos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2p)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  III BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'ptres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3p)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  IV BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'pcuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4p)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  V BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'pcinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                </td>
              </tr>
          </tbody>
        </table>
      </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Básico y Diversificado</th>
            </tr>
            <tr>
              <th class="text-center">BLOQUE</th>
              <th class="text-center">FECHA DE ENTREGA</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td class="text-center">
                  I BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'bcuno','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b1c)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  II BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'bcdos','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b2c)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  III BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'bctres','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b3c)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  IV BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'bccuatro','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'value'=>$b4c)); ?>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  V BLOQUE
                </td>
                <td>
                  <?php echo form_input(array('name'=>'bccinco','class'=>'form-control', 'required'=>'required', 'maxlength'=>'40', 'autocomplete'=>'off', 'placeholder'=>'fecha de entrega', 'disabled'=>'disabled', 'value'=>'Al día siguiente después de evaluar')); ?>
                </td>
              </tr>
          </tbody>
        </table>
      </div>
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
-->
