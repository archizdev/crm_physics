<hr>
         <?php echo form_open_multipart('client/update_dynamic_query/'.$details->enquiry_id,'class="form-inner tabbed_form"') ?>           
         <input name="en_comments" type="hidden" value="<?=$details->Enquery_id?>" >
         <input name="cmnt_id" value="<?=$cmnt_id?>" type="hidden">    
         <input type="hidden" name="enquiry_id" value="<?=$details->enquiry_id?>">
         <div class="row">
         <?php
         if(!empty($dynamic_field)) {       
          foreach($dynamic_field as $ind => $fld){
            $fld_id = $fld['input_id'];
            ?>  
<?php if($fld['input_type']==19){?>			   
<div class="col-md-12">
<label style="color:#283593;"><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?><i class="text-danger"></i></label>
 <hr>
</div>
<?php }?>
<?php if($fld['input_type']!=19){ ?>
            <div class="form-group col-md-6 <?=$fld['input_name']?> col-md-6" >			
               <?php if($fld['input_type']==1){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="text" name="enqueryfield[<?=$fld_id?>]"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>"  class="form-control">
               <?php }if($fld['input_type']==2){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
               ?>
               <select class="form-control"  name="enqueryfield[<?=$fld_id?>]" >
                  <option>Select</option>
                  <?php  foreach($optarr as $key => $val){
                  ?>
                  <option value = "<?php echo $val; ?>" <?php echo (!empty($fld["fvalue"]) and trim($fld["fvalue"]) == trim($val)) ? "selected" : ""; ?>><?php echo $val; ?></option>
                  <?php
                     } 
                  ?>
               </select>
               <?php }if($fld['input_type']==3){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="hidden"  name="enqueryfield[<?=$fld_id?>]" class="form-control">                         
               <?php 
               $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
                  foreach($optarr as $key => $val){
                  ?><label><?=$val?></label>
                  <input type="radio"  id="<?=$fld['input_name']?>" name="enqueryfield[<?=$fld_id?>]" value="<?=$val;?>" class="form-control">
				  <?php
                     }                               
               }if($fld['input_type']==4){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="hidden"  name="enqueryfield[<?=$fld_id?>]" class="form-control">                         
               <input type="checkbox"  name="enqueryfield[<?=$fld_id?>]"  id="<?= $fld['input_name']?>" class="form-control">                         
               <?php }if($fld['input_type']==5){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <textarea   name="enqueryfield[<?=$fld_id?>]"  <?= $fld['fld_attributes']; ?>  class="form-control" placeholder="<?= $fld['input_place']; ?>" ><?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?></textarea>
               <?php }?>
               <?php if($fld['input_type']==6){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="date"  name="enqueryfield[<?=$fld_id?>]" class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
               <?php if($fld['input_type']==7){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="time"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
               <?php if($fld['input_type']==8){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="hidden" readonly name="enqueryfield[<?=$fld_id?>]"  class="form-control"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">               
               <input type="file"  name="enqueryfiles[]"  class="form-control" >
               <?php 
               if (!empty($fld["fvalue"])) {
                  ?>
                  <a href="<?=$fld['fvalue']?>" target="_blank"><?=basename($fld['fvalue'])?></a>
                  <?php
               }
            }?>
               <?php if($fld['input_type']==9){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="password"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                  <?php if($fld['input_type']==10){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="color"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
               <?php if($fld['input_type']==11){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="datetime-local"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==12){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="email"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==13){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="month"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==14){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="number"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==15){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="url"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==16){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="week"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
                 <?php if($fld['input_type']==17){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="search"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>
               <?php if($fld['input_type']==18){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="tel"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <?php }?>	
                
               <?php
               if($fld['input_type']==20){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
               ?>
               <input type="hidden"  name="enqueryfield[<?=$fld_id?>]"  id="multi-<?=$fld['input_name']?>"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <select class="edit-multiple-select" name='multi[]' multiple onchange="changeSelect(this)" id="<?=$fld['input_name']?>">
                  <?php  foreach($optarr as $key => $val){                  
                    $fvalues  = explode('|', $fld['fvalue']);
                    ?>
                    <option value = "<?php echo $val; ?>" <?php echo (!empty($fld["fvalue"]) and in_array($val, $fvalues)) ? "selected" : ""; ?>><?php echo $val; ?></option>
                  <?php
                     } 
                  ?>
               </select>
               <script type="text/javascript">

                    $("#<?=$fld['input_name']?>").select2();

               </script>

               <?php }
               ?>
               
               <input type="hidden" name= "inputfieldno[]" value = "<?=$fld['input_id']; ?>">
               <input type="hidden" name= "inputtype[]" value = "<?=$fld['input_type']?>">
            </div>
<?php } ?>
      <?php  }
         } ?>
         </div>
         <div class="row" id="save_button">
            <div class="col-md-12 text-center">                                                               
               <input type="submit" name="submit_only" class="btn btn-primary" value="Save" >
              <!--  <input type="submit" name="submit_and_next" class="btn btn-primary" value="Save And Next"> -->
               <input type="hidden" name="go_new_tab">
            </div>
         </div>
   <?php
   echo form_close(); 
?>
