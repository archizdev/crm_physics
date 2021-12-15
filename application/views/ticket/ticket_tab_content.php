<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.1/themes/fontawesome-stars.min.css">        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.1/jquery.barrating.min.js"></script>        
<?php
if($form_type == 1)
{
 ?>
          
          <hr>
          <?php
          if ($tid == 51) { 
            $form_id = base64_encode($tid);
            $ucomp_id = base64_encode($this->session->companey_id);
            $uenquiry_code = base64_encode($details->ticketno);
            $uuid = base64_encode($this->session->user_id);
            $f_url = base_url().'public/survey/form/'.$form_id.'/'.$ucomp_id.'/'.$uenquiry_code.'/'.$uuid.'/2';
            ?>
            <input type="text" value="<?=$f_url?>" id='copy-txt' style="width:85%;">
            <button type="button" id='copy-btn'>Copy</button>

            <!-- <a onclick='share_form("<?=$f_url?>","<?=$details->email?>")' href='javascript:void(0)' class="btn btn-primary btn-sm">Share to user</a> -->

            <br>
            <br>            
          <?php
          }
          if(!empty($dynamic_field)) {
          ?>
          <div style="overflow-y: scroll;">
          <table class="table table-striped table-bordered table-responsive table-sm">
            <thead class="thead-dark">
                <tr>
                  <?php
                    $counter = 0;
                  if(!empty($dynamic_field)) {
                    foreach($dynamic_field as $ind => $fld){ $counter++; ?>

                        <th><?=ucwords($fld["input_label"])?></th>
                    <?php
                    }
                    ?>
                    <th>Created At</th>

                    <?=(($action['delete'] or $action['edit'])?'<th>Action</th>':'')?>
                    <?php
                  }
                  ?>
                </tr>              
            </thead>
            <tbody>
              <?php              
                $sql  = "SELECT GROUP_CONCAT(concat(`ticket_dynamic_data`.`input`,'#',`ticket_dynamic_data`.`fvalue`,'#',`ticket_dynamic_data`.`created_date`,'#',`ticket_dynamic_data`.`comment_id`) separator ',') as d FROM `ticket_dynamic_data` INNER JOIN (select * from tbl_input where form_id=$tid) as tbl_input ON `tbl_input`.`input_id`=`ticket_dynamic_data`.`input` where `ticket_dynamic_data`.`cmp_no`=$comp_id and `ticket_dynamic_data`.`enq_no`='$details->ticketno' GROUP BY `ticket_dynamic_data`.`comment_id` ORDER BY `ticket_dynamic_data`.`comment_id` DESC";
                $res = $this->db->query($sql)->result_array(); 

                //print_r($res);exit();

                if (!empty($res)) {
                  foreach ($res as $key => $value) {
                    ?>
                    <tr>
                    <?php
                    $arr  = explode(',', $value['d']);                     
                    if (!empty($arr)) {
                      foreach($dynamic_field as $ind => $fld){ 
                        $d = 'NA';
                        foreach ($arr as $key1 => $value1) {                        
                          $arr1 = explode('#', $value1);                           
                          if (!empty($arr1[1]) && $arr1[0]==$fld['input']) {
                            $d  = $arr1[1];
                            $d  = explode('/',$arr1[1]);
                            if (filter_var($arr1[1], FILTER_VALIDATE_URL)) 
                            {
                              $d = '<a href='.$arr1[1].'>'.end($d).'</a>';
                            }
                            else
                            {
                              $d = end($d);
                            }                              
                            
                            break;
                          }                         
                        } 
                        ?>                        
                        <td><?=$d?></td>                                                           
                        <?php
                      } 
                      ?>
                      <td><?=!empty($arr1[2])?$arr1[2]:'NA'?></td>
                     <?php
                     //print_r($arr1); exit();
	                    if($action['delete'] or $action['edit'])
	                    {

                     ?>
                      <td>
                      	<?=$action['edit']? "<a data-cmnt='".$arr1[3]."' data-tab-id='".$tid."' data-ticket='".$details->ticketno."' data-comp-id='".$comp_id."' data-tab-name='".$tabname."' class='btn btn-primary btn-xs' onclick='edit_dynamic_query(this)'><i class='fa fa-edit'></i></a> " :''?>

                      	<?=$action['delete']? "<a class='btn btn-danger btn-xs' href='".base_url("ticket/delete_query_data/$arr1[3]/$details->ticketno")."' onclick='return alert(\'are you sure\')'><i class='fa fa-trash'></i></a> " :''?>
                      	
                      </td>                                                  
                      <?php
                  		}
                    } ?>                    
                    </tr>
                    <?php
                  }
                }
                else { ?>
                  <tr><td colspan="<?=($counter+2);?>" class="text-center">No Records Found</td></tr>
                <?php } 
              
              ?>              
            </tbody>
          </table>
          </div>
          <?php
        }?>
         <?php echo form_open_multipart('ticket/update_ticket_tab/'.$details->id,'class="form-inner"') ?>           
         <input name="en_comments" type="hidden" value="<?=$details->ticketno?>" >    
         <input name="tid" type="hidden" value="<?=$tid?>" >    
         <input name="form_type" type="hidden" value="<?=$form_type?>" >    
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
               <input type="text" name="enqueryfield[<?=$fld_id?>]" class="form-control">
               <?php }
               if($fld['input_type']==2){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
               ?>
               <select class="form-control"  name="enqueryfield[<?=$fld_id?>]" >
                  <option value=''>Select</option>
                  <?php  foreach($optarr as $key => $val){
                  ?>
                  <option value = "<?php echo $val; ?>"><?php echo $val; ?></option>
                  <?php
                     } 
                  ?>
               </select>
               <?php }

                if($fld['input_type']==21){?>
                  <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                  <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
                  ?>
                  <select class="star-rating"  name="enqueryfield[<?=$fld_id?>]" >
                    <option value=''>Select</option>
                    <?php  foreach($optarr as $key => $val){
                    ?>
                    <option value = "<?php echo $val; ?>"><?php echo $val; ?></option>
                    <?php
                        } 
                    ?>
                  </select>
                  <?php }


               if($fld['input_type']==3){?>
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
               <textarea   name="enqueryfield[<?=$fld_id?>]" <?= $fld['fld_attributes']; ?>  class="form-control" placeholder="<?= $fld['input_place']; ?>" ></textarea>
               <?php }?>
               <?php if($fld['input_type']==6){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input    name="enqueryfield[<?=$fld_id?>]" class="form-control form-date">
               <?php }?>
               <?php if($fld['input_type']==7){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="time"  name="enqueryfield[<?=$fld_id?>]"  class="form-control">
               <?php }?>
               <?php if($fld['input_type']==8){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="hidden" readonly name="enqueryfield[<?=$fld_id?>]"  class="form-control"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">               
               <input type="file"  name="enqueryfiles[]"  class="form-control" >
               <?php 
               if (!empty($fld["fvalue"])) {
                  ?>
                  <!-- <a href="<?=$fld['fvalue']?>" target="_blank"><?=basename($fld['fvalue'])?></a> -->
                  <?php
               }
            }?>
               <?php if($fld['input_type']==9){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="password"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                  <?php if($fld['input_type']==10){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="color"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
               <?php if($fld['input_type']==11){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="datetime-local"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==12){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="email"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==13){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="month"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==14){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="number"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==15){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="url"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==16){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="week"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
                 <?php if($fld['input_type']==17){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="search"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>
               <?php if($fld['input_type']==18){?>
               <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
               <input type="tel"  name="enqueryfield[<?=$fld_id?>]"  class="form-control" >
               <?php }?>                 
               <input type="hidden" name= "inputfieldno[]" value = "<?=$fld['input_id']; ?>">
               <input type="hidden" name= "inputtype[]" value = "<?=$fld['input_type']?>">
            </div>
<?php } ?>
      <?php  }
         } ?>
         </div>
         <div class="row"   id="save_button">
            <div class="col-md-12 text-center">                                                
               <button class="btn btn-primary" type="submit" >Save</button>            
            </div>
         </div>
   <?php
   echo form_close(); 
}
else
{
?>
<hr>  
 <?php
   if($is_primary != '1')
   {
  echo form_open_multipart('ticket/update_ticket_tab/'.$details->id,'class="form-inner tabbed_form"');
    }
  ?>           
         <input name="en_comments" type="hidden" value="<?=$details->ticketno?>" >    
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
               //echo $fld["fvalue"];
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
               <input type="hidden"  name="enqueryfield[]"  id="multi-<?=$fld['input_name']?>"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
               <select class="multiple-select" name='multi[]' multiple onchange="changeSelect(this)" id="<?=$fld['input_name']?>">
                  <?php  foreach($optarr as $key => $val){                  
                    $fvalues  = explode(',', $fld['fvalue']);
                    ?>
                    <option value = "<?php echo $val; ?>" <?php echo (!empty($fld["fvalue"]) and in_array($val, $fvalues)) ? "selected" : ""; ?>><?php echo $val; ?></option>
                  <?php
                     } 
                  ?>
               </select>
               <?php }
               ?>
               
               <input type="hidden" name= "inputfieldno[]" value = "<?=$fld['input_id']; ?>">
               <input type="hidden" name= "inputtype[]" value = "<?=$fld['input_type']?>">
            </div>
<?php } ?>
      <?php  }
         } ?>
         </div>

         <?php
         if($is_primary != '1')
         {
        ?>
         <div class="row" id="save_button">
            <div class="col-md-12 text-center">                                                               
               <input type="submit" name="submit_only" class="btn btn-primary" value="Save" >
               <input type="submit" name="submit_and_next" class="btn btn-primary" value="Save And Next">
               <input type="hidden" name="go_new_tab">
            </div>
         </div>
         <?php

         echo form_close(); 

       }
       ?>
   <?php
}
?>
<script>
   $(function() {
    $('.star-rating').barrating({
      theme: 'fontawesome-stars'
    });  
  });
  (function() {
    var copyButton = document.getElementById('copy-btn');
    var copyInput = document.getElementById('copy-txt');
    
    $("#copy-btn").on('click', function(e) {
      $("#copy-btn").html('<b>Copied</b>');
      e.preventDefault();
      var text = copyInput.select();
      document.execCommand('copy');
    });
    $("#copy-txt").on('click', function() {
      this.select();
    });
  })();
  jQuery(function($){ //on document.ready
        $('.form-date').datepicker({ dateFormat: 'yy-mm-dd' });
      });
</script>