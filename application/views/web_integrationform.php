<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>
            <?php
            if(!empty($setting->title)){
                echo $setting->title;
                $favicon = base_url().$setting->favicon;
                $logo = base_url().$setting->logo;
            }else{
                echo "Archiz Solutions";
                $favicon = 'https://archizsolutions.com/wp-content/uploads/2018/03/cropped-Archiz-logo-1-32x32.jpg';
                $logo = '';
            }
            ?>            
        </title>
        
        <link rel="icon" href="<?=$favicon?>" sizes="32x32" />
        
        <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>     
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
         <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
     
        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    </head>
    <body class="sidebar-mini  sidebar-collapse pace-done" style="background-image: url('<?php echo base_url("assets/images/OSUM Smart Wall Paper.jpg")?>');background-size:cover;">
        <div class="se-pre-con"></div>
        <br>
    <div class="container">
                <?php
                if(!empty($logo)){
                    ?>
                    <center><img src="<?php echo $logo?>" style="width:130px;"></center>                
                    <?php
                }else{
                    
                }                
                ?>
                <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
                    <div class="col-md-12 btn btn-danger">
                <?=$this->session->flashdata('SUCCESSMSG')?>
                </div>
                <?php } ?>

                <?php
                define('FIRST_NAME',1);
                define('LAST_NAME',2);
                define('GENDER',3);
                define('MOBILE',4);
                define('EMAIL',5);
                define('COMPANY',6);
                define('LEAD_SOURCE',7);
                define('PRODUCT_FIELD',8);
                define('STATE_FIELD',9);
                define('CITY_FIELD',10);
                define('ADDRESS_FIELD',11);  
                define('REMARK_FIELD',12);  
                define('PREFERRED_COUNTRY_FIELD',13);  
                define('PIN_CODE',14); 
                define('SUB_SOURCE',51);  
                define('PRODUCT_CATEGORY_FIELD',52);  
                define('PRODUCT_SUBCATEGORY_FIELD',53);  
                ?>
                <br>
                <div class="row">
                    <div class="<?php echo 'col-md-4'; ?>">&nbsp;</div>
                    <div class="col-md-4 panel panel-default thumbnail">
                       <form method="post" class="form-inner panel-body">
                            <input type="hidden" id="name" name="create_dby" value="<?=$qr_row['web_created_by']?>">                            
                            <input type="hidden" id="qr_code_id" name="qr_code_id" value="<?=$qr_row['wid']?>">                            
                            <input type="hidden" id="wid" name="wid" value="<?=$wid?>">               						
                            <?php
                            if(!empty($basic_fields)){
                      foreach($basic_fields as $bsfld){
                      if($bsfld['field_id']==FIRST_NAME){ ?>
                    
                     <div class="form-group col-sm-12 col-md-12 enq-first-name">
                        <label> <?php echo display("first_name"); ?> <?php if($this->session->companey_id==65){echo'<i class="text-danger">*</i>';}?>  </label>
                        
                           
                           <input class="form-control" name="enquirername" type="text" value="<?php  echo set_value('enquirername');?>" placeholder="Enter First Name" style="width:100%;" <?php if($this->session->companey_id==65){echo'required';}?>/>
                        
                     </div>
                     <?php
                   }
                   ?>
                    <?php
                    if($bsfld['field_id']==LAST_NAME){
                    ?>
                     <div class="form-group col-sm-12 col-md-12 enq-last-name"> 
                        <label><?php echo display("last_name"); ?> <i class="text-danger"></i></label>
                        <input class="form-control" value="<?php  echo set_value('lastname');?>" name="lastname" type="text" placeholder="Last Name">  
                     </div>
                     <?php
                   }
                   ?>
                   <?php
                    if($bsfld['field_id']==GENDER){
                    ?>
                     <div class="form-group col-sm-12 col-md-12 enq-gender"> 
                        <label><?php echo display("gender"); ?><i class="text-danger"></i></label>
                         <select name="gender" class="form-control">
                           <option value="">---Select---</option>
                           <option value="1"><?php echo display("male"); ?></option>
                           <option value="2"><?php echo display("female"); ?></option>
                           <option value="3"><?php echo display("other"); ?></option>
                         </select>                           
                     </div>
                   
                  <?php
                   } 
                   ?>
                   <?php
                    if($bsfld['field_id']==MOBILE){
                    ?>
                     <?php
                          $required = 'required';
                        ?>

                     <div class="form-group col-sm-12 col-md-12 enq-mobile"> 
                        <label><?php echo display('mobile') ?> 
                        
                        
                        <i class="text-danger">*</i></label>
                        
                        <input id="chk-mob-number" class="form-control" value="<?php if(!empty($_GET['phone'])){echo $_GET['phone']; }else{ echo set_value('mobileno')?set_value('mobileno'):($this->input->get('phone')?$this->input->get('phone'):'');}?>" name="mobileno" type="text" maxlength='10' oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Enter Mobile Number" <?=$required?>>
                        <i class="fa fa-plus" onclick="add_more_phone('add_more_phone')" style="float:right;margin-top:-25px;margin-right:10px;color:red"></i>          
                        <div id="is-avl-mobile" style="margin-top:-4px;"></div>              
                     </div>
                   
                  <?php
                   }
                   ?>
                     <?php
                    if($bsfld['field_id']==EMAIL){
                    ?>
                     <div class="form-group col-sm-12 col-md-12 enq-email"> 
                        <label><?php echo display('email') ?>  </label>
                        <input class="form-control" value="<?php  echo set_value('email');?> " id='chk-email-id' name="email" type="email"  placeholder="Enter Email">  
                        <div id="is-avl-email" style="margin-top:-4px;"></div>              
                     </div>                     
                     <?php
                   }
                   ?>
                   <?php  
                    if($bsfld['field_id']==COMPANY){
                    ?>
                     <div class="form-group col-sm-12 col-md-12">
                        <label><?php echo display('company_name') ?> <i class="text-danger"></i></label>
                        <input class="form-control" value="<?php  echo set_value('company');?> " name="company" type="text"  placeholder="Enter Company"> 
                        <label id='company_code'></label>
                     </div>
                   
                     <?php
                   }
                   ?>  
                    <?php
                    if($bsfld['field_id']==LEAD_SOURCE){
                    ?>      
                              
                     <div class="form-group col-sm-12 col-md-12 enq-source">
                        <label><?php echo display('lead_source') ?> <i class="text-danger"></i></label>
                        <select class="form-control" name="lead_source" id="lead_source" onchange="find_sub()">
                           <option value="" style="display:none;">---Select---</option>
                           <?php foreach ($leadsource as $post){ ?>
                           <option value="<?= $post->lsid?>"><?= $post->lead_name?></option>
                           <?php } ?>
                        </select>
                     </div>
                    <?php
                   }
                   ?>  
                    <?php
                    if($bsfld['field_id']==SUB_SOURCE){
                    ?>      
                              
                     <div class="form-group col-sm-12 col-md-12 enq-subsource">
                        <label><?php echo display('sub_source') ?> <i class="text-danger"></i></label>
                        <select class="form-control" name="subsource" id="subsource">

                        </select>
                     </div>
                    <?php
                   }
                   ?>  
                    <?php
                     if($bsfld['field_id']==PRODUCT_CATEGORY_FIELD){
                      ?>                
                       <div class="form-group col-sm-12 col-md-12 enq-product">
                          <label><?php echo display("product_category"); ?></label>
                          <select class="form-control" name="product_category" id="product_category" onchange="get_product()">
                             <option value="" style="display:none;">---Select---</option>
                             <?php foreach ($product_category as $cat){ ?>
                             <option value="<?= $cat['id']?>"><?= $cat['name']?></option>
                             <?php } ?>
                          </select>
                       </div>
                        <?php
                     }
                     
                     if($bsfld['field_id']==PRODUCT_SUBCATEGORY_FIELD){
                      ?>                
                       <div class="form-group col-sm-12 col-md-12 enq-product">
                          <label><?php echo display("product_subcategory"); ?></label>
                          <select class="form-control" name="product_subcategory" id="product_subcategory" onchange="get_product()">
                           
                          </select>
                       </div>
                        <?php
                     }
                    if($bsfld['field_id']==PRODUCT_FIELD){
                    ?>                
                     <div class="form-group col-sm-12 col-md-12 enq-product">
                        <label><?php echo display("product"); ?></label>
                        <select class="form-control" name="product_country" id="product_country">
                           <option value="" style="display:none;">---Select---</option>
                           <?php foreach ($product_contry as $subsource){ ?>
                           <option value="<?= $subsource->id?>"><?= $subsource->country_name?></option>
                           <?php } ?>
                        </select>
                     </div>
                      <?php
                   }                   
                    if($bsfld['field_id']==ADDRESS_FIELD){
                    ?>                                     
                     <div class="form-group col-sm-12 col-md-12 enq-address">
                        <label><?php echo display('address') ?> <i class="text-danger"></i></label>
                        <textarea class="form-control" name="address" placeholder="Enter Address"><?php  echo set_value('address');?></textarea> 
                     </div>
                   
                     <?php 
                   }                    
                    if($bsfld['field_id']==STATE_FIELD){
                    ?>                
                     <div class="form-group col-sm-12 col-md-12 enq-state">
                        <label> <?php echo display("state"); ?> <i class="text-danger"></i></label>
                        <select name="state_id" id="fstate" class='form-control'>
                           <option value="" style="display:none;">---Select---</option>
                           <?php foreach($state_list as $state){?>
                           <option value="<?php echo $state->id ?>"><?php echo $state->state; ?></option>
                           <?php } ?>
                        </select>
                     </div>                   
                       <?php
                   }
                   ?>  
                    <?php
                    if($bsfld['field_id']==CITY_FIELD){
                    ?>             
                                             
                      <div class="form-group col-sm-12 col-md-12 enq-city">
                        <label><?php echo display("city"); ?> <i class="text-danger"></i></label>
                        <select name="city_id" class="form-control" id="fcity" >
                           <option value="" >---Select---</option>
                            
                        </select>
                     </div>
                       <?php
                   }
                  if($bsfld['field_id']==PIN_CODE){
                    ?>
                     <div class="form-group col-sm-12 col-md-12 enq-pincode">
                        <label><?php echo display('pin_code') ?> <i class="text-danger"></i></label>
                        <input class="form-control" value="<?php  echo set_value('pin_code');?> " name="pin_code" type="text"  placeholder="Pin Code"> 
                     </div>
                   
                     <?php
                   }
                   
                   if($bsfld['field_id']==REMARK_FIELD){
                    ?>                                     
                     <div class="form-group col-sm-12 col-md-12 enq-remark"> 
                        <label><?=display('remark')?></label>
                        <textarea class="form-control" name="enquiry"></textarea>
                     </div>
                     <?php 
                   }
                  }}
                   ?> 
        

  <?php  
      if(!empty($dynamic_field)) {       
          foreach($dynamic_field as $ind => $fld){
            ?>
                <?php if($fld['input_type']==19){ ?>			   
                <div class="col-md-12">
                <label style="color:#283593;"><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?><i class="text-danger"></i></label>
                <hr>
                </div>
                <?php }?>
                <?php if($fld['input_type']!=19){ ?>			
                            <div class="form-group col-md-12 <?=$fld['input_name']?> " >
                            <?php if($fld['input_type']==1){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="text" name="enqueryfield[]"  placeholder="<?= $fld['input_place']; ?>" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>" id="<?=$fld['input_name']?>"  class="form-control">
                            <?php }
                            if($fld['input_type']==2){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
                            ?>
                            <select class="form-control"  name="enqueryfield[]" id="<?=$fld['input_name']?>">
                                <option value="">Select</option>
                                <?php  foreach($optarr as $key => $val){
                                ?>
                                <option value = "<?php echo $val; ?>" <?php echo (!empty($fld["fvalue"]) and trim($fld["fvalue"]) == trim($val)) ? "selected" : ""; ?>><?php echo $val; ?></option>
                                <?php
                                    } 
                                ?>
                            </select>
                            <?php }
                            if($fld['input_type']==20){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <?php $optarr = (!empty($fld['input_values'])) ? explode(",",$fld['input_values']) : array(); 
                            ?>
                            <input type="hidden"  name="enqueryfield[]"  id="multi-<?=$fld['input_name']?>"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <select class="multiple-select" name='multi[]' multiple onchange="changeSelect(this)" id="<?=$fld['input_name']?>">
                                <?php  foreach($optarr as $key => $val){                  
                                    $fvalues  = explode('|', $fld['fvalue']);
                                    ?>
                                    <option value = "<?php echo $val; ?>" <?php echo (!empty($fld["fvalue"]) and in_array($val, $fvalues)) ? "selected" : ""; ?>><?php echo $val; ?></option>
                                <?php
                                    } 
                                ?>
                            </select>
                            <?php }
                            if($fld['input_type']==3){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="radio"  name="enqueryfield[]"  id="<?=$fld['input_name']?>" class="form-control">                         
                            <?php }if($fld['input_type']==4){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="checkbox"  name="enqueryfield[]"  id="<?=$fld['input_name']?>" class="form-control">			   
                            <?php }if($fld['input_type']==5){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <textarea   name="enqueryfield[]"  <?= $fld['fld_attributes']; ?> class="form-control" placeholder="<?= $fld['input_place']; ?>" ><?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?></textarea>
                            <?php }?>
                            <?php if($fld['input_type']==6){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="date"  name="enqueryfield[]" class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                            <?php if($fld['input_type']==7){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="time"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                            <?php if($fld['input_type']==8){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="hidden" readonly name="enqueryfield[]"  class="form-control"  value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
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
                            <input type="password"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==10){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="color"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                            <?php if($fld['input_type']==11){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="datetime-local"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==12){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="email"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==13){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="month"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==14){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="number"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==15){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="url"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==16){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="week"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                                <?php if($fld['input_type']==17){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="search"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>
                            <?php if($fld['input_type']==18){?>
                            <label><?php echo(!empty($fld["input_label"])) ?  ucwords($fld["input_label"]) : ""; ?></label>
                            <input type="tel"  name="enqueryfield[]"  class="form-control" value ="<?php echo  (!empty($fld["fvalue"])) ? $fld["fvalue"] : ""; ?>">
                            <?php }?>              
                            <input type="hidden" name= "inputfieldno[]" value = "<?=$fld['input_id']; ?>">
                            <input type="hidden" name= "inputtype[]" value = "<?=$fld['input_type']?>">
                            </div>
                <?php } ?>
                <?php  }   
                }
                ?>


                            
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6 text-center">
                                    <button class="ui positive button" type="submit"><?php echo display('save') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="<?php  echo 'col-md-3';  ?>">
				
				</div>
            </div>
         </div>
      <div style="<?php if(!empty($this->session->popup)){echo 'display:block';} ?>">
      <div id="success_model" class="modal  <?php if(!empty($this->session->popup)){echo 'fade in';} ?>" role="dialog" style="<?php if(!empty($this->session->popup)){echo 'display:block';} ?>">
  <div class="modal-dialog">
     <div class="modal-content">        
        <div class="modal-body">
            <center><img src="<?php echo $logo;?>" style="width:130px;"></center>
          <h3>Thank you for your enquiry. We will contact you shortly.</h3>
        </div>
        <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" onClick="refreshPage()">OK</button>  <center>
        </div>
      </div>  
  </div>
</div>  
</div> 

<script>
function checkAlreadyExist(phone) {
	//alert(phone);
     $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>client/find_same_data',
            data: {cdata:phone},
         success:function(data){
            res = JSON.parse(data);
              if(res){              
                $("input[name='e_name']").val(res.name_prefix + res.name  +' '+ res.lastname);
                $("input[name='e_mobile']").val(res.phone);                
                $("input[name='e_email']").val(res.email);
                $("input[name='e_requirements']").val(res.enquiry);              
              }
         }               
     });      
}
</script>
 
<script>
    $("#fstate").change(function(){        
        var state_id = $(this).val();                
        $.ajax({
            type: 'POST',
            url: "<?=base_url()?>location/get_city_byid",
            data: {state_id:state_id},
        })
        .done(function(data){
            if(data!=''){
              document.getElementById('fcity').innerHTML=data;
            }else{
              document.getElementById('fcity').innerHTML='';   
            }
        })
    });
</script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script> 
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>          
        
        <script type="text/javascript">
        function refreshPage(){
        $('#success_model').modal('hide');
        } 
        $(function(){        
            $("#enquiry_type").change(function(){            
                var enq_type = $(this).val();            
                if(enq_type==1){                
                    $("#customer_type").show(); 
                }else{                
                    $("#customer_type").hide(); 
                }          
                if(enq_type==11){                
                    $("#channel_partner").show();
                    $("#optunity_size").hide();  
                }else{                
                    $("#channel_partner").hide();                
                    $("#optunity_size").show();
                }            
            });
        });    
    </script>
</body>
</html>